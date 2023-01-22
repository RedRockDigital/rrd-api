<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;

/**
 * Class Response
 */
final class Response extends JsonResponse
{
    /**
     * Pagination Array
     *
     * @var array
     */
    private array $paginate = [];

    /**
     * Send response message back to client
     *
     * @noinspection ParameterDefaultValueIsNotNullInspection
     *
     * @param  array  $data
     * @param  null|int  $status
     * @return JsonResponse
     **/
    public function respond(mixed $data = [], ?int $status = null): JsonResponse
    {
        if (!empty($data)) {
            $response['data'] = $data;
        }

        if (!empty($this->paginate)) {
            $response['pagination'] = $this->paginate;
        }

        return response()->json($response ?? [], $status ?? $this->getStatusCode());
    }

    /**
     * Set paginate instance
     *
     * @param object $awarePaginator
     * @param ?int   $status
     *
     * @return JsonResponse
     */
    public function paginate(object $awarePaginator, ?int $status = null): JsonResponse
    {
        $this->paginate = [
            'total'        => $awarePaginator->total(),
            'last_page'    => $awarePaginator->lastPage(),
            'per_page'     => $awarePaginator->perPage(),
            'current_page' => $awarePaginator->currentPage(),
        ];

        return $this->respond($awarePaginator->items(), $status);
    }

    /**
     * Send a created response
     *
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function created(mixed $data = []): JsonResponse
    {
        return $this->respond($data)->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Send a deleted response
     *
     * @return JsonResponse
     */
    public function deleted(): JsonResponse
    {
        return $this->respond()->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * Send the exception message
     *
     * @param          $exception
     * @param null|int $status
     *
     * @return JsonResponse
     */
    public function exception($exception, ?int $status = null): JsonResponse
    {
        // If exception passed is not string, process the exception class.
        if (!is_string($exception)) {
            $exception = $exception::$message;
            $status = $exception::$status;
        }

        return $this->respond(['message' => $exception])->setStatusCode($status ?? $this->getStatusCode());
    }
}
