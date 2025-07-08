<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}" >
    <title>Edit Project - CrowdFund</title>
    
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
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Project</h1>
                    <p class="text-gray-600">Update your project information and settings.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('projects.show', $project) }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                        Preview
                    </a>
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">Active Campaign</span>
                </div>
            </div>
        </div>

        <!-- Project Status Alert -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-blue-800">Project is Live</h3>
                    <p class="text-sm text-blue-700 mt-1">Your project is currently live and accepting contributions. Some changes may require admin approval.</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-sm text-red-600 space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form class="space-y-8" action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Basic Information</h2>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Project Title</label>
                            <input name="title" type="text" value="{{ $project->title }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            @error('title')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <div id="tag-container" class="flex flex-wrap items-center gap-2 p-2 bg-white border border-gray-300 rounded-md focus-within:ring-2 focus-within:ring-blue-500">
                                <!-- Tags will go here -->
                                <input
                                    id="tag-input"
                                    type="text"
                                    placeholder="Type and press Enter"
                                    class="flex-grow border-none outline-none focus:ring-0 placeholder-gray-400 text-sm py-0.5"
                                />
                                <input type="hidden" name="tags[]" id="tags" />
                            </div>
                            @error('tags')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="short_desc" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                        <textarea name="short_desc" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none">{{ $project->short_desc }}</textarea>
                        @error('short_desc')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Project Media -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Project Media</h2>
                
                <div class="space-y-6">
                    <!-- Current Main Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Main Project Image</label>
                        <div class="flex items-start space-x-4">
                            <img src="{{ asset('storage/'.$project->image) }}" alt="Current main image" class="w-32 h-24 rounded-lg object-cover">
                            <div class="flex-1">
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors">
                                    <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-2">
                                        <label class="cursor-pointer">
                                            <span class="text-sm font-medium text-gray-900">Upload new image</span>
                                            <input name="image" type="file" class="sr-only" accept="image/*">
                                            @error('image')
                                                <div class="text-red-500">{{ $message }}</div>
                                            @enderror
                                        </label>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Funding Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Funding Details</h2>
                
                <div class="space-y-6">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-yellow-800">Funding Goal Cannot Be Changed</h3>
                                <p class="text-sm text-yellow-700 mt-1">The funding goal and campaign duration cannot be modified once the project is live.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Funding Goal</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">$</span>
                                <input type="number" value="60000" disabled 
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed">
                            </div>
                        </div>
                        
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                            <input 
                            type="date" 
                            name="deadline" 
                            id="deadline"
                            value="{{ \Carbon\Carbon::parse($project->deadline)->format('Y-m-d') }}"
                            disabled
                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                            />
                            @error('deadline')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Project Description</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="full_desc" class="block text-sm font-medium text-gray-700 mb-2">Full Project Description</label>
                        <textarea name="full_desc" rows="12" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none">
                            {{ $project->full_desc }}
                        </textarea>
                        @error('full_desc')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Reward Tiers -->
            <div class="bg-white rounded-lg shadow p-6">
                @error('tiers')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Reward Tiers</h2>
                    <button type="button" onclick="addRewardTier()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Add Reward
                    </button>
                </div>
                
                <div id="rewardTiers" class="space-y-4">
                    @foreach ($project->tiers as $tier)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <input type="hidden" name="tiers[{{ $loop->index }}][id]" value="{{ $tier->id }}">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-medium">{{ $tier->title }} - ${{ $tier->amount }}</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">{{ $tier->donations->map->backers->count() }} backers</span>
                                    <button type="button" onclick="removeRewardTier(this)" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="tiers[{{ $loop->index }}][amount]" class="block text-sm font-medium text-gray-700 mb-2">Pledge Amount</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                                        <input name="tiers[{{ $loop->index }}][amount]" type="number" value="{{ $tier->amount }}" 
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                </div>
                                <div>
                                    <label for="tiers[{{ $loop->index }}][title]" class="block text-sm font-medium text-gray-700 mb-2">Reward Title</label>
                                    <input name="tiers[{{ $loop->index }}][title]" type="text" value="{{ $tier->title }}" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="tiers[{{ $loop->index }}][desc]" class="block text-sm font-medium text-gray-700 mb-2">Reward Description</label>
                                <textarea name="tiers[{{ $loop->index }}][desc]" rows="3" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none">{{ $tier->desc }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between items-center pt-6">
                <div class="space-x-4">
                    <button type="button" onclick="cancelChanges()" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let rewardTierCount = {{ $project->tiers->count() }};

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        function addRewardTier() {
            rewardTierCount++;
            const container = document.getElementById('rewardTiers');
            const newTier = document.createElement('div');
            newTier.className = 'border border-gray-200 rounded-lg p-4';
            newTier.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-medium">New Reward Tier</h3>
                    <button type="button" onclick="removeRewardTier(this)" class="text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="tiers[${rewardTierCount - 1}][amount]" class="block text-sm font-medium text-gray-700 mb-2">Pledge Amount</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input name="tiers[${rewardTierCount - 1}][amount]" type="number" placeholder="0" 
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="tiers[${rewardTierCount - 1}][title]" class="block text-sm font-medium text-gray-700 mb-2">Reward Title</label>
                        <input name="tiers[${rewardTierCount - 1}][title]" type="text" placeholder="e.g., Premium Package" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="tiers[${rewardTierCount - 1}][desc]" class="block text-sm font-medium text-gray-700 mb-2">Reward Description</label>
                    <textarea for="tiers[${rewardTierCount - 1}][desc]" rows="3" placeholder="Describe what backers will receive..." 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                </div>
            `;
            container.appendChild(newTier);
        }

        function removeRewardTier(button) {
            const tier = button.closest('.border');
            const container = document.getElementById('rewardTiers');
            if (container.children.length > 1) {
                tier.remove();
            } else {
                alert('You must have at least one reward tier.');
            }
        }

        function cancelChanges() {
            if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                window.location.href = '{{ route('my-projects') }}';
            }
        }

        // Tags
        const container = document.getElementById("tag-container");
        const input = document.getElementById("tag-input");
        const hiddenInput = document.getElementById("tags");
        const tags = @json($project->tags ?? []);

        function renderTag(tagText) {
            const tag = document.createElement("span");
            tag.className = "flex items-center bg-blue-100 text-primary text-sm font-medium px-2 py-1 rounded-full mr-2 mb-2";
            tag.innerHTML = `
                ${tagText}
                <button type="button" class="ml-2 text-blue-500 hover:text-blue-700" onclick="removeTag('${tagText}', this)">×</button>
            `;
            container.insertBefore(tag, input);
        }

        function updateHiddenInput() {
            hiddenInput.value = tags.map(tag => tag.name).join(",");
        }

        function removeTag(text, btn) {
            const index = tags.indexOf(text);
            if (index > -1) {
                tags.splice(index, 1);
                updateHiddenInput();
            }
            btn.parentElement.remove();
        }

        input.addEventListener("keydown", function (e) {
            if (e.key === "Enter" && input.value.trim() !== "") {
                e.preventDefault();
                const tagText = input.value.trim();
                if (!tags.includes(tagText)) {
                    tags.push(tagText);
                    updateHiddenInput();
                    renderTag(tagText);
                }
                input.value = "";
            }
        });

        tags.forEach(tag => {
            renderTag(tag.name);
        });
        updateHiddenInput();
    </script>
</body>
</html>