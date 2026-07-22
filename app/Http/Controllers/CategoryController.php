<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return Category::where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $category = $request->user()->categories()->create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
            ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes',
        ]);

        $category = $request->user()->categories()->update($validated);

        return response()->json([
            'messgae' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    public function getTasksByCategory(Request $request, $name)
    {
    $category = Category::where('user_id', $request->user()->id)
                        ->where('name', $name)
                        ->firstOrFail();

   
    $tasks = $category->tasks;

    return response()->json([
        'category' => $category->name,
        'tasks_count' => $tasks->count(),
        'tasks' => $tasks
    ], 200);
}

    public function addCategory(Request $request, Category $category, Task $task)
{
    // Authorization check
    if ($task->user_id !== $request->user()->id || $category->user_id !== $request->user()->id) {
        return response()->json([
            'message' => 'Unauthorized action.'
        ], 403);
    }

    // Attach category without removing existing ones
    $task->categories()->syncWithoutDetaching([$category->id]);

    return response()->json([
        'message' => "Category '{$category->name}' added to task successfully.",
        'task' => $task->load('categories')
    ], 200);
}

public function removeCategory(Request $request, Category $category, Task $task)
{
    // Authorization check for BOTH task and category ownership
    if ($task->user_id !== $request->user()->id || $category->user_id !== $request->user()->id) {
        return response()->json([
            'message' => 'Unauthorized action.'
        ], 403);
    }

    $task->categories()->detach($category->id);

    return response()->json([
        'message' => "Category '{$category->name}' removed from task successfully.",
        'task' => $task->load('categories')
    ], 200);
}
}