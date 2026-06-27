<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.menuItem')
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kitchen.display', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $order->status]);
        }

        return back()->with('success', "Order #{$order->id} status updated.");
    }

    public function getActiveOrdersJson()
    {
        $orders = Order::with('items.menuItem')
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer_name' => $order->customer_name,
                    'table_number_or_delivery' => $order->table_number_or_delivery,
                    'total_price' => $order->total_price,
                    'status' => $order->status,
                    'notes' => $order->notes,
                    'elapsed_time' => $order->created_at->diffForHumans(null, true) . ' ago',
                    'items' => $order->items->map(function ($item) {
                        return [
                            'name' => $item->menuItem->name ?? 'Deleted Item',
                            'quantity' => $item->quantity,
                            'notes' => $item->notes
                        ];
                    })
                ];
            });

        return response()->json($orders);
    }
}
