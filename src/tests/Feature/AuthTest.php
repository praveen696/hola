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

class AuthTest extends TestCase
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

    public function test_sign_in_page()
    {
        
        $response = $this->get('/signin');

        $response->assertStatus(200);
    }
    public function test_can_sign_in()
    {
        Session::start();
        $response = $this->call('POST', '/signin', [
            'userename' => 'admin',
            'password' => 'adminpassword',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(302, $response->getStatusCode());
    }
    public function test_sign_in_with_wrong_password()
    {
        Session::start();
        $response = $this->call('POST', '/signin', [
            'userename' => 'admin',
            'password' => 'test',
            '_token' => csrf_token()
        ]);
        $response->assertSessionHasErrors();
    }
    public function test_sign_in_with_wrong_username()
    {
        Session::start();
        $response = $this->call('POST', '/signin', [
            'userename' => 'test',
            'password' => 'adminpassword',
            '_token' => csrf_token()
        ]);
        $response->assertSessionHasErrors();
    }
}
