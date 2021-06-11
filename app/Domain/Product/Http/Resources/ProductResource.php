<?php

namespace App\Domain\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "company_name" => $this->company_name,
            "symbol" => $this->symbol,
            "type" => TypeProductResource::make($this->type),
            "description" => $this->description,
            "document" => $this->document
        ];
    }
}
