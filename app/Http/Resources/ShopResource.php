<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'latitude'              => $this->latitude,
            'longitude'             => $this->longitude,
            'status'                => $this->status,
            'type'                  => $this->type,
            'distance_from'         => $this->whenHas('distance_from'),
            'max_delivery_distance' => $this->max_delivery_distance,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];

        return $data;
    }
}
