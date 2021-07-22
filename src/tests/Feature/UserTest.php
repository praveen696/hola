<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    protected $admin;
    protected $user;

    public function setUp() :void
    {
        parent::setUp();
        $this->admin = User::factory()
        ->hasRoles(1, [
            'name' => 'Admin',
            'description' => 'admin'
        ])
        ->create();

        $this->user = User::factory()
            ->hasRoles(1, [
                'name' => 'PAGE_1',
                'description' => 'page1'
            ])
            ->create();
    }

    public function test_can_list_users()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->admin, 'web');

        $response = $this->get('/users');

        $response->assertStatus(200);
    }
   
    public function test_list_users_for_non_admin_user()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'web');
        try {

            $this->get('/users');
        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_FORBIDDEN, $e->getStatusCode());
            return;
        }
    }
    public function test_list_users_without_login()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/users');
        $response->assertStatus(Response::HTTP_FOUND);
    }
    public function test_create_users()
    {
        $this->withoutExceptionHandling();
        $role = Role::factory()->create();
        Session::start();
        $userData = [
            'username' => 'test',
            'name' => 'test',
            'password' => 'abc1234',
            'role' => $role->id,
            '_token' => csrf_token()
        ];


        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/create', $userData);

        $response->assertStatus(Response::HTTP_CREATED);
    }
   
    public function test_create_users_for_non_admin_user()
    {
        $this->withoutExceptionHandling();      

        $role = Role::factory()->create();
        Session::start();
        $userData = [
            'username' => 'test',
            'name' => 'test',
            'password' => 'abc1234',
            'role' => $role->id,
            '_token' => csrf_token()
        ];
        $this->actingAs($this->user, 'web'); 

        try {

            $this->post('/users/create', $userData);

        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_FORBIDDEN, $e->getStatusCode());
            return;
        }
    }


    public function test_create_users_without_login()
    {
        $this->withoutExceptionHandling();
        $role = Role::factory()->create();
        Session::start();
        $userData = [
            'username' => 'test',
            'name' => 'test',
            'password' => 'abc1234',
            'role' => $role->id,
            '_token' => csrf_token()
        ];

        $response = $this->post('/users/create', $userData);

        $response->assertStatus(Response::HTTP_FOUND);
    }
    public function test_create_users_without_username()
    {
        // $this->withoutExceptionHandling();
        $role = Role::factory()->create();
        Session::start();
        $userData = [
            'username' => '',
            'name' => 'test',
            'password' => 'abc1234',
            'role' => $role->id,
            '_token' => csrf_token()
        ];


        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/create', $userData);
        $response->assertSessionHasErrors(['username']);
    }
    public function test_create_users_without_password()
    {
        // $this->withoutExceptionHandling();
        $role = Role::factory()->create();
        Session::start();
        $userData = [
            'username' => 'test1',
            'name' => 'test',
            'password' => '',
            'role' => $role->id,
            '_token' => csrf_token()
        ];


        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/create', $userData);
        $response->assertSessionHasErrors(['password']);
    }
    public function test_create_users_without_role()
    {
        Session::start();
        $userData = [
            'username' => 'test2',
            'name' => 'test',
            'password' => 'abc1234',
            'role' => '',
            '_token' => csrf_token()
        ];


        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/create', $userData);
        $response->assertSessionHasErrors(['role']);
    }
    public function test_create_users_with_duplicate_username()
    {
        $role = Role::factory()->create();
        Session::start();
        $existingUser = User::first();
        $userData = [
            'username' => $existingUser->username,
            'name' => 'test',
            'password' => 'abc1234',
            'role' => $role->id,
            '_token' => csrf_token()
        ];


        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/create', $userData);

        $response->assertSessionHasErrors(['username' => 'The username has already been taken.']);
    }

    public function test_edit_users()
    {
        $user = User::first();
        Session::start();
        $userData = [
            'username' => $user->username,
            'name' =>  $user->name,
            'password' => 'abc1234',
            'role' => $user->roles[0]->id,
            '_token' => csrf_token()
        ];
        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/edit/' . $user->id, $userData);

        $response->assertStatus(Response::HTTP_CREATED);
    }
   
    public function test_edit_users_for_non_admin_user()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        Session::start();
        $userData = [
            'username' => $user->username,
            'name' =>  $user->name,
            'password' => 'abc1234',
            'role' => $user->roles[0]->id,
            '_token' => csrf_token()
        ];
        $this->actingAs($this->user, 'web'); 

        try {

            $this->post('/users/edit/' . $user->id, $userData);

        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_FORBIDDEN, $e->getStatusCode());
            return;
        }
    }


    public function test_edit_users_without_login()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        Session::start();
        $userData = [
            'username' => $user->username,
            'name' =>  $user->name,
            'password' => 'abc1234',
            'role' => $user->roles[0]->id,
            '_token' => csrf_token()
        ];

        $response = $this->post('/users/edit/' . $user->id, $userData);

        $response->assertStatus(Response::HTTP_FOUND);
    }
    public function test_edit_users_without_username()
    {
        $user = User::first();
        Session::start();
        $userData = [
            'username' => '',
            'name' =>  $user->name,
            'password' => 'abc1234',
            'role' => $user->roles[0]->id,
            '_token' => csrf_token()
        ];
        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/edit/' . $user->id, $userData);

        $response->assertSessionHasErrors(['username']);
    }
    public function test_edit_users_without_password()
    {
        $user = User::first();
        Session::start();
        $userData = [
            'username' => $user->name,
            'name' =>  $user->name,
            'password' => '',
            'role' => $user->roles[0]->id,
            '_token' => csrf_token()
        ];
        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/edit/' . $user->id, $userData);
        $response->assertSessionHasErrors(['password']);
    }
    public function test_edit_users_without_role()
    {
        $user = User::first();
        Session::start();
        $userData = [
            'username' => $user->name,
            'name' =>  $user->name,
            'password' => 'abc1234',
            'role' => '',
            '_token' => csrf_token()
        ];
        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/edit/' . $user->id, $userData);
        $response->assertSessionHasErrors(['role']);
    }
    public function test_edit_users_with_duplicate_username()
    {
        $user = User::first();
        $anotherUser = User::where('id', '!=', $user->id)->first();
        Session::start();
        $userData = [
            'username' => $anotherUser->username,
            'name' =>  $user->name,
            'password' => 'abc1234',
            'role' => $user->roles[0]->id,
            '_token' => csrf_token()
        ];
        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/edit/' . $user->id, $userData);
        $response->assertSessionHasErrors(['username' => 'The username has already been taken.']);
    }
    public function test_delete_users()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
    
        $this->actingAs($this->admin, 'web');

        $response = $this->post('/users/delete/' . $user->id);

        $response->assertStatus(Response::HTTP_CREATED);
    }
   
    public function test_delete_users_for_non_admin_user()
    {
        $this->withoutExceptionHandling();
        $user = User::first();

        $this->actingAs($this->user, 'web'); 

        try {

            $this->post('/users/delete/' . $user->id);

        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_FORBIDDEN, $e->getStatusCode());
            return;
        }
    }


    public function test_delete_users_without_login()
    {
        $this->withoutExceptionHandling();
        $user = User::first();

        $response = $this->post('/users/delete/' . $user->id);

        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function show_create() {
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->admin, 'web');

        $response = $this->get('/users/create');

        $response->assertStatus(200);
    }
    public function show_edit() {
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->admin, 'web');

        $response = $this->get('/users/edit/1');

        $response->assertStatus(200);
    }

}
