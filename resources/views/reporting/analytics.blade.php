@php
    $deviceCount = $deviceLogs->count() == 0 ? 1 : $deviceLogs->count();
    $desktopPercentage = round($deviceLogs->where('device_type', 'Desktop')->count() * 100 / $deviceCount);
    $mobilePercentage = round($deviceLogs->where('device_type', 'Mobile')->count() * 100 / $deviceCount);
    $tabletPercentage = round($deviceLogs->where('device_type', 'Tablet')->count() * 100 / $deviceCount);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Analytics - FundRaiser</title>
    
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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Analytics Dashboard</h1>
            <p class="text-gray-600">Track your project performance and audience insights.</p>
        </div>

        <!-- Project Selector -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Project</label>
                    <select onchange="changeProject(this)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Select a project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @if (!$selected)
        <div class="text-center text-gray-500 text-lg mt-12">
            <p>Select a project to view analytics.</p>
        </div>
        @else
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg. Pledge</p>
                        <p id="avg-pledge" class="text-2xl font-semibold text-gray-900">${{ round(max(0, $selected->tiers->flatMap->donations->avg('amount')), 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Backers</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $selected->tiers->flatMap->donations->map->backer->unique('id')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Funding Progress Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Funding Progress Over Time</h3>
                <canvas id="fundingChart" class="h-64 rounded-lg">
                    
                </canvas>
            </div>
            <!-- Device Types -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Device Types</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium">Desktop</span>
                            <span class="text-sm text-gray-600">{{ $desktopPercentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $desktopPercentage }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium">Mobile</span>
                            <span class="text-sm text-gray-600">{{ $mobilePercentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $mobilePercentage }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium">Tablet</span>
                            <span class="text-sm text-gray-600">{{ $tabletPercentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $tabletPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0"></script>
    <script>
        function changeProject(select) {
            if (select.value !== '') {
                window.location.href = '?id=' + select.value;
            } else {
                window.location.href = window.location.pathname; // reset if user selects empty
            }
        }

        // Chart
        const ctx = document.getElementById('fundingChart').getContext('2d');
        const fundingChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [
                    {
                        label: 'Total Funding ($)',
                        data: @json($totals),
                        fill: true,
                        borderColor: 'rgba(34, 197, 94, 1)', // green-500
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        tension: 0.4
                    },
                    {
                        label: 'Funding Goal (${{ $selected?->funding_goal ?? 0 }})',
                        data: [], // no data — purely for legend
                        borderColor: 'rgb(248, 136, 7)',
                        backgroundColor: 'rgba(248, 136, 7, 0.2)',
                        borderWidth: 2,
                        borderDash: [6, 6],
                        pointRadius: 0, // no points
                        fill: false,
                    }
                ]
            },
            options: {
                plugins: {
                    annotation: {
                        annotations: {
                            goalLine: {
                                type: 'line',
                                yMin: {{ $selected?->funding_goal ?? 100 }},
                                yMax: {{ $selected?->funding_goal ?? 100 }},
                                borderColor: 'rgb(248, 136, 7)', // orange
                                borderWidth: 2,
                                borderDash: [6, 6],
                                label: {
                                    enabled: false,
                                    content: 'Funding Goal (${{ $selected?->funding_goal ?? 0 }})',
                                    position: 'start',
                                    backgroundColor: 'rgba(248, 136, 7, 0.7)',
                                    color: 'white'
                                }
                            }
                        }
                    }
                },
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            },
            plugins: [Chart.registry.getPlugin('annotation')]
        });
    </script>
</body>
</html>