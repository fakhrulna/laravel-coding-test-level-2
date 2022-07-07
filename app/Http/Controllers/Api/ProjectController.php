<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Project;

class ProjectController extends Controller
{
    public function __construct(){
        $this->project = new Project();
    }

    public function allList(Request $request)
    {
        $data = $this->project::where('name', 'like', '%' . $request['q'] . '%')->paginate($request['pageSize'], ['*'], 'page', $request['pageIndex']);
        if ($request['sortDirection'] == 'ASC') {
            $data = $data->sortBy($request['sortBy']);
        } else {
            $data = $data->sortByDesc($request['sortBy']);
        }
        return $data;
    }

    public function list($id)
    {
        return $this->project::find($id);
    }

    public function create(Request $request)
    {
        return $this->project::create($request->all());
    }

    public function updateIdempotent(Request $request, $id)
    {
        $projects = $this->project::findOrFail($id);
        return $projects->update($request->all());
    }

    public function update(Request $request, $id)
    {
        $projects = $this->project::findOrFail($id);
        return $projects->update($request->all());
    }

    public function delete($id)
    {
        $this->project::find($id)->delete();
        return 'Delete Success';
    }
}
