<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboadContrller;
use App\Http\Controllers\Admin\GroupUserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\CategoriBlogController;
use App\Http\Controllers\Admin\ContactContrller;
use App\Http\Controllers\Admin\OrderContrller;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\SessionController as AdminSessionController;
use App\Http\Controllers\RegisteredStoreController;
use App\Http\Controllers\Client\ClientController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('cp-login', [AdminSessionController::class, 'create'])->name('login');
Route::post('cp-login', [AdminSessionController::class, 'store'])->name('submitLogin');
Route::get('cp-logout', [ClientController::class, 'logout'])->name('logout');
Route::get('cp-register', [ClientController::class, 'register'])->name('register');
Route::post('cp-register', [ClientController::class, 'registerCreate'])->name('registerCreate');
Route::get('quen-mat-khau', [ClientController::class, 'forgetPassword'])->name('forgetPassword');
Route::post('quen-mat-khau', [ClientController::class, 'SentPassword'])->name('SentPassword');
Route::get('doi-mat-khau', [ClientController::class, 'ChangePassword'])->name('ChangePassword');
Route::post('doi-mat-khau', [ClientController::class, 'SentChangePassword'])->name('SentChangePassword');
Route::get('registered/store', [RegisteredStoreController::class, 'create'])->name('registered_shop');
Route::post('registered/store', [RegisteredStoreController::class, 'save']);

