<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'image' => $this->image,
            'Product' => $this->Product,
            'Price' => $this->Price,
            'Description' => $this->Description,
            'created_at' => date_format($this->created_at, "y/m/d H:i:s"),
            'Branch' => $this->Branch,
            'seller' => $this->seller,
        ];
    }
}
