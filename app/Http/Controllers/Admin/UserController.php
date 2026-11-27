<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $roleFilter = trim((string) $request->query('role', ''));
        $validRole = UserRole::tryFrom($roleFilter);

        $paidStatus = PaymentStatus::Paid->value;
        $cancelledStatus = OrderStatus::Cancelled->value;

        $users = User::query()
            ->withCount('orders')
            ->withSum([
                'orders as total_spent' => fn ($q) => $q
                    ->where('payment_status', $paidStatus)
                    ->where('order_status', '!=', $cancelledStatus),
            ], 'total')
            ->withMax('orders', 'created_at')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($validRole !== null, fn ($query) => $query->where('role', $validRole->value))
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        $userStats = User::query()
            ->selectRaw('COUNT(*) as total_users')
            ->selectRaw("SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_users")
            ->first();

        $orderStats = Order::query()
            ->selectRaw('COUNT(*) as total_orders')
            ->selectRaw('COALESCE(SUM(CASE WHEN payment_status = ? AND order_status != ? THEN total ELSE 0 END), 0) as total_spent', [$paidStatus, $cancelledStatus])
            ->first();

        return view('admin.userManagement', [
            'users' => $users,
            'search' => $search,
            'selectedRole' => $validRole?->value ?? '',
            'totalUsers' => (int) ($userStats->total_users ?? 0),
            'activeUsers' => (int) ($userStats->active_users ?? 0),
            'totalOrders' => (int) ($orderStats->total_orders ?? 0),
            'totalSpent' => (int) ($orderStats->total_spent ?? 0),
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'managedUser' => $user,
            'roles' => UserRole::cases(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if ($user->id === $request->user()->id) {
            if ($validated['role'] !== UserRole::Admin->value || $validated['status'] !== 'active') {
                return back()
                    ->withInput()
                    ->with('error', 'You cannot demote or suspend your own account.');
            }
        }

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = $validated['password'];
        }

        $user->update($payload);

        if ($user->status === 'suspended') {
            $this->purgeUserSessions($user);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User {$user->name} updated successfully.");
    }

    public function suspend(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->update(['status' => 'suspended']);
        $this->purgeUserSessions($user);

        return back()->with('success', "{$user->name} has been suspended.");
    }

    public function restore(User $user): RedirectResponse
    {
        $user->update(['status' => 'active']);

        return back()->with('success', "{$user->name} has been restored.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->orders()->exists()) {
            return back()->with('error', "Cannot delete {$user->name} because they have existing order history. Use Suspend instead.");
        }

        $this->purgeUserSessions($user);
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User {$user->name} deleted.");
    }

    private function purgeUserSessions(User $user): void
    {
        if (config('session.driver') === 'database' && Schema::hasTable('sessions')) {
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }
    }
}
