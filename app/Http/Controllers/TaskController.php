<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskController;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
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
    public function show(Task $task)
    {
        Return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskController $request, string $id)
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
