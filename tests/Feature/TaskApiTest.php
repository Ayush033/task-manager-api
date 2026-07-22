<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase; // Resets database after every test

    public function test_authenticated_user_can_create_task(): void
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson('/api/tasks', [
            'title'    => 'Learn Laravel Testing',
            'due_date' => now()->addDays(2)->toDateString(),
        ]);

    $response->assertStatus(201)
        ->assertJsonPath('title', 'Learn Laravel Testing');

    $this->assertDatabaseHas('tasks', [
        'title'   => 'Learn Laravel Testing',
        'user_id' => $user->id,
    ]);
}

    public function test_user_cannot_access_another_users_tasks(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $task = Task::factory()->create(['user_id' => $userA->id]);

        $response = $this->actingAs($userB)
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(404); // Forbidden
    }
}