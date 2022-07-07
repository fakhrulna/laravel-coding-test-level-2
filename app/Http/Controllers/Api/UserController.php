<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as Users;

class UserController extends Controller
{
    public function __construct(){
        $this->users = new Users();
    }

    public function allList(Request $request)
    {
        return $this->users::all();
    }

    public function list(Request $request, $id)
    {
        return $this->users::find($id);
    }

    public function create(Request $request)
    {
        return users::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
        ]);
    }

    public function updateIdempotent(Request $request, $id)
    {
        $user = users::findOrFail($id);
        $requestData = $request->all();

        if ($request['password'] != '') {

            $password = password_hash($request['password'], PASSWORD_DEFAULT);
            $requestData['password'] = $password;
        }

        foreach ($requestData as $key => $value) {
            if ($value == '') {
                unset($requestData[$key]);
            }
        }
        return $user->update($requestData);
    }

    public function update(Request $request, $id)
    {
        $user = users::findOrFail($id);
        return $user->update($request->all());
    }

    public function delete(Request $request, $id)
    {
        users::find($id)->delete();
        return 'Delete Success';
    }
}
