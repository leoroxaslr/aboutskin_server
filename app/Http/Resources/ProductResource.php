<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "brand" => $this->brand,
            "image" => $this->image,
            "description" => $this->description,
            "description_long" => $this->description_long,
            "price" => (float) $this->price,
            "rating" =>  $this->rating,
            "stock" => $this->stock,
            "category" => $this->category->name,
        ];
    }
}
