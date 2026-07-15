<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    protected $fillable = ['quiz_id', 'user_id', 'score'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}