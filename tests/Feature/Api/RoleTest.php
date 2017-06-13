<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    function testListsRoles()
    {
        $user = factory(User::class)->create();
        factory(Role::class, 3)->create();

        $this->actingAs($user, 'api')
            ->get('api/v1/core/roles')
            ->assertStatus(200)
            ->assertJson([
                'data' => Role::orderBy('name')->get()->toArray(),
            ]);
    }
}
