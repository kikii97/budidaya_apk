<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


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
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        Carbon::setLocale('id');

        // View Composer global untuk notifikasi pembudidaya
        View::composer('*', function ($view) {
        $user = Auth::guard('pembudidaya')->user();
        $notifications = $user ? $user->unreadNotifications : collect();
        $view->with('notifications', $notifications);
    });
    }
}