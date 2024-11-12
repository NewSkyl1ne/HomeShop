<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Api\PagesModel;
use Auth;
use DB;
use Validator;
class PagesController extends Controller
{
    public function getFaq()
    {
    	$faq 						= 	DB::table('faqs')->where('status','1')->get();
    	$faq_arr		 			=	[];
    	$i 							=	0;
    	foreach ($faq as $key => $value) { $i++;
    		$faq_arr[$i]['title'] = $value->title;
    		$faq_arr[$i]['details'] = $value->details;
    		
    	}

    	if ( isset($faq_arr) ) {
            $faq_arr = array_values($faq_arr);
    		$response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Executed ';
            $response['data']		=	$faq_arr;   	
            return response()->json(['success'=>$response]);
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);	
    	}
    	
    }
   	public function getPages( Request $request )
   	{
   		$validator 				= 	Validator::make($request->all(), [
            'slug' 					=> 	'required',
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        $input 						= 	$request->all();
        $pages 						= 	DB::table('pages')->where('slug',$input['slug'])->get();
        $pageData 					=	[];
        foreach ($pages as $key => $value) {
        	$pageData['title']		=		$value->title;
        	$pageData['slug']		=		$value->slug;
        	$pageData['details']	=		$value->details;
        }
        if ( isset($pageData) ) {
    		$response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Executed ';
            $response['data']		=	$pageData;   	
            return response()->json(['success'=>$response]);
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);	
    	}
   	}
   	public function contact_us( Request $request )
   	{
   		$validator 				= 	Validator::make($request->all(), [
            'name' 					=> 	'required',
            'email' 				=> 	'required|email',
            'message' 				=> 	'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
return response()->json(['success'=>$response]);
        }
        // SAVE NEW USER
        $input 					= 	$request->all();
        $name 					=	$input['name'];
        $email 					=	$input['email'];
        $message 				=	$input['message'];
        $to 					= 	'unais@whytecreations.co';
		$subject 				= 	'Contact US :: Inventory';	
		$msg 					= 	"Hi,<br>
									 Name:".$name."<br>
									 Email:".$email."<br>
									 Message:".$message."<br>
		 							";
		$gs 					= 	Generalsetting::findOrFail(1);
		//Sending Email To Customer
        if($gs->is_smtp == 1)
        {
        	$data 			    = 	[
							            'to' => $to,
							            'subject' => $subject,
							            'body' => $msg,
							        ];

	        $mailer 			= 	new GeniusMailer();
	        $mailer->sendCustomMail($data);
        }
 		$response               =   array();
        $response['status']     =   200;
        $response['message']    =   'Successfully sent your enquiry , we will contact you soon! ';
        return response()->json(['success'=>$response]);
   	}
}
