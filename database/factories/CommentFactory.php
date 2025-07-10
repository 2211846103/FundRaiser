<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'parent_id' => null,
            'content' => fake()->sentence(6, true)
        ];
    }

    public function reply()
    {
        return $this->state(fn () => [
            'parent_id' => Comment::factory()
        ]);
    }
    public function main()
    {
        return $this->state(fn () => [
            'parent_id' => null
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function ($comment) {
            Like::factory()->count(fake()->numberBetween(0, 100))->create([
                'comment_id' => $comment->id
            ]);
        });
    }
}
