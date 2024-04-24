<?php

namespace App\Http\Controllers\Copy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Copy\CopyUpdateRequest;
use App\Models\Copy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(CopyUpdateRequest $request,Copy $id)
    {
        try {
            DB::beginTransaction();

            $copy = Copy::findOrFail($id);

            if ($request->status === 'Disponible') {
                $copy->quantity += $request->quantity;
                $copy->save();
            } elseif ($request->status === 'Dañado') {
                $copy->quantity -= $request->quantity;
                if ($copy->quantity < 0) {
                    $copy->quantity = 0;
                }
                $newCopy = new Copy();
                $newCopy->book_id = $copy->book_id;
                $newCopy->quantity = $request->quantity;
                $newCopy->status = $request->status;
                $newCopy->save();
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
