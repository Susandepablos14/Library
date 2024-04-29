@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <copies
        deletet="{{ Auth::user()->can('copies.delete') }}"
        updated="{{ Auth::user()->can('copies.updated') }}"
     />
</div>
@endsection
