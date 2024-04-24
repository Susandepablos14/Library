<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'attributes' => [
                'id'       => $this->resource->id,
                'path'     => $this->resource->path,
                'name'     => $this->resource->name,
                'extension'=> $this->resource->extension,
                'description'=> $this->resource->description,
            ],
        ];
    }
}
