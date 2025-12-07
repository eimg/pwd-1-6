<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $posts = Post::query()
            ->with(['category', 'user'])
            ->when(
                $request->filled('category'),
                fn ($query) => $query->where('category_id', $request->integer('category'))
            )
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'activeCategory' => $request->integer('category'),
        ]);
    }

    public function show(Post $post): View
    {
        $post->load(['category', 'user', 'comments.user', 'comments.post']);

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Post::class);

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('posts.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'min:50'],
            'category_id' => ['required', 'exists:categories,id'],
            'featured_image' => ['nullable', 'url'],
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'featured_image' => $validated['featured_image']
                ?? sprintf('https://picsum.photos/id/%d/1200/800', random_int(1, 1000)),
            'category_id' => $validated['category_id'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'post-created');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('status', 'post-deleted');
    }
}
