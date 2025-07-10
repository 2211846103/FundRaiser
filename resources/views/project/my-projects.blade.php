@php
    use \Illuminate\Support\Carbon;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects - FundRaiser</title>
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-alt-navigation />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">My Projects</h1>
                <p class="text-gray-600">Manage and track all your FundRaisering projects.</p>
            </div>
            <a href="{{ route('projects.create') }}" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                Create New Project
            </a>
        </div>

        <!-- Projects List -->
        <div class="space-y-6">
            @foreach ($projects as $project)
                @if ($project->status == 'active')
                    <x-project-card.active.creator :project="$project"/>
                @elseif ($project->status == 'pending')
                    <x-project-card.pending.creator :project="$project" />
                @elseif ($project->status == 'achieved')
                    <x-project-card.achieved.creator :project="$project" />
                @elseif ($project->status == 'deactivated')
                    <x-project-card.deactivated.creator :project="$project" />
                @elseif ($project->status == 'rejected')
                    <x-project-card.rejected.creator :project="$project" />
                @else
                    <x-project-card.failed.creator :project="$project" />
                @endif
            @endforeach
        </div>
        {{ $projects->links() }}
        <!-- Pagination -->
        <!--div class="flex justify-center mt-8">
            <nav class="flex items-center space-x-2">
                <button class="px-3 py-2 text-gray-500 hover:text-gray-700 disabled:opacity-50" disabled>
                    Previous
                </button>
                <button class="px-3 py-2 bg-primary text-white rounded">1</button>
                <button class="px-3 py-2 text-gray-700 hover:text-primary">2</button>
                <button class="px-3 py-2 text-gray-700 hover:text-primary">
                    Next
                </button>
            </nav>
        </div-->
    </div>

    <!-- Post Update Modal -->
    <div id="updateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Post Project Update</h3>
                <button onclick="closeUpdateModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Update Title</label>
                <input type="text" placeholder="Enter update title..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Update Content</label>
                <textarea rows="8" placeholder="Share your progress, milestones, or important news with your backers..." 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Visibility</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option>Public - Visible to everyone</option>
                    <option>Backers Only - Visible to backers only</option>
                </select>
            </div>
            
            <div class="flex gap-3">
                <button onclick="closeUpdateModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="publishUpdate()" class="flex-1 bg-primary text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                    Publish Update
                </button>
            </div>
        </div>
    </div>

    <script>
        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const projectMenus = document.querySelectorAll('[id^="projectMenu"]');
            
            if (!event.target.closest('button')) {
                userMenu.classList.add('hidden');
                projectMenus.forEach(menu => menu.classList.add('hidden'));
            }
        });
    </script>
</body>
</html>