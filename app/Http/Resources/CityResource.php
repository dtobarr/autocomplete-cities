<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'name' => $this->name. ', '. $this->admin1_code. ', '. $this->country_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'score' => $this->score
        ];
    }
}