@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <editorials
         create="{{ Auth::user()->can('editorials.create') }}"
         deletet="{{ Auth::user()->can('editorials.delete') }}"
         updated="{{ Auth::user()->can('editorials.updated') }}"
     />
</div>
@endsection
