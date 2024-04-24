<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'attributes' => [
                'id' => $this->resource->id,
                'title' => $this->resource->title,
                'description' => $this->resource->description,
                'author_id' => $this->resource->author_id,
                'editorial_id' => $this->resource->editorial_id,
                'category_id' => $this->resource->category_id,
                'publication_date' => $this->resource->publication_date,
                'created_at'  => $this->resource->created_at,
                'deleted_at'  => $this->resource->deleted_at,
            ],
            'relationships' => [
                'country' => new CountryResource($this->whenLoaded('country')),
                'author' => new AuthorResource($this->whenLoaded('author')),
                'editorial' => new EditorialResource($this->whenLoaded('editorial')),
                'category' => new CategoryResource($this->whenLoaded('category')),
                'copies' => CopyResource::collection($this->whenLoaded('copies')),
                'bookings' => CopyResource::collection($this->whenLoaded('bookings')),
                'loans' => CopyResource::collection($this->whenLoaded('loans')),
                'comments' => CopyResource::collection($this->whenLoaded('comments')),
                'image' => new ImageResource($this->whenLoaded('image')),
            ]
        ];
    }
}
