@php
    $color = 'gray';
    switch ($notification->notif_type) {
        case 'milestone':
            $color = 'green';
            break;
        case 'reply':
            $color = 'blue';
            break;
        case 'fail':
            $color = 'red';
            break;
        case 'welcome':
            $color = 'blue';
            break;
    }
@endphp

<div class="bg-white rounded-lg shadow p-6 border-l-4 border-primary">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            <div class="w-12 h-12 bg-{{ $color }}-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-1">
                    @if ($notification->notif_type == 'milestone')
                        <h3 class="font-semibold">Project funded: {{ $notification->project->title }}</h3>
                    @elseif ($notification->notif_type == 'reply')
                        <h3 class="font-semibold">Reply From: {{ $notification->comment->author->username }}</h3>
                    @elseif ($notification->notif_type == 'fail')
                        <h3 class="font-semibold">Project Failed: {{ $notification->project->title }}</h3>
                    @else
                        <h3 class="font-semibold">Welcome to FundRaiser!</h3>
                    @endif
                </div>
                @if ($notification->notif_type == 'milestone')
                    <p class="text-gray-600 mb-2">Congratulations! The project you backed has reached its funding goal and is now moving to production.</p>
                @elseif ($notification->notif_type == 'reply')
                    <p class="text-gray-600 mb-2">{{ $notification->comment->content }}</p>
                @elseif ($notification->notif_type == 'fail')
                    <p class="text-gray-600 mb-2">Unfortunately, the project you backed did not reach its funding goal and will not proceed to production. Thank you for your support.</p>
                @else
                    <p class="text-gray-600 mb-2">Thanks for joining our community. Discover amazing projects and start backing creators today.</p>
                @endif
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                    <span>•</span>
                    @if ($notification->notif_type == 'milestone')
                        <span>Funding Milestone</span>
                    @elseif ($notification->notif_type == 'reply')
                        <span>Reply</span>
                    @elseif ($notification->notif_type == 'fail')
                        <span>Project Fail</span>
                    @else
                        <span>Welcome</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <form action="{{ route('mark-read', $notification) }}" method="post">
                @csrf
                <button type="submit" class="text-primary hover:text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </form>
            <form action="{{ route('clear-notifs', $notification) }}" method="post">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>