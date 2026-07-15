<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'group_id',
        'warnings_count'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * FOR STUDENTS: A student belongs to exactly ONE academic group.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * FOR LECTURERS: A lecturer can manage MULTIPLE academic groups.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id');
    }

    /**
     * RELATIONSHIP: A user can create/author multiple discussion topics.
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'user_id');
    }

    /**
     * RELATIONSHIP: A user can submit multiple replies across streams.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class, 'user_id');
    }
}