<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public const HOME = '/user/dashboard';

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::middleware(['web', 'auth', 'role:admin'])
        ->prefix('admin')
        ->as('admin.')
        ->group(base_path('routes/admin.php'));

        Blade::directive('currency', function ( $expression ) { return "Rp. <?php echo number_format($expression,0,',','.'); ?>"; });
    }
}
