@php
    use \App\Models\Project;
    use \App\Models\User;
    use \App\Models\Report;
    use \App\Models\AdminLog;
    use Laravolt\Avatar\Facade as Avatar;

    $projects = Project::latest()->get();
    $projectsToReview = $projects->where('status', 'pending');
    $users = User::latest()->get();
    $reports = Report::where('is_resolved', false)->latest()->get();
    $logs = AdminLog::latest()->get();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FundRaiser</title>
    
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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
            <p class="text-gray-600">Monitor platform activity and manage users and projects.</p>
        </div>

        <!-- Quick Stats -->
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
                        <p class="text-2xl font-semibold text-gray-900">{{ $projects->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-secondary bg-opacity-10 rounded-lg">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $users->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-accent bg-opacity-10 rounded-lg">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Reviews</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $projectsToReview->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Open Reports</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $reports->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-primary to-blue-600 text-white p-6 rounded-lg hover:shadow-lg transition-shadow cursor-pointer" onclick="window.location.href='{{ route('review-projects') }}'">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold">Review Projects</h3>
                        <p class="text-blue-100">Approve or reject submissions</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-secondary to-green-600 text-white p-6 rounded-lg hover:shadow-lg transition-shadow cursor-pointer" onclick="window.location.href='{{ route('manage-users') }}'">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold">Manage Users</h3>
                        <p class="text-green-100">View and moderate users</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-lg hover:shadow-lg transition-shadow cursor-pointer" onclick="window.location.href='{{ route('handle-reports') }}'">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold">Handle Reports</h3>
                        <p class="text-red-100">Review reported content</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-lg hover:shadow-lg transition-shadow cursor-pointer" onclick="window.location.href='{{ route('activity-logs') }}'">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold">Activity Logs</h3>
                        <p class="text-yellow-100">View system activity</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Projects Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Review Projects</h2>
                <a href="{{ route('review-projects') }}" class="text-primary hover:text-blue-600 text-sm font-medium">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($projectsToReview->take(2) as $project)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/'.$project->image) }}" alt="Project" class="w-12 h-12 rounded-lg object-cover">
                                    <div>
                                        <h3 class="font-semibold">{{ $project->title }}</h3>
                                        <p class="text-sm text-gray-600">By {{ $project->creator->company_name }}</p>
                                        <p class="text-sm text-gray-600">Goal: ${{ $project->funding_goal }} • Deadline: {{ $project->deadline }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('approve', $project) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors text-sm">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('reject', $project) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors text-sm">
                                            Reject
                                        </button>
                                    </form>
                                    <a href="{{ route('projects.show', $project) }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                        Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Manage Users Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Manage Users</h2>
                <a href="{{ route('manage-users') }}" class="text-primary hover:text-blue-600 text-sm font-medium">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($users->take(3) as $user)
                        <div class="flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <img src="{{ Avatar::create($user->username)->toBase64() }}" alt="Profile" class="w-8 h-8 rounded-full">
                                <div>
                                    <h3 class="font-semibold">{{ $user->username }}</h3>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">{{ $user->is_banned ? 'Suspended' : 'Active' }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if (!$user->is_banned)
                                    <form action="{{ route('suspend', $user) }}" method="post">
                                        @csrf
                                        <button class="text-red-600 hover:text-red-800 text-sm">Suspend</button>
                                    </form>
                                @else
                                    <form action="{{ route('unsuspend', $user) }}" method="post">
                                        @csrf
                                        <button class="text-gray-600 hover:text-green-800 text-sm">Unsuspend</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Handle Reports Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Handle Reports</h2>
                <a href="{{ route('handle-reports') }}" class="text-primary hover:text-blue-600 text-sm font-medium">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($reports->take(3) as $report)
                        @switch ($report->reason)
                            @case ('inappropriate')
                                <div class="flex items-center justify-between p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold text-red-800">Inappropriate Content</h3>
                                        <p class="text-sm text-red-600">Project: "{{ $report->project->title }}" reported by {{ $report->project->reports->count() }} users</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('deactivate', $report) }}" method="post">
                                            @csrf
                                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                                Deactivate Project
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case ('fraud')
                                <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold text-yellow-800">Spam/Fraud</h3>
                                        <p class="text-sm text-yellow-600">Project: "{{ $report->project->title }}" reported for spam</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('deactivate', $report->project) }}" method="post">
                                            @csrf
                                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                                Deactivate Project
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case ('misleading')
                                <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold text-blue-800">Misleading Content</h3>
                                        <p class="text-sm text-blue-600">Project: "{{ $report->project->title }}" reported for misleading content</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('deactivate', $report->project) }}" method="post">
                                            @csrf
                                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                                Deactivate Project
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case ('copyright')
                                <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold text-blue-800">Copyright Violation</h3>
                                        <p class="text-sm text-blue-600">Project: "{{ $report->project->title }}" reported</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('deactivate', $report->project) }}" method="post">
                                            @csrf
                                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                                Deactivate Project
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case ('other')
                                <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Other</h3>
                                        <p class="text-sm text-gray-600">Project: "{{ $report->project->title }}" reported</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('deactivate', $report->project) }}" method="post">
                                            @csrf
                                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                                                Deactivate Project
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @break
                        @endswitch
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Activity Logs Section -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Activity Logs</h2>
                <a href="{{ route('activity-logs') }}" class="text-primary hover:text-blue-600 text-sm font-medium">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($logs->take(3) as $log)
                        <?php
                            $color = 'blue';
                            switch ($log->action) {
                                case 'banned': $color = 'red'; break;
                                case 'unbanned': $color = 'green'; break;
                                case 'approved': $color = 'blue'; break;
                                case 'declined': $color = 'yellow'; break;
                                case 'deactivated': $color = 'red'; break;
                            }
                        ?>
                        <div class="flex items-center space-x-4 p-4 bg-{{ $color }}-50 rounded-lg">
                            <div class="w-12 h-12 bg-{{ $color }}-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-{{ $color  }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ $log->affectedProject ? 'Project' : 'User' }} "{{ $log->affectedProject ? $log->affectedProject->title : $log->affectedUser->username }}" {{ $log->action }}</p>
                                <p class="text-sm text-gray-600">{{ ucfirst($log->action) }} by Admin User</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentProjectId = null;

        function openRejectModal(id) {
            currentProjectId = id;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            currentProjectId = null;
        }

        function confirmReject() {
            if (currentProjectId) {
                alert('Project rejected and creator notified.');
                closeRejectModal();
                document.querySelector(`[onclick="openRejectModal(${currentProjectId})"]`).closest('.border').remove();
            }
        }
    </script>
</body>
</html>