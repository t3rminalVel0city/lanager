<?php

namespace Zeropingheroes\Lanager\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Game extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'provider' => 'steam',
            'url' => $this->url(),
            'logo' => [
                'small' => $this->logo('small'),
                'medium' => $this->logo('medium'),
                'large' => $this->logo('large'),
            ],
            'links' => [
                'self' => route('api.games.show', ['game' => $this->id]),
            ],
        ];
    }
}
