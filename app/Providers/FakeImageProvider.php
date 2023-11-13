<?php

namespace App\Providers;

use App\Testing\FakerImageService;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakeImageProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, function (){
            $faker = Factory::create();
            $faker->addProvider(new FakerImageService($faker));
            return $faker;
        });
    }
}
