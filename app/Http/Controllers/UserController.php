<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ordent\RamenRest\Controllers\RestController;
use Ordent\RamenAuth\Auth\AuthTrait;
use App\Http\Model\User;
use App\Http\Model\Role;
use Ordent\RamenRest\Requests\RestRequestFactory;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\PasswordResetController;
use Validator;

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
            'email' => 'requiredWithoutAll:phone,username',
            'username' => 'requiredWithoutAll:phone,email',
            'phone' => 'requiredWithoutAll:email,username',
            'password' => 'required'
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
        $validator = Validator::make($request->all(), [
            'email' => 'requiredWithoutAll:phone,username',
            'username' => 'requiredWithoutAll:phone,email',
            'phone' => 'requiredWithoutAll:email,username',
            'password' => 'required'
        ]);

        if($validator->fails()){
            throw ValidationException::withMessages($validator->errors()->getMessages());
        }
        $type = head(array_keys(array_except($request->all(), 'password')));
        $roles = $request->input('roles', false);
        return $this->typeLogin($request[$type], $request->password, $type, $roles);


        try {
            $request = RestRequestFactory::createRequest($this->model, "login");
        } catch (ValidationException $e) {
            return response()->exceptionResponse($e);
        }
        $credentials =  $request -> only('email','password');
        if($credentials["email"] == null && $credentials["password"] == null){
            $credentials = $request->json()->all();
        }

        try{
            if (! $token = AuthTrait::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }catch(Exception $e){
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
        $user = $this->model->where('email',$credentials["email"])->first();
        $user->roles;
        $token = AuthTrait::fromUser($user);


        if(count($user->role)){
            if(env('APP_ENV') == "production"){
                return response()->json(['data' => $user, 'token' => $token], 200)->cookie('token', $token, 60, "/", $request->getHttpHost(), true, true);
            }else{
                return response()->json(['data' => $user, 'token' => $token], 200)->cookie('token', $token, 60, "/", "localhost");
            }          
        }else{
            return response()->json(['error' => 'This account is not activated yet'], 403);
        }        

        
    }

    

}
