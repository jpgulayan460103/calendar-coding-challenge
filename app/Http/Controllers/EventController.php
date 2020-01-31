<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventDetail;
use Illuminate\Http\Request;
use App\Http\Requests\EventStoreRequest;
use App\Transformers\EventTransformer;
use DB;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\EventStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStoreRequest $request)
    {
        DB::beginTransaction();
        try{
            $event = Event::create($request->all());
            $event->details()->saveMany($this->createDetails($event));
            DB::commit();
        }
        catch(\Exception $e){DB::rollback();throw $e;}

        return [
            'event' => fractal($event, new EventTransformer)->parseIncludes('details')
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }


    private function createDetails(Event $event)
    {
        $days_diff = $event->end_date->diffInDays($event->start_date);
        $details = array();
        for ($i=0; $i <= $days_diff; $i++) { 
            $event_date = date('m/d/Y ',strtotime($event->start_date->format('m/d/Y') . '+ '.$i.'days'));
            $details[$i] = new EventDetail($event->toArray());
            $details[$i]['event_date'] = $event_date;
            $details[$i]['has_event'] = $this->isDayHasEvent($event,$event_date);
        }
        return $details;
    }

    public function isDayHasEvent(Event $event,$event_date)
    {
        $event_date = Carbon::parse($event_date)->format('l');
        $event_days = json_decode($event->event_days);
        return preg_grep("/$event_date/i", $event_days) != array();
    }
}
