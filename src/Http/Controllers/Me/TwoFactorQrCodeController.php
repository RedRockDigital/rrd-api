<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TwoFactorQrCodeController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.2fa.qr-code' => false,
    ];

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        return $this->response->respond([
            'svg' => $request->user()->twoFactorQrCodeSvg(),
        ]);
    }
}
