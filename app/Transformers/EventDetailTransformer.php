<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\EventTransformer;
use Carbon\Carbon;

class EventDetailTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'event'
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($table)
    {
        return [
            'id' => $table->id,
            'event_id' => $table->event_id,
            'event_date' => $table->event_date,
            'has_event' => $table->has_event == true,
            'event_day_of_week' => $table->event_date->format('D'),
            'event_day' => $table->event_date->format('j'),
            'event_month' => $table->event_date->format('M'),
        ];
    }

    public function includeEvent($table)
    {
        if ($table->event) {
            return $this->collection($table->event, new EventTransformer);
        }
    }
}
