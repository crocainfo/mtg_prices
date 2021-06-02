<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardKingdomResource extends JsonResource
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
            'price_nm' => $this->price_nm,
            'price_ex' => $this->price_ex,
            'price_nm_foil' => $this->price_nm_foil,
            'price_ex_foil' => $this->price_ex_foil,
            'link_to_webpage' => $this->link_to_webpage,
            'link_to_webpage_foil' => $this->link_to_webpage_foil,
            'link_to_image' => $this->link_to_image,
            'link_to_image_little' => $this->link_to_image_little,
            'currency' => $this->currency,
        ];
    }
}
