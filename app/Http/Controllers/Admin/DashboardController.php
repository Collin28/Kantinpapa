<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = now('Asia/Jakarta');
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();
        $thisWeekStart = $now->copy()->subDays(6)->startOfDay();
        $lastWeekStart = $now->copy()->subDays(13)->startOfDay();
        $lastWeekEnd = $now->copy()->subDays(7)->endOfDay();

        $paidStatus = PaymentStatus::Paid->value;
        $cancelledStatus = OrderStatus::Cancelled->value;
        $pendingStatus = OrderStatus::Pending->value;
        $completedStatus = OrderStatus::Completed->value;

        $orderStats = Order::query()
            ->selectRaw('COUNT(*) as total_orders')
            ->selectRaw('SUM(CASE WHEN order_status = ? THEN 1 ELSE 0 END) as pending_orders', [$pendingStatus])
            ->selectRaw('SUM(CASE WHEN order_status = ? THEN 1 ELSE 0 END) as completed_orders', [$completedStatus])
            ->selectRaw('COALESCE(SUM(CASE WHEN payment_status = ? AND order_status != ? THEN total ELSE 0 END), 0) as total_revenue', [$paidStatus, $cancelledStatus])
            ->selectRaw('COALESCE(SUM(CASE WHEN payment_status = ? AND order_status != ? AND created_at BETWEEN ? AND ? THEN total ELSE 0 END), 0) as today_revenue', [$paidStatus, $cancelledStatus, $todayStart, $todayEnd])
            ->selectRaw('SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as today_orders', [$todayStart, $todayEnd])
            ->selectRaw('COALESCE(SUM(CASE WHEN payment_status = ? AND order_status != ? AND created_at BETWEEN ? AND ? THEN total ELSE 0 END), 0) as this_week_revenue', [$paidStatus, $cancelledStatus, $thisWeekStart, $todayEnd])
            ->selectRaw('COALESCE(SUM(CASE WHEN payment_status = ? AND order_status != ? AND created_at BETWEEN ? AND ? THEN total ELSE 0 END), 0) as last_week_revenue', [$paidStatus, $cancelledStatus, $lastWeekStart, $lastWeekEnd])
            ->first();

        $menuStats = Menu::query()
            ->selectRaw('COUNT(*) as total_menus')
            ->selectRaw('SUM(CASE WHEN is_available = 1 AND stock > 0 THEN 1 ELSE 0 END) as available_menus')
            ->first();

        $totalOrders = (int) ($orderStats->total_orders ?? 0);
        $completedOrders = (int) ($orderStats->completed_orders ?? 0);
        $successRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 1) : 0.0;

        $thisWeekRevenue = (int) ($orderStats->this_week_revenue ?? 0);
        $lastWeekRevenue = (int) ($orderStats->last_week_revenue ?? 0);

        if ($lastWeekRevenue > 0) {
            $growth = round((($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100, 1);
            $revenueSubtitle = ($growth >= 0 ? '+' : '').$growth.'% vs last week';
        } else {
            $revenueSubtitle = 'All time paid orders';
        }

        return view('admin.dashboard', [
            'todayLabel' => $now->locale('id')->translatedFormat('l, d F Y'),
            'totalRevenue' => (int) ($orderStats->total_revenue ?? 0),
            'revenueSubtitle' => $revenueSubtitle,
            'todayRevenue' => (int) ($orderStats->today_revenue ?? 0),
            'todayOrders' => (int) ($orderStats->today_orders ?? 0),
            'totalOrders' => $totalOrders,
            'pendingOrders' => (int) ($orderStats->pending_orders ?? 0),
            'completedOrders' => $completedOrders,
            'successRate' => $successRate,
            'totalMenus' => (int) ($menuStats->total_menus ?? 0),
            'availableMenus' => (int) ($menuStats->available_menus ?? 0),
        ]);
    }
}
