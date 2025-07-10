@php
    $tier = $donation->tier;
    $project = $tier->project;
@endphp

<div class="bg-white rounded-lg shadow p-6 opacity-75">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-start space-x-4">
            <img src="{{ asset('storage/'.$project->image) }}" alt="Project" class="w-16 h-16 rounded-lg object-cover">
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                    <h3 class="text-lg font-semibold">{{ $project->title }}</h3>
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Failed</span>
                </div>
                <p class="text-gray-600 text-sm mb-2">{{ $project->short_desc }}</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Pledged:</span>
                        <span class="font-medium">${{ $donation->amount }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Reward:</span>
                        <span class="font-medium">{{ $tier->title }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right">
            <div class="text-2xl font-bold text-gray-900">${{ $donation->amount }}</div>
            <div class="text-sm text-gray-500">Refunded</div>
        </div>
    </div>
    
    <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
        <p class="text-sm text-red-800">
            <strong>Project Deactivation:</strong> This project got deactivated. Your contribution has been refunded to your original payment method.
        </p>
    </div>
    
    <div class="flex items-center justify-between border-t pt-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('projects.show', $project) }}" class="text-primary hover:text-blue-600 font-medium">View Project</a>
            <span class="text-gray-400">Project ended</span>
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-gray-500 text-sm">Refund processed</span>
        </div>
    </div>
</div>
</div>