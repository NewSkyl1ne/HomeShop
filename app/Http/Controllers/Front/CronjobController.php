<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CronjobController extends Controller
{
    public function expirePackageProduct()
    {
       $users      =    DB::table('users')->where('is_vendor','1')->get()->all();
       if( count($users) > 0 ){
            foreach($users AS $key=>$value){
                DB::table('products')->where('user_id',$value->id)->update([ 'status'=>2]);
            }
        }
       
    }
}
?>