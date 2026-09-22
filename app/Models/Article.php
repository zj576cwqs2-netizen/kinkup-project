<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function viewingHistories(): HasMany
    {
        return $this->hasMany(ViewingHistory::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany('App\\Models\\Review');
    }
}