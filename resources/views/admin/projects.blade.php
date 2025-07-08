<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Projects - CrowdFund Admin</title>
    
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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Review Projects</h1>
            <p class="text-gray-600">Review and approve or reject project submissions.</p>
        </div>

        <!-- Projects List -->
        <div class="space-y-6">
            @foreach ($projects as $project)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start space-x-4">
                            <img src="{{ asset('storage/'.$project->image) }}" alt="Project" class="w-20 h-20 rounded-lg object-cover">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <h3 class="text-xl font-semibold">{{ $project->title }}</h3>
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending Review</span>
                                </div>
                                <p class="text-gray-600 mb-2">{{ $project->short_desc }}</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500">Creator:</span>
                                        <span class="font-medium">{{ $project->creator->company_name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Goal:</span>
                                        <span class="font-medium">${{ $project->funding_goal }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Deadline:</span>
                                        <span class="font-medium">{{ $project->deadline }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right text-sm text-gray-500">
                            <pre>ID: {{ $project->id }}</pre>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('projects.show', $project) }}" class="text-primary hover:text-blue-600 font-medium">
                                    View Full Details
                                </a>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('approve', $project) }}" method="post">
                                    @csrf
                                    <button onclick="approveProject(1)" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('reject', $project) }}" method="post">
                                    @csrf
                                    <button onclick="openRejectModal(1)" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{ $projects->links() }}
    </div>

    <!-- Reject Project Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Reject Project</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option>Incomplete information</option>
                    <option>Inappropriate content</option>
                    <option>Unrealistic goals</option>
                    <option>Violates terms of service</option>
                    <option>Duplicate project</option>
                    <option>Other</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Feedback for Creator</label>
                <textarea rows="4" placeholder="Provide detailed feedback to help the creator improve their project..." 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
            </div>
            
            <div class="flex gap-3">
                <button onclick="closeRejectModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="confirmReject()" class="flex-1 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors">
                    Reject Project
                </button>
            </div>
        </div>
    </div>

    <!-- Request Changes Modal -->
    <div id="changesModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Request Changes</h3>
                <button onclick="closeChangesModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Required Changes</label>
                <textarea rows="5" placeholder="Specify what changes are needed for approval..." 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
            </div>
            
            <div class="flex gap-3">
                <button onclick="closeChangesModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="confirmChanges()" class="flex-1 bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600 transition-colors">
                    Request Changes
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentProjectId = null;

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        function approveProject(id) {
            if (confirm('Are you sure you want to approve this project?')) {
                alert('Project approved successfully! The creator has been notified.');
                // Remove the project from the list or update its status
            }
        }

        function openRejectModal(id) {
            currentProjectId = id;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            currentProjectId = null;
        }

        function confirmReject() {
            if (currentProjectId) {
                alert('Project rejected and creator notified with feedback.');
                closeRejectModal();
            }
        }

        function requestChanges(id) {
            currentProjectId = id;
            document.getElementById('changesModal').classList.remove('hidden');
        }

        function closeChangesModal() {
            document.getElementById('changesModal').classList.add('hidden');
            currentProjectId = null;
        }

        function confirmChanges() {
            if (currentProjectId) {
                alert('Change request sent to creator.');
                closeChangesModal();
            }
        }

        function viewProjectDetails(id) {
            window.open('/project-detail.html', '_blank');
        }

        function viewCreatorProfile(id) {
            alert('Opening creator profile...');
        }

        // Close menus when clicking outside
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