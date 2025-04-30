<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceProvider>
 */
class ServiceProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'short_description' => $this->faker->sentence(),
            'logo' => $this->faker->optional()->randomElement([
                null,
                'https://placehold.co/300x300?text=Logo',
            ]),
            'category_id' => Category::factory(),
        ];
    }
}
