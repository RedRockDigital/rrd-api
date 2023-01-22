<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Trait HasUuid
 */
trait HasScope
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function hasScope(string|array $scope): bool
    {
        if (is_string($scope)) {
            $scope = [$scope];
        }

        return $this
            ->getScopesBaseQuery()
            ->whereHas('scopes', function ($q) use ($scope) {
                $q->whereIn('scope', $scope);
            })
            ->exists();
    }

    /**
     * @return Collection
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getScopesAttribute(): Collection
    {
        return $this
            ->getScopesBaseQuery()
            ->first()
            ->scopes
            ->map(fn ($scope) => $scope->scope);
    }

    /**
     * @return BelongsToMany
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getScopesBaseQuery(): BelongsToMany
    {
        return $this
            ->groups()
            ->with('scopes')
            ->wherePivot('team_id', request()->get('team_id', null) ?? $this->current_team_id);
    }
}
