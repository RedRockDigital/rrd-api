<?php

use RedRockDigital\Api\Models\{
    Team,
    User
};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('team')) {
    /**
     * @return Team|null
     */
    function team(): ?Team
    {
        /** @var User $user */
        $user = request()?->user();

        return $user?->team;
    }
}

if (!function_exists('actions')) {
    /**
     * @param $action
     * @param  mixed  ...$arguments
     * @return mixed
     */
    function actions($action, ...$arguments): mixed
    {
        return (new $action())(...$arguments);
    }
}

if (!function_exists('vite')) {
    /**
     * Returns an absolute path to a Vite asset.
     *
     * @param  string  $filename The asset filename/entrypoint to load
     * @param  string  $buildDirectory Vite build directory
     * @return string
     *
     * @throws Exception
     */
    function vite(string $filename, string $buildDirectory = 'build'): string
    {
        // handle hot reloading
        if (is_file(public_path('/hot'))) {
            $url = rtrim(file_get_contents(public_path('/hot')));

            return "$url/$filename";
        }

        // load our entrypoint from our manifest.
        $manifestPath = public_path("$buildDirectory/manifest.json");

        if (is_file($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);

            if (!$manifest[$filename]['file'] ?? null) {
                throw new Exception('Unknown vite entrypoint '.$filename);
            }

            return $buildDirectory.'/'.$manifest[$filename]['file'];
        }

        throw new Exception('Unable to load Vite manifest file at '.$manifestPath);
    }
}

if (!function_exists('upload_file')) {
    /**
     * Handles a file by moving it from tmp to perm storage
     *
     * @param  string  $key
     * @param  string  $disk
     *
     * @return string
     */
    function upload_file(string $key, string $disk = 's3'): string
    {
        $permKey = Str::after($key, 'tmp/');

        Storage::disk($disk)->copy(
            $key,
            $permKey
        );

        return $permKey;
    }
}

if (!function_exists('terminate')) {
    /**
     * @throws Throwable
     */
    function terminate(Throwable $throwable): void
    {
        if ($throwable->getCode() <= 499) {
            abort($throwable->getCode(), $throwable->getMessage());
        }

        if ($throwable->getCode() >= 500 && $throwable->getCode() <= 599) {
            throw $throwable;
        }
    }
}
