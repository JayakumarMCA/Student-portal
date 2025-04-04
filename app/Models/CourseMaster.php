<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'title', 'description', 'duration', 'status',
    ];
}
