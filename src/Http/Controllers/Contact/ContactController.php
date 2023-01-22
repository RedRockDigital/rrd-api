<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\CreateContactRequest;
use App\Mail\ContactSubmission;
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