Route::name('cp-admin.')->middleware('AdminLogin')->prefix('cp-admin/')->group(function () {
    Route::get('/', [DashboadContrller::class, 'index'])->name('dashboad');
    //
    Route::middleware('AdminLogin')->group(function () {
        Route::get('logout', [AdminSessionController::class, 'logout'])->name('logout');
        Route::get('profile', [UserController::class, 'proFile'])->name('profile');
        Route::post('profile', [UserController::class, 'proFileStore'])->name('proFileStore');
        Route::post('changePassword', [UserController::class, 'changePassword'])->name('changePassword');
        Route::get('config', [ConfigController::class, 'config'])->name('config');
        Route::post('config', [ConfigController::class, 'updateConfig'])->name('config');
        Route::post('change-maket-status', [ConfigController::class, 'changeMaketStatus'])->name('change-maket-status');
    });
    // category
    Route::name('category.')->middleware('AdminLogin')->prefix('category/')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index')->middleware('can:XEM-LOAI-SAN-PHAM');
        Route::get('create', [CategoryController::class, 'create'])->name('create')->middleware('can:THEM-LOAI-SAN-PHAM');
        Route::post('store', [CategoryController::class, 'store'])->name('store')->middleware('can:THEM-LOAI-SAN-PHAM');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit')->middleware('can:SUA-LOAI-SAN-PHAM');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('update')->middleware('can:SUA-LOAI-SAN-PHAM');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('delete')->middleware('can:XOA-LOAI-SAN-PHAM');
    });
    // Sản phẩm
    Route::name('products.')->middleware('AdminLogin')->prefix('products/')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index')->middleware('can:XEM-SAN-PHAM');
        Route::get('create', [ProductController::class, 'create'])->name('create')->middleware('can:THEM-SAN-PHAM');
        Route::post('store', [ProductController::class, 'store'])->name('store')->middleware('can:THEM-SAN-PHAM');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit')->middleware('can:SUA-SAN-PHAM');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('update')->middleware('can:SUA-SAN-PHAM');
        Route::post('update/status/{id}', [ProductController::class, 'updateStatus'])->name('updateStatus')->middleware('can:SUA-SAN-PHAM');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('delete')->middleware('can:XOA-SAN-PHAM');
        Route::name('variant.')->group(function () {
            Route::get('{id}/variant', [ProductVariantController::class, 'edit'])->name('edit')->middleware('can:SUA-SAN-PHAM');
            Route::post('{product_id}/variant/update', [ProductVariantController::class, 'update'])->name('update')->middleware('can:SUA-SAN-PHAM');
            Route::get('{product_id}/variant/delete/{id}', [ProductVariantController::class, 'delete'])->name('delete')->middleware('can:SUA-SAN-PHAM');
        });
    });

    // Variants
    Route::name('variant.')->middleware('AdminLogin')->prefix('variant/')->group(function () {
        Route::get('/', [VariantController::class, 'index'])->name('index')->middleware('can:XEM-SAN-PHAM');
        Route::get('create', [VariantController::class, 'create'])->name('create')->middleware('can:THEM-LOAI-SAN-PHAM');
        Route::post('store', [VariantController::class, 'store'])->name('store')->middleware('can:THEM-SAN-PHAM');
        Route::get('edit/{id}', [VariantController::class, 'edit'])->name('edit')->middleware('can:SUA-SAN-PHAM');
        Route::post('update/{id}', [VariantController::class, 'update'])->name('update')->middleware('can:SUA-SAN-PHAM');
        Route::get('delete/{id}', [VariantController::class, 'delete'])->name('delete')->middleware('can:XOA-SAN-PHAM');
    });

    // Nhà cung câp
    Route::name('supplier.')->middleware('AdminLogin')->prefix('supplier/')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index')->middleware('can:XEM-NHA-PHAN-PHOI');
        Route::get('create', [SupplierController::class, 'create'])->name('create')->middleware('can:XEM-NHA-PHAN-PHOI');
        Route::post('store', [SupplierController::class, 'store'])->name('store')->middleware('can:XEM-NHA-PHAN-PHOI');
        Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('edit')->middleware('can:XEM-NHA-PHAN-PHOI');
        Route::post('update/{id}', [SupplierController::class, 'update'])->name('update')->middleware('can:XEM-NHA-PHAN-PHOI');
        Route::get('delete/{id}', [SupplierController::class, 'delete'])->name('delete')->middleware('can:XEM-NHA-PHAN-PHOI');
    });
    // nhom khách hàng
    Route::name('groups.')->middleware('AdminLogin')->prefix('groups/')->group(function () {
        Route::get('', [GroupUserController::class, 'index'])->name('index')->middleware('can:XEM-NHOM-KHACH-HANG');
        Route::get('create', [GroupUserController::class, 'create'])->name('create')->middleware('can:THEM-NHOM-KHACH-HANG');
        Route::post('store', [GroupUserController::class, 'store'])->name('store')->middleware('can:THEM-NHOM-KHACH-HANG');
        Route::get('edit/{id}', [GroupUserController::class, 'edit'])->name('edit')->middleware('can:SUA-NHOM-KHACH-HANG');
        Route::post('update/{id}', [GroupUserController::class, 'update'])->name('update')->middleware('can:SUA-NHOM-KHACH-HANG');
        Route::get('delete/{id}', [GroupUserController::class, 'delete'])->name('delete')->middleware('can:XOA-NHOM-KHACH-HANG'); // todo xóa khi ko có hóa đơn
    });
    // khách hàng
    Route::name('customers.')->middleware('AdminLogin')->prefix('customers/')->group(function () {
        Route::get('', [CustomerController::class, 'index'])->name('index')->middleware('can:XEM-KHACH-HANG');
        Route::get('create', [CustomerController::class, 'create'])->name('create')->middleware('can:THEM-KHACH-HANG');
        Route::post('store', [CustomerController::class, 'store'])->name('store')->middleware('can:THEM-KHACH-HANG');
        Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('edit')->middleware('can:SUA-KHACH-HANG');
        Route::post('update/{id}', [CustomerController::class, 'update'])->name('update')->middleware('can:SUA-KHACH-HANG');
        Route::get('delete/{id}', [CustomerController::class, 'delete'])->name('delete')->middleware('can:XOA-KHACH-HANG'); // todo xóa khi ko có hóa đơn
    });
    //Nhân viên
    Route::name('user.')->middleware('AdminLogin')->prefix('user/')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index')->middleware('can:XEM-NHAN-VIEN');
        Route::get('create', [UserController::class, 'create'])->name('create')->middleware('can:THEM-NHAN-VIEN');
        Route::post('store', [UserController::class, 'store'])->name('store')->middleware('can:THEM-NHAN-VIEN');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit')->middleware('can:SUA-NHAN-VIEN');
        Route::post('update/{id}', [UserController::class, 'update'])->name('update')->middleware('can:SUA-NHAN-VIEN');
        Route::get('delete/{id}', [UserController::class, 'delete'])->name('delete')->middleware('can:XOA-NHAN-VIEN'); // todo xóa khi ko có hóa đơn
        Route::name('role.')->prefix('role/')->group(function () {
            Route::get('', [RoleController::class, 'index'])->name('index')->middleware('can:XEM-CHUC-VU');
            Route::get('create', [RoleController::class, 'create'])->name('create')->middleware('can:THEM-CHUC-VU');
            Route::post('store', [RoleController::class, 'store'])->name('store')->middleware('can:THEM-CHUC-VU');
            Route::get('edit/{id}', [RoleController::class, 'edit'])->name('edit')->middleware('can:SUA-CHUC-VU');
            Route::post('update/{id}', [RoleController::class, 'update'])->name('update')->middleware('can:SUA-CHUC-VU');
            Route::get('delete/{id}', [RoleController::class, 'delete'])->name('delete')->middleware('can:XOA-CHUC-VU');
        });
    });

    // voucher
    Route::name('voucher.')->middleware('AdminLogin')->prefix('voucher/')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('index')->middleware('can:XEM-VOUCHER');
        Route::get('create', [SaleController::class, 'create'])->name('create')->middleware('can:THEM-VOUCHER');
        Route::post('store', [SaleController::class, 'store'])->name('store')->middleware('can:THEM-VOUCHER');
        Route::get('edit/{id}', [SaleController::class, 'edit'])->name('edit')->middleware('can:SUA-VOUCHER');
        Route::post('update/{id}', [SaleController::class, 'update'])->name('update')->middleware('can:SUA-VOUCHER');
        Route::get('delete/{id}', [SaleController::class, 'delete'])->name('delete')->middleware('can:XOA-VOUCHER');
    });
    //Seller
    Route::name('seller.')->middleware('AdminLogin')->prefix('seller/')->group(function () {
        Route::get('', [UserController::class, 'getSeller'])->name('index')->middleware('can:XEM-SALLER');
    });

    Route::name('cate_blog.')->prefix('cate_blog/')->group(function () {
        Route::get('', [CategoriBlogController::class, 'index'])->name('index')->middleware('can:XEM-LOAI-BAI-VIET');
        Route::get('create', [CategoriBlogController::class, 'create'])->name('create')->middleware('can:THEM-LOAI-BAI-VIET');
        Route::post('store', [CategoriBlogController::class, 'store'])->name('store')->middleware('can:THEM-LOAI-BAI-VIET');
        Route::get('edit/{id}', [CategoriBlogController::class, 'edit'])->name('edit')->middleware('can:SUA-LOAI-BAI-VIET');
        Route::post('update/{id}', [CategoriBlogController::class, 'update'])->name('update')->middleware('can:SUA-LOAI-BAI-VIET');
        Route::get('delete/{id}', [CategoriBlogController::class, 'delete'])->name('delete')->middleware('can:XOA-LOAI-BAI-VIET'); // todo xóa khi ko có hóa đơn
    });
     // bài viết
    Route::name('blogs.')->prefix('blogs/')->group(function () {
        Route::get('', [BlogsController::class, 'index'])->name('index')->middleware('can:XEM-BAI-VIET');
        Route::get('create', [BlogsController::class, 'create'])->name('create')->middleware('can:THEM-BAI-VIET');
        Route::post('store', [BlogsController::class, 'store'])->name('store')->middleware('can:THEM-BAI-VIET');
        Route::get('edit/{id}', [BlogsController::class, 'edit'])->name('edit')->middleware('can:SUA-BAI-VIET');
        Route::post('update/{id}', [BlogsController::class, 'update'])->name('update')->middleware('can:SUA-BAI-VIET');
        Route::get('delete/{id}', [BlogsController::class, 'delete'])->name('delete')->middleware('can:XOA-BAI-VIET'); // todo xóa khi ko có hóa đơn
    });
    Route::name('contact.')->prefix('contact/')->group(function () {
        Route::get('', [ContactContrller::class, 'index'])->name('index')->middleware('can:XEM-LIEN-HE');
        Route::get('edit/{id}', [ContactContrller::class, 'edit'])->name('edit')->middleware('can:SUA-LIEN-HE');
        Route::post('update/{id}', [ContactContrller::class, 'update'])->name('update')->middleware('can:SUA-LIEN-HE');
    });
    Route::name('orders.')->prefix('orders/')->group(function () {
        Route::get('', [OrderContrller::class, 'index'])->name('index')->middleware('can:XEM-DON-HANG');
        Route::get('edit/{id}', [OrderContrller::class, 'edit'])->name('edit')->middleware('can:SUA-DON-HANG');
        Route::post('update/{id}', [OrderContrller::class, 'update'])->name('update')->middleware('can:SUA-DON-HANG');
        // Route::get('delete/{id}', [BlogsController::class, 'delete'])->name('delete'); // todo xóa khi ko có hóa đơn
    });
});

