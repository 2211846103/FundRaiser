<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Projects - FundRaiser</title>

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
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Explore Projects</h1>
            <p class="text-gray-600">Discover amazing projects and support creators you love.</p>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input id="search-input" type="text" placeholder="Search projects..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                <select id="status-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="achieved">Funded</option>
                </select>
                <button class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Search
                </button>
            </div>
        </div>

        <!-- Projects Grid -->
        <div id="project-list" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($projects as $project)
                @if ($project->status == 'achieved')
                    <div class="project-card"
                        data-title="{{ strtolower($project->title) }}"
                        data-tags="{{ strtolower(implode(',', $project->tags->pluck('name')->toArray())) }}"
                        data-status="{{ strtolower($project->status) }}">
                        <x-project-card.achieved.explore :project="$project" />
                    </div>
                @elseif ($project->status == 'active')
                    <div class="project-card"
                        data-title="{{ strtolower($project->title) }}"
                        data-tags="{{ strtolower(implode(',', $project->tags->pluck('name')->toArray())) }}"
                        data-status="{{ strtolower($project->status) }}">
                        <x-project-card.active.explore :project="$project" />
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Pagination -->
        {{ $projects->links() }}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
        });

        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('search-input');
            const statusFilter = document.getElementById('status-filter');
            const cards = document.querySelectorAll('.project-card');
            function filterProjects() {
                const keyword = input.value.toLowerCase();
                const selectedStatus = statusFilter.value.toLowerCase();
                cards.forEach(card => {
                    const title = card.getAttribute('data-title');
                    const tags = card.getAttribute('data-tags');
                    const status = card.getAttribute('data-status');
                    const matchesSearch = title.includes(keyword) || tags.includes(keyword);
                    const matchesStatus = !selectedStatus || status === selectedStatus;
                    card.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                });
            }
            input.addEventListener('input', filterProjects);
            statusFilter.addEventListener('change', filterProjects);
        });
    </script>
</body>
</html>