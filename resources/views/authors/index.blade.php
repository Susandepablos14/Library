@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <authors
         create="{{ Auth::user()->can('authors.create') }}"
         deletet="{{ Auth::user()->can('authors.delete') }}"
         updated="{{ Auth::user()->can('authors.updated') }}"
     />
</div>
@endsection
