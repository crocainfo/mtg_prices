<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MagicCardResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'expansion' => $this->expansion,
            'cardkingdom' => $this->cardKingdom,
            'price' => ''
        ];
    }
}
