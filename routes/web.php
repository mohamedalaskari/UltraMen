<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\ShippingController as AdminShippingController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'], true)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/collections', [CollectionController::class, 'index'])->name('collections');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/best-sellers', [ArchiveController::class, 'index'])->name('best-sellers');
Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add',    [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/coupon/apply',  [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/checkout',  [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/calculate', [CheckoutController::class, 'calculateTotals'])->name('checkout.calculate');
Route::get('/order-confirmed', [ConfirmationController::class, 'index'])->name('confirmation');

// ── Admin ──────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::get('/products',               [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create',        [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products',              [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit',[AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}',     [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}',  [AdminProductController::class, 'destroy'])->name('products.destroy');

        // Categories
        Route::get('/categories',               [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories',              [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}',    [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        // Orders
        Route::get('/orders',                   [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}',           [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status',  [AdminOrderController::class, 'updateStatus'])->name('orders.status');

        // Messages
        Route::get('/messages',                      [AdminMessageController::class, 'index'])->name('messages.index');
        Route::patch('/messages/{message}/read',     [AdminMessageController::class, 'markRead'])->name('messages.read');
        Route::post('/messages/{message}/reply',     [AdminMessageController::class, 'reply'])->name('messages.reply');
        Route::delete('/messages/{message}',         [AdminMessageController::class, 'destroy'])->name('messages.destroy');

        // Shipping & Tax
        Route::get('/shipping',                    [AdminShippingController::class, 'index'])->name('shipping.index');
        Route::post('/shipping/zones',              [AdminShippingController::class, 'store'])->name('shipping.zones.store');
        Route::put('/shipping/zones/{zone}',        [AdminShippingController::class, 'update'])->name('shipping.zones.update');
        Route::delete('/shipping/zones/{zone}',     [AdminShippingController::class, 'destroy'])->name('shipping.zones.destroy');
        Route::post('/shipping/tax',                [AdminShippingController::class, 'updateTax'])->name('shipping.tax.update');

        // Coupons
        Route::get('/coupons',                [AdminCouponController::class, 'index'])->name('coupons.index');
        Route::post('/coupons',                [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::put('/coupons/{coupon}',        [AdminCouponController::class, 'update'])->name('coupons.update');
        Route::delete('/coupons/{coupon}',     [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

        // Settings (site content)
        Route::get('/settings/{page?}',  [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/{page}',  [AdminSettingsController::class, 'update'])->name('settings.update');
    });
});
