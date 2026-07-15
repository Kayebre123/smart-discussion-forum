<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    // Allows mass assignment for the features we are building
    protected $fillable = ['name', 'code'];

    /**
     * Set up the structural relationship link back to users table matrix.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function lecturers()
{
    return $this->belongsToMany(User::class);
}

public function students()
{
    return $this->hasMany(User::class, 'group_id')->where('role', 'student');
}
}