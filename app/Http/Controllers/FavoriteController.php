<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
public function toggle(Article $article)
{
    $user = Auth::user();

    /** @var \App\Models\User $user */

    if ($user->favorites()->where('article_id', $article->id)->exists()){
         $user->favorites()->detach($article->id);
        $favorited = false;
    } else {
        $user->favorites()->attach($article->id);
        $favorited = true;
    }
    
    return response()->json([
        'favorited' => $favorited,
        'count' => $article->favorites()->count()
    ]);
} 
}