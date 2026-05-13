<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $orders = Order::query()
            ->with('user:id,name,email')
            ->withCount('items')
            ->when($status !== '', function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $availableStatuses = Order::query()
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        return view('admin.orders.index', [
            'orders' => $orders,
            'selectedStatus' => $status,
            'availableStatuses' => $availableStatuses,
        ]);
    }

    public function show(Order $order): View
    {
        $order->load([
            'user:id,name,email',
            'items.product:id,title,slug,image',
        ]);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }
}
