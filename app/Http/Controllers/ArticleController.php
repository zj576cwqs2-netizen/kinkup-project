<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\ViewingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::with(['user', 'images', 'reviews'])
            ->where('status', 'published');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('author')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->author . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        $articles = $query->latest('published_at')->paginate(20)->withQueryString();

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
        $article->load(['user', 'images', 'reviews.user']);

        ViewingHistory::updateOrCreate(
            ['user_id' => Auth::id(), 'article_id' => $article->id],
            ['viewed_at' => now()]
        );

        $isFavorited = $article->favorites()->where('user_id', Auth::id())->exists();
        $favoritesCount = $article->favorites()->count();

        return view('articles.show', compact('article', 'isFavorited', 'favoritesCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        $article->load(['images']);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreArticleRequest $request, Article $article)
    {
        Gate::authorize('update', $article);

        $validated = $request->validated();

        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published'
                ? ($article->published_at ?? now())
                : null,
        ]);

        if ($request->hasFile('image')) {
            // 既存画像があれば、ファイルとレコードの両方を削除
            $existing = $article->images->first();
            if ($existing) {
                Storage::disk('public')->delete($existing->image_path);
                $existing->delete();
            }

            $path = $request->file('image')->store('articles', 'public');

            ArticleImage::create([
                'article_id' => $article->id,
                'image_path' => $path,
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('articles.show', $article)
            ->with('success', '更新しました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', '削除しました！');
    }
}