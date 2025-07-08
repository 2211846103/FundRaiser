<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\DeviceLog;
use App\Models\Donation;
use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showAnalytics(Request $request)
    {
        $projects = Project::select('id', 'title')->get();
        $deviceLogs = DeviceLog::all();
        $dates = null;
        $totals = null;
        $selected = null;

        if ($request->has('id')) {
            $projectId = $request->input('id');
            $selected = Project::with('tiers.donations')->findOrFail($projectId);
            $fundingData = Donation::whereHas('tier', function ($query) use ($projectId) {
                $query->where('project_id', $projectId);
            })
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

            $dates = $fundingData->pluck('date');
            $totals = $fundingData->pluck('total');
        }

        return view('reporting.analytics', compact(['projects', 'selected', 'deviceLogs', 'dates', 'totals']));
    }

    public function storeReport(ReportRequest $request)
    {
        $data = $request->validated();
        
        $report = Report::create([
            'user_id' => auth()->id(),
            'project_id' => $data['project_id'],
            'reason' => $data['reason'],
            'details' => $data['details']
        ]);

        return redirect()->back();
    }
}
