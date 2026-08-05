<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CanteenController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SellerCanteenController;
use App\Http\Controllers\SellerMenuController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\AdminController; // Import AdminController
use App\Http\Controllers\AdminSchoolController; // Import AdminSchoolController
use App\Http\Controllers\AdminUserController; // Import AdminUserController
use App\Http\Controllers\AdminCanteenController; // Import AdminCanteenController
use App\Http\Controllers\AdminOrderController; // Import AdminOrderController
use App\Http\Controllers\AdminDeliveryController; // Import AdminDeliveryController
use App\Http\Controllers\AdminReportController; // Import AdminReportController
use App\Http\Controllers\AdminSettingController; // Import AdminSettingController
use App\Http\Controllers\AdminDisputeController; // Import AdminDisputeController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login/user', [LoginController::class, 'showUserLoginForm'])->name('login.user');
    Route::post('/login/user', [LoginController::class, 'loginUser']);
    Route::get('/login/seller', [LoginController::class, 'showSellerLoginForm'])->name('login.seller');
    Route::post('/login/seller', [LoginController::class, 'loginSeller']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::get('/login', function () {
    return redirect()->route('login.user');
})->name('login');

Route::middleware(['auth', 'role:customer,seller,courier,system_manager'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin/System Manager specific dashboard route
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Customer Routes
    Route::get('/canteens', [App\Http\Controllers\CanteenController::class, 'index'])->name('canteens.index');
    Route::get('/canteens/{canteen}/menus', [App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{menu}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{menu}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{menu}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/order-history', [OrderController::class, 'history'])->name('order.history');
    Route::post('/orders/{order}/confirm-receipt', [OrderController::class, 'confirmReceipt'])->name('orders.confirm-receipt');

    // Dispute Routes for Customers
    Route::get('/orders/{order}/dispute/create', [DisputeController::class, 'create'])->name('disputes.create');
    Route::post('/orders/{order}/dispute', [DisputeController::class, 'store'])->name('disputes.store');

    // Seller Routes
    Route::resource('/seller/canteens', SellerCanteenController::class)->names([
        'index' => 'seller.canteens.index',
        'create' => 'seller.canteens.create',
        'store' => 'seller.canteens.store',
        'edit' => 'seller.canteens.edit',
        'update' => 'seller.canteens.update',
        'destroy' => 'seller.canteens.destroy',
    ]);
    Route::resource('/seller/canteens/{canteen}/menus', SellerMenuController::class)->names([
        'index' => 'seller.menus.index',
        'create' => 'seller.menus.create',
        'store' => 'seller.menus.store',
        'edit' => 'seller.menus.edit',
        'update' => 'seller.menus.update',
        'destroy' => 'seller.menus.destroy',
    ]);
    Route::get('/seller/orders', [OrderController::class, 'sellerIndex'])->name('seller.orders.index');
    Route::post('/seller/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('seller.orders.update-status');

    // Courier Routes
    Route::get('/courier/available-orders', [CourierController::class, 'availableOrders'])->name('courier.available-orders');
    Route::post('/courier/orders/{order}/accept', [CourierController::class, 'acceptOrder'])->name('courier.accept-order');
    Route::get('/courier/deliveries', [CourierController::class, 'deliveries'])->name('courier.deliveries');
    Route::post('/courier/deliveries/{order}/mark-delivered', [CourierController::class, 'markAsDelivered'])->name('courier.mark-delivered');
    Route::get('/courier/history', [CourierController::class, 'history'])->name('courier.history');
    Route::get('/courier/earnings', [CourierController::class, 'earnings'])->name('courier.earnings');
    Route::post('/courier/toggle-availability', [CourierController::class, 'toggleAvailability'])->name('courier.toggle-availability');

    // System Manager Routes
    Route::resource('/admin/schools', AdminSchoolController::class)->names([
        'index' => 'admin.schools.index',
        'create' => 'admin.schools.create',
        'store' => 'admin.schools.store',
        'edit' => 'admin.schools.edit',
        'update' => 'admin.schools.update',
        'destroy' => 'admin.schools.destroy',
    ]);
    Route::resource('/admin/users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::resource('/admin/canteens', AdminCanteenController::class)->names([
        'index' => 'admin.canteens.index',
        'edit' => 'admin.canteens.edit',
        'update' => 'admin.canteens.update',
        'destroy' => 'admin.canteens.destroy',
    ]);
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/deliveries', [AdminDeliveryController::class, 'index'])->name('admin.deliveries.index');
    Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
    Route::get('/admin/disputes', [AdminDisputeController::class, 'index'])->name('admin.disputes.index');
    Route::post('/admin/disputes/{dispute}/update-status', [AdminDisputeController::class, 'updateStatus'])->name('admin.disputes.update-status');

    // Profile route is intentionally outside the 'role' middleware group to allow unverified users access
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/apply-courier', [ProfileController::class, 'applyCourier'])->name('profile.apply-courier');
});
