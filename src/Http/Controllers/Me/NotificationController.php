<?php

namespace App\Http\Controllers\Me;

use App\Actions\Me\MarkNotificationAsRead;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * @var array|false[]
     */
    public array $scopes = [
        'me.notifications.index'  => false,
        'me.notifications.update' => false,
    ];

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->response->respond($request->user()->unreadNotifications);
    }

    /**
     * @param  string  $notificationId
     * @param  MarkNotificationAsRead  $markNotificationAsRead
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(string $notificationId, MarkNotificationAsRead $markNotificationAsRead, Request $request): JsonResponse
    {
        $markNotificationAsRead($request->user(), $notificationId);

        return $this->response->respond();
    }
}
