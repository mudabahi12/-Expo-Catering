<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Company;
use App\Models\Contact;
use App\Models\DeliveryAddress;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Calculate Stats
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $activeOrdersCount = Order::whereIn('status', ['pending', 'preparing', 'ready'])->count();
        $totalMenuItemsCount = MenuItem::count();
        $totalCustomersCount = User::where('role', 'customer')->count();

        // 2. Fetch Multi-tenant data for Super Admin dashboard
        $restaurants = Restaurant::all();
        $totalAccounts = User::count();
        $activePendingOrders = Order::where('status', 'pending')->count();
        $completedSales = Order::where('status', 'completed')->sum('total_price');

        // 3. Fetch CRM lists for Super Admin Console
        $companies = Company::withCount('contacts')->get();
        $contacts = Contact::with('company')->get();
        $deliveryAddresses = DeliveryAddress::with('contact')->get();
        $settings = Setting::all();

        // 4. Fetch daily Production Sheet prep items
        $productionItems = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->whereIn('orders.status', ['pending', 'preparing', 'ready'])
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('menu_items.name')
            ->get();

        // 5. Fetch general lists
        $orders = Order::with('items.menuItem')->orderBy('created_at', 'desc')->get();
        $categories = Category::withCount('menuItems')->get();
        $menuItems = MenuItem::with('category')->get();
        $users = User::orderBy('name')->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'activeOrdersCount', 'totalMenuItemsCount', 'totalCustomersCount',
            'orders', 'categories', 'menuItems', 'users', 'restaurants', 'totalAccounts',
            'activePendingOrders', 'completedSales', 'companies', 'contacts', 
            'deliveryAddresses', 'settings', 'productionItems'
        ));
    }

    // --- Order Operations ---
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', "Order #{$order->id} status updated to " . ucfirst($order->status));
    }

    // --- Category Operations ---
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string'
        ]);

        Category::create($request->only('name', 'description'));

        return back()->with('success', 'Category created successfully!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }

    // --- Menu Item Operations ---
    public function storeMenuItem(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string', // comma-separated
            'is_available' => 'nullable|boolean'
        ]);

        $data = $request->only('category_id', 'name', 'description', 'price', 'tags');
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu_items', 'public');
            $data['image_path'] = '/storage/' . $path;
        } else {
            // Seed a default placeholder if none uploaded
            $data['image_path'] = '/images/default-dish.jpg';
        }

        MenuItem::create($data);

        return back()->with('success', 'Menu Item added successfully!');
    }

    public function updateMenuItem(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'is_available' => 'nullable|boolean'
        ]);

        $data = $request->only('category_id', 'name', 'description', 'price', 'tags');
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($menuItem->image_path && !str_contains($menuItem->image_path, 'default-dish.jpg')) {
                $oldPath = str_replace('/storage/', '', $menuItem->image_path);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('menu_items', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        $menuItem->update($data);

        return back()->with('success', 'Menu Item updated successfully!');
    }

    public function deleteMenuItem(MenuItem $menuItem)
    {
        if ($menuItem->image_path && !str_contains($menuItem->image_path, 'default-dish.jpg')) {
            $oldPath = str_replace('/storage/', '', $menuItem->image_path);
            Storage::disk('public')->delete($oldPath);
        }
        $menuItem->delete();
        return back()->with('success', 'Menu Item deleted successfully!');
    }

    public function toggleMenuItemAvailability(MenuItem $menuItem)
    {
        $menuItem->is_available = !$menuItem->is_available;
        $menuItem->save();

        return back()->with('success', "Item '{$menuItem->name}' status updated to " . ($menuItem->is_available ? 'In Stock' : 'Out of Stock') . ".");
    }

    // --- User Operations ---
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:super_admin,admin,customer'
        ]);

        // Prevent super admins from changing their own role to something else
        if (auth()->id() === $user->id && $user->role === 'super_admin' && $request->role !== 'super_admin') {
            return back()->with('error', 'You cannot demote yourself from Super Admin.');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('success', "Role for {$user->name} updated to " . ucfirst($user->role));
    }

    public function storeRestaurant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'icon' => 'nullable|string|max:10',
        ]);

        Restaurant::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'description' => $request->description,
            'address' => $request->address,
            'icon' => $request->icon ?? '🍔',
            'staff_count' => rand(2, 5),
            'dishes_count' => rand(3, 8),
            'orders_count' => 0,
        ]);

        return back()->with('success', 'Restaurant added successfully to CaterFlow PRO.');
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'industry' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        Company::create($request->only('name', 'industry', 'phone'));

        return back()->with('success', 'Company profile created successfully.');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        Contact::create($request->only('name', 'email', 'phone', 'company_id'));

        return back()->with('success', 'Contact created successfully.');
    }

    public function storeDeliveryAddress(Request $request)
    {
        $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'contact_id' => 'nullable|exists:contacts,id',
            'notes' => 'nullable|string',
        ]);

        DeliveryAddress::create($request->only('street', 'city', 'postal_code', 'contact_id', 'notes'));

        return back()->with('success', 'Delivery Address registered successfully.');
    }

    public function updateConfiguration(Request $request)
    {
        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'tax_rate' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Configuration parameters updated successfully.');
    }
}
