<?php

namespace App\Http\Controllers\Editorial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Editorial\EditorialRequest;
use App\Models\Editorial;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function create(EditorialRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->createNew($request);

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
                        'title'       => $ex->getMessage(),
                        'description' => $ex->getMessage(),
                    ]
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    protected function createNew($request)
    {
        $editorial = new Editorial();
        $editorial->name = $request->name;
        $editorial->address = $request->address;
        $editorial->phone = $request->phone;
        $editorial->email = $request->email;
        $editorial->country_id = $request->country_id;
        $editorial->save();

        $file = $request->file('image');
        $imageName = $request->input('image_name');

        $editorial->image()->create([
            'path'      => $editorial->storeFile('/public/editorial', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), $file),
            'extension' => $file->getClientOriginalExtension(),
            'name' => $imageName,
        ]);
        return $editorial->id;
    }
}
