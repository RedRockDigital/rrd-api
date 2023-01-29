<?php

namespace RedRockDigital\Api\Http\Controllers\Newsletter;

use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Newsletter\CreateSubscribeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Spatie\Newsletter\Facades\Newsletter;

class SubscribeController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'newsletter.subscribe' => false,
    ];

    /**
     * @param  CreateSubscribeRequest  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(CreateSubscribeRequest $request): JsonResponse
    {
        try {
            Newsletter::subscribe($request->get('email'));

            return $this->response->created();
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => __('Your email address already appears to be subscribed.'),
            ]);
        }
    }
}
