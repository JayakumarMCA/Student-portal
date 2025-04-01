<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image', 'date', 'time', 'location', 'country_id', 'status','language_id','link'
    ];

    // Relationship with Country (assuming a countries table exists)
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
