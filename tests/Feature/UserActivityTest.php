<?php

namespace Tests\Feature;

use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserActivityTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_user_register_and_redirect_to_welcome()
    {
        //user REGISTRATION test
        $response = $this->get('/register');
        $response->assertStatus(200);

        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $url = $this->faker->url;
        $password = $this->faker->password(8);
        $response = $this->post('/register', [
            'name'                  => $name,
            'email'                 => $email,
            'website'               => $url,
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect('welcome');

    }

    public function test_can_user_login_and_redirect_to_welcome_and_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->get('login');
        $response->assertStatus(200);

        //Check User Can Login
        $response = $this->post('login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('welcome');

        //check user can logout
        $response = $this->actingAs($user)->post('logout');
        $response->assertRedirect('/');
    }

    public function test_user_can_see_welcome_consult_page_after_login()
    {
        $user = User::factory()->create();
        //Check welcome page
        $response = $this->actingAs($user)->get('/welcome');
        $response->assertStatus(200);

        //Check welcome page
        $response = $this->actingAs($user)->get('/consultation');
        $response->assertStatus(200);
    }

    public function test_can_user_access_on_admin_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/admin');
        $response->assertStatus(403);

        //Checklist Group access test
        $checklist_group = ChecklistGroup::factory()->create();
        $response = $this->get('admin/checklist_groups/create');
        $response->assertStatus(403);

        //Checklist access test
        $checklist = Checklist::factory()->create(['checklist_groups_id' => $checklist_group->id]);
        $response = $this->get('admin/checklist_groups/' . $checklist_group->id . '/checklists/create');
        $response->assertStatus(403);

        //Task access test
        $response = $this->post('admin/checklists/' . $checklist->id . '/tasks/', [
            'name'        => 'Test task',
            'description' => 'This is test task description',
        ]);
        $response->assertStatus(403);

        //Pages access test
        $response = $this->get('admin/pages/1/edit');
        $response->assertStatus(403);


        //Users access test
        $response = $this->get('admin/users');
        $response->assertStatus(403);

    }
}
