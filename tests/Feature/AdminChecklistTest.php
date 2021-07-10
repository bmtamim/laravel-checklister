<?php

namespace Tests\Feature;

use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\Task;
use App\Models\User;
use App\Services\MenuService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AdminChecklistTest extends TestCase
{
    use RefreshDatabase;

    public function test_manage_checklist_group()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $groupUrl = '/admin/checklist_groups';

        //ChecklistGroup Create Page Test
        $response = $this->actingAs($admin)->get($groupUrl . '/create');
        $response->assertStatus(200);

        //ChecklistGroup Store Test
        $response = $this->actingAs($admin)->post($groupUrl, [
            'name' => 'Test Group',
        ]);
        $response->assertRedirect('/admin');

        //ChecklistGroup Created or Not Test
        $testGroup = ChecklistGroup::where('name', 'Test Group')->first();
        $this->assertNotNull($testGroup);

        //ChecklistGroup Edit Page Test
        $response = $this->actingAs($admin)->get($groupUrl . '/' . $testGroup->id . '/edit');
        $response->assertStatus(200);

        //ChecklistGroup Update Test
        $response = $this->actingAs($admin)->put($groupUrl . '/' . $testGroup->id, [
            'name' => 'Updated Test Group',
        ]);
        $response->assertRedirect('/admin');

        //ChecklistGroup Updated or Not Test
        $updatedTestGroup = ChecklistGroup::where('name', 'Updated Test Group')->first();
        $this->assertNotNull($updatedTestGroup);

        //ChecklistGroup Menu Test
        $menu = (new MenuService())->get_menu();
        $this->assertEquals(1, ChecklistGroup::where('name', 'Updated Test Group')->count());

        //ChecklistGroup Delete Test
        $response = $this->actingAs($admin)->delete($groupUrl . '/' . $updatedTestGroup->id);
        $response->assertRedirect('/admin');

        //ChecklistGroup Menu Test After Deleting
        $menu = (new MenuService())->get_menu();
        $this->assertEquals(0, ChecklistGroup::where('name', 'Updated Test Group')->count());
    }

    public function test_manage_checklist()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist_url = '/admin/checklist_groups/' . $checklist_group->id . '/checklists';

        //Creating Checklist Test
        $response = $this->actingAs($admin)->get($checklist_url . '/create');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->post($checklist_url, [
            'name' => 'Test Checklist',
        ]);
        $response->assertRedirect('/admin');

        $checklist = Checklist::where('name', 'Test Checklist')->first();
        $this->assertNotNull($checklist);

        //test Editing the checklist
        $response = $this->get($checklist_url . '/' . $checklist->id . '/edit');
        $response->assertStatus(200);

        $response = $this->put($checklist_url . '/' . $checklist->id, [
            'name'        => 'Update Test Checklist',
            'description' => 'This is test checklist decryption',
        ]);
        $response->assertRedirect('/admin');

        $checklist = Checklist::where('name', 'Update Test Checklist')->first();
        $this->assertNotNull($checklist);

        //Test Checklist menu
        $menu = (new MenuService())->get_menu();
        $this->assertTrue($menu['admin']->first()->checklists->contains($checklist));

        //test DELETING checklist
        $response = $this->delete($checklist_url . '/' . $checklist->id);
        $response->assertRedirect('/admin');

        //Test Checklist menu
        $menu = (new MenuService())->get_menu();
        $this->assertFalse($menu['admin']->first()->checklists->contains($checklist));
    }

    public function test_manage_task()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $task_url = '/admin/checklists/' . $checklist->id . '/tasks';

        //test Creating Task
        $response = $this->actingAs($admin)->post($task_url, [
            'name'        => 'Test task',
            'description' => 'This is test task description',
        ]);
        $response->assertRedirect('admin/checklist_groups/' . $checklist_group->id . '/checklists/' . $checklist->id . '/edit');

        $task = Task::where('name', 'Test task')->get()->first();
        $this->assertNotNull($task);

        $menu = (new MenuService())->get_menu();
        $this->assertTrue($menu['admin']->first()->checklists->first()->tasks->contains($task));

        //test Editing task
        $response = $this->actingAs($admin)->get($task_url . '/' . $task->id . '/edit');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put($task_url . '/' . $task->id, [
            'name'        => 'Update Test task',
            'description' => 'This is test task description',
        ]);
        $response->assertRedirect('admin/checklist_groups/' . $checklist_group->id . '/checklists/' . $checklist->id . '/edit');

        $task = Task::where('name', 'Update Test task')->get()->first();
        $this->assertNotNull($task);

        $menu = (new MenuService())->get_menu();
        $this->assertTrue($menu['admin']->first()->checklists->first()->tasks->contains($task));

    }

    public function test_task_delete_with_order()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $task_url = '/admin/checklists/' . $checklist->id . '/tasks';

        $task1 = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1,]);
        $task2 = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 2,]);

        $response = $this->actingAs($admin)->delete($task_url . '/' . $task1->id);
        $response->assertRedirect('admin/checklist_groups/' . $checklist_group->id . '/checklists/' . $checklist->id . '/edit');

        $task = Task::where('name', $task2->name)->first();
        $this->assertNotNull($task);
        $this->assertEquals(1, $task->order);
    }

    public function test_task_reorder_with_livewire()
    {
        $checklist_group = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);

        $task1 = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 1,]);
        $task2 = Task::factory()->create(['checklist_id' => $checklist->id, 'order' => 2,]);

        Livewire::test(\App\Http\Livewire\Task::class, ['checklist' => $checklist])->call('taskOrderUp', $task2->id);
        $task = Task::find($task2->id);
        $this->assertEquals(1, $task->order);

        Livewire::test(\App\Http\Livewire\Task::class, ['checklist' => $checklist])->call('taskOrderDown', $task2->id);
        $task = Task::find($task2->id);
        $this->assertEquals(2, $task->order);
    }
}
