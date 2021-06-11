<?php

namespace App\Domain\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "category" => $this->category,
        ];
    }
}
