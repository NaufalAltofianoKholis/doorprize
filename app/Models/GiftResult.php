<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'gift_id',
        'member_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function member()
    {
        return $this->hasMany(Member::class);
    }
}
