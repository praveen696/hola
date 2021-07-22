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

class RoleTest extends TestCase
{

    use RefreshDatabase;

   public function test_a_role_belongs_to_users() {
        $user = User::factory()->create(); 
        $role = Role::factory()->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $role->users); 
   }
    
    
}
