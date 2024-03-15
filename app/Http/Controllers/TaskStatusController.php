<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Utils\ErrorResolve;
use Exception;
use Illuminate\Http\JsonResponse;

class TaskStatusController extends Controller
{
    use ErrorResolve;

    public function index(): JsonResponse
    {
        try {
            $status = TaskStatus::query()->get();
            return response()->json($status);
        } catch (Exception $exception) {
            return $this->displayError($exception);
        }
    }
}
