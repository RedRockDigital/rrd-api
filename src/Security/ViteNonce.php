<?php

namespace RedRockDigital\Api\Security;

use Illuminate\Support\Facades\Vite;
use Spatie\Csp\Nonce\NonceGenerator;

class ViteNonce implements NonceGenerator
{
    /**
     * @return string
     */
    public function generate(): string
    {
        return Vite::useCspNonce();
    }
}
