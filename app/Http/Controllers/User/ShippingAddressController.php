<?php

namespace App\Http\Controllers\User;

use App\Classes\GeniusMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription;
use App\Models\Generalsetting;
use App\Models\UserSubscription;
use App\Models\FavoriteSeller;
use DB;

class ShippingAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $list               =   DB::table('shipping_address')
                                            ->where('user_id','=',$user->id)
                                            ->get();
        return view('user.shipping.index',compact('list'));
    }
    public function add()
    {
        $user = Auth::user();
        return view('user.shipping.add');
    }
    public function save()
    {
        $user = Auth::user();
        $postData                               =   $_POST;
        $update_data                            =   [];
        $update_data['shipping_name']           =   $postData['shipping_name'];
        $update_data['shipping_phone']          =   $postData['shipping_phone'];
        $update_data['shipping_email']          =   $postData['shipping_email'];
        $update_data['shipping_building_no']    =   $postData['shipping_building_no'];
        $update_data['shipping_zone_no']        =   $postData['shipping_zone_no'];
        $update_data['shipping_street_no']      =   $postData['shipping_street_no'];
        $update_data['shipping_city']           =   "Delhi";
        $update_data['shipping_address']        =   $postData['shipping_address'];
        $update_data['map_lat']                 =   '';
        $update_data['map_long']                =   '';
        $update_data['user_id']                 =   $user->id;
        DB::table('shipping_address')->insert($update_data);
        return redirect(route('user-shipping-address'))->with('message', 'Successfully Added!');
    }
    public function edit($id)
    {
       $user = Auth::user();
       $data    = DB::table('shipping_address')->where('user_id','=',$user->id)->where('id','=',$id)->get()->first();
       return view('user.shipping.edit',compact('data'));
    }
    public function update($id)
    {
        $user = Auth::user();
        $postData                               =   $_POST;
        $update_data                            =   [];
        $update_data['shipping_name']           =   $postData['shipping_name'];
        $update_data['shipping_phone']          =   $postData['shipping_phone'];
        $update_data['shipping_email']          =   $postData['shipping_email'];
        $update_data['shipping_building_no']    =   $postData['shipping_building_no'];
        $update_data['shipping_zone_no']        =   $postData['shipping_zone_no'];
        $update_data['shipping_street_no']      =   $postData['shipping_street_no'];
        $update_data['shipping_city']           =   'Delhi';
        $update_data['shipping_address']        =   $postData['shipping_address'];
        $update_data['map_lat']                 =   '';
        $update_data['map_long']                =   '';
        DB::table('shipping_address')->where('user_id','=',$user->id)->where('id','=',$id)->update($update_data);
        return redirect(route('user-shipping-address'))->with('message', 'Successfully updated!');
    }
    public function delete($id){
        $user = Auth::user();
        DB::table('shipping_address')->where('user_id','=',$user->id)->where('id','=',$id)->delete();
        return redirect()->back()->with('message', 'Successfully deleted!');
    }


}
