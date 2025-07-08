@php
    use \Illuminate\Support\Carbon;

    $donations = $project->tiers->flatMap->donations;
    $raised = $donations->sum('amount');
    $backers = $donations->map->backer;
    $fund_percentage = round(min(100, $raised * 100 / $project->funding_goal));
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
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Active</span>
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
                        <span class="text-gray-500">Days Left:</span>
                        <span class="font-medium">{{ $daysLeft }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative">
            <button onclick="toggleProjectMenu({{ $project->id }})" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
            </button>
            <div id="projectMenu{{ $project->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10">
                <form action="{{ route('projects.destroy', $project) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Delete Project</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="mb-4">
        <div class="flex justify-between text-sm text-gray-600 mb-1">
            <span>{{ $fund_percentage }}% funded</span>
            <span>${{ $project->funding_goal - $raised }} to go</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-secondary h-2 rounded-full" style="width: {{ $fund_percentage }}%"></div>
        </div>
    </div>
    
    <div class="flex items-center justify-between border-t pt-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('projects.show', $project) }}" class="text-primary hover:text-blue-600 font-medium">View Project</a>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('projects.edit', $project) }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm">
                Edit
            </a>
        </div>
    </div>
</div>
<script>
    function toggleProjectMenu(id) {
        const menu = document.getElementById(`projectMenu${id}`);
        menu.classList.toggle('hidden');
    }
</script>