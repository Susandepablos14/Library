<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function index()
    {
        return view('bookings.index');
    }

    public function get(Request $request)
    {
        try {
            $booking = Booking::with('user','book')->withTrashed()->filter($request)->get();

            return BookingResource::collection($booking);
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

    public function getPaginate(Request $request)
    {
        try {
            $booking = Booking::with('user','book')->filter($request)->get();

            return Booking::collection($booking)->paginate($request->pag);
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
