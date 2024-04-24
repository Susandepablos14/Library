@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <categories
         create="{{ Auth::user()->can('categories.create') }}"
         deletet="{{ Auth::user()->can('categories.delete') }}"
         updated="{{ Auth::user()->can('categories.updated') }}"
     />
</div>
@endsection
