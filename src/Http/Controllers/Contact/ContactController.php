<?php

namespace RedRockDigital\Api\Http\Controllers\Contact;

use RedRockDigital\Api\Http\Controllers\Controller;
use RedRockDigital\Api\Http\Requests\Contact\CreateContactRequest;
use RedRockDigital\Api\Mail\ContactSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'contact' => false,
    ];

    /**
     * @param  CreateContactRequest  $request
     * @return JsonResponse
     */
    public function __invoke(CreateContactRequest $request): JsonResponse
    {
        Mail::to(config('base.support_email'))->send(new ContactSubmission(...$request->all()));

        return $this->response->created();
    }
}
