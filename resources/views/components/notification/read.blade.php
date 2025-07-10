<div class="bg-white rounded-lg shadow p-6 opacity-75">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                @if ($notification->notif_type == 'milestone')
                    <h3 class="font-semibold">Project funded: {{ $notification->project->title }}</h3>
                @elseif ($notification->notif_type == 'reply')
                    <h3 class="font-semibold">Reply From: {{ $notification->comment->author->username }}</h3>
                @elseif ($notification->notif_type == 'fail')
                    <h3 class="font-semibold">Project Failed: {{ $notification->project->title }}</h3>
                @elseif ($notification->notif_type == 'deactivate')
                    <h3 class="font-semibold">Project Deactivated: {{ $notification->project->title }}</h3>
                @elseif ($notification->notif_type == 'reject')
                    <h3 class="font-semibold">Project Rejected: {{ $notification->project->title }}</h3>
                @elseif ($notification->notif_type == 'approve')
                    <h3 class="font-semibold">Project Approved: {{ $notification->project->title }}</h3>
                @else
                    <h3 class="font-semibold">Welcome to FundRaiser!</h3>
                @endif

                @if ($notification->notif_type == 'milestone')
                    <p class="text-gray-600 mb-2">Congratulations! The project you backed has reached its funding goal and is now moving to production.</p>
                @elseif ($notification->notif_type == 'reply')
                    <p class="text-gray-600 mb-2">{{ $notification->comment->content }}</p>
                @elseif ($notification->notif_type == 'fail')
                    <p class="text-gray-600 mb-2">Unfortunately, the project you backed did not reach its funding goal and will not proceed to production. Thank you for your support.</p>
                @elseif ($notification->notif_type == 'deactivate')
                    <p class="text-gray-600 mb-2">Your project has been deactivated following a report and subsequent review.</p>
                @elseif ($notification->notif_type == 'reject')
                    <p class="text-gray-600 mb-2">Unfortunately, your project did not meet our publishing guidelines and was not approved. Please review our policies and consider resubmitting.</p>
                @elseif ($notification->notif_type == 'approve')
                    <p class="text-gray-600 mb-2">Your project has been approved and is now live on FundRaiser. Backers can now discover and support your idea—good luck!</p>
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
                    @elseif ($notification->notif_type == 'deactivate')
                        <span>Project Deactivation</span>
                    @elseif ($notification->notif_type == 'reject')
                        <span>Project Rejection</span>
                    @elseif ($notification->notif_type == 'approve')
                        <span>Project Approval</span>
                    @else
                        <span>Welcome</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-2">
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