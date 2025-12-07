<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('posts.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-200">
                ← Back to posts
            </a>
            <span class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-600">/</span>
            <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-200">
                {{ $post->category->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl space-y-10 px-4 sm:px-6 lg:px-8">
            @if (session('status') === 'post-created')
                <div class="rounded-2xl border border-green-200 dark:border-green-900/60 bg-green-50 dark:bg-green-900/30 p-4 text-sm text-green-900 dark:text-green-100">
                    Post published successfully!
                </div>
            @endif

            <article class="overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow">
                <div class="h-80 w-full overflow-hidden bg-gray-900">
                    <img
                        src="{{ $post->featured_image }}"
                        alt="{{ $post->title }}"
                        class="h-full w-full object-cover"
                    >
                </div>
                <div class="space-y-6 p-8">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                        <span>By <span class="font-medium text-gray-900 dark:text-gray-100">{{ $post->user->name }}</span></span>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <span>{{ $post->created_at->format('F d, Y') }}</span>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <span>{{ $post->comments->count() }} comments</span>
                    </div>
                    <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-gray-100 sm:text-4xl">
                        {{ $post->title }}
                    </h1>
                    <div class="prose max-w-none text-gray-700 dark:text-gray-200">
                        <p class="whitespace-pre-line">{{ $post->body }}</p>
                    </div>

                    @can('delete', $post)
                        <div class="flex justify-end">
                            <form
                                method="POST"
                                action="{{ route('posts.destroy', $post) }}"
                                onsubmit="return confirm('Delete this post? This cannot be undone.');"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="inline-flex items-center rounded-full border border-red-500 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 dark:text-red-300 dark:hover:bg-red-500/10"
                                >
                                    Delete post
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </article>

            <section id="comments" class="space-y-6">
                @if (session('status') === 'comment-deleted')
                    <div class="rounded-2xl border border-amber-200 dark:border-amber-900/60 bg-amber-50 dark:bg-amber-900/30 p-4 text-sm text-amber-900 dark:text-amber-100">
                        Comment removed.
                    </div>
                @endif

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Comments</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $post->comments->count() }} total</p>
                    </div>
                    <a href="#add-comment" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-200">
                        Jump to form ↓
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse ($post->comments as $comment)
                        <div class="rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-sm">
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</span>
                                    <span class="text-gray-300 dark:text-gray-600">•</span>
                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @can('delete', $comment)
                                    <form
                                        method="POST"
                                        action="{{ route('comments.destroy', $comment) }}"
                                        class="text-xs"
                                        onsubmit="return confirm('Delete this comment?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-full border border-red-400 px-3 py-1 font-semibold text-red-500 hover:bg-red-50 dark:border-red-500/60 dark:text-red-300 dark:hover:bg-red-500/10">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                            <p class="mt-3 text-gray-700 dark:text-gray-200">
                                {{ $comment->body }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 p-8 text-center text-gray-500 dark:text-gray-400">
                            No comments yet. Be the first to share your thoughts!
                        </div>
                    @endforelse
                </div>
            </section>

            <section id="add-comment" class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-8 shadow">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Add a comment</h3>

                @if (session('status') === 'comment-added')
                    <div class="mt-4 rounded-xl border border-green-100 bg-green-50 dark:border-green-900 dark:bg-green-900/40 p-4 text-sm text-green-800 dark:text-green-200">
                        Thanks for jumping into the conversation!
                    </div>
                @endif

                @auth
                    <form
                        method="POST"
                        action="{{ route('posts.comments.store', $post) }}"
                        class="mt-6 space-y-4"
                        x-data="{ body: @js(old('body', '')) }"
                    >
                        @csrf
                        <div>
                            <label for="body" class="text-sm font-medium text-gray-700 dark:text-gray-300">Your message</label>
                            <textarea
                                id="body"
                                name="body"
                                rows="4"
                                class="mt-1 w-full rounded-2xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Share your perspective..."
                                x-model="body"
                            >{{ old('body') }}</textarea>
                            <div class="mt-1 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span x-text="`${body.length} / 1000 characters`"></span>
                                <span>Markdown not supported</span>
                            </div>
                            @error('body')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Commenting as <span class="font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</span></p>
                            <x-primary-button>Post comment</x-primary-button>
                        </div>
                    </form>
                @else
                    <div class="mt-4 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 p-6 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Please
                            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-200">log in</a>
                            to join the discussion.
                        </p>
                    </div>
                @endauth
            </section>
        </div>
    </div>
</x-app-layout>

