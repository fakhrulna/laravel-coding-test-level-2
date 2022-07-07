<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User as Users;

class createProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_example()
    {
        $response = $this->json('POST',route('api.projectcreate'),[
            'name' => 'New Project1',
            'action_by' => 2
        ]);
        $data = json_decode($response->getContent(), true);

        $project_id = $data['id'];

        $responseUser = $this->json('GET',route('api.alluser'),[
            "action_by" => 1
        ]);

        $dataUser = json_decode($responseUser->getContent(), true);

        foreach ($dataUser as $key => $value) {
            if ($value['role'] == 'TEAM_MEMBER') {
                $responsetask = $this->json('POST',route('api.taskcreate'),[
                    'title' => 'task for '.$value['name'],
                    'description' => 'Test Project',
                    'project_id' => $project_id,
                    'user_id' => $value['id'],
                    'action_by' => 2
                ]);
            }
        }

        echo "Project created, and assigned team member for task";
    }
}
