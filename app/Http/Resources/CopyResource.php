<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CopyResource extends JsonResource
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
                'book_id' => $this->resource->book_id,
                'status' => $this->resource->status,
                'quantity' => $this->resource->quantity,
                'created_at'  => $this->resource->created_at,
                'deleted_at'  => $this->resource->deleted_at,
            ],
            'relationships' => [
                'book' => new BookResource($this->whenLoaded('book')),
            ]
        ];
    }
}
