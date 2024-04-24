<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookRequest;
use App\Models\Book;
use App\Models\Copy;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function create(BookRequest $request)
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
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author_id = $request->author_id;
        $book->editorial_id = $request->editorial_id;
        $book->category_id = $request->category_id;
        $book->publication_date = $request->publication_date;
        $book->save();

        $copiesCount = $request->quantity ?? 1;
        $copy = new Copy();
        $copy->book_id = $book->id;
        $copy->status = 'Disponible';
        $copy->quantity = $copiesCount;
        $copy->save();

        $file = $request->file('image');
        $imageName = $request->input('image_name');

        $book->image()->create([
            'path'      => $book->storeFile('/public/book', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), $file),
            'extension' => $file->getClientOriginalExtension(),
            'name' => $imageName,
        ]);
        return $book->id;
    }
}
