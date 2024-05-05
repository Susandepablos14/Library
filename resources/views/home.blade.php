@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @can ('statistics')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-book"></i>
                    </div>
                    <div class="mr-5">{{ $availableBooks }} Libros Disponibles</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('copies.index') }}">
                    <span class="float-left">Ver Detalles</span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-book"></i>
                    </div>
                    <div class="mr-5">{{ $reservedBooks }} Libros Reservados</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('copies.index') }}">
                    <span class="float-left">Ver Detalles</span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-book"></i>
                    </div>
                    <div class="mr-5">{{ $loanedBooks }} Libros Prestados</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('copies.index') }}">
                    <span class="float-left">Ver Detalles</span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-book"></i>
                    </div>
                    <div class="mr-5">{{ $lostBooks }} Libros Perdidos</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('copies.index') }}">
                    <span class="float-left">Ver Detalles</span>
                    <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>

  @endcan
  <div class="container">
    <h2 class="text-center mb-3 mt-3">Libros Disponibles</h2>
    <div class="row">
        @foreach($books as $book)
        @php
            $availableCopies = $book->copies->where('status', 'Disponible')->sum('quantity');
        @endphp
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3 mt-3">
            <div class="card h-100">
                <a href="{{ route('book-detail', ['id' => $book->id]) }}"> <!-- Enlace a la página de detalles -->
                    <img class="card-img-top" src="{{ $book->image ? $book->image->path : 'placeholder.jpg' }}" alt="{{ $book->title }}">
                </a>
                <div class="card-body">
                    <h4 class="card-title">{{ $book->title }}</h4>
                    @if($availableCopies > 0)
                        <p class="text-success">Disponible</p>
                    @else
                        <p class="text-danger">No Disponible</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
