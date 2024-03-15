<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Utils\ErrorResolve;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    use ErrorResolve;

    /**
     * TaskController constructor
     *
     * @param TaskService $service
     */
    public function __construct(private readonly TaskService $service)
    {
    }

    /**
     * Get all tasks
     *
     * @param TaskRequest $request
     * @throws Exception
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $tasks = $this->service->getAllTasks(['*'], ['user', 'status']);
            return response()->json($tasks);
        } catch (Exception $exception) {
            return $this->displayError($exception);
        }
    }

    /**
     * Create a task.
     *
     * @param TaskRequest $request
     * @throws Exception
     * @return JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse
    {
        try {
            $created = $this->service->createTask([
                'user_id' => $request->get('user_id'),
                'status_id' => $request->get('status_id'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'started_at' => $request->get('isStarted') ? Carbon::now() : null,
            ]);

            return response()->json($created, 201);
        } catch (Exception $exception) {
            return $this->displayError($exception);
        }
    }

    /**
     * Update existing task.
     *
     * @param TaskRequest $request
     * @throws Exception
     * @return JsonResponse
     */
    public function update(TaskRequest $request): Response | JsonResponse
    {
        try {
            $updated = $this->service->updateTask($request->id, $request->safe()->all());

            if ($updated == false)
                return response('Ocorreu um erro ao atualizar a task.', Response::HTTP_BAD_REQUEST);

            return response()->json($updated);
        } catch (Exception $exception) {
            return $this->displayError($exception);
        }
    }

    /**
     * Delete task by id.
     *
     * @param TaskRequest $request
     * @throws Exception
     * @return Response
     */
    public function destroy(Request $request): Response | JsonResponse
    {
        try {
            $id = intval($request->id);
            $hasDeleted = $this->service->deleteTask($id);
            if (!$hasDeleted)
                return response("Não foi possível deletar a task com o id {$id}", Response::HTTP_BAD_REQUEST);

            return response()->noContent();
        } catch (Exception $exception) {
            return $this->displayError($exception);
        }
    }
}
