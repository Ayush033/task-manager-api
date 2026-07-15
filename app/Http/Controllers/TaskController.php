<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
    $validated = $request->validate([
        'title' => 'required|string',
        'priority' => 'required|string',
        'due_date' => 'required|date',
        'user_id' => 'required|exists:users,id', // Expecting this in Postman
    ]);

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
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);  

        $validated = $request->validate([
        'title' => 'sometimes|string',
        'priority' => 'sometimes|string',
        'due_date' => 'sometimes|date',
        'status' => 'sometimes|string',
    ]);

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
