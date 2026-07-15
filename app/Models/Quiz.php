<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = [
        'user_id', 
        'group_id', 
        'title', 
        'description', 
        'custom_questions', 
        'opens_at', 
        'duration_minutes', 
        'ends_at', 
        'is_active'
    ];

    protected $casts = [
        'custom_questions' => 'array',
        'opens_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * RELATIONSHIP: A quiz belongs to the lecturer who deployed it.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELATIONSHIP: A quiz belongs to a target academic cohort group.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}