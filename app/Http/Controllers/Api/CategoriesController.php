<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\CategoriesModel;
use Auth;
use DB;
use Validator;
class CategoriesController extends Controller
{
    public function getCategories( Request $request )
    {
    	$validator 				= 	Validator::make($request->all(), [
            'parentCategoryID' 	=> 	'required',
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        $input 						= 	$request->all();
        $categories 				= 	DB::table('categories')->where('category_id',$input['parentCategoryID'])->get();
        $re_cat_ar 					=	[];$i=0;
        foreach ($categories as $key => $value) {
        	$re_cat_ar[$i]['id']		=	$value->id;
        	$re_cat_ar[$i]['name']		=	$value->name;
        	$re_cat_ar[$i]['slug']		=	$value->slug;
        	if( isset( $value->photo )){
        		$re_cat_ar[$i]['photo']		=	'assets/images/categories/'.$value->photo;
        	}else{
        		$re_cat_ar[$i]['photo']		=	'';
        	}$i++;
        }
        $response               =   array();
        $response['status']     =   200;
        $response['message']    =   'Successfully Executed ';
        $response['data']		=	$re_cat_ar;   	
        return response()->json(['success'=>$response]);
    }
}
