@extends('layouts.app')

@section('content')
<event :latest-event="{!! $event !!}"/>
@endsection
