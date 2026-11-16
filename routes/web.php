<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,AuthController,ProductController,OrderController,FarmerController,CustomerController,ReviewController,AdminController,AssistantController,CartController,PickupSlotController,WeeklyStockTemplateController};

Route::get('/product-media/{path}', function (string $path) {
    if (!preg_match('#^products/[A-Za-z0-9._/-]+$#', $path)) {
        abort(404);
    }
    $disk = Storage::disk('public');
    if (!$disk->exists($path)) {
        abort(404);
    }
    return response()->file($disk->path($path));
})->where('path', '.*')->name('product.media');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/compare', [ProductController::class, 'compare'])->name('products.compare');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/markets', [HomeController::class, 'markets'])->name('markets.index');
Route::get('/farmers/{user}', [FarmerController::class, 'publicShow'])->name('farmers.show');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/verify-otp', [AuthController::class, 'showOtp'])->name('password.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:10,1')->name('password.otp.verify');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:5,1')->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/notifications', [CustomerController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [CustomerController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [CustomerController::class, 'markAllNotificationsRead'])->name('notifications.read_all');
    Route::post('/assistant', [AssistantController::class, 'ask'])->middleware('throttle:30,1')->name('assistant.ask');

    Route::middleware('role:customer')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
        Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [CartController::class, 'store'])->name('checkout.store');

        Route::get('/customer', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::patch('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
        Route::get('/customer/orders', [OrderController::class, 'customerOrders'])->name('customer.orders');
        Route::get('/customer/orders/export', [CustomerController::class, 'exportOrders'])->name('customer.orders.export');
        Route::get('/customer/orders/{order}/edit', [OrderController::class, 'customerEdit'])->name('customer.orders.edit');
        Route::put('/customer/orders/{order}', [OrderController::class, 'customerUpdate'])->name('customer.orders.update');
        Route::get('/customer/orders/{order}', [OrderController::class, 'customerShow'])->name('customer.orders.show');
        Route::get('/customer/order', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/customer/order', [OrderController::class, 'store'])->name('orders.store');
        Route::post('/customer/order/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/customer/order/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');
        Route::get('/customer/favorites', [CustomerController::class, 'favorites'])->name('customer.favorites');
        Route::post('/customer/favorites', [CustomerController::class, 'toggleFavorite'])->name('favorites.toggle');
        Route::get('/customer/markets', [CustomerController::class, 'markets'])->name('customer.markets');
        Route::post('/customer/markets/{market}/toggle', [CustomerController::class, 'toggleMarket'])->name('customer.markets.toggle');
        Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    });

    Route::middleware('role:farmer')->group(function () {
        Route::get('/farmer', [FarmerController::class, 'dashboard'])->name('farmer.dashboard');
        Route::get('/farmer/profile', [FarmerController::class, 'profile'])->name('farmer.profile');
        Route::post('/farmer/profile', [FarmerController::class, 'updateProfile'])->name('farmer.profile.update');
        Route::get('/farmer/products', [FarmerController::class, 'products'])->name('farmer.products');
        Route::post('/farmer/products', [ProductController::class, 'store'])->name('farmer.products.store');
        Route::put('/farmer/products/{product}', [ProductController::class, 'update'])->name('farmer.products.update');
        Route::delete('/farmer/products/{product}', [ProductController::class, 'destroy'])->name('farmer.products.destroy');
        Route::get('/farmer/orders', [OrderController::class, 'farmerOrders'])->name('farmer.orders');
        Route::get('/farmer/orders/export', [FarmerController::class, 'salesExport'])->name('farmer.orders.export');
        Route::get('/farmer/orders/{order}', [OrderController::class, 'farmerShow'])->name('farmer.orders.show');
        Route::post('/farmer/orders/{order}/status', [OrderController::class, 'status'])->name('farmer.orders.status');
        Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
        Route::get('/farmer/pickup-slots', [PickupSlotController::class, 'index'])->name('farmer.pickup-slots');
        Route::post('/farmer/pickup-slots', [PickupSlotController::class, 'store'])->name('farmer.pickup-slots.store');
        Route::delete('/farmer/pickup-slots/{pickupSlot}', [PickupSlotController::class, 'destroy'])->name('farmer.pickup-slots.destroy');
        Route::get('/farmer/stock-templates', [WeeklyStockTemplateController::class, 'index'])->name('farmer.stock-templates');
        Route::post('/farmer/stock-templates', [WeeklyStockTemplateController::class, 'store'])->name('farmer.stock-templates.store');
        Route::patch('/farmer/stock-templates/{template}', [WeeklyStockTemplateController::class, 'update'])->name('farmer.stock-templates.update');
        Route::post('/farmer/stock-templates/{template}/apply', [WeeklyStockTemplateController::class, 'apply'])->name('farmer.stock-templates.apply');
        Route::delete('/farmer/stock-templates/{template}', [WeeklyStockTemplateController::class, 'destroy'])->name('farmer.stock-templates.destroy');
    });

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('admin.users.export');
        Route::post('/users/{user}/farmer-approval', [AdminController::class, 'farmerApproval'])->name('admin.farmer.approval');
        Route::post('/users/{user}/status', [AdminController::class, 'userStatus'])->name('admin.users.status');
        Route::get('/markets', [AdminController::class, 'markets'])->name('admin.markets');
        Route::post('/markets', [AdminController::class, 'storeMarket'])->name('admin.markets.store');
        Route::patch('/markets/{market}', [AdminController::class, 'updateMarket'])->name('admin.markets.update');
        Route::delete('/markets/{market}', [AdminController::class, 'deleteMarket'])->name('admin.markets.delete');
        Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
        Route::get('/moderation', [AdminController::class, 'moderation'])->name('admin.moderation');
        Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
        Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('admin.review.delete');
        Route::get('/announcements', [AdminController::class, 'announcements'])->name('admin.announcements');
        Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])->name('admin.announcements.store');
        Route::delete('/announcements/{announcement}', [AdminController::class, 'deleteAnnouncement'])->name('admin.announcements.delete');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/reports/export', [AdminController::class, 'exportOrders'])->name('admin.reports.export');
        Route::get('/activity', [AdminController::class, 'activity'])->name('admin.activity');
    });
});
