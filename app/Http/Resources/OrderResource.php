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
            'shipping_address' => $this->shipping_address,
            'items' => $this->items->map(function ($item) {
                return [
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'image' => $item->product->image,
                    'description' => $item->product->description
                ];
            }),
        ];
    }
}
