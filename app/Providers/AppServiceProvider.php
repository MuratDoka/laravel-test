<?php

namespace App\Providers;

use App\Services\PriceCalculator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PriceCalculator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', fn($amount) => "<?php echo '£' . number_format($amount, 2); ?>");
    }
}
