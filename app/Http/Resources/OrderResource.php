<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "product_name" => $this->product->name,
            "price" => (float) $this->product->price,
            "quantity" => $this->quantity,
            "total" => ((float) $this->product->price) * ((int) $this->quantity),
            "weight" => (float) $this->weight,
            "length" => (float) $this->length,
            "width" => (float) $this->width,
            "height" => (float) $this->height,
            "item_type" => $this->item_type,
            "phone_number" => $this->phone_number,
            "postal_code" => $this->postal_code,
            "customer_name" => $this->user->name,
            "address" => $this->address,
            "customer_order_number" => $this->customer_order_number,
        ];
    }
}
