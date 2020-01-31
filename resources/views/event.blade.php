@extends('layouts.app')

@section('content')
<event :latest-event="{{ json_encode($event) }}"/>
@endsection
