<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckProjectDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:check-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all projects and mark those with expired deadlines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $projects = Project::all();

        foreach ($projects as $project) {

            $raised = $project->tiers->flatMap->donations->sum('amount');
            $deadline = Carbon::parse($project->deadline);
            
            if ($raised < $project->funding_goal && $deadline->isPast()) {
                $project->refund();
                $project->tiers->flatMap->donations->map->backer->notifyFail($project);
            }
            
        }

        return Command::SUCCESS;
    }
}
