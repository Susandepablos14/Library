<?php

namespace App\Http\Controllers\Editorial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Editorial\EditorialUpdateRequest;
use App\Models\Editorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(EditorialUpdateRequest $request,Editorial $id)
    {
        try {
            DB::beginTransaction();

            $id->update($request->all());
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $request->input('image_name');

                $id->image->update([
                    'path'      => $id->storeFile('/public/editorial', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), $file),
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
