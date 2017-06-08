<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    function testListsUsers()
    {
        $user = factory(User::class)->create();
        factory(User::class, 3)->create();

        $this->actingAs($user, 'api')
            ->get('api/v1/core/users')
            ->assertStatus(200)
            ->assertJson([
                'data' => User::orderBy('name')->get()->toArray(),
            ]);
    }

    function testShowAUser()
    {
        $auth = factory(User::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($auth, 'api')
            ->get('api/v1/core/users/'.$user->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => $user->load('role')->toArray(),
            ]);
    }

    function testStoreAUser()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $parameters = [
            'name' => 'sebastian',
            'email' => 'test@loquesea.cl',
            'password' => 1234,
            'role_id' => $role->id,
        ];

        $this->actingAs($user, 'api')
            ->post('api/v1/core/users', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data' => User::latest('id')->first()->makeHidden('deleted_at')->toArray(),
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $parameters['name'],
            'email' => $parameters['email'],
            'role_id' => $parameters['role_id'],
        ]);
    }

    function testValidateUserAtStore()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->json('POST', 'api/v1/core/users', [])
            ->assertStatus(422)
            ->assertJson([
                'name' => ['El nombre es obligatorio'],
                'email' => ['El email es obligatorio'],
            ]);
    }

    function testUpdateAUser()
    {
        $auth = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();

        $parameters = [
            'name' => 'sebastian',
            'email' => 'test@loquesea.cl',
            'password' => 1234,
            'role_id' => $role->id,
        ];

        $this->actingAs($auth, 'api')
            ->put('api/v1/core/users/'.$user->id, $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => User::latest('id')->first()->toArray(),
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $parameters['name'],
            'email' => $parameters['email'],
            'role_id' => $parameters['role_id'],
        ]);
    }

    function testDeleteAUser()
    {
        $auth = factory(User::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($auth, 'api')
            ->delete('api/v1/core/users/'.$user->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => $user->toArray(),
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }
}