Route::get('/', [ClientController::class, 'index'])->name('home');
Route::get('products', [ClientController::class, 'products'])->name('products');
Route::get('product/{slug}', [ClientController::class, 'productDetail'])->name('product');
Route::get('blogs', [ClientController::class, 'blogs'])->name('blogs');
Route::get('lien-he', [ClientController::class, 'contact'])->name('contact');
Route::post('lien-he', [ClientController::class, 'sentContact'])->name('sentContact');
Route::get('blog/{slug}', [ClientController::class, 'blog'])->name('blog');

// check login
Route::get('carts', [ClientController::class, 'carts'])->middleware('clientLogin')->name('carts');
Route::get('payment', [ClientController::class, 'payment'])->middleware('clientLogin')->name('payment');
Route::get('payment-vnpay', [ClientController::class, 'savePayment'])->middleware('clientLogin')->name('payment-vnpay');
Route::post('check-voucher', [ClientController::class, 'checkVoucher'])->middleware('clientLogin');
Route::get('profile', [ClientController::class, 'profile'])->middleware('clientLogin')->name('profile');
Route::post('profile', [ClientController::class, 'UpdateProfile'])->middleware('clientLogin')->name('UpdateProfile');
Route::get('order', [ClientController::class, 'order'])->middleware('clientLogin')->name('order');
Route::get('order/{id}', [ClientController::class, 'order_detail'])->middleware('clientLogin')->name('order_detail');
Route::post('update-carts', [ClientController::class, 'updateCarts'])->middleware('clientLogin')->name('updateCarts');
Route::post('checkout', [ClientController::class, 'checkout'])->middleware('clientLogin')->name('checkout');
Route::post('api/orders/update/{id}', [OrderContrller::class, 'update'])->middleware('clientLogin');
Route::post('comment', [ClientController::class, 'createComment'])->middleware('clientLogin')->name('createComment');


// nhớ check user quyền đăng nhập người dùng
Route::name('api.')->middleware('ApiclientLogin')->prefix('api/')->group(function () {
    // id sản phẩm|| có sô lượng sp
    Route::post('add-to-cart/{product_id}', [ClientController::class, 'addCart'])->name('addCart');
    // id sản phẩm|| sl sản phẩm mặc định là 1
    Route::post('update-product-carts/{product_id}', [ClientController::class, 'updateProductCarts'])->name('updateProductCarts');
    Route::get('add-cart/{product_id}', [ClientController::class, 'addCart'])->name('addCart');
  
    Route::get('remove-cart/{product_id}', [ClientController::class, 'removeCart'])->name('removeCart');
});

Route::fallback(function () {
    return view("errors.404");
});
