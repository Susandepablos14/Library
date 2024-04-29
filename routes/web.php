<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(
    [
        'prefix'     => 'country'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Country\IndexController::class, 'index'])
            ->name('countries.index')
            ->middleware('permission:countries.index');

        Route::post('create', [App\Http\Controllers\Country\CreateController::class, 'create'])
            ->middleware('permission:countries.create');

        Route::delete('delete/{id}', [App\Http\Controllers\Country\DeleteController::class, 'destroy'])
            ->middleware('permission:countries.delete');

        Route::get('get', [App\Http\Controllers\Country\IndexController::class, 'get'])
            ->middleware('permission:countries.index');

        Route::post('{id}', [App\Http\Controllers\Country\UpdatedController::class, 'updated'])
            ->middleware('permission:countries.updated');
    }
);

Route::group(
    [
        'prefix'     => 'category'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Category\IndexController::class, 'index'])
            ->name('categories.index')
            ->middleware('permission:categories.index');

        Route::post('create', [App\Http\Controllers\Category\CreateController::class, 'create'])
            ->middleware('permission:categories.create');

        Route::delete('delete/{id}', [App\Http\Controllers\Category\DeleteController::class, 'destroy'])
            ->middleware('permission:categories.delete');

        Route::get('get', [App\Http\Controllers\Category\IndexController::class, 'get'])
            ->middleware('permission:categories.index');

        Route::post('{id}', [App\Http\Controllers\Category\UpdatedController::class, 'updated'])
            ->middleware('permission:categories.updated');
    }
);

Route::group(
    [
        'prefix'     => 'author'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Author\IndexController::class, 'index'])
            ->name('authors.index')
            ->middleware('permission:authors.index');

        Route::post('create', [App\Http\Controllers\Author\CreateController::class, 'create'])
            ->middleware('permission:authors.create');

        Route::delete('delete/{id}', [App\Http\Controllers\Author\DeleteController::class, 'destroy'])
            ->middleware('permission:authors.delete');

        Route::get('get', [App\Http\Controllers\Author\IndexController::class, 'get'])
            ->middleware('permission:authors.index');

        Route::post('{id}', [App\Http\Controllers\Author\UpdatedController::class, 'updated'])
            ->middleware('permission:authors.updated');
    }
);

Route::group(
    [
        'prefix'     => 'editorial'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Editorial\IndexController::class, 'index'])
            ->name('editorials.index')
            ->middleware('permission:editorials.index');

        Route::post('create', [App\Http\Controllers\Editorial\CreateController::class, 'create'])
            ->middleware('permission:editorials.create');

        Route::delete('delete/{id}', [App\Http\Controllers\Editorial\DeleteController::class, 'destroy'])
            ->middleware('permission:editorials.delete');

        Route::get('get', [App\Http\Controllers\Editorial\IndexController::class, 'get'])
            ->middleware('permission:editorials.index');

        Route::post('{id}', [App\Http\Controllers\Editorial\UpdatedController::class, 'updated'])
            ->middleware('permission:editorials.updated');
    }
);

Route::group(
    [
        'prefix'     => 'book'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Book\IndexController::class, 'index'])
            ->name('books.index')
            ->middleware('permission:books.index');

        Route::post('create', [App\Http\Controllers\Book\CreateController::class, 'create'])
            ->middleware('permission:books.create');

        Route::delete('delete/{id}', [App\Http\Controllers\Book\DeleteController::class, 'destroy'])
            ->middleware('permission:books.delete');

        Route::get('get', [App\Http\Controllers\Book\IndexController::class, 'get'])
            ->middleware('permission:books.index');

        Route::post('{id}', [App\Http\Controllers\Book\UpdatedController::class, 'updated'])
            ->middleware('permission:books.updated');

        Route::get('{bookId}/copies', [App\Http\Controllers\Book\IndexController::class, 'getCopiesByBookId'])
            ->middleware('permission:books.index');

    }
);

Route::group(
    [
        'prefix'     => 'copy'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Copy\IndexController::class, 'index'])
            ->name('copies.index')
            ->middleware('permission:copies.index');

//         Route::post('create', [App\Http\Controllers\Copy\CreateController::class, 'create'])
//             ->middleware('permission:copies.create');

//         Route::delete('delete/{id}', [App\Http\Controllers\Copy\DeleteController::class, 'destroy'])
//             ->middleware('permission:copies.delete');

        Route::get('get', [App\Http\Controllers\Copy\IndexController::class, 'get'])
            ->middleware('permission:copies.index');

        Route::post('{id}/book', [App\Http\Controllers\Book\UpdatedController::class, 'updatedCopy'])
            ->middleware('permission:copies.updated');
    }

);

Route::group(
    [
        'prefix'     => 'booking'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Booking\IndexController::class, 'index'])
            ->name('bookings.index')
            ->middleware('permission:bookings.index');

        Route::post('create', [App\Http\Controllers\Booking\CreateController::class, 'create'])
            ->middleware('permission:bookings.create');

//         Route::delete('delete/{id}', [App\Http\Controllers\Booking\DeleteController::class, 'destroy'])
//             ->middleware('permission:bookings.delete');

        Route::get('get', [App\Http\Controllers\Booking\IndexController::class, 'get'])
            ->middleware('permission:bookings.index');
    }

);
