class ArticlePolicy
{
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article)
    {
        return $user-id === $article->user_id;
        
    }
}