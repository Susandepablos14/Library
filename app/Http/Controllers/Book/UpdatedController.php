<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use App\Models\Copy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(BookUpdateRequest $request,Book $id)
    {
        try {
            DB::beginTransaction();

            $id->update($request->all());

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $request->input('image_name');

                $id->image->update([
                    'path'      => $id->storeFile('/public/book', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), $file),
                    'extension' => $file->getClientOriginalExtension(),
                    'name'      => $imageName,
                ]);
            }

            DB::commit();

            return response()->json(Response::HTTP_OK);

        } catch (ValidationException $ex) {
            return response()->json(
                [
                'data' => [
                    'title'  => $ex->getMessage(),
                    'errors' => collect($ex->errors())->flatten()
                ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(
                [
                'data' => [
                    'code'        => $ex->getCode(),
                    'title'       => __('errors.server.title'),
                    'description' => __('errors.server.description'),
                ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updatedCopy(BookUpdateRequest $request, $bookId)
    {
        try {
            DB::beginTransaction();

            // Encuentra todas las copias relacionadas con el book_id
            $copies = Copy::where('book_id', $bookId)->get();

            foreach ($copies as $copy) {
                if ($request->status === 'Disponible') {
                    $copy->quantity += $request->quantity;
                    $copy->save();
                } elseif ($request->status === 'Dañado') {
                    $copy->quantity -= $request->quantity;
                    if ($copy->quantity < 0) {
                        $copy->quantity = 0;
                    }

                    // Crear nueva copia en caso de que la cantidad sea negativa
                    if ($copy->quantity === 0) {
                        $newCopy = new Copy();
                        $newCopy->book_id = $copy->book_id;
                        $newCopy->quantity = $request->quantity;
                        $newCopy->status = $request->status;
                        $newCopy->save();
                    }

                    $copy->save();
                }
            }

            DB::commit();

            return response()->json(Response::HTTP_OK);

        } catch (ValidationException $ex) {
            return response()->json(
                [
                    'data' => [
                        'title'  => $ex->getMessage(),
                        'errors' => collect($ex->errors())->flatten()
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(
                [
                    'data' => [
                        'code'        => $ex->getCode(),
                        'title'       => __('errors.server.title'),
                        'description' => __('errors.server.description'),
                    ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}
