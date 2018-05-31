<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ordent\RamenRest\Controllers\RestController;
use Ordent\RamenAuth\Auth\AuthTrait;
use App\Http\Model\User;
use App\Http\Model\Role;
use Ordent\RamenRest\Requests\RestRequestFactory;
use Illuminate\Validation\ValidationException;

class UserController extends RestController
{

    use AuthTrait;
    
    protected $model = "\App\Http\Model\User";
    protected $uri = "/users/";
    
    public function addRoles(Request $request, $id){
        $validator = \Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id'
        ]);

        if($validator->fails()){
            throw ValidationException::withMessages($validator->errors()->getMessages());
        }
        $user = User::findOrFail($id);
        $role_id = $request->input('role_id');
        $roles = $user->roles->pluck('id')->toArray();
        if(!in_array(intval($role_id), $roles)){
            $user->roles;                                
            $user->roles()->attach($role_id);
        }
        $user->load('roles');
        $user->roles()->get();
        return response()->successResponse($this->wrapModel($user));
    }

    public function removeRoles(Request $request, $id){
        $validator = \Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id'
        ]);

        if($validator->fails()){
            throw ValidationException::withMessages($validator->errors()->getMessages());
        }
        $user = User::findOrFail($id);
        $role_id = $request->input('role_id');
        $user->roles()->detach($role_id);
        $user->load('roles');
        return response()->successResponse($this->wrapModel($user));
    }

    public function register(Request $request){
            try {
                $request = RestRequestFactory::createRequest($this->model, "store");
            } catch (ValidationException $e) {
                return response()->exceptionResponse($e);
            }
            $result = $this->processor->postItemStandard($request);
            $user = User::find($result['data']['id']);
        return response()->createdResponse($result);
    }

    	
	public function login(Request $request){
        try {
            $request = RestRequestFactory::createRequest($this->model, "login");
        } catch (ValidationException $e) {
            return response()->exceptionResponse($e);
        }
        $credentials = $request->only('email', 'password');
        if($credentials["email"] == null && $credentials["password"] == null)
        {
            $credentials = $request->json()->all();
        }
                
    } 

}
