<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingRequest;
use App\Models\Booking;
use App\Models\Copy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CreateController extends Controller
{
    public function create(BookingRequest $request)
    {
        try {
            DB::beginTransaction();

            $bookingId = $this->createType($request);

            DB::commit();

            return Redirect::route('loan.page', ['id' => $bookingId]);
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
        $reservationDate = Carbon::now()->toDateString();
        $bookId = $request->book_id;

        $existingBooking = Booking::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('status', 'Activa')
            ->first();

        if ($existingBooking) {
            throw new \Exception('Ya has reservado este libro', 400);
        }

        $availableCopy = Copy::where('book_id', $bookId)
            ->where('status', 'Disponible')
            ->where('quantity', '>', 0)
            ->first();

        if (!$availableCopy) {
            throw new \Exception('No hay copias disponibles para reservar', 400);
        }

        $availableCopy->quantity -= 1;
        $availableCopy->save();

        $reservedCopy = Copy::where('book_id', $bookId)
            ->where('status', 'Reservado')
            ->first();

        if ($reservedCopy) {
            $reservedCopy->quantity += 1;
            $reservedCopy->save();
        } else {
            $reservedCopy = new Copy();
            $reservedCopy->book_id = $bookId;
            $reservedCopy->quantity = 1;
            $reservedCopy->status = 'Reservado';
            $reservedCopy->save();
        }

        $booking = new Booking();
        $booking->user_id = $userId;
        $booking->book_id =  $bookId;
        $booking->reservation_date = $reservationDate;
        $booking->status = 'Activa';
        $booking->save();

        return $booking->id;
    }
}
