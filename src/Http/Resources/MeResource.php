<?php

namespace RedRockDigital\Api\Http\Resources;

use RedRockDigital\Api\Http\Resources\{
    Me\MyTeamsResource,
    Team\TeamResource
};
use RedRockDigital\Api\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @mixin User
 */
class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id'                   => $this->id,
            'current_team_id'      => $this->current_team_id,
            'first_name'           => $this->first_name,
            'last_name'            => $this->last_name,
            'full_name'            => $this->full_name,
            'email_verified'       => $this->email_verified,
            'email'                => $this->email,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
            'current_team'         => new TeamResource($this->team),
            'teams'                => MyTeamsResource::collection($this->teams),
            'scopes'               => $this->scopes,
            'two_factor_verified'  => $this->two_factor_verified,
            'two_factor_enabled'   => $this->two_factor_enabled,
            'unread_notifications' => $this->unreadNotifications->count(),
        ];
    }
}
