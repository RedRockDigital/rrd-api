<?php

namespace RedRockDigital\Api\Http\Resources;

use RedRockDigital\Api\Models\Informable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Informable
 */
class InformableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name'       => $this->name,
            'created_at' => $this->created_at,
        ];
    }
}
