<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use MinhD\Role;
use MinhD\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_can_has_a_role()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->roles()->save($role);
        $this->assertEquals(1, count($user->fresh()->roles));
        $this->assertEquals($role->id, $user->fresh()->roles->first()->id);
    }

    /** @test */
    function a_role_can_has_user()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $role->users()->save($user);
        $role->save();
        $this->assertEquals(1, count($user->roles));
    }

    /** @test */
    function it_can_have_many_roles()
    {
        $user = factory(User::class)->create();
        for ($i = 0; $i < 10; $i++) {
            $role = factory(Role::class)->create();
            $user->roles()->save($role);
        }
        $this->assertEquals(10, count($user->roles));
    }

    /** @test */
    function it_allows_user_to_have_role()
    {
        $user = factory(User::class)->create();
        $role1 = Role::create(['name' => 'role1']);
        $role2 = Role::create(['name' => 'role2']);
        $user->roles()->save($role1);
        $user->roles()->save($role2);
        $this->assertTrue($user->hasRole('role1'));
        $this->assertTrue($user->hasRole('role2'));
        $this->assertFalse($user->hasRole('role3'));
    }
}
