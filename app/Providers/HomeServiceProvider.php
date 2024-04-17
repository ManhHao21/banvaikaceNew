<?php

namespace App\Providers;

use App\Models\System;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class HomeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $keywords = [];
            $contents = [];
            $systems = System::all();
            foreach ($systems as $key => $value) {
                $keywords[] = $value['keyword'];
                $contents[] = $value['content'];
            }
            $result = array_combine($keywords, $contents);

            // Hiển thị mảng kết quả
            $view->with('result', $result);
        });
    }

}
