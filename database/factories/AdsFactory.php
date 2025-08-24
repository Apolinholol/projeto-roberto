<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
 use HasFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ads>
 */
class AdsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(),
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id
            ?? \App\Models\Category::factory()->create()->id
        ];
    }
}