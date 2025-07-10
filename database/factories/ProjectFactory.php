<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Report;
use App\Models\Tag;
use App\Models\Tier;
use App\Models\User;
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
            'creator_id' => User::inRandomOrder()->where('role', 'creator')->first()->id ?? User::factory()->creator(),
            'title' => fake()->sentence(3, true),
            'short_desc' => fake()->sentence(10, true),
            'full_desc' => fake()->paragraphs(3, true),
            'deadline' => fake()->dateTimeBetween('tomorrow', '+60 days'),
            'funding_goal' => fake()->numberBetween(1000, 100000),
            'status' => 'active',
            'image' => 'https://picsum.photos/640/400',
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return ['status' => 'active'];
        });
    }
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return ['status' => 'pending'];
        });
    }
    public function achieved()
    {
        return $this->state(function (array $attributes) {
            return ['status' => 'achieved'];
        });
    }
    public function failed()
    {
        return $this->state(function (array $attributes) {
            return ['status' => 'failed'];
        });
    }
    
    public function configure()
    {
        return $this->afterCreating(function ($project) {
            Tier::factory()->count(fake()->numberBetween(2, 5))->create([
                'project_id' => $project->id,
            ]);

            $tags = Tag::inRandomOrder()->take(fake()->numberBetween(2, 4))->pluck('id');
            if ($tags->count() < 2) {
                $newTags = Tag::factory(3)->create();
                $tags = $newTags->pluck('id');
            }
            $project->tags()->attach($tags);

            Comment::factory()->count(fake()->numberBetween(1, 7))->create([
                'project_id' => $project->id
            ]);

            Like::factory()->count(fake()->numberBetween(0, 100))->create([
                'project_id' => $project->id
            ]);

            Report::factory()->count(fake()->numberBetween(0, 3))->create([
                'project_id' => $project->id
            ]);
        });
    }
}
