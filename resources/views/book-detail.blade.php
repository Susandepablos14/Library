@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mt-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $book->title }}</h3>
                </div>
                @php
                    $availableCopies = $book->copies->where('status', 'Disponible')->sum('quantity');
                @endphp
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img class="card-img-top" src="{{ asset($book->image->path) }}" alt="{{ $book->title }}">
                            <!-- Botón "Pedir" condicional -->
                            @if($availableCopies > 0)
                            <form action="{{ route('booking.create') }}" method="POST" id="bookingForm">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="btn btn-secondary mt-4">Pedir</button>
                            </form>

                            @endif
                        </div>
                        <div class="col-md-8">
                            <p><strong>Autor:</strong> {{ $book->author->name }}</p>
                            <p><strong>Categoría:</strong> {{ $book->category->name }}</p>
                            <p><strong>Editorial:</strong> {{ $book->editorial->name }}</p>
                            <p><strong>Fecha de Publicación:</strong> {{ $book->publication_date }}</p>
                            <!-- Mostrar mensaje descriptivo sobre las copias disponibles -->
                            <p><strong>Copias Disponibles:</strong>
                                @if($availableCopies > 0)
                                    Hay {{ $availableCopies }} copia(s) disponible(s).
                                @else
                                    No hay copias disponibles en este momento.
                                @endif
                            </p>
                            <p><strong>Descripción:</strong> {{ $book->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tarjeta de Información del Autor -->
        <div class="col-md-4 mt-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="text-center">Información del Autor</h4>
                </div>
                <div class="card-body">
                    <p><strong>Fecha de Nacimiento:</strong> {{ \Carbon\Carbon::parse($book->author->birthdate)->format('d/m/Y') }}</p>
                    <p><strong>Biografía:</strong> {{ $book->author->biography }}</p>
                    <img class="card-img-top" src="{{ asset($book->author->image->path) }}" alt="">
                    <!-- Agrega más información del autor si es necesario -->
                </div>
            </div>
        </div>
    </div>
    <!-- Tarjeta de Información de la Editorial -->
    <div class="row">
        <div class="col-md-12 mt-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Información de la Editorial</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $book->editorial->name }}</p>
                    <p><strong>Información de contacto:</strong></p>
                    <p><strong>Dirección:</strong> {{ $book->editorial->address }}</p>
                    <p><strong>Número de Teléfono:</strong> {{ $book->editorial->phone }}</p>
                    <p><strong>Email:</strong> {{ $book->editorial->email }}</p>
                    <img class="card-img-top" src="{{ asset($book->editorial->image->path) }}" alt="" style="width: 100px">
                    <!-- Agrega más información de la editorial si es necesario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
