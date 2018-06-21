<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ordent\RamenRest\Controllers\RestController;
use Ordent\RamenRest\Response\RestResponse;
use Ordent\RamenRest\Requests\RestRequestFactory;
use DateTime;

use App\Http\Model\PasswordReset;
use App\Http\Model\User;

class PasswordResetController extends Controller
{
    protected $model = "App\Http\Model\PasswordReset";
    protected $uri = "/passwordresets/";

    public function createToken (Request $request){
        $currentTime = date('Y-m-d H:i:s', time());
        $token = sha1($request->email.$currentTime);
        $request->request->add(['created_at' => $currentTime]);
        $request->request->add(['token' => $token]);
        $user = User::where('email', $request->email)->first();
        if (!$user){
            return response()->error(404, 'user not found');
        } else {
            try {
                $request = RestRequestFactory::createRequest($this->model, "store");
                
            } catch (ValidationException $e) {
                return response()->exceptionResponse($e);
            }
            try{
                
                $emailTemplate = passwords.email::where('name', 'email_reset_template')->first();
                $user = User::where('email', $request->email)->first();
                
                $email['sender'] = passwords.email::where('name', 'email_address_sender')->first();
                $email['alias'] = passwords.email::where('name', 'email_alias_seder')->first();
                $email['receiver'] = $request->email;

                \Mail::send( $emailTemplate->value, ['url' => env('CLIENT_DOMAIN').'/passwordreset/'.$token, 'name' => $user->name], function($message) use($email) 
                {
                    $message->subject('DEVI Password Reset');
                    $message->from($email['sender']->value, $email['alias']->value);
                    $message->to($email['receiver']);
                });        
                $data = $this->postItem($request, false);
            }catch(\Exception $e){
                dd($e);
            }
            
            return $data;

        }
    }

    public function checkRequest($token){
        $timestamp = date('Y-m-d H:i:s', time());
        $date = new DateTime;

        $date->modify('-1 days');
    		$formattedDate = $date->format('Y-m-d H:i:s');

        $requestCheck = PasswordReset::where('token', $token)
                              ->where('created_at', '>=', $formattedDate)
                              ->first();
        if ($requestCheck == null) {
            return response()->error(400, 'url expired');
        } else {
            return response()->json(['data' => $requestCheck], 200);
        }
    }

    public function reset(Request $request){
        $timestamp = date('Y-m-d H:i:s', time());
        $date = new DateTime;

        $date->modify('-1 days');
    		$formattedDate = $date->format('Y-m-d H:i:s');

        $requestCheck = PasswordReset::where('token', $request->token)
                              ->where('created_at', '>=', $formattedDate)
                              ->first();
      if ($requestCheck != null){
        $new_password = User::where('email', $requestCheck->email)->update(['password'=> bcrypt($request->password)]);
        $token_delete = PasswordReset::where('token', $request->token)->update(['token'=> '-']);
            return response()->json(['data' => $new_password], 200);
      }

            return response()->error(400);
    }
}
