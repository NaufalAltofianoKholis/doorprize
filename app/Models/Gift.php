<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'stock',
        'is_main_doorprize'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
