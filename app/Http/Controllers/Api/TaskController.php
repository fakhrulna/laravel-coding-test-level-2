<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function __construct(){
        $this->task = new Task();
    }

    public function allList()
    {
        return $this->task::all();
    }

    public function list($id)
    {
        return $this->task::find($id);
    }

    public function create(Request $request)
    {
        $request->request->add(['status' => 'NOT_STARTED']);
        return $this->task::create($request->all());
    }

    public function updateIdempotent(Request $request, $id)
    {
        if (!in_array($request['status'], ['NOT_STARTED',"IN_PROGRESS",'READY_FOR_TEST','COMPLETED'])) {
            return 'Status not exist in the list (NOT_STARTED, IN_PROGRESS, READY_FOR_TEST, COMPLETED)';
        }

        $tasks = $this->task::findOrFail($id);

        $checkRole = User::find($request['action_by']);
        $role = $checkRole->role;
        $member_id = $checkRole->id;
        $timestamp = Carbon::now();
        $project_id = $request['project_id'];

        if ($role == 'TEAM_MEMBER') {
            $status = $request['status'];

            $request = new $request();
            $request['status'] = $status;
            $request['status_ts'] = $timestamp;
            $status == 'IN_PROGRESS' ? $request['start_ts'] = $timestamp : '' ;

            $tasks = $this->task::where('project_id', $project_id)->where('user_id', $member_id);
        }
        return $tasks->update($request->all());
    }

    public function update(Request $request, $id)
    {
        if (!in_array($request['status'], ['NOT_STARTED',"IN_PROGRESS",'READY_FOR_TEST','COMPLETED'])) {
            return 'Status not exist in the list (NOT_STARTED, IN_PROGRESS, READY_FOR_TEST, COMPLETED)';
        }

        $tasks = $this->task::findOrFail($id);

        $checkRole = User::find($request['action_by']);
        $role = $checkRole->role;
        $member_id = $checkRole->id;
        $timestamp = Carbon::now();
        $project_id = $request['project_id'];

        $status = $request['status'];

        $request = new $request();
        $request['status'] = $status;
        $request['status_ts'] = $timestamp;

        $status == 'IN_PROGRESS' ? $request['start_ts'] = $timestamp : '' ;
        
        if ($role == 'TEAM_MEMBER') {
            $tasks = $this->task::where('project_id', $project_id)->where('user_id', $member_id);
        }
        
        return $tasks->update($request->all());
    }

    public function delete($id)
    {
        $this->task::find($id)->delete();
        return 'Delete Success';
    }}
