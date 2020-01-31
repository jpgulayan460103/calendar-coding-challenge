<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Transformers\EventTransformer;

class PageController extends Controller
{
    public function index()
    {
        $event = Event::orderBy('id','DESC')->first();
        $data['event'] = fractal($event, new EventTransformer)->parseIncludes('details');
        return view('event',$data);
    }
}
