<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class userChangeStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {

        $responsetask = $this->json('PUT',route('api.taskupdate', [ 'task_id'=> 1 ]),[
            'status' => 'IN_PROGRESS',
            'project_id' => 1,
            'action_by' => 3
        ]);
        $responsetask2 = $this->json('PUT',route('api.taskupdate', [ 'task_id'=> 1 ]),[
            'status' => 'READY_FOR_TEST',
            'project_id' => 1,
            'action_by' => 4
        ]);
    }
}
