@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <books
         create="{{ Auth::user()->can('books.create') }}"
         deletet="{{ Auth::user()->can('books.delete') }}"
         updated="{{ Auth::user()->can('books.updated') }}"
     />
</div>
@endsection
