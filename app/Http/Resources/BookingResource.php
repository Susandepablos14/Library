<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
                'user_id' => $this->resource->user_id,
                'book_id' => $this->resource->book_id,
                'reservation_date' => $this->resource->reservation_date,
                'status' => $this->resource->status,
                'created_at'  => $this->resource->created_at,
                'deleted_at'  => $this->resource->deleted_at,
            ],
            'relationships' => [
                'user' => new UserResource($this->whenLoaded('user')),
                'book' => new BookResource($this->whenLoaded('book')),
            ]
        ];
    }
}
