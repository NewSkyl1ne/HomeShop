<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\ProductsModel;
use Auth;
use DB;
use Validator;

class ProductsController extends Controller
{
	public function __construct()
    {
        $this->homePageLimit 		=	6;
        $this->pageLimit            =   10;
    }
    public function getHomeProducts( Request $request )
    {
    	$validator 				= 	Validator::make($request->all(), [
            'slug' 	=> 	'required',            
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        $headerValue                =      array_change_key_case(getallheaders(),CASE_LOWER);
        $token                      =   @$headerValue['token'];
        if( @$token != '' ){
            $user                   =   $this->checkToken($token);
            $user_id                =   $user->id;
        }
        $input 						= 	$request->all();
        if( $input['slug'] == 'top' ){
        	$products 				= 	DB::table('products')->where('top','1')->where('status','1')->limit($this->homePageLimit)->orderBy('created_at','DESC')->get();
        }
        if( $input['slug'] == 'best' ){
            $products               =   DB::table('products')->where('best','1')->where('status','1')->limit($this->homePageLimit)->orderBy('created_at','DESC')->get();
        }
        if( isset($products) ){
        	$products_arr 			=	[];
        	$i 						=	0;
        	foreach ($products as $key => $value) {
                $products_arr[$i]['id']     =   $value->id;
        		$products_arr[$i]['name']	=	$value->name;
        		$products_arr[$i]['slug']	=	$value->slug;
        		$products_arr[$i]['price']	=	$value->price;
        		$products_arr[$i]['photo']	=	'assets/images/products/'.$value->photo;
                $stars                      =   DB::table('ratings')
                                                ->where('product_id',$value->id)
                                                ->avg('rating');
                $ratings                    =   number_format((float)$stars, 1, '.', '');
                $products_arr[$i]['stars']  =   $ratings;
                $products_arr[$i]['stock']  =   $value->stock;
                $wishlists                  =   0;
                if( @$user_id != '' ){
                    $wishlists                 =   DB::table('wishlists')
                                                    ->where('user_id',$user_id)
                                                    ->where('product_id',$value->id)
                                                    ->get()->first();
                     if( @$wishlists->id != ''){
                        $wishlists              =   1;
                    }else{
                        $wishlists              =   0;
                    }
                }
                $products_arr[$i]['wishlists']  =   $wishlists;
        		$i++;
        	}
        	$response               =   array();
	        $response['status']     =   200;
	        $response['message']    =   'Successfully Executed ';
	        $response['data']		=	$products_arr;   	
	        return response()->json(['success'=>$response]);
        }else{
        	$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);
        }
        
    }
    public function productListing( Request $request )
    {
        $validator              =   Validator::make($request->all(), [
            'page'  =>  'required',            
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        $headerValue                =      array_change_key_case(getallheaders(),CASE_LOWER);
        $token                      =   @$headerValue['token'];
        
        if( @$token != '' ){
            $user                   =   $this->checkToken($token);
            $user_id               =   $user->id;
        }
        
        $input                     =   $request->all();
        $category_id               =    @$input['category_id'];
        $price_from                =    @$input['price_from'];
        $price_to                  =    @$input['price_to'];
        $keywords                  =    @$input['keywords'];
        $slug                      =    @$input['slug'];
        $current_product           =    @$input['current_product'];
        $price_filter              =    @$input['price_filter'];
        if( $category_id != '' && $category_id != 0 ){
            $searchcat                   =   DB::table('categories')->where('id',$category_id)->get()->first();
            // if( $searchcat->category_id == 0){
            //     $cat                   =   DB::table('categories')->where('category_id',$category_id)->get();
            //     $cat_id_list            =   [];
            //     $cat_id_list[]          =   $category_id;
            //     foreach ($cat as $key => $value) {
            //         $cat_id_list[]  =   $value->id;
            //     }
            // }else{
            //     $cat_id_list            =   [];
            //     $cat_id_list[]          =   $category_id;
            // }
        }
         if( $input['page'] != '' && $input['page'] != 0  ){
            $newcount               =   ( $input['page'] -1 ) * $this->pageLimit;
            $query                  =   DB::table('products')->where('status','1');
            if( $category_id != '' && $category_id != 0 ){
                if( $searchcat->category_id == 0){
                    $query->where('category_id',$category_id);
                }else{
                    $query->where('subcategory_id',$category_id);
                }
            }
            if( $price_from != '' && $price_to != '' ){
                $query->whereBetween('price', [$price_from, $price_to]);
            }
            if( $keywords != ''){
                $keywords       =   trim($keywords);
                $query->where('name', 'LIKE', "%$keywords%");
            }
            if( $slug != ''){
                $slug       =   strtolower(trim($slug));
                if( $slug == 'best'){
                    $query->where('best', '=', "1");
                }
                if( $slug == 'top'){
                    $query->where('v', '=', "1");
                }
                if( $slug == 'latest'){
                    $query->where('latest', '=', "1");
                }
                if( $slug == 'discount'){
                    $query->where('is_discount', '=', "1");
                }  
            }
            if( $current_product != '' ){
                $query->where('id', '!=', $current_product);
            }
            $query->skip($newcount)->take($this->pageLimit);
            if( $price_filter == 'A_D'){
                $query->orderBy('price','ASC');
            }elseif( $price_filter == 'D_A'){
                $query->orderBy('price','DESC');
            }else{
                $query->orderBy('created_at','DESC');
            }
            
            $products                 =    $query->get();                            
        }else{
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);
        }
        
        if( isset($products) ){
            $products_arr           =   [];
            $i                      =   0;
            foreach ($products as $key => $value) {
                $products_arr[$i]['id']     =   $value->id;
                $products_arr[$i]['name']   =   $value->name;
                $products_arr[$i]['slug']   =   $value->slug;
                $products_arr[$i]['price']  =   $value->price;
                $products_arr[$i]['photo']  =   'assets/images/products/'.$value->photo;
                $stars                      =   DB::table('ratings')
                                                ->where('product_id',$value->id)
                                                ->avg('rating');
                $ratings                    =   number_format((float)$stars, 1, '.', '');
                $products_arr[$i]['stars']  =   $ratings;
                $products_arr[$i]['stock']  =   $value->stock;
                $wishlists                  =   0;
                if( @$user_id != '' ){
                    $wishlists                 =   DB::table('wishlists')
                                                    ->where('user_id',$user_id)
                                                    ->where('product_id',$value->id)
                                                    ->get()->first();
                    if( @$wishlists->id != ''){
                        $wishlists              =   1;
                    }else{
                        $wishlists              =   0;
                    }
                }
                $products_arr[$i]['wishlists']  =   $wishlists;
                $i++;
            }
            $response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Executed ';
            $response['data']       =   $products_arr;      
            return response()->json(['success'=>$response]);
        }else{
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);
        }
    }
    public function productDetails( Request $request  )
    {
        $validator              =   Validator::make($request->all(), [
            'product_id'        =>  'required',            
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
return response()->json(['success'=>$response]);
        }
        $headerValue                =     array_change_key_case(getallheaders(),CASE_LOWER);
        $token                      =   @$headerValue['token'];
        if( @$token != '' ){
            $user                   =   $this->checkToken($token);
            $user_id                =   $user->id;
        }
        $input                      =   $request->all();
        $product_id                 =   $input['product_id'];
        $products                   =   DB::table('products')
                                            ->where('id',$product_id)
                                            ->get()->first();
        if( isset($products) ){
            $product_data               =   [];
            $product_data['id']         =   $products->id;
            $product_data['name']       =   $products->name;
            $product_data['price']      =   $products->price;
            $product_data['previous_price']      =   $products->previous_price;
            $product_data['details']         =   $products->details;
            $product_data['category_id']         =   $products->category_id;
            $product_data['photo']      =   'assets/images/products/'.$products->photo;
            $product_data['stock']      =   $products->stock;
            $wishlists                  =   0;
            if( @$user_id != '' ){
                $wishlists                 =   DB::table('wishlists')
                                                ->where('user_id',$user_id)
                                                ->where('product_id',$products->id)
                                                ->get()->first();
                if( @$wishlists->id != ''){
                    $wishlists              =   1;
                }else{
                    $wishlists              =   0;
                }
            }
            $product_data['wishlists']      =   $wishlists;
            // need to add Photo Gallery
            $photo_gallery                  =   array();
            $photo_gallery[]                =   $product_data['photo'];
            //$photo_gallery[]                =   "assets/images/products/1560581085minimal.jpg";
            $gallery =  DB::table('galleries')->where('product_id',$product_id)->get()->all();
            if( isset($gallery) ){
                foreach ($gallery as $gallery_key => $gallery_value) {
                   $photo_gallery[]                =   "assets/images/galleries/".$gallery_value->photo;
                }
            }
            //end photo gallery
            $ratings                    =   DB::table('ratings')
                                            ->join('users', 'users.id', '=', 'ratings.user_id')
                                            ->where('ratings.product_id','=',$product_id)
                                            ->get();
            $reviews_data           =   [];
            if( isset($ratings) ){
                $reviews_data           =   [];
                $i                      =   0;
                foreach ($ratings as $key => $value) {
                    $reviews_data[$i]['user_name']  =   $value->name;
                    $reviews_data[$i]['photo']  =   'assets/images/users/'.$value->photo;
                    $reviews_data[$i]['rating'] =   $value->rating;
                    $reviews_data[$i]['review'] =   $value->review;
                    $reviews_data[$i]['review_date']    =   $value->review_date;
                    $i++;
                }
                $reviews_data           =   array_values($reviews_data);
            }
            $stars                      =   DB::table('ratings')
                                                ->where('product_id',$product_id)
                                                ->avg('rating');
            $ratings                    =   number_format((float)$stars, 1, '.', ''); //number_format((float)$stars, 1, '.', '')*20;

            $response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Executed ';
            $response['data']['product_data']       =   $product_data; 
            $response['data']['photo_gallery']       =   $photo_gallery;  
            $response['data']['product_stars']       =   $ratings;      
            $response['data']['product_ratings_list']       =   $reviews_data;   
            $response['data']['product_url']       =   url('/item/'.$products->slug);   
            return response()->json(['success'=>$response]);
        }else{
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);
        }
    }
     public function checkToken( $token =   '' )
    {
        if( $token == '' ){
            return false;
        }
        $all                        =   DB::table('users')->where('app_token', $token)->first();
        return $all;
    }
}
