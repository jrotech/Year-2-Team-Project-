<?php
/********************************
Developer: Abdullah Alharbi, Robert Oros, Iddrisu Musah
University ID: 230046409, 230237144, 230222232
********************************/
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\login;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\register;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ChangeAddressDetails;
use App\Http\Controllers\ChangePersonalDetails;
use App\Http\Controllers\LoggedInAPI;
use App\Http\Controllers\DashboardController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Footer Buttons
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::get('/about', [HomeController::class, 'about'])->name('about_us');
Route::get('/payment-methods', [HomeController::class, 'paymentMethods'])->name('payment-methods');

// Nav Bar Links
Route::get('/wishlist', [NavController::class, 'wishlist'])->name('wishlist');
Route::get('/about', [NavController::class, 'about'])->name('about');
Route::get('/pc-builder', [NavController::class, 'pcBuilder'])->name('pc-builder');
Route::get('/login', [NavController::class, 'login'])->name('login');

// Search / Shop Page
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
// API endpoint for filtering
Route::get('/api/products', [ShopController::class, 'apiShop'])->name('api.shop');

// Product
Route::get('/shop/product/{id}', [ProductController::class, 'show'])->name('product.getProduct');
Route::get('/api/products/{id}', [ProductController::class, 'getProduct'])->name('api.product.show');



// Submit Contact Form
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/api/auth-status', [LoggedInAPI::class, 'loggedin'])->name('is.logged.in');

Route::get('/register', [register::class, 'create'])->name('register');
Route::post('/register', [register::class, 'store'])->name('register');

Route::get('/login', [login::class, 'create'])->name('login');
Route::post('/login', [login::class, 'login'])->name('login');
Route::get('/logout', [login::class, 'logout'])->name('logout');

Route::get('/auth/google', [GoogleAuthController::class, 'redirect']);
Route::get('/authenticate/google/callback', [GoogleAuthController::class, 'callback']);


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/manage-profile', [ChangePersonalDetails::class, 'showChangePersonalDetailsForm'])->name('profile.manage-profile');
    Route::post('/profile/change-password', [ChangePasswordController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/change-personal-details', [ChangePersonalDetails::class, 'updatePersonalDetails'])->name('profile.update-personal-details');


    Route::get('/basket', [BasketController::class, 'index'])->name('basket');
    Route::post('/basket/add/{product}', [BasketController::class, 'add'])->name('basket.add');
    Route::put('/basket/{basketItem}', [BasketController::class, 'update'])->name('basket.update');
    Route::delete('/basket/{basketItem}', [BasketController::class, 'remove'])->name('basket.remove');
    Route::delete('/api/basket', [BasketController::class, 'clear'])->name('basket.clear');
    Route::get('/api/basket', [BasketController::class, 'getBasket'])->name('api.basket.get');

    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/api/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/basket/checkout', [BasketController::class, 'proceedToCheckout'])->name('basket.checkout');
    Route::post('/api/check-compatibility', [CompatibilityController::class, 'checkCompatibility'])->name('basket.compatibility');

    Route::get('/dashboard/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');;
    Route::get('/dashboard/orders/{id}', [DashboardController::class, 'order'])->name('dashboard.order');
    Route::get('/api/categorylastproduct', [DashboardController::class, 'apiCategoryLastProduct'])->name('dashoard.api');
});

// Get reviews for a product (public)
Route::get('/products/{id}/reviews', [App\Http\Controllers\ReviewController::class, 'getProductReviews'])
    ->name('products.reviews');

// Customer review operations (protected)
Route::middleware(['auth:customer'])->prefix('reviews')->group(function () {
    // Submit or update a review
    Route::post('/', [App\Http\Controllers\ReviewController::class, 'store'])
        ->name('reviews.store');

    // Update an existing review
    Route::put('/{id}', [App\Http\Controllers\ReviewController::class, 'update'])
        ->name('reviews.update');

    // Delete a review
    Route::delete('/{id}', [App\Http\Controllers\ReviewController::class, 'destroy'])
        ->name('reviews.destroy');

    // Get the authenticated customer's reviews
    Route::get('/my-reviews', [App\Http\Controllers\ReviewController::class, 'getCustomerReviews'])
        ->name('reviews.my');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'loginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {

        Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [App\Http\Controllers\Admin\AdminDashboardController::class, 'profile'])->name('profile');

        Route::get('/change-password', [App\Http\Controllers\Admin\AdminAuthController::class, 'changePasswordForm'])->name('change-password');
        Route::post('/change-password', [App\Http\Controllers\Admin\AdminAuthController::class, 'changePassword']);
        Route::post('/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('logout');

        Route::resource('products', App\Http\Controllers\Admin\AdminProductController::class);
        Route::post('/products/{product}/stock', [App\Http\Controllers\Admin\AdminProductController::class, 'updateStock'])->name('products.stock.update');


        Route::resource('categories', App\Http\Controllers\Admin\AdminCategoryController::class);

        Route::get('/orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.status.update');
        Route::post('/orders/{order}/ship', [App\Http\Controllers\Admin\AdminOrderController::class, 'processShipment'])->name('orders.ship');
        Route::post('/orders/{order}/cancel', [App\Http\Controllers\Admin\AdminOrderController::class, 'cancelOrder'])->name('orders.cancel');
        Route::get('/orders/{order}/invoice', [App\Http\Controllers\Admin\AdminOrderController::class, 'generateInvoice'])->name('orders.invoice');

        Route::resource('customers', App\Http\Controllers\Admin\AdminCustomerController::class);

        Route::resource('users', App\Http\Controllers\Admin\AdminUserController::class);

        Route::get('/reports/sales', [App\Http\Controllers\Admin\AdminReportController::class, 'salesReport'])->name('reports.sales');
        Route::get('/reports/inventory', [App\Http\Controllers\Admin\AdminReportController::class, 'inventoryReport'])->name('reports.inventory');
        Route::get('/reports/customers', [App\Http\Controllers\Admin\AdminReportController::class, 'customerReport'])->name('reports.customers');
    });
});
