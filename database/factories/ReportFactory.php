<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'project_id' => Project::inRandomOrder()
                                    ->where('status', 'active')
                                    ->first()->id ?? Project::factory()->active(),
            'reason' => fake()->randomElement(['inappropriate', 'fraud', 'misleading', 'copyright', 'other']),
            'details' => fake()->sentence(6, true),
        ];
    }

    public function resolved()
    {
        return $this->state(fn () => [
            'is_resolved' => true,
            'resolve_date' => fake()->dateTimeBetween('-60 days', 'now')
        ]);
    }
    public function open()
    {
        return $this->state(fn () => [
            'is_resolved' => false,
            'resolve_date' => null
        ]);
    }
}
