<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\AdminDashboardController;

// 1. Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. User Profile Routes (Protected by Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// 4. Restaurant Ordering Kiosk / Customer Screen Routes
Route::redirect('/kiosk', '/restaurant');
Route::get('/restaurant', [KioskController::class, 'index'])->name('kiosk');
Route::post('/restaurant/order', [KioskController::class, 'placeOrder'])->name('kiosk.order.place');
Route::get('/restaurant/live-orders', [KioskController::class, 'getLiveOrders'])->name('kiosk.live-orders');

// 5. Kitchen Display System (KDS) Routes (Protected by Auth & Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.display');
    Route::patch('/kitchen/orders/{order}/status', [KitchenController::class, 'updateStatus'])->name('kitchen.orders.status');
    Route::get('/kitchen/active-orders-data', [KitchenController::class, 'getActiveOrdersJson'])->name('kitchen.active-orders-data');
});

// 6. Admin Panel Routes (Protected by Auth and Custom Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/orders/{order}/status', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.status');
    Route::post('/restaurants', [AdminDashboardController::class, 'storeRestaurant'])->name('restaurants.store');
    
    // Category management
    Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminDashboardController::class, 'deleteCategory'])->name('categories.delete');
    
    // Menu item management
    Route::post('/menu', [AdminDashboardController::class, 'storeMenuItem'])->name('menu.store');
    Route::patch('/menu/{menuItem}', [AdminDashboardController::class, 'updateMenuItem'])->name('menu.update');
    Route::patch('/menu/{menuItem}/toggle-availability', [AdminDashboardController::class, 'toggleMenuItemAvailability'])->name('menu.toggle-availability');
    Route::delete('/menu/{menuItem}', [AdminDashboardController::class, 'deleteMenuItem'])->name('menu.delete');
    
    // CRM management endpoints
    Route::post('/companies', [AdminDashboardController::class, 'storeCompany'])->name('companies.store');
    Route::post('/contacts', [AdminDashboardController::class, 'storeContact'])->name('contacts.store');
    Route::post('/delivery-addresses', [AdminDashboardController::class, 'storeDeliveryAddress'])->name('delivery-addresses.store');
    Route::post('/configuration', [AdminDashboardController::class, 'updateConfiguration'])->name('configuration.update');
    
    // User role management
    Route::patch('/users/{user}/role', [AdminDashboardController::class, 'updateUserRole'])->name('users.role');
});
