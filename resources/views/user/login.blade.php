<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - CrowdFund</title>
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 p-8">
        <div class="text-center">
            <a href="/" class="text-3xl font-bold text-primary">CrowdFund</a>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Sign in to your account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Or
                <a href="{{ route('register') }}" class="font-medium text-primary hover:text-blue-500">create a new account</a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="#" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" 
                           placeholder="Enter your email">
                </div>
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" 
                           placeholder="Enter your password">
                </div>
                @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" onclick="handleLogin()" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Sign in
                </button>
            </div>
        </form>
    </div>

    <script>
        function handleLogin() {
            // Simulate login - in real app, this would make an API call
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (email && password) {
                // Store user session (simplified)
                localStorage.setItem('userLoggedIn', 'true');
                localStorage.setItem('userEmail', email);
                
                // Redirect based on user type (simplified logic)
                if (email.includes('admin')) {
                    window.location.href = '/admin-dashboard.html';
                } else if (email.includes('creator')) {
                    window.location.href = '/creator-dashboard.html';
                } else {
                    window.location.href = '/backer-dashboard.html';
                }
            }
        }
    </script>
</body>
</html>