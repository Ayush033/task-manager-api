<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($request->user()->tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
    $validated = $request->validated();
    $validated['user_id'] = $request->user()->id;

    $task = Task::create($validated);

    return response()->json($task, 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $task = Task::findOrFail($id);  
        $task -> update($validated);
    
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        $task -> delete();

        return response()->json(['Task deleted successfully']);
    }
}
