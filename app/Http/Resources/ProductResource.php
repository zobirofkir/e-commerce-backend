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
        $images = $this->image ? json_decode($this->image, true) : [];

        return [
            'id' => $this->id,
            'title' => $this->title,
            'images' => is_array($images) ? array_map(function($image) {
                return asset('storage/' . $image);
            }, $images) : [],
            'image' => asset('storage/' . $this->image),
            'description' => $this->description,
            'price' => $this->price,
            'slug' => $this->slug,
        ];
    }
}
