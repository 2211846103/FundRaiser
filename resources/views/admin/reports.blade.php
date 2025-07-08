@php
    use \Illuminate\Support\Carbon;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handle Reports - CrowdFund Admin</title>
    
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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Handle Reports</h1>
            <p class="text-gray-600">Review and resolve reported content and user behavior.</p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Open Reports</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $reports->where('is_resolved', false)->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Resolved Today</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $reports->filter(function ($report) {
                                    return $report->resolve_date && $report->resolve_date->isSameDay(Carbon::now());
                                })->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total This Month</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $reports->filter(function ($report) {
                                    return $report->created_at->isSameMonth(Carbon::now());
                                })->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports List -->
        <div class="space-y-6">
            @foreach ($reports as $report)
                @if ($report->reason == 'inappropriate')
                    @php
                    $color = $report->is_resolved ? 'green' : 'red';
                    @endphp
                    <div class="bg-white rounded-lg shadow border-l-4 border-{{ $color }}-500">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-lg font-semibold text-{{ $color }}-800">Inappropriate Content</h3>
                                        <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-medium px-2.5 py-0.5 rounded">High Priority</span>
                                        @if (!$report->is_resolved)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Open</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Resolved</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 mb-3">Project "{{ $report->project->title }}" reported for containing inappropriate content.</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Target ID:</span>
                                            <span class="font-medium">{{ $report->project->id }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Creator:</span>
                                            <span class="font-medium">{{ $report->project->creator->company_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <p>Report ID: {{ $report->id }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 rounded-lg p-3 mb-4">
                                <h4 class="font-medium text-{{ $color }}-800 mb-2">Report Details:</h4>
                                <p class="text-sm text-{{ $color }}-700">"{{ $report->details }}"</p>
                            </div>
                            
                            @if (!$report->is_resolved)
                                <div class="flex items-center justify-end space-x-2">
                                    <form action="{{ route('deactivate', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            Deactivate Project
                                        </button>
                                    </form>
                                    <form action="{{ route('resolve', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                            Dismiss
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif ($report->reason == 'fraud')
                    @php
                    $color = $report->is_resolved ? 'green' : 'yellow';
                    @endphp
                    <div class="bg-white rounded-lg shadow border-l-4 border-{{ $color }}-500">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-lg font-semibold text-{{ $color }}-800">Spam/Fraud</h3>
                                        <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-medium px-2.5 py-0.5 rounded">Medium Priority</span>
                                        @if (!$report->is_resolved)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Open</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Resolved</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 mb-3">Project "{{ $report->project->title }}" reported for containing fraudulent content.</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Target ID:</span>
                                            <span class="font-medium">{{ $report->project->id }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Creator:</span>
                                            <span class="font-medium">{{ $report->project->creator->company_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <p>Report ID: {{ $report->id }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 rounded-lg p-3 mb-4">
                                <h4 class="font-medium text-{{ $color }}-800 mb-2">Report Details:</h4>
                                <p class="text-sm text-{{ $color }}-700">"{{ $report->details }}"</p>
                            </div>
                            
                            @if (!$report->is_resolved)
                                <div class="flex items-center justify-end space-x-2">
                                    <form action="{{ route('deactivate', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            Deactivate Project
                                        </button>
                                    </form>
                                    <form action="{{ route('resolve', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                            Dismiss
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif ($report->reason == 'misleading')
                    @php
                    $color = $report->is_resolved ? 'green' : 'blue';
                    @endphp
                    <div class="bg-white rounded-lg shadow border-l-4 border-{{ $color }}-500">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-lg font-semibold text-{{ $color }}-800">Misleading Content</h3>
                                        <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-medium px-2.5 py-0.5 rounded">Low Priority</span>
                                        @if (!$report->is_resolved)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Open</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Resolved</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 mb-3">Project "{{ $report->project->title }}" reported for containing misleading content.</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Target ID:</span>
                                            <span class="font-medium">{{ $report->project->id }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Creator:</span>
                                            <span class="font-medium">{{ $report->project->creator->company_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <p>Report ID: {{ $report->id }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 rounded-lg p-3 mb-4">
                                <h4 class="font-medium text-{{ $color }}-800 mb-2">Report Details:</h4>
                                <p class="text-sm text-{{ $color }}-700">"{{ $report->details }}"</p>
                            </div>
                            
                            @if (!$report->is_resolved)
                                <div class="flex items-center justify-end space-x-2">
                                    <form action="{{ route('deactivate', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            Deactivate Project
                                        </button>
                                    </form>
                                    <form action="{{ route('resolve', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                            Dismiss
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif ($report->reason == 'copyright')
                    @php
                    $color = $report->is_resolved ? 'green' : 'blue';
                    @endphp
                    <div class="bg-white rounded-lg shadow border-l-4 border-{{ $color }}-500">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-lg font-semibold text-{{ $color }}-800">Copyright Violation</h3>
                                        <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-medium px-2.5 py-0.5 rounded">Low Priority</span>
                                        @if (!$report->is_resolved)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Open</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Resolved</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 mb-3">Project "{{ $report->project->title }}" reported for violating copyright terms.</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Target ID:</span>
                                            <span class="font-medium">{{ $report->project->id }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Creator:</span>
                                            <span class="font-medium">{{ $report->project->creator->company_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <p>Report ID: {{ $report->id }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 rounded-lg p-3 mb-4">
                                <h4 class="font-medium text-{{ $color }}-800 mb-2">Report Details:</h4>
                                <p class="text-sm text-{{ $color }}-700">"{{ $report->details }}"</p>
                            </div>
                            
                            @if (!$report->is_resolved)
                                <div class="flex items-center justify-end space-x-2">
                                    <form action="{{ route('deactivate', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            Deactivate Project
                                        </button>
                                    </form>
                                    <form action="{{ route('resolve', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                            Dismiss
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    @php
                    $color = $report->is_resolved ? 'green' : 'gray';
                    @endphp
                    <div class="bg-white rounded-lg shadow border-l-4 border-{{ $color }}-500">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-lg font-semibold text-{{ $color }}-800">Unknown Reason</h3>
                                        <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-medium px-2.5 py-0.5 rounded">Low Priority</span>
                                        @if (!$report->is_resolved)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Open</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Resolved</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 mb-3">Project "{{ $report->project->title }}" reported.</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Target ID:</span>
                                            <span class="font-medium">{{ $report->project->id }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Creator:</span>
                                            <span class="font-medium">{{ $report->project->creator->company_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <p>Report ID: {{ $report->id }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 rounded-lg p-3 mb-4">
                                <h4 class="font-medium text-{{ $color }}-800 mb-2">Report Details:</h4>
                                <p class="text-sm text-{{ $color }}-700">"{{ $report->details }}"</p>
                            </div>
                            
                            @if (!$report->is_resolved)
                                <div class="flex items-center justify-end space-x-2">
                                    <form action="{{ route('deactivate', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            Deactivate Project
                                        </button>
                                    </form>
                                    <form action="{{ route('resolve', $report) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                            Dismiss
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Pagination -->
        {{ $reports->links() }}
    </div>
</body>
</html>