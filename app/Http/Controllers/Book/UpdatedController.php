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
        // try {
        // Obtener todas las copias relacionadas con el libro
        $copies = Copy::where('book_id', $bookId)->get();

        // Calcular la cantidad total de copias disponibles y perdidas
        $availableCopies = $copies->whereIn('status', ['Disponible', 'Perdido'])->sum('quantity');
        $lostCopies = $copies->where('status', 'Perdido')->sum('quantity');

        // Cantidad de copias a agregar
        $quantityToAdd = $request->quantity;

        // Verificar el estado de la copia y manejar la lógica correspondiente
        if ($request->status === 'Perdido') {
            if ($request->reason === 'Prestado') {
                // Restar la cantidad de copias perdidas del total de copias prestadas
                $lostCopies += $quantityToAdd;
            } elseif ($request->reason === 'Disponible') {
                // Calcular la cantidad total de copias perdidas que se agregarán
                $totalLostCopies = $lostCopies + $quantityToAdd;
                // Verificar si la cantidad total de copias perdidas excede la cantidad disponible
                if ($totalLostCopies > $availableCopies) {
                    return response()->json(['error' => 'La cantidad de copias perdidas excede la cantidad disponible'], 400);
                }
            }
        } elseif ($request->status === 'Disponible') {
            // Aumentar la cantidad de copias disponibles
            $availableCopies += $quantityToAdd;
        }

        // Actualizar la cantidad de copias disponibles y perdidas para todos los registros
        foreach ($copies as $copy) {
            if ($request->status === 'Disponible' && $copy->status === 'Disponible') {
                $copy->quantity += $quantityToAdd;
            } elseif ($request->status === 'Perdido' && $copy->status === 'Disponible') {
                if ($request->reason === 'Prestado') {
                    // Restar del total de copias prestadas
                    $copy->quantity -= $quantityToAdd;
                } elseif ($request->reason === 'Disponible') {
                    // Restar del total de copias disponibles
                    $copy->quantity -= $quantityToAdd;
                }
                // Asegurarse de que la cantidad no sea negativa
                if ($copy->quantity < 0) {
                    $copy->quantity = 0;
                }
            }
            // Guardar los cambios en la copia
            $copy->save();
        }
        DB::commit();

        return response()->json([], Response::HTTP_OK);
        // } catch (ValidationException $ex) {
        //     return response()->json(
        //         [
        //             'data' => [
        //                 'title'  => $ex->getMessage(),
        //                 'errors' => collect($ex->errors())->flatten()
        //             ]
        //         ],
        //         Response::HTTP_UNPROCESSABLE_ENTITY
        //     );
        // } catch (\Exception $ex) {
        //     DB::rollBack();
        //     return response()->json(
        //         [
        //             'data' => [
        //                 'code'        => $ex->getCode(),
        //                 'title'       => __('errors.server.title'),
        //                 'description' => __('errors.server.description'),
        //             ]
        //         ],
        //         Response::HTTP_INTERNAL_SERVER_ERROR
        //     );
        // }
    }
}
