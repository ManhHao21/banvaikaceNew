<?php

namespace App\Providers;

use session;
use App\Models\Cart;
use App\Models\Categories;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $serviceBinding = [
        "App\Repositories\Interface\UserRepositoryInterface" => "App\Repositories\UserRepository",
        "App\Repositories\Interface\UserCatelogueRepositoryInterface" => "App\Repositories\UserCatelogueRepository",

        "App\Services\Interface\UserServiceInterface" => "App\Services\UserService",
        "App\Services\Interface\UserCatelogueServiceInterface" => "App\Services\UserCatelogueService",

        "App\Repositories\Interface\PostCategoryRepositoryInterface" => "App\Repositories\PostCategoryRepository",
        "App\Services\Interface\PostCategoryServiceInterface" => "App\Services\PostCategoryService",

        "App\Repositories\Interface\PostRepositoryInterface" => "App\Repositories\PostRepository",
        "App\Services\Interface\PostServiceInterface" => "App\Services\PostService",

        "App\Repositories\Interface\MaterialRepositoryInterface" => "App\Repositories\MaterialRepository",
        "App\Services\Interface\MaterialServiceInterface" => "App\Services\MaterialService",

        "App\Repositories\Interface\ProductCategoryRepositoryInterface" => "App\Repositories\ProductCategoryRepository",
        "App\Services\Interface\ProductCategoryServiceInterface" => "App\Services\ProductCategoryService",

        "App\Repositories\Interface\ProductRepositoryInterface" => "App\Repositories\ProductRepository",
        "App\Services\Interface\ProductServiceInterface" => "App\Services\ProductService",

        "App\Repositories\Interface\SinglePageRepositoryInterface" => "App\Repositories\SinglePageRepository",
        "App\Services\Interface\SinglePageServiceInterface" => "App\Services\SinglePageService",
        "App\Repositories\Interface\SystemRepositoryInterface" => "App\Repositories\SystemRepository",
        "App\Services\Interface\SystemServiceInterface" => "App\Services\SystemService",

        "App\Repositories\Interface\DistrictRepositoryInterface" => "App\Repositories\DistrictRepository",
        "App\Repositories\Interface\AdminRepositoryInterface" => "App\Repositories\AdminRepository",
        "App\Repositories\Interface\ProvinceRepositoryInterface" => "App\Repositories\ProvinceRepository",
        "App\Repositories\Interface\WardRepositoryInterface" => "App\Repositories\WardRepository"
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
            $name = "";
            if (Auth::check()) {
                $name = Auth::user()->name;
            }
            $menus = Categories::where('parent_id', '=', 0)->get();
            $view->with('menus', $menus);
            $view->with('name', $name);
            $sum = 0;

            $quantitys = session()->get("carts", []);
            foreach ($quantitys as $key => $quantity) {
                $sum += $quantity['quantity'];
            }
            $view->with('quantity', $sum);
        });
    }
}