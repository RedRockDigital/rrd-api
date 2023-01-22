<?php

namespace App\Log;

use Illuminate\Log\Logger;

/**
 * Final Class LogWithAuthContext
 */
final class LogAuthContext
{
    /**
     * @param Logger $logger
     *
     * @return void
     */
    public function __invoke(Logger $logger): void
    {
        $logger->withContext([
            'ip'      => request()?->ip(),
            'ua'      => request()?->userAgent(),
            'user_id' => request()?->user()?->id,
        ]);
    }
}
