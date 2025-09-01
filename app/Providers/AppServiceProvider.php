<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Genre;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-books', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('create-vouchers', function ($user) {
            return $user->role === 'admin';
        });

        View::composer('partials.header', function ($view) {
            $view->with('genres', Genre::all());
        });

        Paginator::useBootstrapFive();
    }
}
