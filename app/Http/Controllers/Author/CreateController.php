<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\AuthorRequest;
use App\Models\Author;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function create(AuthorRequest $request)
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
        $author = new Author();
        $author->name = $request->name;
        $author->biography = $request->biography;
        $author->birthdate = $request->birthdate;
        $author->country_id = $request->country_id;
        $author->save();

        $file = $request->file('image');
        $imageName = $request->input('image_name');

        $author->image()->create([
            'path'      => $author->storeFile('/public/author', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), $file),
            'extension' => $file->getClientOriginalExtension(),
            'name' => $imageName,
        ]);
        return $author->id;
    }
}
