<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                    Latest posts
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Browse the most recent stories from our community.</p>
            </div>
            @auth
                <div class="flex flex-wrap items-center gap-3">
                    <a
                        href="{{ route('posts.create') }}"
                        class="inline-flex items-center rounded-full border border-indigo-500 bg-indigo-600/10 px-4 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 dark:border-indigo-400 dark:text-indigo-200 dark:hover:bg-indigo-500/20"
                    >
                        + New post
                    </a>
                    <a
                        href="{{ route('dashboard') }}"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-200"
                    >
                        Go to dashboard →
                    </a>
                </div>
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status') === 'post-deleted')
                <div class="rounded-2xl border border-amber-200 dark:border-amber-900/60 bg-amber-50 dark:bg-amber-900/30 p-4 text-sm text-amber-900 dark:text-amber-100">
                    Post deleted successfully.
                </div>
            @endif

            <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-gray-900/70 p-4 backdrop-blur">
                <div class="flex flex-wrap items-center gap-2 text-sm font-medium">
                    <span class="text-gray-600 dark:text-gray-300">Filter by category:</span>
                    <div class="flex flex-wrap gap-2">
                        <a
                            href="{{ route('posts.index') }}"
                            class="rounded-full border px-3 py-1 transition
                                {{ $activeCategory
                                    ? 'border-gray-200 text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:border-gray-700 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:border-gray-500'
                                    : 'border-indigo-500 bg-indigo-50 text-indigo-600 dark:border-indigo-400 dark:bg-indigo-500/10 dark:text-indigo-200' }}"
                        >
                            All
                        </a>
                        @foreach ($categories as $category)
                            <a
                                href="{{ route('posts.index', ['category' => $category->id]) }}"
                                class="rounded-full border px-3 py-1 transition
                                    {{ (int) $activeCategory === $category->id
                                        ? 'border-indigo-500 bg-indigo-50 text-indigo-600 dark:border-indigo-400 dark:bg-indigo-500/10 dark:text-indigo-200'
                                        : 'border-gray-200 text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:border-gray-700 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:border-gray-500' }}"
                            >
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @if ($posts->count() === 0)
                <div class="rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 p-12 text-center text-gray-500 dark:text-gray-400">
                    No posts yet. Check back soon!
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($posts as $post)
                        <article class="flex flex-col overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:hover:border-indigo-500/50">
                            <a href="{{ route('posts.show', $post) }}" class="h-48 overflow-hidden">
                                <img
                                    src="{{ $post->featured_image }}"
                                    alt="{{ $post->title }}"
                                    class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                    loading="lazy"
                                >
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <div class="mb-3 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-300">
                                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-200">
                                        {{ $post->category->name }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-600">•</span>
                                    <span class="text-gray-500 dark:text-gray-400">{{ $post->created_at->format('M d, Y') }}</span>
                                </div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600 dark:hover:text-indigo-300">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="mb-4 flex-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ \Illuminate\Support\Str::limit($post->body, 160) }}
                                </p>
                                <div class="mt-auto flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <span>By <span class="text-gray-900 dark:text-gray-200">{{ $post->user->name }}</span></span>
                                    <a
                                        href="{{ route('posts.show', $post) }}"
                                        class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-200"
                                    >
                                        Read more →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="pt-4">
                    {{ $posts->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

