<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchDetail extends Model
{
    use HasFactory;
    protected $fillable = ['batch_id', 'link', 'date', 'start_time', 'to_time', 'video'];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'to_time' => 'datetime:H:i:s',
    ];
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
