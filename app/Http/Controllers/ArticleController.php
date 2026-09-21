<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['user', 'images'])
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(20);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $validated = $request->validated();

        $article = Article::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');

            ArticleImage::create([
                'article_id' => $article->id,
                'image_path' => $path,
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('articles.show', $article)
            ->with('success', '投稿しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['user', 'images']);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        abort_if($article->user_id !== Auth::id(), 403);

        $article->load(['images']);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreArticleRequest $request, Article $article)
    {
        abort_if($article->user_id !== Auth::id(), 403);

        $validated = $request->validated();

        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published'
                ? ($article->published_at ?? now())
                : null,
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', '更新しました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        abort_if($article->user_id !== Auth::id(), 403);

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', '削除しました！');
    }
}