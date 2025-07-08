@php
    use \Illuminate\Support\Carbon;
    $tier = $donation->tier;
    $project = $tier->project;
    $fund_percentage = round($project->tiers->flatMap->donations->sum('amount') * 100 / $donation->tier->project->funding_goal);
    $deadline = Carbon::parse($project->deadline);
    $now = Carbon::now();
    $daysLeft = round($now->diffInDays($deadline, false));
    if ($daysLeft < 0) {
        $daysLeft = 0;
    }
@endphp

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-start space-x-4">
            <img src="{{ $project->image }}" alt="Project" class="w-16 h-16 rounded-lg object-cover">
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                    <h3 class="text-lg font-semibold">{{ $project->title }}</h3>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Active</span>
                </div>
                <p class="text-gray-600 text-sm mb-2">{{ $project->short_desc }}</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Pledged:</span>
                        <span class="font-medium">${{ $donation->amount }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Reward:</span>
                        <span class="font-medium">{{ $tier->title }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right">
            <div class="text-2xl font-bold text-gray-900">${{ $donation->amount }}</div>
            <div class="text-sm text-gray-500">Contribution</div>
        </div>
    </div>
    
    <div class="mb-4">
        <div class="flex justify-between text-sm text-gray-600 mb-1">
            <span>Project Progress: {{ $fund_percentage }}% funded</span>
            <span>{{ $daysLeft }} days left</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-secondary h-2 rounded-full" style="width: {{ $fund_percentage }}%"></div>
        </div>
    </div>
    
    <div class="flex items-center justify-between border-t pt-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('projects.show', $project) }}" class="text-primary hover:text-blue-600 font-medium">View Project</a>
        </div>
    </div>
</div>