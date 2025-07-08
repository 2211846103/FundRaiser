@php
    use Laravolt\Avatar\Facade as Avatar;
@endphp

<div class="border-b border-gray-200 pb-6 {{ $level ?? 0 ? 'ml-6' : '' }}">
    <div class="flex items-start space-x-3">
        <img src="{{ Avatar::create($comment->author->username)->toBase64() }}" alt="Profile" class="w-8 h-8 rounded-full">
        <div class="flex-1">
            <div class="flex items-center space-x-2 mb-1">
                <span class="font-semibold">{{ $comment->author->username }}</span>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded">{{ ucfirst($comment->author->role) }}</span>
            </div>
            <p class="text-gray-700 mb-2">{{ $comment->content }}</p>
            <div class="flex items-center space-x-4 text-sm">
                <form class="like-form" action="/like-comment" method="POST" data-comment-id="{{ $comment->id }}">
                    @csrf
                    <input name="comment_id" type="hidden" value="{{ $comment->id }}" />
                    <button type="submit" class="flex items-center space-x-1 text-gray-500 hover:text-primary">
                        <svg class="w-4 h-4" fill="{{ auth()->user() && $comment->likedUsers->contains(auth()->user()) ? '#3B82F6' : 'transparent' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                        </svg>
                        <span data-like-count>{{ $comment->likedUsers->count() }}</span>
                    </button>
                </form>

                <button class="text-gray-500 hover:text-primary" onclick="toggleReplyForm({{ $comment->id }})">Reply</button>
            </div>
            <div id="reply-form-{{ $comment->id }}" class="mt-4 hidden">
                <form action="/comments" method="POST" class="space-y-2">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                    <textarea 
                        name="content" 
                        rows="2" 
                        class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring focus:ring-primary/20 focus:outline-none resize-none text-sm" 
                        placeholder="Write your reply..." 
                        required
                    ></textarea>

                    <div class="flex justify-end space-x-2">
                        <button 
                            type="button" 
                            class="text-sm text-gray-500 hover:text-gray-700 transition"
                            onclick="toggleReplyForm({{ $comment->id }})"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition"
                        >
                            Post Reply
                        </button>
                    </div>
                </form>
            </div>
            {{-- Nested Replies --}}
            @if ($comment->replies->count())
                <div class="mt-4 ml-6 border-l border-gray-300 pl-4">
                    @foreach ($comment->children as $child)
                        @include('_comment', ['comment' => $child, 'level' => ($level ?? 0) + 1])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form) {
            form.classList.toggle('hidden');
        }
    }
</script>