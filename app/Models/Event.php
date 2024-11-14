<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_start',
        'date_end',
    ];

    public function gifts()
    {
        return $this->hasMany(Gift::class);
    }
}
