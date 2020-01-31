<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use Carbon\Carbon;

class EventDetail extends Model
{
    protected $dates = [
        'event_date'
    ];

    protected $fillable = [
        'event_id',
        'event_date',
        'has_event',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function setEventDateAttribute($value)
    {
        $this->attributes['event_date'] = Carbon::parse($value);
    }
}
