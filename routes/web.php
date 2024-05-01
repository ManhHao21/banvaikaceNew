<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\GroupController;
use App\Http\Controllers\Backend\PostCategoryController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\SinglePageController;
use App\Http\Controllers\Backend\SystemController;
use App\Http\Controllers\Backend\UserCatelogueController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Fontend\AuthController as LoginController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MaterialController;
use App\Http\Controllers\Backend\OptionController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Fontend\CartController;
use App\Http\Controllers\Fontend\CategoryController;
use App\Http\Controllers\Fontend\CheckoutController;
use App\Http\Controllers\Fontend\DetailController;
use App\Http\Controllers\Fontend\HomeController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Ajax\DashBoardController as DashboardAjaxController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//route admin

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/login', [AuthController::class, 'login'])
            ->name('login')
            ->middleware('guest:admin');
        Route::get('/logout', [AuthController::class, 'logout'])
            ->name('logout')
            ->middleware('auth:admin');
        Route::Post('/login', [AuthController::class, 'postLogin'])
            ->name('post.login')
            ->middleware('guest:admin');
        Route::get('/', [DashboardController::class, 'index'])
            ->name('index')
            ->middleware('auth:admin');
        Route::resource('quantri', AdminController::class);
        Route::resource('users', UserController::class);
        Route::resource('postcategory', PostCategoryController::class);
        Route::resource('post', PostController::class);
        Route::resource('singlepage', SinglePageController::class);
        Route::resource('catelogue', UserCatelogueController::class);
        Route::resource('group', GroupController::class);
        Route::post('user/search', [AdminController::class, 'search'])->name('user.search');
        Route::resource('category', CategoriesController::class);
        Route::resource('material', MaterialController::class);
        Route::resource('product', ProductController::class);
        Route::prefix('option')
            ->name('option.')
            ->group(function () {
                Route::get('/catelog', [OptionController::class, 'catelog'])->name('catelog');
                Route::post('/catelog', [OptionController::class, 'postCatelog'])->name('postCatelog');
                Route::get('/product', [OptionController::class, 'getProduct'])->name('getProduct');
                Route::post('/product', [OptionController::class, 'getProductPost'])->name('getProductPost');
            });
        Route::prefix('system')
            ->name('system.')
            ->group(function () {
                Route::get('/', [SystemController::class, 'system'])->name('system');
                Route::post('/create', [SystemController::class, 'store'])->name('create');
            });
    })
    ->middleware('auth:admin');

Route::post('/import/excel', [ExcelController::class, 'import'])->name('import.excel');

Route::name('web.')
    ->group(function () {
        //import
        Route::get('/', [HomeController::class, 'index'])->name('home');
        //Auth Fontend
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'postLogin'])->name('login.user');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/register', [LoginController::class, 'logoregisterut'])->name('register');

        Route::get('/product/{slug}', [DetailController::class, 'getProductDetail'])->name('productDetail');
        Route::post('/post/ProductDetail', [DetailController::class, 'postProductDetail'])->name('post.productDetail');
        Route::get('/cart-order', [CartController::class, 'cart'])->name('cart-order');
        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::get('/category/{slug}', [CategoryController::class, 'getCategory'])->name('category');
        Route::get('/load/category/{slug}', [CategoryController::class, 'loadCategory'])->name('load.category');
    })
    ->middleware(['web', 'auth']);
//Ajax
Route::get('/ajax/address', [LocationController::class, 'getAddress'])->name('address.province');
Route::POST('/ajax/dashboard/changeStatus', [DashboardAjaxController::class, 'changeStatus'])->name('.ajax.dashboard.changeStatus');
Route::POST('/ajax/dashboard/changeStatusPublicAll', [DashboardAjaxController::class, 'changeStatusPublicAll'])->name('.ajax.dashboard.changeStatusPublicAll');
Route::POST('/ajax/comment/{id}', [LocationController::class, 'getComment'])->name('comment');
Route::name('Ajax.')->group(function () {
    Route::get('/cart/{id}', [CartController::class, 'getCart'])->name('getCart');
    Route::post('/delete/cart', [CartController::class, 'deleteTable']);
    Route::post('/update/cart', [CartController::class, 'updateTable']);
    Route::get('{slug}', [CategoryController::class, 'getCategory'])->name('getCategory');
    Route::POST('/ajax/cart', [LocationController::class, 'getComment'])->name('comment');
});
