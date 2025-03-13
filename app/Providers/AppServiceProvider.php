<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;
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
    // Compartir variables globales con todas las vistas
    View::share([
        'APP_VERSION' => env('APP_VERSION')
    ]);

    // Mantener la configuración de Vite
    Vite::useStyleTagAttributes(function (?string $src, string $url, ?array $chunk, ?array $manifest) {
        if ($src !== null) {
            return [
                'class' => preg_match("/(resources\/assets\/vendor\/scss\/(rtl\/)?core)-?.*/i", $src) ? 'template-customizer-core-css' :
                          (preg_match("/(resources\/assets\/vendor\/scss\/(rtl\/)?theme)-?.*/i", $src) ? 'template-customizer-theme-css' : '')
            ];
        }
        return [];
    });
}
}