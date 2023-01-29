<?php

namespace RedRockDigital\Api\Http\Controllers\Me;

use RedRockDigital\Api\Actions\Me\CreateToken;
use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Me\CreateTokenRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;

class TokenController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.tokens.index'   => false,
        'me.tokens.store'   => false,
        'me.tokens.destroy' => false,
    ];

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tokens = Passport::token()
            ->where([
                ['user_id', $request->user()->id],
                ['client_id', Passport::personalAccessClient()->first()->client_id],
                ['revoked', false],
            ])
            ->paginate();

        return $this
            ->response
            ->paginate($tokens);
    }

    /**
     * @param  CreateToken  $createToken
     * @param  CreateTokenRequest  $request
     * @return JsonResponse
     */
    public function store(CreateToken $createToken, CreateTokenRequest $request): JsonResponse
    {
        $token = $createToken($request->user(), $request->get('name'), $request->get('expiration'));

        return $this->response->created($token);
    }

    /**
     * @param  Request  $request
     * @param $tokenId
     * @return JsonResponse
     */
    public function destroy(Request $request, $tokenId): JsonResponse
    {
        $token = Passport::token()->where([
            ['id', $tokenId],
            ['user_id', $request->user()->id],
        ])->firstOrFail();

        $token->revoke();

        return $this->response->deleted();
    }
}
