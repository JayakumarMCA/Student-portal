<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'name', 'from_date', 'to_date'];

    public function course()
    {
        return $this->belongsTo(CourseMaster::class);
    }
}
