<?php

namespace App\Providers;

use App\Models\Seccion;
use App\Observers\SeccionObserver;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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

     Blade::if('activeRole', function ($roles) {
        // Verifica si el rol en la sesión coincide con el que pedimos
        $activeRole = session('active_role');
        // 2. Convertimos el string 'ADMIN|DOCENTE' en un array ['ADMIN', 'DOCENTE']
        $allowedRoles = explode('|', $roles);

        // 3. Verificamos si el rol actual está en la lista permitida
        return in_array($activeRole, $allowedRoles);
    });
        //
        Paginator::useBootstrapFive();
        // Seccion::observe(SeccionObserver::class);
    }
     /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
