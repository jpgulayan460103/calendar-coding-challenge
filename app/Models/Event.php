<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventDetail;
use Carbon\Carbon;

class Event extends Model
{
    protected $dates = [
        'start_date',
        'end_date',
    ];
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'event_days',
    ];

    public function details()
    {
        return $this->hasMany(EventDetail::class);
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::parse($value);
    }
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::parse($value);
    }
    public function setEventDaysAttribute($value)
    {
        $this->attributes['event_days'] = json_encode($value);
    }
}
