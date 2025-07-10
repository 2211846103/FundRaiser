<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FundRaiser - Home</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation>
        <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-primary transition-colors">Explore Projects</a>
    </x-navigation>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary to-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-6">Fund Your Dreams, Support Innovation</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Join thousands of creators and backers in bringing amazing projects to life. Start your campaign or discover the next big thing.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">Start a Project</a>
                @endguest
                <a href="{{ route('projects.index') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors">Explore Projects</a>
            </div>
        </div>
    </section>

    <!-- Featured Projects -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Featured Projects</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($projects as $project)
                    @if ($project->status == 'achieved')
                        <x-project-card.achieved.explore :project="$project" />
                    @elseif ($project->status == 'active')
                        <x-project-card.active.explore :project="$project" />
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                    <h3 class="text-xl font-semibold mb-2">Create Your Project</h3>
                    <p class="text-gray-600">Share your idea, set your funding goal, and create compelling rewards for backers.</p>
                </div>
                <div class="text-center">
                    <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                    <h3 class="text-xl font-semibold mb-2">Build Your Community</h3>
                    <p class="text-gray-600">Engage with backers and build excitement around your project.</p>
                </div>
                <div class="text-center">
                    <div class="bg-accent text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                    <h3 class="text-xl font-semibold mb-2">Bring It to Life</h3>
                    <p class="text-gray-600">Reach your funding goal and deliver amazing rewards to your supporters.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>