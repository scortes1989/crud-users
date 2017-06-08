<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserBasicTest()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create([
            'role_id' => $role->id,
        ]);

        $this->assertTrue($user->role_id == $role->id);
    }
}
