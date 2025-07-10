<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
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
        ];
    }

    public function comment()
    {
        return $this->state(fn () => [
            'comment_id' => Comment::inRandomOrder()->first()->id ?? Comment::factory()
        ]);
    }
    public function project()
    {
        return $this->state(fn () => [
            'project_id' => Project::inRandomOrder()->first()->id ?? Project::factory()
        ]);
    }
}
