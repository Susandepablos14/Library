<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingUpdateRequest;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(BookingUpdateRequest $request, Booking $id)
    {
        try {

            DB::beginTransaction();

            $id->update($request->all());

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
                    'description' => $ex->getMessage(),
                ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
