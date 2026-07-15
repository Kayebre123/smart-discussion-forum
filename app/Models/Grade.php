<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // ⚡ ALLOW MASS ASSIGNMENT FOR STUDENT GRADES
    protected $fillable = [
        'student_id',
        'assessment_name',
        'score',
    ];
}