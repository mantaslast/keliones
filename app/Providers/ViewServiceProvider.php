<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;
use Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.shop.app', function($view) {
            $data = [
                'categories' => Category::all(),
            ];
            if (Auth::user()) {
                $data['api_token'] = Auth::user()->api_token;
            }
            
            $view->with($data);
        });

        view()->composer('layouts.admin.adminLayout', function($view) {
            if (Auth::user()) {
                $data['api_token'] = Auth::user()->api_token;
                $view->with($data);
            };
        });
    }
}
