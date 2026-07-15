<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    protected $fillable = ['content', 'topic_id', 'user_id'];

    // Connects the reply back to the topic thread stream
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    // Connects the reply to the student or lecturer who wrote it
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}