<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class createUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->userAdmin();
        $response1 = $this->userOwner();
        $response2 = $this->userMember();
        $response3 = $this->userMember2();
        echo "User created";
    }

    public function userAdmin()
    {
        $this->json('POST',route('api.usercreate'),[
            'name' => 'Admin',
            'username' => 'Admin',
            'password' => 123456,
            'role' => 'ADMIN',
            'action_by' => 1
        ]);
    }

    public function userOwner()
    {
        $this->json('POST',route('api.usercreate'),[
            'name' => 'Owner',
            'username' => 'Owner',
            'password' => 123456,
            'role' => 'PRODUCT_OWNER',
            'action_by' => 1
        ]);
    }

    public function userMember()
    {
        $this->json('POST',route('api.usercreate'),[
            'name' => 'Member',
            'username' => 'Member',
            'password' => 123456,
            'role' => 'TEAM_MEMBER',
            'action_by' => 1
        ]);
    }

    public function userMember2()
    {
        $this->json('POST',route('api.usercreate'),[
            'name' => 'Member2',
            'username' => 'Member2',
            'password' => 123456,
            'role' => 'TEAM_MEMBER',
            'action_by' => 1
        ]);
    }
}
