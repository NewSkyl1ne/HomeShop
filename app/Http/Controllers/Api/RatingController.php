<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\RatingModel;
use App\Models\Order;
use Auth;
use DB;
use Validator;

class RatingController extends Controller
{
    public function reviewsubmit(Request $request)
    {
		$user                       = Auth::user();
		$user_id 			=	$user->id;
		$input 				=	$request->all();
		$prev 				= 	DB::table('ratings')
								->where('product_id','=',$input['product_id'])
								->where('user_id','=',$user_id)
								->get();
		if(count($prev) > 0)
		{ 
			return response()->json(['success'=>[ 0 => 'You Have Reviewed Already.' ]], 400);              
		} 
		$rating 				= 	new RatingModel;
		$rating['user_id'] 		=	$user_id;
		$rating['product_id'] 	=	$input['product_id'];
		$rating['title']        =   $input['title'];
		$rating['review'] 		=	$input['review'];
		$rating['rating'] 		=	(int)$input['rating'];
		$rating['review_date'] 	= 	date('Y-m-d H:i:s');
		$rating->save();

		$response               =   array();
		$response['status']     =   200;
		$response['message']    =   'Your Rating Submitted Successfully.';	
		// $user = Auth::guard('web')->user();
		$product=db::table('products')->where('id',$input['product_id'])->first();
		$vendor=db::table('users')->where('id',$product->user_id)->first();
	
		$orders = Order::where('user_id','=',$user->id)->orderBy('id','desc')->get();
		return view('user.order.index',compact('user','orders'));    

    }
    public function listReviews(Request $request)
    {
    	$validator 				= 	Validator::make($request->all(), [
            'product_id' 			=> 	'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        $input 					=	$request->all();
        $prev 				= 	DB::table('ratings')
        								->join('users', 'users.id', '=', 'ratings.user_id')
    									->where('ratings.product_id','=',$input['product_id'])
    									->get();
    	if( isset($prev) ){
    		$reviews_data 			=	[];
    		$i 						=	0;
            
    		foreach ($prev as $key => $value) {$i++;
    			$reviews_data[$i]['user_name']	=	$value->name;
    			$reviews_data[$i]['photo']	=	'assets/images/users/'.$value->photo;
    			$reviews_data[$i]['rating']	=	$value->rating;
                $reviews_data[$i]['title'] =   $value->title;
    			$reviews_data[$i]['review']	=	$value->review;
    			$reviews_data[$i]['review_date']	=	$value->review_date;
    			$i++;
    		}
            $rating_5               =   DB::table('ratings')->where('product_id','=',$input['product_id'])->where('rating','=','5')->get();
            $rating_4               =   DB::table('ratings')->where('product_id','=',$input['product_id'])->where('rating','=','4')->get();
            $rating_3               =   DB::table('ratings')->where('product_id','=',$input['product_id'])->where('rating','=','3')->get();
            $rating_2               =   DB::table('ratings')->where('product_id','=',$input['product_id'])->where('rating','=','2')->get();
            $rating_1               =   DB::table('ratings')->where('product_id','=',$input['product_id'])->where('rating','=','1')->get();
            $ratingCount            =   [];
            $ratingCount['5']       =   count($rating_5);
            $ratingCount['4']       =   count($rating_4);
            $ratingCount['3']       =   count($rating_3);
            $ratingCount['2']       =   count($rating_2);
            $ratingCount['1']       =   count($rating_1);
    		$reviews_data 			= 	array_values($reviews_data);
    		$response               =   array();
	        $response['status']     =   200;
	        $response['message']    =   'Successfully Executed ';
	        $response['data']['cartlist']		=	$reviews_data;
            $response['data']['ratingCount']     =   $ratingCount;  

	        return response()->json(['success'=>$response]);
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);
    	}
    }

	public function reviewupdatesubmit(Request $request)
	{
	
		$user                       = Auth::user();
		$user_id 			=	$user->id;
		$input 				=	$request->all();
				$updating = DB::table('ratings')
				->where('product_id','=',$input['product_id'])
				->where('user_id','=',$user_id)
              ->update(['rating' => (int)$input['rating'],'review'=>$input['review']]);
			  if($updating)
			  {
				
				$orders = Order::where('user_id','=',$user->id)->orderBy('id','desc')->get();
				return view('user.order.index',compact('user','orders')); 
			  }else{
                $response               =   array();
                $response['status']     =   400;
                $response['message']    =   'Failed to update !' ;
                return response()->json(['success'=>$response]);
            }

	}

	public function reviewdelte()
	{
		$input=$_POST['id'];
		$delete_rating=DB::table('ratings')->where('id', $input)->delete();
			$response               =   array();
			$response['status']     =   200;
			$response['message']    =   'Successfully Executed ';
	        return response()->json(['success'=>$response]);

	}
  
}
