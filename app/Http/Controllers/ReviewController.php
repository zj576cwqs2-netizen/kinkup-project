<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|max:500',
        ]);

        $article->reviews()->updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only('rating', 'comment')
        );

        return back()->with('success', 'レビューを投稿しました');
    }
}