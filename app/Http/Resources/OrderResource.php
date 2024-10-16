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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'order_status' => $this->order_status,
            'total_price' => $this->total_price,
            'payment_method' => $this->payment_method,
            'shipping_address' => $this->shiping_address,
            'phone' => $this->phone,
            'name' => $this->name,
            'email' => $this->email,
            'items' => $this->items->map(function ($item) {
                return new ProductResource($item->product);
            }),
        ];
    }
}
