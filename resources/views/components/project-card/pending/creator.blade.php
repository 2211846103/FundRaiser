<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-start space-x-4">
            <img src="{{ asset('storage/'.$project->image) }}" alt="Project" class="w-20 h-20 rounded-lg object-cover">
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                    <h3 class="text-xl font-semibold">{{ $project->title }}</h3>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>
                </div>
                <p class="text-gray-600 mb-3">{{ $project->short_desc }}</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Goal:</span>
                        <span class="font-medium">${{ $project->funding_goal }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Deadline:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($project->deadline)->format('Y-m-d') }}</span>
                    </div>
                    @if (!$project->tags->isEmpty())
                        <div>
                            <span class="text-gray-500">Tags:</span>
                            @foreach ($project->tags as $index => $tag)
                                <span class="font-medium">{{ $tag->name }}</span>@if(!$loop->last),@endif
                            @endforeach
                        </div>
                    @endif
                    <div>
                        <span class="text-gray-500">Status:</span>
                        <span class="font-medium text-yellow-600">Pending</span>
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
    
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
        <p class="text-sm text-yellow-800">
            <strong>Pending:</strong> Your project is being reviewed by our team. You'll receive an update within 2-3 business days.
        </p>
    </div>
</div>
<script>
    function toggleProjectMenu(id) {
        const menu = document.getElementById(`projectMenu${id}`);
        menu.classList.toggle('hidden');
    }
</script>