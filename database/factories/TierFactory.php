<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tier>
 */
class TierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::inRandomOrder()->first()->id ?? Project::factory(),
            'amount' => fake()->numberBetween(5, 100),
            'title' => fake()->sentence(2, true),
            'desc' => fake()->sentence(6, true)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($tier) {
            Donation::factory(fake()->numberBetween(20, 50))->create([
                'tier_id' => $tier->id
            ]);
        });
    }
}
