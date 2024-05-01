<?php

namespace App\Providers;

use App\Models\System;
use session;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Categories;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $serviceBinding = [
        'App\Repositories\Interface\UserRepositoryInterface' => 'App\Repositories\UserRepository',
        'App\Repositories\Interface\UserCatelogueRepositoryInterface' => 'App\Repositories\UserCatelogueRepository',

        'App\Repositories\Interface\PostCategoryRepositoryInterface' => 'App\Repositories\PostCategoryRepository',

        'App\Repositories\Interface\PostRepositoryInterface' => 'App\Repositories\PostRepository',

        'App\Repositories\Interface\MaterialRepositoryInterface' => 'App\Repositories\MaterialRepository',

        'App\Repositories\Interface\ProductCategoryRepositoryInterface' => 'App\Repositories\ProductCategoryRepository',

        'App\Repositories\Interface\ProductRepositoryInterface' => 'App\Repositories\ProductRepository',

        'App\Repositories\Interface\SinglePageRepositoryInterface' => 'App\Repositories\SinglePageRepository',
        'App\Repositories\Interface\SystemRepositoryInterface' => 'App\Repositories\SystemRepository',

        'App\Repositories\Interface\DistrictRepositoryInterface' => 'App\Repositories\DistrictRepository',
        'App\Repositories\Interface\AdminRepositoryInterface' => 'App\Repositories\AdminRepository',
        'App\Repositories\Interface\ImageColorProductRepositoryInterface' => 'App\Repositories\ImageColorProductRepository',
        'App\Repositories\Interface\RepositoryInterface' => 'App\Repositories\Repository',
        'App\Repositories\Interface\WardRepositoryInterface' => 'App\Repositories\WardRepository',
    ];
    /**
     * Register any application services.
     */

    public function register(): void
    {
        foreach ($this->serviceBinding as $key => $value) {
            $this->app->bind($key, $value);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useBootstrapFour();
        View::composer('*', function ($view) {
            $name = '';
            if (Auth::check()) {
                $name = Auth::user()->name;
            }
            $menus = Categories::where([['parent_id', '=', 0], ['publish', '=', 1]])->get();
            $system = System::get();
            $product = Product::where([['publish', '=', 1]])->get();
            $view->with('menus', $menus);
            $view->with('product', $product);
            $view->with('name', $name);
            $sum = 0;

            $cart = session()->get('carts', []);
            foreach ($cart as $key => $quantity) {
                $sum += $quantity['quantity'];
            }
            $view->with('quantity', $sum);
            $view->with('cart', $cart);
        });
    }
}
