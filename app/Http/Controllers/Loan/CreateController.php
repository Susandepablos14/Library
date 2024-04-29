<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\LoanRequest;
use App\Models\Copy;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function create(LoanRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->createType($request);

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
                        'description' => $ex->getMessage(),
                    ]
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    protected function createType(Request $request)
    {
        $userId = Auth::id();
        $loanDate = Carbon::now()->toDateString();
        $bookId = $request->book_id;

        $reservedCopy = Copy::where('book_id', $bookId)
            ->where('status', 'Reservado')
            ->first();

        if ($reservedCopy) {
            $reservedCopy->quantity -= 1;
            $reservedCopy->save();
        } else {
            return response()->json(['error' => 'No hay copias reservadas para prestar'], 400);
        }

        $loan = new Loan();
        $loan->user_id = $userId;
        $loan->book_id = $bookId;
        $loan->loan_date = $loanDate;
        $loan->return_date = $request->return_date;
        $loan->status = 'Pendiente';
        $loan->save();

        $reservedCopy->status = 'Prestado';
        $reservedCopy->save();

        return $loan->id;
    }
}
