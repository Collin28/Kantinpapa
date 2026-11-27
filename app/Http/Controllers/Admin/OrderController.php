<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $statusFilter = trim((string) $request->query('status', ''));
        $validStatus = OrderStatus::tryFrom($statusFilter);

        $orders = Order::with(['user', 'items'])
            ->when($validStatus !== null, fn ($query) => $query->where('order_status', $validStatus->value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orderManagement', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
            'selectedStatus' => $validStatus?->value ?? '',
        ]);
    }

    public function updateStatus(Request $request, Order $order, OrderStatusService $orderStatusService): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(OrderStatus::class)],
        ]);

        $targetStatus = OrderStatus::from($validated['status']);

        try {
            $orderStatusService->transition($order, $targetStatus);
        } catch (ValidationException $e) {
            return back()->with('error', $e->validator->errors()->first('status'));
        }

        return back()->with('success', "Order {$order->order_number} updated to {$targetStatus->label()}.");
    }
}
