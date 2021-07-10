<?php

namespace Tests\Feature;

use App\Http\Livewire\ChecklistShow;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserChecklistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_load_checklist_page()
    {
        $user = User::factory()->create();
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $response = $this->actingAs($user)->get('/checklist/' . $checklist->id);
        $response->assertStatus(200);

        //Check CLONE checklist to user
        $checklists = Checklist::where('checklist_id', $checklist->id)->where('user_id', $user->id)->get();
        $this->assertNotNull($checklists);

        //Checklist Task test
        $task = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1]);
        Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->assertCount('checklist.tasks', 1);
    }

    public function test_can_complete_task_livewire()
    {
        $user = User::factory()->create();
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $task = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1]);

        $response = Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->call('complete_task', $task->id);
        $response->assertStatus(200);

        $user_tasks = Task::where('task_id', $task->id)->where('user_id', auth()->id())->whereNotNull('completed_at')->get();
        $this->assertNotNull($user_tasks);
    }

    public function test_can_add_to_my_day_livewire()
    {
        $user = User::factory()->create();
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $task = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1]);
        $user_task_create = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1, 'user_id' => $user->id, 'task_id' => $task->id]);
        $user_task = Task::query()->where(['user_id' => $user->id, 'task_id' => $task->id])->first();
        $this->assertEquals($user->id, $user_task->user_id);

        $response = Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->call('add_to_my_day', $user_task->id);
        $response->assertStatus(200);

        $response = Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->call('add_to_my_day', $user_task->id);
        $response->assertStatus(200);
    }

    public function test_can_add_to_important_livewire()
    {
        $user = User::factory()->create();
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $task = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1]);
        $user_task_create = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1, 'user_id' => $user->id, 'task_id' => $task->id]);
        $user_task = Task::query()->where(['user_id' => $user->id, 'task_id' => $task->id])->first();
        $this->assertEquals($user->id, $user_task->user_id);

        $response = Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->call('add_to_important', $user_task->id);
        $response->assertStatus(200);
    }

    public function test_can_set_due_date_livewire()
    {
        $user = User::factory()->create();
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $task = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1]);
        $user_task_create = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1, 'user_id' => $user->id, 'task_id' => $task->id]);
        $user_task = Task::query()->where(['user_id' => $user->id, 'task_id' => $task->id])->first();
        $this->assertEquals($user->id, $user_task->user_id);

        $response = Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->call('set_due_date', $user_task->id, Carbon::now()->addDay()->toDateString());
        $response->assertStatus(200);
    }

    public function test_can_set_reminder_at_livewire()
    {
        $user = User::factory()->create();
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $task = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1]);
        $user_task_create = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1, 'user_id' => $user->id, 'task_id' => $task->id]);
        $user_task = Task::query()->where(['user_id' => $user->id, 'task_id' => $task->id])->first();
        $this->assertEquals($user->id, $user_task->user_id);

        $response = Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->call('set_reminder_at', $user_task->id, Carbon::now()->addDay()->toDateString());
        $response->assertStatus(200);
    }

    public function test_task_lists()
    {
        $user = User::factory()->create();
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $task = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1]);
        $user_task_create = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1, 'user_id' => $user->id, 'task_id' => $task->id]);
        $user_task = Task::query()->where(['user_id' => $user->id, 'task_id' => $task->id])->first();
        $this->assertEquals($user->id, $user_task->user_id);
        Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->call('add_to_my_day', $user_task->id);
        $response = $this->actingAs($user)->get('task_list/my_day');
        $response->assertStatus(200);
    }

}
