<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs - CrowdFund Admin</title>
    
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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Activity Logs</h1>
            <p class="text-gray-600">Monitor system activities and administrative actions.</p>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold">Recent Activities</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-6">
                    @foreach ($logs as $log)
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
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-{{ $color }}-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-{{ $color  }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $log->affectedProject ? 'Project' : 'User' }} {{ ucfirst($log->action) }}</p>
                                        <p class="text-sm text-gray-600">{{ $log->affectedProject ? 'Project' : 'User' }} "{{ $log->affectedProject ? $log->affectedProject->title : $log->affectedUser->username }}" was {{ $log->action }} by Admin User</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                    <span>{{ $log->affectedProject ? 'Project' : 'User' }} ID: {{ $log->affectedProject ? $log->affectedProject->id : $log->affectedUser->id }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pagination -->
        {{ $logs->links() }}
    </div>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        function exportLogs() {
            alert('Exporting activity logs to CSV...');
        }

        function refreshLogs() {
            alert('Refreshing activity logs...');
            // In a real application, this would reload the logs from the server
        }

        // Auto-refresh functionality
        let autoRefreshInterval;
        document.getElementById('autoRefresh').addEventListener('change', function(e) {
            if (e.target.checked) {
                autoRefreshInterval = setInterval(() => {
                    console.log('Auto-refreshing logs...');
                    // In a real application, this would fetch new logs
                }, 30000);
            } else {
                clearInterval(autoRefreshInterval);
            }
        });

        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('userMenu');
            const button = event.target.closest('button');
            if (!button || !button.onclick || button.onclick.toString().indexOf('toggleUserMenu') === -1) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>