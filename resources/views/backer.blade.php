<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backer Dashboard - FundRaiser</title>
    
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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, John!</h1>
            <p class="text-gray-600">Discover amazing projects and support creators you love.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-primary bg-opacity-10 rounded-lg">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Backed</p>
                        <p class="text-2xl font-semibold text-gray-900">${{ auth()->user()->donations->sum('amount') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-secondary bg-opacity-10 rounded-lg">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Projects Backed</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Project::whereHas('tiers.donations', function ($query) {
                                    $query->where('backer_id', auth()->id());
                                })->distinct('projects.id')->count('projects.id') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Favorites</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->likedProjects->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Browse Projects Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Browse Projects</h2>
                <a href="{{ route('projects.index') }}" class="text-primary hover:text-blue-600 text-sm font-medium">View All</a>
            </div>

            <!-- Featured Projects Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    @if ($project->status == 'achieved')
                        <x-project-card.achieved.explore :project="$project" />
                    @elseif ($project->status == 'active')
                        <x-project-card.active.explore :project="$project" />
                    @endif
                @endforeach
            </div>
        </div>

        <!-- My Contributions Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">My Contributions</h2>
                <a href="{{ route('contributions') }}" class="text-primary hover:text-blue-600 text-sm font-medium">View All</a>
            </div>
            
            <div class="space-y-4">
                @foreach (auth()->user()->donations as $donation)
                    <div class="flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/'.$donation->tier->project->image) }}" alt="Project" class="w-12 h-12 rounded-lg object-cover">
                            <div>
                                <h3 class="font-semibold">{{ $donation->tier->project->title }}</h3>
                                <p class="text-sm text-gray-600">Backed ${{ $donation->amount }}</p>
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-0.5 rounded">{{ ucfirst($donation->tier->project->status) }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-lg">${{ $donation->amount }}</p>
                            <p class="text-sm text-gray-500">Reward: {{ $donation->tier->title }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Donation Modal -->
    <div id="donationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Back This Project</h3>
                <button onclick="closeDonationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Donation Amount</label>
                <input type="number" placeholder="Enter amount" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Reward Tier</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="reward" value="25" class="text-primary">
                        <div class="ml-3">
                            <div class="font-medium">$25 - Early Bird</div>
                            <div class="text-sm text-gray-600">Digital thank you + updates</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="reward" value="100" class="text-primary">
                        <div class="ml-3">
                            <div class="font-medium">$100 - Supporter</div>
                            <div class="text-sm text-gray-600">Product + digital rewards</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="reward" value="250" class="text-primary">
                        <div class="ml-3">
                            <div class="font-medium">$250 - Premium</div>
                            <div class="text-sm text-gray-600">Premium package + exclusive access</div>
                        </div>
                    </label>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button onclick="closeDonationModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button class="flex-1 bg-primary text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                    Confirm Backing
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        function openDonationModal() {
            document.getElementById('donationModal').classList.remove('hidden');
        }

        function closeDonationModal() {
            document.getElementById('donationModal').classList.add('hidden');
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