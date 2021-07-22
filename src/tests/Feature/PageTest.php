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

class PageTest extends TestCase
{

    use RefreshDatabase;

    protected $admin;
    protected $page1;
    protected $page2;

    public function setUp() :void
    {
        parent::setUp();
        $this->admin = User::factory()
        ->hasRoles(1, [
            'name' => 'Admin',
            'description' => 'admin'
        ])
        ->create();

        $this->page1 = User::factory()
            ->hasRoles(1, [
                'name' => 'PAGE_1',
                'description' => 'page1'
            ])
            ->create();

        $this->page2 = User::factory()
            ->hasRoles(1, [
                'name' => 'PAGE_2',
                'description' => 'page2'
            ])
            ->create();
    }

    public function test_can_view_pag1_for_admin()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->admin, 'web');

        $response = $this->get('/page/1');

        $response->assertStatus(200);
    }
    public function test_can_view_pag1_for_page1_user()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->page1, 'web');

        $response = $this->get('/page/1');

        $response->assertStatus(200);
    }

    public function test_can_view_pag1_for_page2_user()
    {
        
        $this->actingAs($this->page2, 'web');

        $response = $this->get('/page/1');

        $response->assertForbidden();
    }
    public function test_can_view_pag2_for_admin()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->admin, 'web');

        $response = $this->get('/page/2');

        $response->assertStatus(200);
    }
    public function test_can_view_pag2_for_page1_user()
    {
        
        $this->actingAs($this->page1, 'web');

        $response = $this->get('/page/2');

        $response->assertForbidden();

    }

    public function test_can_view_pag2_for_page2_user()
    {
        
        $this->actingAs($this->page2, 'web');

        $response = $this->get('/page/2');

        $response->assertStatus(200);

        
    }
   
    
    
}
