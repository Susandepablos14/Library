<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\LoanRequest;
use App\Models\Booking;
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

            $this->createLoan($request);

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

    protected function createLoan(Request $request)
    {
        $userId = Auth::id();
        $loanDate = Carbon::now()->toDateString();
        $bookingId = $request->booking_id; // Obtener el booking_id de la solicitud

        // Obtener el book_id asociado al booking_id proporcionado
        $bookId = Booking::where('id', $bookingId)->value('book_id');

        // Manejar la creación de préstamo y actualización de copias aquí
        $this->handleLoanCreation($userId, $loanDate, $bookingId, $bookId, $request->return_date);
    }

    protected function handleLoanCreation($userId, $loanDate, $bookingId, $bookId, $returnDate)
    {
        // Buscar la copia reservada basada en el book_id obtenido
        $reservedCopy = Copy::where('book_id', $bookId)
            ->where('status', 'Reservado')
            ->first();

        if ($reservedCopy) {
            $reservedCopy->quantity -= 1;
            $reservedCopy->save();
        } else {
            throw new \Exception('No hay copias reservadas para prestar', Response::HTTP_BAD_REQUEST);
        }

        // Buscar copias prestadas del mismo libro
        $loanedCopiesCount = Copy::where('book_id', $bookId)
            ->where('status', 'Prestado')
            ->count();

        // Si hay copias prestadas, incrementar la cantidad prestada
        if ($loanedCopiesCount > 0) {
            $loanedCopy = Copy::where('book_id', $bookId)
                ->where('status', 'Prestado')
                ->first();
            $loanedCopy->quantity += 1;
            $loanedCopy->save();
        } else {
            // Si no hay copias prestadas, crear una nueva copia prestada
            $loanedCopy = new Copy();
            $loanedCopy->book_id = $bookId;
            $loanedCopy->status = 'Prestado';
            $loanedCopy->quantity = 1;
            $loanedCopy->save();
        }

        // Crear un nuevo préstamo
        $loan = new Loan();
        $loan->user_id = $userId;
        $loan->booking_id = $bookingId; // Asignar el booking_id
        $loan->loan_date = $loanDate;
        $loan->return_date = $returnDate;
        $loan->status = 'Pendiente';
        $loan->save();

        return $loan->id;
    }
}
