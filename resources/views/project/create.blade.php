<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <title>Create Project - CrowdFund</title>

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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Project</h1>
            <p class="text-gray-600">Share your idea with the world and bring it to life with the support of our community.</p>
        </div>


        <!-- Form -->
        <form class="space-y-8" action="{{ route('projects.store') }}" method="POST">
            @csrf
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Basic Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                        <input id="title" name="title" type="text" required placeholder="Enter your project title" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Choose a clear, compelling title that describes your project</p>
                    </div>
                    @error('title')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    
                    <div>
                        <label for="tags[]" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
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
                
                <div class="mt-6">
                    <label for="short_desc" class="block text-sm font-medium text-gray-700 mb-2">Short Description *</label>
                    <textarea id="short_desc" name="short_desc" required rows="3" placeholder="Briefly describe your project in 1-2 sentences" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                    <p class="text-xs text-gray-500 mt-1">This will appear in project listings and search results</p>
                    @error('short_desc')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Project Media -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Project Media</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Main Image *</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">Upload main project image</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    <div id="image-preview" class="flex flex-wrap gap-4 mt-4"></div>
                                </label>
                                <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF up to 10M</p>
                            </div>
                        </div>
                        @error('image')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Funding Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Funding Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="funding_goal" class="block text-sm font-medium text-gray-700 mb-2">Funding Goal *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input id="funding_goal" name="funding_goal" type="number" required placeholder="0" min="100" 
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Minimum goal is $100</p>
                        @error('funding_goal')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Deadline *</label>
                        <input 
                        type="date" 
                        name="deadline" 
                        id="deadline" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        />
                        @error('deadline')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Detailed Description -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Project Description</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="full_desc" class="block text-sm font-medium text-gray-700 mb-2">Full Project Description *</label>
                        <textarea id="full_desc" name="full_desc" required rows="10" placeholder="Tell the full story of your project. What problem does it solve? What makes it unique? Include details about your background and experience..." 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Be detailed and compelling. This is your chance to convince backers to support your project.</p>
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
                    <!-- Default reward tier -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-medium">Reward Tier 1</h3>
                            <button type="button" onclick="removeRewardTier(this)" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tiers[0][amount]" class="block text-sm font-medium text-gray-700 mb-2">Pledge Amount *</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input name="tiers[0][amount]" type="number" required placeholder="0" min="1" 
                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label for="tiers[0][title]" class="block text-sm font-medium text-gray-700 mb-2">Reward Title *</label>
                                <input name="tiers[0][title]" type="text" required placeholder="e.g., Early Bird Special" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label for="tiers[0][desc]" class="block text-sm font-medium text-gray-700 mb-2">Reward Description *</label>
                            <textarea name="tiers[0][desc]" required rows="3" placeholder="Describe what backers will receive for this pledge amount..." 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-between items-center pt-6">
                <div class="space-x-4">
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Submit for Review
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let rewardTierCount = 1;

        function addRewardTier() {
            rewardTierCount++;
            const container = document.getElementById('rewardTiers');
            const newTier = document.createElement('div');
            newTier.className = 'border border-gray-200 rounded-lg p-4';
            newTier.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-medium">Reward Tier ${rewardTierCount}</h3>
                    <button type="button" onclick="removeRewardTier(this)" class="text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tiers[${rewardTierCount - 1}][amount]" class="block text-sm font-medium text-gray-700 mb-2">Pledge Amount *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input name="tiers[${rewardTierCount - 1}][amount]" type="number" required placeholder="0" min="1" 
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label for="tiers[${rewardTierCount - 1}][title]" class="block text-sm font-medium text-gray-700 mb-2">Reward Title *</label>
                        <input name="tiers[${rewardTierCount - 1}][title]" type="text" required placeholder="e.g., Early Bird Special" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="tiers[${rewardTierCount - 1}][desc]" class="block text-sm font-medium text-gray-700 mb-2">Reward Description *</label>
                    <textarea name="tiers[${rewardTierCount - 1}][desc]" required rows="3" placeholder="Describe what backers will receive for this pledge amount..." 
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

        // Tags
        const container = document.getElementById("tag-container");
        const input = document.getElementById("tag-input");
        const hiddenInput = document.getElementById("tags");
        const tags = [];

        input.addEventListener("keydown", function (e) {
            if (e.key === "Enter" && input.value.trim() !== "") {
                e.preventDefault();
                const tagText = input.value.trim();

                if (!tags.includes(tagText)) {
                    tags.push(tagText);
                    updateHiddenInput();

                    const tag = document.createElement("span");
                    tag.className = "flex items-center bg-blue-100 text-primary text-sm font-medium px-2 py-1 rounded-full";

                    const textNode = document.createTextNode(tagText);
                    const button = document.createElement("button");
                    button.className = "ml-2 text-blue-500 hover:text-blue-700";
                    button.textContent = "×";
                    button.addEventListener("click", () => removeTag(tagText, tag));

                    tag.appendChild(textNode);
                    tag.appendChild(button);

                    container.insertBefore(tag, input);
                }

                input.value = "";
            }
        });

        function removeTag(text, tagElement) {
            const index = tags.indexOf(text);
            if (index > -1) {
                tags.splice(index, 1);
                updateHiddenInput();
            }
            tagElement.remove();
        }

        function updateHiddenInput() {
            hiddenInput.value = JSON.stringify(tags);
        }

        // Images
        document.getElementById('images').addEventListener('change', function (event) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = ''; // Clear old previews

            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-32 h-32 object-cover rounded border border-gray-300';
                    preview.appendChild(img);
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
</body>
</html>