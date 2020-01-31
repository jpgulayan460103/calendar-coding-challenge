<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\EventDetailTransformer;

class EventTransformer extends TransformerAbstract
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
        'details',
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
            'name' => $table->name,
            'start_date' => $table->start_date,
            'start_date_formatted' => $table->start_date->format('M Y'),
            'end_date' => $table->end_date,
            'end_date_formatted' => $table->end_date->format('M Y'),
            'event_days' => json_decode($table->event_days),
        ];
    }

    public function includeDetails($table)
    {
        if ($table->details) {
            return $this->collection($table->details, new EventDetailTransformer);
        }
    }
}
