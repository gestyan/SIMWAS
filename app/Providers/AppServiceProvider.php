<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        Gate::define('sekretaris', function (User $user) {
            return $user->is_sekma == true || $user->is_sekwil == true;
        });

        Gate::define('inspektur', function (User $user) {
            return $user->is_aktif == true;
        });

        Gate::define('analis_sdm', function (User $user) {
            return $user->is_analissdm == true;
        });
    }
}
