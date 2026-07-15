<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    // Protect from MassAssignmentException during actions
    protected $fillable = ['title', 'content', 'user_id', 'group_id', 'moderation_status'];

    /**
     * RELATIONSHIP: A topic belongs to the user who created it.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELATIONSHIP: A topic can have many discussion replies.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * RELATIONSHIP: A topic belongs to a specific academic cohort group.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}