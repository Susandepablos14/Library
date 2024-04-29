@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <bookings
        create="{{ Auth::user()->can('bookings.create') }}"
        deletet="{{ Auth::user()->can('bookings.delete') }}"
        updated="{{ Auth::user()->can('bookings.updated') }}"
     />
</div>
@endsection
