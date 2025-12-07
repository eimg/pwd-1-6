<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-900 dark:text-gray-100">
                    Create a new post
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Share your story with the community.</p>
            </div>
            <a
                href="{{ route('posts.index') }}"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-200"
            >
                ← Back to posts
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form
                method="POST"
                action="{{ route('posts.store') }}"
                class="space-y-8 rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-8 shadow"
                x-data="{ body: @js(old('body', '')) }"
            >
                @csrf

                <div>
                    <label for="title" class="text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        class="mt-2 w-full rounded-2xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Give your post a standout headline"
                        required
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="category_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select
                            id="category_id"
                            name="category_id"
                            class="mt-2 w-full rounded-2xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="featured_image" class="text-sm font-medium text-gray-700 dark:text-gray-300">Featured image URL</label>
                        <input
                            type="url"
                            id="featured_image"
                            name="featured_image"
                            value="{{ old('featured_image') }}"
                            class="mt-2 w-full rounded-2xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="https://picsum.photos/seed/your-post/1200/800"
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to auto-generate a Picsum image.</p>
                        @error('featured_image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="body" class="text-sm font-medium text-gray-700 dark:text-gray-300">Body</label>
                    <textarea
                        id="body"
                        name="body"
                        rows="8"
                        class="mt-2 w-full rounded-2xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Write something insightful…"
                        x-model="body"
                        required
                    >{{ old('body') }}</textarea>
                    <div class="mt-1 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span x-text="`${body.length} characters`"></span>
                        <span>Minimum 50 characters</span>
                    </div>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Posting as <span class="font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</span>
                    </p>
                    <div class="flex gap-3">
                        <a
                            href="{{ route('posts.index') }}"
                            class="inline-flex items-center rounded-full border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100"
                        >
                            Cancel
                        </a>
                        <x-primary-button>
                            Publish post
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

