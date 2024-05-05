@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <loans
        create="{{ Auth::user()->can('loans.create') }}"
        deletet="{{ Auth::user()->can('loans.delete') }}"
        updated="{{ Auth::user()->can('loans.updated') }}"
     />
</div>
@endsection
