<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'creator_id' => 1,
            'title' => fake()->sentence(3, true),
            'short_desc' => fake()->sentence(10, true),
            'full_desc' => fake()->paragraphs(3, true),
            'deadline' => fake()->dateTimeBetween('tomorrow', '+60 days'),
            'funding_goal' => fake()->numberBetween(1000, 100000),
            'status' => fake()->randomElement(['pending', 'active', 'achieved', 'failed']),
            'image' => 'project-images/' . fake()->image('public/storage/project-images', 640, 480, null, false),
        ];
    }
}
