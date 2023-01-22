<?php

namespace RedRockDigital\Api\Traits;

trait HasModelRoutes
{
    /**
     * @return void
     */
    public function initializeHasModelRoutes(): void
    {
        $this->casts = array_merge($this->casts, [
            'routes' => 'array',
        ]);

        $this->appends = array_merge($this->appends, [
            'routes',
        ]);
    }

    /**
     * @return array
     */
    public function getRoutesAttribute(): array
    {
        return [
            'show'   => $this->getShowRoute(),
            'update' => $this->getUpdateRoute(),
            'delete' => $this->getDeleteRoute(),
        ];
        $routes = [
            'show'   => $this->getShowRoute(),
            'update' => $this->getUpdateRoute(),
            'delete' => $this->getDeleteRoute(),
        ];

        foreach ($routes as &$route) {
            $route = str_replace([config('app.url').'/api', '/api'], '', $route);
        }

        return $routes;
    }

    /**
     * @return string|null
     */
    public function getShowRoute(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getUpdateRoute(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getDeleteRoute(): ?string
    {
        return null;
    }
}
