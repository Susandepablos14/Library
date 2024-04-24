<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EditorialResource extends JsonResource
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
                'name' => $this->resource->name,
                'address' => $this->resource->address,
                'phone' => $this->resource->phone,
                'email' => $this->resource->email,
                'country_id' => $this->resource->country_id,
                'created_at'  => $this->resource->created_at,
                'deleted_at'  => $this->resource->deleted_at,
            ],
            'relationships' => [
                'country' => new CountryResource($this->whenLoaded('country')),
                'image' => new ImageResource($this->whenLoaded('image')),
            ]
        ];
    }
}
