@php
    use Laravolt\Avatar\Facade as Avatar;
    use Illuminate\Support\Carbon;
    use App\Models\Comment;

    $donations = $project->tiers->flatMap->donations;
    $backers = $donations->map->backer;
    $raised = $donations->sum('amount');
    $fund_percentage = round(min(100, $raised * 100 / $project->funding_goal));
    $deadline = Carbon::parse($project->deadline);
    $now = Carbon::now();
    $daysLeft = round($now->diffInDays($deadline, false));
    if ($daysLeft < 0) {
        $daysLeft = 0;
    }

    $comments = $project->comments->groupBy('parent_id');
    function buildTree($comments, $parentId = null) {
        $branch = [];
        if (!isset($comments[$parentId])) {
            return $branch;
        }
        foreach ($comments[$parentId] as $comment) {
            $children = buildTree($comments, $comment->id);
            if ($children) {
                $comment->children = $children;
            } else {
                $comment->children = collect();
            }
            $branch[] = $comment;
        }
        return $branch;
    }
    $nestedComments = buildTree($comments);

    $comments = Comment::with('author')->where('project_id', $project->id)->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <title>Smart Home Assistant 2.0 - CrowdFund</title>
    
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Project Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="relative">
                <img src="{{ asset('storage/'.$project->image) }}" onerror="this.onerror=null;this.src='https://placehold.co/600x400';" alt="Smart Home Assistant" class="w-full h-96 object-cover">
                <div class="absolute top-4 left-4">
                    @foreach ($project->tags as $tag)
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="absolute top-4 right-4 flex space-x-2">
                    <form id="like-form-{{ $project->id }}" action="/like-project" method="POST" data-comment-id="{{ $project->id }}">
                        @csrf
                        <input name="project_id" type="hidden" value="{{ $project->id }}" />
                        <button class="bg-white bg-opacity-90 p-2 rounded-full hover:bg-opacity-100 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="{{ auth()->user() && $project->likedUsers->contains(auth()->user()) ? 'red' : 'transparent' }}" stroke="#ef4444" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </form>
                    <button onclick="openReportModal()" class="bg-white bg-opacity-90 p-2 rounded-full hover:bg-opacity-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $project->title }}</h1>
                        <p class="text-gray-600">{{ $project->short_desc }}</p>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center space-x-2 mb-2">
                            <img src="{{ Avatar::create($project->creator->company_name)->toBase64() }}" alt="Profile" class="w-8 h-8 rounded-full">
                            <span>{{ $project->creator->company_name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Funding Progress -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div class="{{ auth()->user()->role == 'backer' ? 'md:col-span-2' : 'col-span-3' }}">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-3xl font-bold text-gray-900">${{ $raised }}</span>
                                <span class="text-lg text-gray-600">raised of ${{ $project->funding_goal }} goal</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-secondary h-3 rounded-full" style="width: {{ $fund_percentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 mt-2">
                                <span>{{ $fund_percentage }}% funded</span>
                                <span>${{ min(abs($project->funding_goal - $raised), $project->funding_goal) }} to go</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $backers->count() }}</div>
                                <div class="text-sm text-gray-600">backers</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $daysLeft }}</div>
                                <div class="text-sm text-gray-600">days to go</div>
                            </div>
                        </div>
                    </div>
                    
                    @if (auth()->user()->role == 'backer')
                        <div class="space-y-4">
                            <button onclick="openDonationModal()" class="w-full bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                                Back This Project
                            </button>
                            <div class="text-center text-sm text-gray-600">
                                <p>All or nothing. This project will only be funded if it reaches its goal by <strong>{{ Carbon::parse($project->deadline)->format('F j, Y') }}</strong>.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Project Description -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold mb-4">About This Project</h2>
                    <div class="prose max-w-none">
                        {{ $project->full_desc }}
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Comments ({{ $project->comments->count() }})</h2>
                    </div>
                    
                    <!-- Add Comment -->
                    <form action="/comments" method="POST" class="mb-6 p-4 border border-gray-200 rounded-lg">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}" />
                        <textarea name="content" placeholder="Share your thoughts about this project..." rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                        <div class="flex justify-end mt-2">
                            @error('content')
                                <div class="text-red-500 mr-auto">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                Post Comment
                            </button>
                        </div>
                    </form>
                    
                    <!-- Comments List -->
                    <div id="comments-container" class="space-y-6">
                        @foreach ($nestedComments as $comment)
                            <div class="top-comment" 
                                data-likes="{{ $comment->likedUsers->count() }}" 
                                data-created="{{ $comment->created_at }}">
                                @include('_comment', ['comment' => $comment, 'level' => 0])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Reward Tiers -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Reward Tiers</h3>
                    <div class="space-y-4">
                        @foreach ($project->tiers->sortBy('amount') as $tier)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors cursor-pointer" onclick="selectReward({{ $tier->id }})">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-lg font-semibold">${{ $tier->amount }}</span>
                                    <span class="text-sm text-gray-500">{{ $tier->donations->pluck('backer_id')->unique()->count() }} backers</span>
                                </div>
                                <h4 class="font-medium mb-2">{{ $tier->title }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $tier->desc }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Donation Modal -->
    <div id="donationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <form id="donation-modal" action="{{ route('donate') }}" method="post"
            class="bg-white rounded-lg p-6 w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            @csrf
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Back This Project</h3>
                <button type="button" onclick="closeDonationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                @foreach ($project->tiers as $tier)
                    <label for="tier_id" class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="tier_id" value="{{ $tier->id }}" class="text-primary">
                        <div class="ml-3">
                            <div class="font-medium">${{ $tier->amount }} - {{ $tier->title }}</div>
                            <div class="text-sm text-gray-600">{{ $backers->count() }} backers</div>
                        </div>
                    </label>
                @endforeach
            </div>
            
            <div class="flex gap-3">
                <button onclick="closeDonationModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-primary text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                    Confirm Backing
                </button>
            </div>
        </form>
    </div>

    <!-- Report Modal -->
    <div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <form action="/report" method="post" class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            @csrf
            <input name="project_id" type="hidden" value="{{ $project->id }}" />
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Report Project</h3>
                <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for Report</label>
                <select name="reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="inappropriate">Inappropriate content</option>
                    <option value="fraud">Spam or fraud</option>
                    <option value="misleading">Misleading information</option>
                    <option value="copyright">Copyright violation</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="details" class="block text-sm font-medium text-gray-700 mb-2">Additional Details (Optional)</label>
                <textarea name="details" rows="3" placeholder="Please provide more details about your report..." 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
            </div>
            
            <div class="flex gap-3">
                <button onclick="closeReportModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="submitReport()" class="flex-1 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors">
                    Submit Report
                </button>
            </div>
        </form>
    </div>

    <script>
        function openDonationModal() {
            document.getElementById('donationModal').classList.remove('hidden');
        }

        function closeDonationModal() {
            document.getElementById('donationModal').classList.add('hidden');
        }

        function openReportModal() {
            document.getElementById('reportModal').classList.remove('hidden');
        }

        function closeReportModal() {
            document.getElementById('reportModal').classList.add('hidden');
        }

        function selectReward(id) {
            openDonationModal();
            // Select the corresponding radio button
            setTimeout(() => {
                const radio = document.querySelector(`input[value="${id}"]`);
                if (radio) radio.checked = true;
            }, 100);
        }

        const form = document.getElementById('donation-modal');
        async function confirmBacking(e) {
            //e.preventDefault();
            const selectedReward = document.querySelector('input[name="tier"]:checked');

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });

            } catch (error) {
                console.error('Error donating:', error);
            }
            
            alert(`Thank you for backing this project!`);
            closeDonationModal();
        }
        form.addEventListener('submit', confirmBacking);

        function submitReport() {
            alert('Thank you for your report. We will review it and take appropriate action if necessary.');
            closeReportModal();
        }

        document.querySelectorAll('.like-form').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const commentId = form.dataset.commentId;
                const svg = form.querySelector('svg');
                const countSpan = form.querySelector('[data-like-count]');
                const url = form.getAttribute('action');

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                            'Accept': 'application/json'
                        },
                        body: new FormData(form)
                    });

                    if (!response.ok) throw new Error('Like failed');

                    const data = await response.json();

                    countSpan.textContent = data.likes;
                    svg.setAttribute('fill', data.liked ? '#3B82F6' : 'transparent');
                    svg.classList.toggle('text-primary');

                } catch (error) {
                    console.error('Error liking comment:', error);
                }
            });
        });

        document.querySelectorAll('#like-form-{{ $project->id }}').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const svg = form.querySelector('svg');
                const url = form.getAttribute('action');

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                            'Accept': 'application/json'
                        },
                        body: new FormData(form)
                    });

                    if (!response.ok) throw new Error('Like failed');

                    const data = await response.json();

                    svg.setAttribute('fill', data.liked ? 'red' : 'transparent');
                    svg.classList.toggle('text-primary');

                } catch (error) {
                    console.error('Error liking comment:', error);
                }
            });
        });
    </script>
</body>
</html>