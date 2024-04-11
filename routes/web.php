<?php


use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\SellerLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Users\AdminController;
use App\Http\Controllers\Users\CustomerController;
use App\Http\Controllers\Users\SellerController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Users\FavoriteController;
use App\Http\Controllers\Products\AdController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the 'web' middleware group. Make something great!
|
*/

Auth::routes();

// Note: We might delete later
Route::get('/', function () {
    return view('welcome');
});

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');
//Search
Route::get('/search', [HomeController::class, 'search'])->name('search');
// Product Detail / {product_id}
Route::get('/productDetail/{id}', [ProductController::class, 'showProductDetail'])->name('productDetail');
// Inquiry
Route::get('/inquiry', function () {
    return view('inquiry');
});

// Payment
Route::get('/customer/cart', function () {
    return view('customer.cart');
});

Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    // Customer Register
    Route::get('register', function () {
        return view('auth.register');
    });

    // Customer Login
    Route::get('signIn', function () {
        return view('auth.login');
    });

    // Profile
    Route::get('profile/{id}', [CustomerController::class, 'showProfile'])->name('profile');

    Route::get('profile/editProfile/{id}', [CustomerController::class, 'showEditProfile'])->name('showEditProfile');
    Route::patch('profile/update/{customer_id}/{address_id}/{payment_id}', [CustomerController::class, 'update'])->name('updateProfile');

    Route::get('profile', function () {
        return view('customer.profile.profile');
    });

    Route::get('profile/editProfile', function () {
        return view('customer.profile.profileEdit');
    });


    Route::get('profile/orderHistory', function () {
        return view('customer.profile.orderHistory');
    });
});

Route::group(['prefix' => 'seller', 'as' => 'seller.'], function () {
    // Seller
    Route::get('signIn', [SellerLoginController::class, 'showLoginPage']);
    Route::post('signIn', [SellerLoginController::class, 'signIn'])->name('signIn');

    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('dashboard');

    // Seller Profile
    Route::get('profile', function () {
        return view('seller.profile.sellerProfile');
    });

    Route::get('profile/editProfile', function () {
        return view('seller.profile.editProfile');
    });

    // Seller Product
    Route::get('products/dashboard', [ProductController::class, 'show'])
        ->name('products.dashboard');

    Route::get('/products/create',  [ProductController::class, 'create'])
        ->name('products.create');

    Route::post('products/store',  [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('products/{id}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::patch('products/{id}/update', [ProductController::class, 'update'])
        ->name('products.update');

    Route::get('products/{id}/delete', [ProductController::class, 'delete'])
        ->name('products.delete');

    Route::delete('products/{id}/destroy', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    Route::delete('products/{i_id}/{p_id}/image/destroy', [ProductController::class, 'imageDestroy'])
        ->name('products.image.destroy');

    // Seller Ads
    Route::get('/ads/dashboard', [AdController::class, 'show'])
        ->name('ads.dashboard');

    Route::get('ads/create', [AdController::class, 'create'])
        ->name('ads.create');

    Route::post('ads/store', [AdController::class, 'store'])
        ->name('ads.store');

    Route::get('ads/{id}/edit', [AdController::class, 'edit'])
        ->name('ads.edit');

    Route::patch('ads/{id}/update', [AdController::class, 'update'])
        ->name('ads.update');

    Route::patch('ads/{id}/delete', [AdController::class, 'delete'])
        ->name('ads.delete');

    Route::delete('ads/{id}/destroy', [AdController::class, 'destroy'])
        ->name('ads.destroy');

    // Seller Evaluation
    Route::get('evaluation', function () {
        return view('seller.evaluation.show');
    });

    Route::get('delivery', function () {
        return view('seller.delivery.show');
    });

    Route::get('customerSupport', function () {
        return view('seller.inquiry.customerSupport');
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('signIn', [AdminLoginController::class, 'showLoginPage']);
    Route::post('signIn', [AdminLoginController::class, 'signIn'])->name('signIn');

    Route::get('dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');

    Route::get('/managementUser', [AdminController::class, 'index'])->name('managementUser'); //admin.managementUser
    Route::post('/store', [AdminController::class, 'store'])->name('store'); // admin.store
    Route::patch('/{id}/update', [AdminController::class, 'update'])->name('update'); //admin.update
    Route::delete('/{id}/destroy', [AdminController::class, 'destroy'])->name('destroy'); //admin.destroy

    Route::get('/admin/delivery', function () {
        return view('admin.delivery.deliveryList');
    });

    Route::get('/admin/customerSupport', function () {
        return view('admin.inquiry.customerSupport');

    });

    Route::get('evaluation', function () {
        return view('admin.assessor.evaluation');
    });

    Route::get('delivery', function () {
        return view('admin.delivery.deliveryList');
    });

    Route::get('customerSupport', function () {
        return view('admin.inquiry.customerSupport');
    });
});

// Favorite
Route::group(['prefix' => 'favorite', 'as' => 'favorite.'], function() {
    Route::post('/{product_id}/store', [FavoriteController::class, 'store'])->name('store');
    Route::delete('/{product_id}/destroy', [FavoriteController::class, 'destroy'])->name('destroy');
});
