<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // GET /api/tasks
    public function index(Request $request)
    {
        // Eager loading of 'categories' which API responses informative & efficient
        $tasks = $request->user()->tasks()->with('categories')->get();

        return response()->json($tasks, 200);
    }

    // POST /api/tasks
    public function store(StoreTaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->validated());

        return response()->json($task->load('categories'), 201);
    }

    // GET /api/tasks/{task}
    public function show(Request $request, Task $task)
    {
        // Ensure the task belongs to the user
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        return response()->json($task->load('categories'), 200);
    }

    // PUT/PATCH /api/tasks/{task}
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update($request->validated());

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task->load('categories')
        ], 200);
    }

    // DELETE /api/tasks/{task}
    public function destroy(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ], 200);
    }
}