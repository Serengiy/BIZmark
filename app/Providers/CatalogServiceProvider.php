<?php

namespace App\Providers;

use App\Filters\ActorFilter;
use App\Filters\FilterManager;
use App\Filters\GenreFilter;
use App\Filters\ProducerFilter;
use App\Filters\RatingFilter;
use App\Filters\ReleaseFilter;
use App\Models\Producer;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app(FilterManager::class)->registerFilters([
            new ActorFilter(),
            new ProducerFilter(),
            new RatingFilter(),
            new ReleaseFilter(),
            new GenreFilter(),
        ]);
    }
}
