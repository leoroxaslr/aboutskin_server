<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            "product_id" => $this->product_id,
            "product_name" => $this->product->name,
            "quantity" => $this->quantity,
            "price" => (float) $this->product->price,
            "total_price" => (float) $this->total_price
        ];
    }
}
