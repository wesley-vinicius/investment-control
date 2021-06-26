<?php

declare(strict_types=1);

namespace App\Domain\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'symbol' => $this->symbol,
            'type' => TypeProductResource::make($this->type),
            'description' => $this->description,
            'document' => $this->document,
        ];
    }
}
