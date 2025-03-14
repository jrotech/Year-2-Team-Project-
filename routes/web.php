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

    Route::get('/dashboard/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');;
    Route::get('/dashboard/orders/{id}', [DashboardController::class, 'order'])->name('dashboard.order');
    Route::get('/api/categorylastproduct', [DashboardController::class, 'apiCategoryLastProduct'])->name('dashoard.api');
});
