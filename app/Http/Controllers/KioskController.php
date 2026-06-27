<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KioskController extends Controller
{
    public function index()
    {
        $categories = Category::with(['menuItems' => function ($query) {
            $query->where('is_available', true);
        }])->get();

        $user = Auth::user();
        $userPreferences = [];
        $myOrders = [];
        if ($user) {
            $userPreferences = array_map('trim', explode(',', $user->dietary_preferences ?? ''));
            $myOrders = Order::with('items.menuItem')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('kiosk.index', compact('categories', 'user', 'userPreferences', 'myOrders'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'table_number_or_delivery' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:menu_items,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $totalPrice = 0;
            $orderItemsData = [];

            foreach ($request->cart as $cartItem) {
                $menuItem = MenuItem::findOrFail($cartItem['id']);
                if (!$menuItem->is_available) {
                    return response()->json(['error' => "Item '{$menuItem->name}' is currently unavailable."], 422);
                }

                $qty = (int)$cartItem['quantity'];
                $itemTotal = $menuItem->price * $qty;
                $totalPrice += $itemTotal;

                $orderItemsData[] = [
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $qty,
                    'price' => $menuItem->price,
                    'notes' => $cartItem['notes'] ?? null
                ];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'contact_info' => $request->contact_info,
                'table_number_or_delivery' => $request->table_number_or_delivery,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $request->notes
            ]);

            foreach ($orderItemsData as $itemData) {
                $itemData['order_id'] = $order->id;
                OrderItem::create($itemData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => "Order #{$order->id} placed successfully!"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to place order. ' . $e->getMessage()], 500);
        }
    }

    public function getLiveOrders()
    {
        $preparing = Order::where('status', 'preparing')
            ->select('id', 'customer_name', 'table_number_or_delivery')
            ->orderBy('updated_at', 'desc')
            ->get();

        $ready = Order::where('status', 'ready')
            ->select('id', 'customer_name', 'table_number_or_delivery')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'preparing' => $preparing,
            'ready' => $ready
        ]);
    }
}
