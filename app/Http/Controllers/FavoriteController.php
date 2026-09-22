public function toggle(Article, $article)
{
    $user = auth()->user();

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
    