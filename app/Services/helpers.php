<?php

use App\Filters\FilterManager;

if(!function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->items();
    }
}
