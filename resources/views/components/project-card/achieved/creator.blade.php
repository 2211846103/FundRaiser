@php
    use \Illuminate\Support\Carbon;
    
    $donations = $project->tiers->flatMap->donations;
    $raised = $donations->sum('amount');
    $backers = $donations->map->backer;
    $fund_percentage = round($raised * 100 / $project->funding_goal);
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
            <img src="{{ asset('storage/'.$project->image) }}" alt="Project" class="w-20 h-20 rounded-lg object-cover">
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                    <h3 class="text-xl font-semibold">{{ $project->title }}</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Achieved Goal</span>
                </div>
                <p class="text-gray-600 mb-3">{{ $project->short_desc }}</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Raised:</span>
                        <span class="font-medium">${{ $raised }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Goal:</span>
                        <span class="font-medium">${{ $project->funding_goal }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Backers:</span>
                        <span class="font-medium">{{ $backers->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Success:</span>
                        <span class="font-medium text-green-600">{{ $fund_percentage }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
        <p class="text-sm text-green-800">
            <strong>Successfully Funded!</strong> Your project exceeded its goal by {{ $fund_percentage - 100 }}%. Time to fulfill rewards and keep backers updated.
        </p>
    </div>
    
    <div class="flex items-center justify-between border-t pt-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('projects.show', $project) }}" class="text-primary hover:text-blue-600 font-medium">View Project</a>
        </div>
    </div>
</div>