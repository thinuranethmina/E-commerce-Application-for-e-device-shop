<?php

use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\OrdersController;
use App\Http\Controllers\Backend\PaymentController as BackendPaymentController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\SeasonalBannerController;
use App\Http\Controllers\Backend\Setting\NotificationController;
use App\Http\Controllers\Backend\Settings\PaymentController;
use App\Http\Controllers\Backend\Settings\SystemSettingController;
use App\Http\Controllers\Backend\StockController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\VariationController;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\Route;


Route::prefix('/admin')->as('admin.')->middleware(['adminIsLoggedIn'])->group(function () {
    // Logout
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    Route::resource('variation', VariationController::class);

    Route::get('variation/{id}/values', [VariationController::class, 'variationValues']);
    Route::get('product/variation/row/{index}', [ProductController::class, 'variationRow']);
    Route::get('product/variation/content', [ProductController::class, 'variationContent']);

    Route::resource('brand', BrandController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('sub-category', SubCategoryController::class);
    Route::resource('banner', BannerController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('review', ReviewController::class);
    Route::resource('orders', OrdersController::class);
    Route::resource('payments', BackendPaymentController::class);

    Route::get('orders/pdf/{id}/{purpose}', [OrdersController::class, 'pdfInvoice'])->name('orders.pdf');

    Route::post('payments/export', [BackendPaymentController::class, 'export'])->name('payments.export');


    Route::get('stock', [StockController::class, 'index'])->name('stock.index');

    // Settings
    Route::get('/system_settings', [SystemSettingController::class, 'show'])->name('system_settings');
    Route::post('/system_settings/update', [SystemSettingController::class, 'update'])->name('system_settings.update');

    Route::get('payment_settings', [PaymentController::class, 'show'])->name('payment_settings');
    Route::post('payment_settings/payment_gateway/update', [PaymentController::class, 'paymentGatewayUpdate'])->name('payment_settings.payment_gateway.update');
    Route::post('payment_settings/offline_payment/update', [PaymentController::class, 'offlinePaymentUpdate'])->name('payment_settings.offline.update');
    Route::post('payment_settings/delivery/update', [PaymentController::class, 'deliveryFeeUpdate'])->name('payment_settings.delivery.update');

    Route::get('notification_settings', [NotificationController::class, 'show'])->name('notification_settings');
    Route::post('notification_settings/sms/update', [NotificationController::class, 'smsUpdate'])->name('notification_settings.sms.update');
    Route::post('notification_settings/email/update', [NotificationController::class, 'emailUpdate'])->name('notification_settings.email.update');
    Route::post('notification_settings/email/template/update', [NotificationController::class, 'smsTemplateUpdate'])->name('notification_settings.sms.template.update');

    Route::get('seasonal_banner', [SeasonalBannerController::class, 'show'])->name('seasonal_banner.show');
    Route::post('seasonal_banner/update', [SeasonalBannerController::class, 'update'])->name('seasonal_banner.update');

    Route::get('backup/', [BackupController::class, 'index'])->name('backup.index');
    Route::get('backup/create', [BackupController::class, 'create'])->name('backup.create');
    Route::get('backup/download/{id}', [BackupController::class, 'download'])->name('backup.download');


    Route::resource('/profile', ProfileController::class);
    Route::post('/profile/changePassword', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
});

Route::prefix('/admin')->as('admin.')->middleware(['adminIsNotLoggedIn'])->group(function () {
    // Login
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'index')->name('login.index');
        Route::post('login', 'login')->name('login');
    });
});
