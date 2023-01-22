<?php

/** @noinspection PhpUndefinedMethodInspection */

namespace RedRockDigital\Api\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;

/**
 * Abstract Class CRUDController
 *
 * @property-read FormRequest|null $indexRequest
 * @property-read FormRequest|null $showRequest
 * @property-read FormRequest|null $createRequest
 * @property-read FormRequest|null $updateRequest
 * @property-read FormRequest|null $destroyRequest
 * @property-read JsonResponse     $showResponse
 * @property-read JsonResponse     $createResponse
 * @property-read JsonResponse     $updateResponse
 * @property      ?Model           $entity
 */
abstract class CRUDController extends Controller implements CRUDControllerInterface
{
    /**
     * @var string|null
     */
    protected ?string $model = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->resolve();
    }

    /**
     * Resolve and Create Eloquent Object
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function index(Request $request): JsonResponse
    {
        $this->request($request, 'index');

        return $this->response->respond(
            $this->response($this->entity::paginate(), 'index', false)
        );
    }

    /**
     * Resolve and Create Eloquent Object
     *
     * @param  Request  $request
     * @param  string|int|null  $uuid
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function show(Request $request, string|int $uuid = null): JsonResponse
    {
        $this->request($request, 'show');

        return $this->response->respond(
            $this->response($this->entity::findOrFail($uuid), 'show')
        );
    }

    /**
     * Resolve and Create Eloquent Object
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        return $this->response->created(
            $this->response(
                $this->entity::create($this->request($request, 'create')),
                'create'
            )
        );
    }

    /**
     * Resolve and Update Eloquent Object
     *
     * @param  Request  $request
     * @param  string|int|null  $uuid
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function update(Request $request, string|int $uuid = null): JsonResponse
    {
        $model = $this->entity::findOrFail($uuid);

        $model->update($this->request($request, 'updateRequest'));

        return $this->response->respond(
            $this->response($model, 'updateResponse')
        );
    }

    /**
     * Resolve and Destroy Eloquent Object
     *
     * @param  Request  $request
     * @param $uuid
     * @return JsonResponse
     */
    public function destroy(Request $request, $uuid): JsonResponse
    {
        $this->entity::destroy($uuid);

        return $this->response->deleted();
    }

    /**
     * @param  Request  $request
     * @param  string  $action
     * @return array
     *
     * @throws ValidationException
     */
    private function request(Request $request, string $action): array
    {
        // Check if the user has the correct

        // Get all the data on the in-coming request
        $data = $request->all();

        // If a request is present and is not null
        // We will use the request and retrieve the validated data
        if ($this->$action !== null) {
            $this->validate($request, $this->$action->rules());
        }

        return $data;
    }

    /**
     * @param  mixed  $data
     * @param  string  $action
     * @param  bool  $singular
     * @return mixed|void
     */
    private function response(mixed $data, string $action, bool $singular = true)
    {
        if ($singular) {
            return $this->$action::make($data);
        }

        return $this->$action::collection($data);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    private function resolve(): void
    {
        // Attempt to resolve the Model, ensure it's the correct instance
        // Assign the Model to its string value and create a new instance of the Model
        $this->model = $this->model();
        $this->entity = new $this->model();

        // If not, thrown an error alerting it needs to be an \Eloquent\Model
        if (!$this->entity instanceof Model) {
            throw new Exception("Model $this->model is not instance of Illuminate\Database\Eloquent\Model");
        }

        // Attempt to grab a collection of the requests
        // We will check to ensure they are an instance of Illuminate\Foundation\Http\FormRequest
        // Then bind them to $this context for each action
        collect($this->requests())->each(function ($class, $action) {
            if (!new $class() instanceof FormRequest) {
                throw new Exception("Request $class is not instance of Illuminate\Foundation\Http\FormRequest");
            }

            $this->{$action.'Request'} = new $class();
        });

        // Attempt to grab a collection of the requests
        // We will check to ensure they are an instance of Illuminate\Foundation\Http\FormRequest
        // Then bind them to $this context for each action
        collect($this->responses())->each(function ($class, $action) {
            if (!new $class() instanceof JsonResource) {
                throw new Exception("Request $class is not instance of Illuminate\Http\Resources\Json\JsonResource");
            }

            $this->{$action.'Response'} = $class;
        });
    }
}
