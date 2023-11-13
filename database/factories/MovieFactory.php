<?php

namespace Database\Factories;

use App\Models\Producer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->words(rand(1,3), 1),
            'producer_id' => Producer::find(rand(1,5)),
            'description' => $this->faker->realText(),
            'released_at' => $this->faker->dateTimeBetween('-30 years', 'now'),
            'preview' => $this->faker->storeTestImages(
                'poster',
                'images/poster'
            )
        ];
    }
}
