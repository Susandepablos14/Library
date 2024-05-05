<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\LoanUpdateRequest;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(LoanUpdateRequest $request, Loan $id)
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
