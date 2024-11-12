<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use App\Classes\GeniusMailer;
use App\Models\Notification;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use View;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $rules 							= 	[
									        'email'   => 'required|email|unique:users',
									        'password' => 'required|confirmed|min:6|'
							                ];
        $validator 						= Validator::make(Input::all(), $rules);        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $gs 							= 	Generalsetting::findOrFail(1);
        $user 							= 	new User;
        $input 							= 	$request->all();        
        $input['password'] 				= 	bcrypt($request['password']);
        $user->email_verified 		= 	'Yes';
		$user->fill($input)->save();
        return response()->json('Successfully Registered');
    }
}
