@php
    $donations = $project->tiers->flatMap->donations;
    $raised = $donations->sum('amount');
@endphp

<div class="h-full bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
    <img src="{{ asset('storage/'.$project->image) }}" alt="Project" class="w-full h-48 object-cover">
    <div class="p-6">
        <div class="flex items-center justify-between mb-2">
            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">
                @if (!$project->tags->isEmpty())
                    {{ $project->tags[0]->name }}
                @endif
            </span>
            <form id="like-form-{{ $project->id }}" action="/like-project" method="POST" data-comment-id="{{ $project->id }}">
                @csrf
                <input name="project_id" type="hidden" value="{{ $project->id }}" />
                <button class="text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="{{ auth()->user() && $project->likedUsers->contains(auth()->user()) ? 'red' : 'transparent' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
        <h3 class="text-lg font-semibold mb-2">{{ $project->title }}</h3>
        <p class="text-gray-600 text-sm mb-4">{{ $project->short_desc }}</p>
        <div class="mb-4">
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>${{ $raised }} raised</span>
                <span class="text-green-600 font-medium">Funded!</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-accent h-2 rounded-full" style="width: 100%"></div>
            </div>
        </div>
        <div class="flex justify-between items-center mb-4">
            <span class="text-sm text-green-600 font-medium">Successfully funded</span>
            <span class="text-sm font-medium text-gray-900">Goal: ${{ $project->funding_goal }}</span>
        </div>
        <div class="flex gap-2">
            <button class="flex-1 bg-gray-300 text-gray-600 py-2 px-4 rounded-lg cursor-not-allowed text-sm font-medium" disabled>
                Funding Complete
            </button>
            <a href="{{ route('projects.show', $project) }}"
                class="flex-1 flex items-center justify-center border border-primary text-primary py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium text-center">
                View Details
            </a>
        </div>
    </div>
</div>
<script>
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

            } catch (error) {
                console.error('Error liking comment:', error);
            }
        });
    });
</script>