@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <countries
         create="{{ Auth::user()->can('countries.create') }}"
         deletet="{{ Auth::user()->can('countries.delete') }}"
         updated="{{ Auth::user()->can('countries.updated') }}"
     />
</div>
@endsection
