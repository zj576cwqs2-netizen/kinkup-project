<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'post_date',
        'servings'
    ];

    public function images(): HasMany
    {
        return $this->hasMany('App\\Models\\ArticleImage');
    }
    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function viewingHistories()
    {
        return $this->hasMany('App\\Models\\ViewingHistory');
    }
}
