<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Requests\Copy\CopyUpdateRequest;
use App\Models\Book;
use App\Models\Copy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(BookUpdateRequest $request, Book $id)
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
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
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
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updatedCopy(CopyUpdateRequest $request, $bookId)
    {
        DB::beginTransaction();
        try {
            $copies = Copy::where('book_id', $bookId)->get();

            $availableCopies = $copies->whereIn('status', ['Disponible', 'Perdido'])->sum('quantity');
            $lostCopies = $copies->where('status', 'Perdido')->sum('quantity');
            $borrowedCopies = $copies->where('status', 'Prestado')->sum('quantity');
            $quantityToAdd = $request->quantity;

            // Verificar si la cantidad de copias perdidas o prestadas excede las disponibles
            if ($request->status === 'Perdido') {
                if ($quantityToAdd > $availableCopies) {
                    return response()->json(['error' => 'No hay suficientes copias disponibles para marcar como perdidas'], 400);
                }
            } elseif ($request->status === 'Prestado') {
                if ($quantityToAdd > $borrowedCopies) {
                    return response()->json(['error' => 'No hay suficientes copias prestadas para marcar como perdidas'], 400);
                }
            }

            if ($request->status === 'Perdido') {
                if ($request->reason === 'Disponible') {
                    $availableCopies -= $quantityToAdd;
                } elseif ($request->reason === 'Prestado') {
                    $borrowedCopies -= $quantityToAdd;
                }

                // Verificar si hay una copia existente con estado perdido
                if ($lostCopies > 0) {
                    // Sumar la cantidad a la copia existente si no excede la cantidad disponible
                    $newLostQuantity = $lostCopies + $quantityToAdd;
                    if ($newLostQuantity <= $availableCopies) {
                        // Actualizar la cantidad de copias perdidas
                        $lostCopies += $quantityToAdd;
                        // Guardar los cambios en la copia perdida existente
                        $lostCopy = $copies->where('status', 'Perdido')->first();
                        $lostCopy->quantity = $newLostQuantity;
                        $lostCopy->save();
                    } else {
                        return response()->json(['error' => 'No hay suficientes copias disponibles para marcar como perdidas'], 400);
                    }
                } else {
                    // Crear una nueva copia perdida si no existe
                    $newLostCopy = new Copy();
                    $newLostCopy->book_id = $bookId;
                    $newLostCopy->status = 'Perdido';
                    $newLostCopy->quantity = $quantityToAdd;
                    $newLostCopy->save();
                }
            } elseif ($request->status === 'Prestado') {
                // Restar del total de copias prestadas
                $borrowedCopies -= $quantityToAdd;
            }

            // Actualizar la cantidad de copias disponibles para todos los registros
            foreach ($copies as $copy) {
                if ($request->status === 'Disponible' && $copy->status === 'Disponible') {
                    $copy->quantity += $quantityToAdd;
                } elseif ($request->status === 'Perdido' && $copy->status === 'Disponible') {
                    $copy->quantity -= $quantityToAdd;
                    if ($copy->quantity < 0) {
                        $copy->quantity = 0;
                    }
                }
                $copy->save();
            }
            DB::commit();

        return response()->json([], Response::HTTP_OK);
        } catch (ValidationException $ex) {
            return response()->json(
                [
                    'data' => [
                        'title'  => $ex->getMessage(),
                        'errors' => collect($ex->errors())->flatten()
                    ]
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
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
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
