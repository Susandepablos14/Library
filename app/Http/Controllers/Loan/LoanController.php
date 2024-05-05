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

class LoanController extends Controller
{
    public function index()
    {
        return view('loan');
    }
    protected function createType(Request $request)
    {
        $userId = Auth::id();
        $loanDate = Carbon::now()->toDateString();
        $bookingId = $request->booking_id; // Obtener el booking_id de la solicitud

        // Obtener el book_id asociado al booking_id proporcionado
        $bookId = Booking::where('id', $bookingId)->value('book_id');

        // Buscar la copia reservada basada en el book_id obtenido
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
        $loan->booking_id = $bookingId; // Asignar el booking_id
        $loan->loan_date = $loanDate;
        $loan->return_date = $request->return_date;
        $loan->status = 'Pendiente';
        $loan->save();

        $reservedCopy->status = 'Prestado';
        $reservedCopy->save();

        return $loan->id;
    }
}
