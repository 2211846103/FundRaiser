<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Contributions - FundRaiser</title>
    
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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Contributions</h1>
            <p class="text-gray-600">Track all your project contributions and rewards.</p>
        </div>

        <!-- Contributions List -->
        <div class="space-y-6">
            @foreach (auth()->user()->donations as $donation)
                @if ($donation->tier->project->status == 'active')
                    <x-contrib-card.active :donation="$donation" />
                @elseif ($donation->tier->project->status == 'achieved')
                    <x-contrib-card.achieved :donation="$donation" />
                @elseif ($donation->tier->project->status == 'failed')
                    <x-contrib-card.failed :donation="$donation" />
                @else
                    <x-contrib-card.deactivated :donation="$donation" />
                @endif
            @endforeach
        </div>

        <!-- Pagination -->
        {{ $donations->links() }}
    </div>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        function contactCreator(id) {
            alert(`Opening message composer for project ${id} creator...`);
        }

        function updatePledge(id) {
            alert(`Opening pledge update form for project ${id}...`);
        }

        function trackReward(id) {
            alert(`Opening reward tracking for project ${id}...`);
        }

        function trackShipment(id) {
            alert(`Opening shipment tracking for project ${id}...`);
        }

        // Close user menu when clicking outside
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