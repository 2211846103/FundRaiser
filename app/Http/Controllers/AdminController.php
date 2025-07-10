<?php

namespace App\Http\Controllers;

use App\Models\AdminLog;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approve(Project $project)
    {
        $project->update([
            'status' => 'active'
        ]);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'approved',
            'user_affected_id' => null,
            'project_affected_id' => $project->id,
        ]);

        return redirect()->back();
    }

    public function reject(Project $project)
    {
        $project->update([
            'status' => 'failed'
        ]);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'declined',
            'user_affected_id' => null,
            'project_affected_id' => $project->id,
        ]);

        return redirect()->back();
    }

    public function suspend(User $user)
    {
        
        $user->update([
            'is_banned' => true
        ]);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'banned',
            'user_affected_id' => $user->id,
            'project_affected_id' => null,
        ]);

        return redirect()->back();
    }

    public function unsuspend(User $user)
    {
        
        $user->update([
            'is_banned' => false
        ]);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'unbanned',
            'user_affected_id' => $user->id,
            'project_affected_id' => null,
        ]);

        return redirect()->back();
    }

    public function deactivate(Report $report)
    {
        $report->project->update([
            'status' => 'failed'
        ]);

        $report->project->refund();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'deactivated',
            'user_affected_id' => null,
            'project_affected_id' => $report->project->id,
        ]);

        foreach ($report->project->tiers->flatMap->donations->map->backer->unique('id') as $backer) {
            $backer->notifyFail($report->project);
        }

        $report->update([
            'is_resolved' => true,
            'resolve_date' => today()
        ]);

        $report->project->reports()->update([
            'is_resolved' => true,
            'resolve_date' => now()
        ]);

        return redirect()->back();
    }

    public function resolve(Report $report)
    {
        $report->update([
            'is_resolved' => true,
            'resolve_date' => now()
        ]);

        return redirect()->back();
    }
}
