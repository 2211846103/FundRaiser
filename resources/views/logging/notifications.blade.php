<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - FundRaiser</title>
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-alt-navigation />

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Notifications</h1>
                <p class="text-gray-600">Stay updated on your projects and activities.</p>
            </div>
            <div class="flex items-center space-x-4">
                <form action="{{ route('mark-all-read') }}" method="post">
                    @csrf
                    <button type="submit" class="text-primary hover:text-blue-600 font-medium">
                        Mark all as read
                    </button>
                </form>
                <form action="{{ route('clear-all-notifs') }}" method="post">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-800">
                        Clear all
                    </button>
                </form>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="space-y-4">
            @foreach ($notifications as $notification)
                @if ($notification->read)
                    <x-notification.read :notification="$notification" />
                @else
                    <x-notification.unread :notification="$notification" />
                @endif
            @endforeach
        </div>

        {{ $notifications->links() }}
    </div>
</body>
</html>