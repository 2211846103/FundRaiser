<?php

namespace Database\Seeders;

use App\Models\DeviceLog;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(15)->backer()->create();
        User::factory()->count(7)->creator()->create();
        User::factory()->count(2)->admin()->create();
        User::factory()->count(4)->banned()->create();
        Project::factory()->count(10)->create();
        DeviceLog::factory()->count(50)->create();
    }
}
