@php
    $projects = auth()->user()->projects;
    $donations = $projects->flatMap->tiers->flatMap->donations;
    $raised = $donations->sum('amount');
    $total = $projects->count();
    $achieved = $projects->where('status', 'achieved')->count();
    $success_percentage = $total > 0 ? round(($achieved / $total) * 100) : 0;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creator Dashboard - CrowdFund</title>
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-alt-navigation />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Creator Dashboard</h1>
            <p class="text-gray-600">Manage your projects and track your success.</p>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('projects.create') }}" class="bg-gradient-to-r from-primary to-blue-600 text-white p-6 rounded-lg hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold">Create New Project</h3>
                        <p class="text-blue-100">Start your next campaign</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('analytics') }}" class="bg-gradient-to-r from-secondary to-green-600 text-white p-6 rounded-lg hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold">View Analytics</h3>
                        <p class="text-green-100">Track performance</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-primary bg-opacity-10 rounded-lg">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Projects</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $total }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-secondary bg-opacity-10 rounded-lg">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Raised</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            ${{ $raised }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-accent bg-opacity-10 rounded-lg">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Backers</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $donations->map->backer->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Success Rate</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            %{{ $success_percentage }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Projects Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold">My Projects</h2>
                <a href="{{ route('my-projects') }}" class="text-primary hover:text-blue-600 text-sm font-medium">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @foreach ($projects->take(3) as $project)
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
            </div>
        </div>
    </div>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        function toggleProjectMenu(id) {
            const menu = document.getElementById(`projectMenu${id}`);
            menu.classList.toggle('hidden');
        }

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