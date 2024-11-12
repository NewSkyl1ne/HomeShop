<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Api\AccountModel;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use App\Models\User;


class AccountController extends Controller
{
    public function signUp(Request $request)
    { 
    	$validator 				= 	Validator::make($request->all(), [
            'name' 					=> 	'required',
            'email' 				=> 	'required|email|unique:users',
            'phone' 				=> 	'required',
            'password' 				=> 	'required',
            //'city'                  =>  'required',
            //'building_no'           =>  'required',
           // 'zone'                  =>  'required',
           // 'street'                =>  'required',
        ]);
        if ($validator->fails()) {
            $error  =  $validator->errors();  
            $error  = json_decode($error);
            if( isset($error->email[0])){
                $msg        =   $error->email[0];
            }else{
                $msg        =   'Required files are cannot be null';  
            }
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =  $msg;  
            return response()->json(['success'=>$response]);
        }
        // SAVE NEW USER
        $input 					= 	$request->all();
        $account 				= 	new AccountModel();
        $account->name 			= 	$input['name'];
        $account->email 		= 	$input['email'];
        $account->phone 		= 	$input['phone'];
       // $account->city          =   $input['city'];
        //$account->phone         =   $input['building_no'];
        //$account->building_no   =   $input['zone'];
        //$account->zone_no       =   $input['street'];
        $account->password 	= 	bcrypt($input['password']);
        $token 					= 	md5(time().$input['name'].$input['email']);
        $account->verification_link  = 	$token;
        $account->affilate_code		 = 	md5($input['name'].$input['email']);   
        $account->app_token         =   md5($token.$account->affilate_code); 
        $account->save();
        if( isset( $account->id ) ){
        	$gs 					= 	Generalsetting::findOrFail(1);
        	// SEND VERIFICATION MAIL
	        $to 					= 	$input['email'];
			$subject 				= 	'Verify your email address :: Basket';	
			$msg 					= 	"Dear Customer,<br>
			 							We noticed that you need to verify your email address. 
			 							<a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
	        //Sending Email To Customer
	        /* 
	        if($gs->is_smtp == 1)
	        {
	        $data 					= 	[
								            'to' => $to,
								            'subject' => $subject,
								            'body' => $msg,
								        ];

	        $mailer 				= 	new GeniusMailer();
	        $mailer->sendCustomMail($data);

	        } 
	        */
	        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
	        mail($to,$subject,$msg,$headers);

            $response               =   array();
            $response['status']     =   200;
            $response['message']    =   'User registered successfully completed ';
            return response()->json(['success'=>$response]);
        }else{
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Error, Please try again later' ;
            return response()->json(['success'=>$response]);
        }
    }
    public function login(Request $request)
    { 
    	$validator 				= 	Validator::make($request->all(), [
            'email' 				=> 	'required|email',
            'password' 				=> 	'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =  'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], @$request->remember)) {
        	$token 			= 	Auth::guard('web')->user()->app_token;
            $user_id          =   Auth::guard('web')->user()->id;
            if( $token == '' ){
                $newToken = md5(time());
                DB::table('users')
                ->where("id", '=',  $user_id)
                ->update(['app_token'=> $newToken]);
                $token       =   $newToken;
            }
            $name           =   Auth::guard('web')->user()->name;
            $email           =   Auth::guard('web')->user()->email;
            $phone           =   Auth::guard('web')->user()->phone;
            $photo           =   Auth::guard('web')->user()->photo;
        	$response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Logined ';
            $response['data']['token']	=	$token;
            $response['data']['name']   =   $name;
            $response['data']['email']  =   $email;
            $response['data']['phone']  =   $phone;
            if( $photo != ''   ){
                $response['data']['photo']  =   'assets/images/users/'.$photo;
            }else{
                $response['data']['photo']  =   '';
            }
            
            return response()->json(['success'=>$response]);
        }else{
        	$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Credentials Doesn\'t Match !' ;
            return response()->json(['success'=>$response]);
        }
        
    }
    public function getBasicInfo(Request $request)
    {
    	$headerValue 				=   array_change_key_case(getallheaders(),CASE_LOWER);
    	$token 						=	@$headerValue['token'];
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
    			$userData 				=	[];

    			$userData['email']		=	@$user->email;	
    			$userData['name']		=	@$user->name;	
    			$userData['phone']		=	@$user->phone;	
                //$userData['address']    =   @$user->address; 
                //$userData['country']    =   '';  
                //$userData['city']       =   @$user->city; 
                //$userData['building_no']=   @$user->building_no;
                //$userData['zone']       =   @$user->zone_no;
               // $userData['street']     =   @$user->street_no;
                if( @$user->photo != '' ){
                   $userData['photo']      =   'assets/images/users/'.$user->photo;  
               }else{
                $userData['photo']      =  ''; 
               }
                 

    			$response               =   array();
	            $response['status']     =   200;
	            $response['message']    =   'Successfully Executed ';
	            $response['data']		=	$userData;
	            return response()->json(['success'=>$response]);
    		}else{
    			$response               =   array();
	            $response['status']     =   400;
	            $response['message']    =   'Token not found !' ;
	            return response()->json(['success'=>$response]);
    		}
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Token not found !' ;
            return response()->json(['success'=>$response]);
    	}
    }
    public function updateBasicInfo(Request $request)
    {
    	$validator 				= 	Validator::make($request->all(), [
            'name' 					=> 	'required',		
            //'email'                 =>  'required',                 
            'phone' 				=> 	'required',
            //'city'                  =>  'required',
            //'building_no'           =>  'required',
            //'zone'                  =>  'required',
            //'street'                =>  'required',
            //'photo'                 => 'mimes:jpeg,jpg,png,svg',
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =  'Required files are cannot be null'; 
            return response()->json(['success'=>$response]);
        }
    	$headerValue 				=   array_change_key_case(getallheaders(),CASE_LOWER);
    	$token 						=	@$headerValue['token'];
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
    			$user_id 				=	$user->id;
                $input                  =   $request->all();
                if ($file = $request->file('photo')) 
                {      
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images/users/',$name);
                    $input['photo'] = $name;

                }
		        
		        $account 				= 	new AccountModel();	        
		        $update 				=	$account->updateUserInfo($user_id,$input);
		        if( $update == true ){
                    $user                   =   $this->checkToken($token);
                    
                    $userData['email']      =   @$user->email;  
                    $userData['name']       =   @$user->name;   
                    $userData['phone']      =   @$user->phone;  
                    //$userData['address']    =   @$user->address; 
                    //$userData['country']    =   '';  
                    //$userData['city']       =   @$user->city; 
                    //$userData['building_no']=   @$user->building_no; 
                    //$userData['zone']       =   @$user->zone_no; 
                   // $userData['street']     =   @$user->street_no; 
                    //$userData['zip']        =   @$user->zip; 
                    if( @$user->photo != '' ){
                       $userData['photo']      =   'assets/images/users/'.$user->photo;  
                   }else{
                    $userData['photo']      =  ''; 
                   }
                     

                    $response               =   array();
                    $response['status']     =   200;
                    $response['message']    =   'Successfully Updated ';
                    $response['data']       =   $userData;
		        	// $response               =   array();
		         //    $response['status']     =   200;
		         //    $response['message']    =   'Successfully Updated ';
		         //    //$response['data']		=	$userData;
		            return response()->json(['success'=>$response]);
		        }else{
		        	$response               =   array();
		            $response['status']     =   400;
		            $response['message']    =   'Errors are found, please try again later !' ;
		            return response()->json(['success'=>$response]);
		        }
    		}else{
    			$response               =   array();
	            $response['status']     =   400;
	            $response['message']    =   'Token not found !' ;
	            return response()->json(['success'=>$response]);
    		}
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Token not found !' ;
            return response()->json(['success'=>$response]);
    	}
    }
    public function changePassword(Request $request)
    {
    	$validator 				= 	Validator::make($request->all(), [
            'oldPassword' 			=> 	'required',		            
            'newPassword' 			=> 	'required',
            'confirmPassword'       =>  'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =  'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }

        $headerValue 				=   array_change_key_case(getallheaders(),CASE_LOWER);
    	$token 						=	@$headerValue['token'];
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
    			$user_id 				=	$user->id;
    			$request 					= 	$request->all();
                if ($request['oldPassword']){
                    if (Hash::check($request['oldPassword'], $user->password)){
                        if ($request['newPassword'] == $request['confirmPassword']){
                            $password = Hash::make($request['newPassword']);
                            DB::table('users')
                                ->where("id", '=',  $user_id)
                                ->update(['password'=> $password,'updated_at'=>date('Y-m-d H:i:s')]);
                            $response               =   array();
                            $response['status']     =   200;
                            $response['message']    =   'Successfully change your passwprd!';
                            //$response['data']     =   $userData;
                            return response()->json(['success'=>$response]);
                        }else{
                            $response               =   array();
                            $response['status']     =   400;
                            $response['message']    =   'Confirm password does not match!' ;
                            return response()->json(['success'=>$response]);
                              
                        }
                    }else{
                        $response               =   array();
                        $response['status']     =   400;
                        $response['message']    =   'Current password Does not match!' ;
                        return response()->json(['success'=>$response]);
                    }
                }

    		}else{
    			$response               =   array();
	            $response['status']     =   400;
	            $response['message']    =   'Token not found !' ;
	            return response()->json(['success'=>$response]);
    		}
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Token not found !' ;
            return response()->json(['success'=>$response]);
    	}

    }
    public function fbLogin(Request $request)
    { 
        $validator              =   Validator::make($request->all(), [
            'fb_user_id'            =>  'required',
            'fb_token'              =>  'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =  'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        // SAVE NEW USER
        $input                  =   $request->all();
        $account                =   new AccountModel();
        $user_list              =   DB::table('users')
                                        ->where('app_token',$input['fb_user_id'])
                                        ->where('fb_user_id',$input['fb_user_id'])
                                        ->get()->first();
        if( isset( $user_list->id ) ){
            $response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Logined ';
            $response['data']['token']  =   $user_list->app_token;
            $response['data']['name']   =   @$user_list->name;
            $response['data']['email']  =   @$user_list->email;
            $response['data']['phone']  =   @$user_list->phone;
            $response['data']['city']   =   @$user_list->cityupdateBasicInfo;
            $response['data']['building_no']  =   @$user_list->building_no;
            $response['data']['zone']   =   @$user_list->zone_no;
            $response['data']['street'] =   @$user_list->street_no;
            $photo =    @$user_list->photo;;
            if( $photo != ''   ){
                $response['data']['photo']  =   'assets/images/users/'.$photo;
            }else{
                $response['data']['photo']  =   '';
            }
            return response()->json(['success'=>$response]);
        }else{
            $account->app_token         =   $input['fb_user_id']; 
            $account->fb_user_id        =   $input['fb_user_id']; 
            $account->save();
            
            $newFBData                  =   [];
            $newFBData['user_id']       =   $account->id;
            $newFBData['provider_id']   =   $input['fb_user_id'];
            $newFBData['provider']      =   'facebook';
            DB::table('social_providers')->insert($newFBData);
            if( isset( $account->id ) ){
                $response               =   array();
                $response['status']     =   200;
                $response['message']    =   'Successfully Logined ';
                $response['data']['token']  =   $input['fb_user_id'];
                $response['data']['name']   =   '';
                $response['data']['email']  =   '';
                $response['data']['phone']  =   '';
                $response['data']['city']   =   '';
                $response['data']['building_no']  =   '';
                $response['data']['zone']   =   '';
                $response['data']['street'] =   '';


                $photo =    '';
                if( $photo != ''   ){
                    $response['data']['photo']  =   'assets/images/users/'.$photo;
                }else{
                    $response['data']['photo']  =   '';
                }
                return response()->json(['success'=>$response]);
            }else{
                $response               =   array();
                $response['status']     =   400;
                $response['message']    =   'Error, Please try again later' ;
                return response()->json(['success'=>$response]);
            }
        }
    }
    public function gmailLogin(Request $request)
    { 
        $validator              =   Validator::make($request->all(), [
            'gmail_user_id'            =>  'required',
            'gmail_token'              =>  'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =  'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        // SAVE NEW USER
        $input                  =   $request->all();
        $account                =   new AccountModel();
        $user_list              =   DB::table('users')
                                        ->where('app_token',$input['gmail_user_id'])
                                        ->where('gmail_user_id',$input['gmail_user_id'])
                                        ->get()->first();
        if( isset( $user_list->id ) ){
            $response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Logined ';
            $response['data']['token']  =   $user_list->app_token;
            $response['data']['name']   =   @$user_list->name;
            $response['data']['email']  =   @$user_list->email;
            $response['data']['phone']  =   @$user_list->phone;
            $response['data']['city']   =   @$user_list->cityupdateBasicInfo;
            $response['data']['building_no']  =   @$user_list->building_no;
            $response['data']['zone']   =   @$user_list->zone_no;
            $response['data']['street'] =   @$user_list->street_no;
            $photo =    @$user_list->photo;;
            if( $photo != ''   ){
                $response['data']['photo']  =   'assets/images/users/'.$photo;
            }else{
                $response['data']['photo']  =   '';
            }
            return response()->json(['success'=>$response]);
        }else{
            //$account->name          =   @$input['name'];
            //$account->email         =   @$input['email'];
            //$account->phone         =   @$input['phone'];
            //$account->password      =   bcrypt($input['password']);
            //$token                  =   md5(time().$input['name'].$input['email']);
            //$account->verification_link  =  $token;
            //$account->affilate_code      =  md5($input['name'].$input['email']);   
            $account->app_token         =   $input['gmail_user_id']; 
            $account->gmail_user_id        =   $input['gmail_user_id']; 
            $account->save();
            $newFBData                  =   [];
            $newFBData['user_id']       =   $account->id;
            $newFBData['provider_id']   =   $input['gmail_user_id'];
            $newFBData['provider']      =   'google';
            DB::table('social_providers')->insert($newFBData);
            if( isset( $account->id ) ){
                $response               =   array();
                $response['status']     =   200;
                $response['message']    =   'Successfully Logined ';
                $response['data']['token']  =   $input['gmail_user_id'];
                $response['data']['name']   =   '';
                $response['data']['email']  =   '';
                $response['data']['phone']  =   '';
                $response['data']['city']   =   '';
                $response['data']['building_no']  =   '';
                $response['data']['zone']   =   '';
                $response['data']['street'] =   '';
                $photo =    '';
                if( $photo != ''   ){
                    $response['data']['photo']  =   'assets/images/users/'.$photo;
                }else{
                    $response['data']['photo']  =   '';
                }
                return response()->json(['success'=>$response]);
            }else{
                $response               =   array();
                $response['status']     =   400;
                $response['message']    =   'Error, Please try again later' ;
                return response()->json(['success'=>$response]);
            }
        }
    }
    public function forgot(Request $request)
    {
        $validator              =   Validator::make($request->all(), [
            'email'             =>  'required|email',
        ]);
        if ($validator->fails()) {
            $error  =  $validator->errors();  
            $error  = json_decode($error);
            if( isset($error->email[0])){
                $msg        =   $error->email[0];
            }else{
                $msg        =   'Required files are cannot be null';  
            }
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =  $msg;  
            return response()->json(['success'=>$response]);
        }
        $gs       =   Generalsetting::findOrFail(1);
        $input    =   $request->all();
        if (User::where('email', '=', $request->email)->count() > 0) {
                $admin = User::where('email', '=', $request->email)->firstOrFail();
                $autopass = str_random(8);
                $input['password'] = bcrypt($autopass);
                $admin->update($input);
                $subject = "Reset Password Request";
                $msg = "Your New Password is : ".$autopass;
                
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                mail($request->email,$subject,$msg,$headers);  
            $response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Your Password Reseted Successfully. Please Check your email for new Password.' ;
            return response()->json(['success'=>$response]);
        }else{
            $response              =   array();
            $response['status']     =   400;
            $response['message']    =   'No Account Found With This Email';
            return response()->json(['success'=>$response]);  
        }  
        
    }

    public function checkToken( $token =	'' )
    {
    	if( $token == '' ){
    		return false;
    	}
    	$all 						= 	DB::table('users')->where('app_token', $token)->first();
    	return $all;
    }
}
	       