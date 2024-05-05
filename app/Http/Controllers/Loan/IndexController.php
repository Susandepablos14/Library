<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function index()
    {
        return view('loans.index');
    }

    public function get(Request $request)
    {
        try {
            $loan = Loan::with('user','booking')->withTrashed()->filter($request)->get();

            return LoanResource::collection($loan);
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
            $loan = Loan::with('user','book')->filter($request)->get();

            return Loan::collection($loan)->paginate($request->pag);
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
