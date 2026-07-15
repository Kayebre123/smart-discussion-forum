<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'target_audience',
    ];

    /**
     * Get the user (Lecturer/Admin) who created the announcement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}