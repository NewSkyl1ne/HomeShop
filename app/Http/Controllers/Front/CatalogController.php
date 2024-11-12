<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\ProductClick;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Rating;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{

// -------------------------------- CATEGORY SECTION ----------------------------------------

    public function category(Request $request,$slug)
    {
        //$this->code_image();
        $sort = "";
        $cat = Category::where('slug','=',$slug)->first();
        $cats = $cat->products()->where('status','=',1)->orderBy('id','desc')->paginate(9);
        
        // Search By Price

    if(!empty($request->min) || !empty($request->max))
    {
        $min = $request->min;
        $max = $request->max;
        $cats = $cat->products()->where('status','=',1)->whereBetween('price', [$min, $max])->orderBy('price','asc')->paginate(9);
        if($request->ajax()){
            return view('front.pagination.category',compact('cat','cats','sort','min','max'));
        }
        return view('front.category',compact('cat','cats','sort','min','max'));
    }

        // Search By Sort

    if( !empty($request->sort) )
    {
        $sort = $request->sort;
        if($sort == "new")
        {
        $cats = $cat->products()->where('status','=',1)->orderBy('id','desc')->paginate(9);
        }
        else if($sort == "old")
        {
        $cats = $cat->products()->where('status','=',1)->paginate(9);
        }
        else if($sort == "low")
        {
        $cats = $cat->products()->where('status','=',1)->orderBy('price','asc')->paginate(9);
        }
        else if($sort == "high")
        {
        $cats = $cat->products()->where('status','=',1)->orderBy('price','desc')->paginate(9);
        }
        if($request->ajax()){
            return view('front.pagination.category',compact('cat','cats','sort'));
        }
        
        return view('front.category',compact('cat','cats','sort'));
    }

        // Otherwise Go To Category

        if($request->ajax()){
            return view('front.pagination.category',compact('cat','sort','cats'));
        }    
        return view('front.category',compact('cat','sort','cats'));
    }

    public function subcategory(Request $request,$slug1,$slug2)
    {
        //$this->code_image();
        $sort = "";
        $subcat = Subcategory::where('slug','=',$slug2)->first();
        $cats = $subcat->products()->where('status','=',1)->orderBy('id','desc')->paginate(9);

        // Search By Price

    if(!empty($request->min) || !empty($request->max))
    {
        $min = $request->min;
        $max = $request->max;
        $cats = $subcat->products()->where('status','=',1)->whereBetween('price', [$min, $max])->orderBy('price','asc')->paginate(9);
        if($request->ajax()){
            return view('front.pagination.category',compact('subcat','cats','sort','min','max'));
        }
        return view('front.category',compact('subcat','cats','sort','min','max'));
    }

        // Search By Sort

    if( !empty($request->sort) )
    {
        $sort = $request->sort;
        if($sort == "new")
        {
        $cats = $subcat->products()->where('status','=',1)->orderBy('id','desc')->paginate(9);
        }
        else if($sort == "old")
        {
        $cats = $subcat->products()->where('status','=',1)->paginate(9);
        }
        else if($sort == "low")
        {
        $cats = $subcat->products()->where('status','=',1)->orderBy('price','asc')->paginate(9);
        }
        else if($sort == "high")
        {
        $cats = $subcat->products()->where('status','=',1)->orderBy('price','desc')->paginate(9);
        }
        if($request->ajax()){
            return view('front.pagination.category',compact('subcat','cats','sort'));
        }
        
        return view('front.category',compact('subcat','cats','sort'));
    }

        // Otherwise Go To Category

        if($request->ajax()){
            return view('front.pagination.category',compact('subcat','sort','cats'));
        }    
        return view('front.category',compact('subcat','sort','cats'));
    }

    public function childcategory(Request $request,$slug1,$slug2,$slug3)
    {
        //$this->code_image();
        $sort = "";
        $childcat = Childcategory::where('slug','=',$slug3)->first();
        $cats = $childcat->products()->where('status','=',1)->orderBy('id','desc')->paginate(9);

        // Search By Price

    if(!empty($request->min) || !empty($request->max))
    {
        $min = $request->min;
        $max = $request->max;
        $cats = $childcat->products()->where('status','=',1)->whereBetween('price', [$min, $max])->orderBy('price','asc')->paginate(9);
        if($request->ajax()){
            return view('front.pagination.category',compact('childcat','cats','sort','min','max'));
        }
        return view('front.category',compact('childcat','cats','sort','min','max'));
    }

        // Search By Sort

    if( !empty($request->sort) )
    {
        $sort = $request->sort;
        if($sort == "new")
        {
        $cats = $childcat->products()->where('status','=',1)->orderBy('id','desc')->paginate(9);
        }
        else if($sort == "old")
        {
        $cats = $childcat->products()->where('status','=',1)->paginate(9);
        }
        else if($sort == "low")
        {
        $cats = $childcat->products()->where('status','=',1)->orderBy('price','asc')->paginate(9);
        }
        else if($sort == "high")
        {
        $cats = $childcat->products()->where('status','=',1)->orderBy('price','desc')->paginate(9);
        }
        if($request->ajax()){
            return view('front.pagination.category',compact('childcat','cats','sort'));
        }
        
        return view('front.category',compact('childcat','cats','sort'));
    }

        // Otherwise Go To Category

        if($request->ajax()){
            return view('front.pagination.category',compact('childcat','sort','cats'));
        }    
        return view('front.category',compact('childcat','sort','cats'));
        }



    public function tag(Request $request, $tag)
    {
        //$this->code_image();
       $tags = $tag;
       $sort = '';
       $products = Product::where('tags', 'like', '%' . $tags . '%')->where('status','=',1)->orderBy('id','desc')->paginate(9);

        // Search By Price

    if(!empty($request->min) || !empty($request->max))
    {
        $min = $request->min;
        $max = $request->max;
       $products = Product::where('tags', 'like', '%' . $tags . '%')->where('status','=',1)->whereBetween('price', [$min, $max])->orderBy('price','asc')->paginate(9);
        if($request->ajax()){
            return view('front.pagination.tags',compact('products','tags','sort','min','max'));
        }
        return view('front.tags',compact('products','tags','sort','min','max'));
    }

        // Search By Sort

    if( !empty($request->sort) )
    {
        $sort = $request->sort;
        if($sort == "new")
        {
        $products = Product::where('tags', 'like', '%' . $tags . '%')->where('status','=',1)->orderBy('id','desc')->paginate(9);
        }
        else if($sort == "old")
        {
        $products = Product::where('tags', 'like', '%' . $tags . '%')->where('status','=',1)->paginate(9);
        }
        else if($sort == "low")
        {
        $products = Product::where('tags', 'like', '%' . $tags . '%')->where('status','=',1)->orderBy('price','asc')->paginate(9);
        }
        else if($sort == "high")
        {
        $products = Product::where('tags', 'like', '%' . $tags . '%')->where('status','=',1)->orderBy('price','desc')->paginate(9);
        }
        if($request->ajax()){
            return view('front.pagination.tags',compact('products','tags','sort'));
        }
        
        return view('front.tags',compact('products','tags','sort'));
    }

        // Otherwise Go To Tags

        if($request->ajax()){
            return view('front.pagination.tags',compact('products','tags','sort'));
        }   
       return view('front.tags', compact('products','tags','sort'));
    }


    public function search(Request $request)
    {
        // *********************** NORMAL SEARCH SECTION ******************
        $users=DB::table('users')->where('is_vendor','>=',1)->get();
        foreach($users as $user){
        $id=$user->id;
        
        }
        if($request->min&&$request->max&&!is_numeric($request->category_id))
        {  
            $sort='';
            $cat_id=0;
            $category_id = $request->category_id; 
            $min=$request->min;
            $max=$request->max;
            $s=$request->select;
            $search = $request->search;
            $perant_cat     = '';
            if($request->min=="low"){
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
               $products = Product::where('name', 'like', '%' . $search . '%')->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','asc')->paginate(12);
               if($request->top=="true")
               {
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where top=1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
                 $top = $request->top; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('top',1)->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','asc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s','top')); 
               }
               if($request->latest=="true")
               {
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where latest=1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
                 $latest = $request->latest; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('latest',1)->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','asc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s','latest')); 
               }
               if($request->best=="true")
               {
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where best=1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
                 $best = $request->best; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('best',1)->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','asc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s','best')); 
               }
               if($request->discount=="true")
               {
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where is_discount=1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
                 $discount = $request->discount; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('is_discount',1)->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','asc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s','discount')); 
               }
               if($request->ajax()){
                    return view('front.pagination.search',compact('products','search','category_id','sort'));
                }   
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s')); 
            }
            if($request->min=="high"){
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }     
                 $products = Product::where('name', 'like', '%' . $search . '%')->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','des')->paginate(12);
                 if($request->top=="true")
               {
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where top=1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
                 $top = $request->top; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('top',1)->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','des')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s','top')); 
               }
               if($request->latest=="true")
               {
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where latest=1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
                 $latest = $request->latest; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('latest',1)->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','des')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s','latest')); 
               }
               if($request->best=="true")
               {
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where best=1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
                 $best = $request->best; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('best',1)->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','des')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s','best')); 
               }
               if($request->discount=="true")
               {
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where is_discount=1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
                 }        
                 $discount = $request->discount; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('is_discount',1)->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','des')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s','discount')); 
               }
                if($request->ajax()){
                    return view('front.pagination.search',compact('products','search','category_id','sort'));
                }   
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s')); 
            }
            if($request->top=="true")
            { $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where top = 1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                    $min=$minmax[0]->min;
            
                    $max=$minmax[0]->max;
            
                }  
                $s=$request->select;
                $top = $request->top; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('status',1)->where('top','=',1)->whereBetween('price', [$min,$s])->orderBy('id','desc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id','top')); 
             }
             if($request->discount=="true")
            { $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where is_discount = 1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                    $min=$minmax[0]->min;
            
                    $max=$minmax[0]->max;
            
                }  
                $s=$request->select;
                $discount = $request->discount; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('status',1)->where('is_discount','=',1)->whereBetween('price', [$min,$s])->orderBy('id','desc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id','discount')); 
             }
             if($request->latest=="true")
            { $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where latest = 1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                    $min=$minmax[0]->min;
            
                    $max=$minmax[0]->max;
            
                }  
                $s=$request->select;
                $cat_id='latest';
                $latest = $request->latest; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('status',1)->where('latest','=',1)->whereBetween('price', [$min,$s])->orderBy('id','desc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id','latest')); 
             }
             if($request->best=="true")
            { $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where best = 1 and status = 1 order by id DESC limit 12");
                if(count($minmax))
                {
                    $min=$minmax[0]->min;
            
                    $max=$minmax[0]->max;
            
                }  
                $s=$request->select;
                $best = $request->best; 
                $products = Product::where('name', 'like', '%' . $search . '%')->where('status',1)->where('best','=',1)->whereBetween('price', [$min,$s])->orderBy('id','desc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id','best')); 
             }
            if($category_id == 0) {  
                $products = Product::where('name', 'like', '%' . $search . '%')->where('status','=',1)->whereBetween('price', [$min,$s])->orderBy('price','asc')->paginate(12);
                if($request->ajax()){
                    return view('front.pagination.search',compact('products','search','category_id','sort'));
                }   
                return view('front.search',compact('products','search','category_id','sort','perant_cat','cat_id','min','max','s'));    
                }
        }
        if($request->brands=="true")
        {  
            $sort='';
            $category_id ='';
            $search = $request->search;
            $perant_cat     = '';
            $discount = $request->discount; 
            $products = Product::join('users', 'users.id', '=', 'products.user_id')->where('products.name', 'like', '%' . $search . '%')->where('products.status','>=',1)->where('users.is_vendor','>=',1)->orderBy('products.id','desc')->paginate(12);
            return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id')); 
        
        }
        if($request->discount=="true")
        {   
            $sort='';
            $category_id ='';
            $search = $request->search;
            $perant_cat     = '';
            $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where is_discount = 1 and status = 1 order by id DESC limit 12");
            if(count($minmax))
            {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
            }       
            $s=$request->select;
            $cat_id='discount';
            $discount = $request->discount; 
            $products = Product::where('name', 'like', '%' . $search . '%')->where('status',1)->where('is_discount','=',1)->orderBy('id','desc')->paginate(12);
            return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id','discount')); 
        
        }
        if($request->top=="true")
        {  
            $sort='';
            $category_id ='';
            $search = $request->search;
            $perant_cat     = '';
            $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where top = 1 and status = 1 order by id DESC limit 12");
            if(count($minmax))
            {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
            }       
            $s=$request->select;
            $cat_id='top';
            $top = $request->top; 
            $products = Product::where('name', 'like', '%' . $search . '%')->where('status',1)->where('top','=',1)->orderBy('id','desc')->paginate(12);
            return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id','top')); 
        
        }
        if($request->best=="true")
        {   
            $sort='';
            $category_id ='';
            $search = $request->search;
            $perant_cat     = '';
            $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where best = 1 and status = 1 order by id DESC limit 12");
            if(count($minmax))
            {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
            }       
            $s=$request->select;
            $cat_id='best';
            $best = $request->best; 
            $products = Product::where('name', 'like', '%' . $search . '%')->where('status',1)->where('best','=',1)->orderBy('id','desc')->paginate(12);
            return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id','best')); 
        
        }
        if($request->latest=="true")
        {   
            $sort='';
            $category_id ='';
            $search = $request->search;
            $perant_cat     = '';
            $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where latest = 1 and status = 1 order by id DESC limit 12");
            if(count($minmax))
            {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
            }       
            $s=$request->select;
            $cat_id='latest';
            $latest = $request->latest; 
            $products = Product::where('name', 'like', '%' . $search . '%')->where('status',1)->where('latest','=',1)->orderBy('id','desc')->paginate(12);
            return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id','latest')); 
        
        }

        $sort='';
        $category_id = $request->category_id; 
        $search = $request->search;
        $perant_cat     = '';
        if($category_id == 0) { 
            $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where status = 1 order by id DESC limit 12");
            if(count($minmax))
            {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
            }        
            $s=$request->select;
            $cat_id=0;
            if($search){ 
                $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where name like '%$search%' and status = 1 order by id DESC limit 12");
            if(count($minmax))
            {
                $min=$minmax[0]->min;
        
                $max=$minmax[0]->max;
        
            }     
                    $products = Product::where('name', 'like', '%' . $search . '%')->where('status', '=', 1)->orderBy('id', 'desc')->paginate(12);
                return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id'));   
            }
            $products = Product::where('name', 'like', '%' . $search . '%')->where('status','=',1)->orderBy('id','desc')->paginate(12);
            if($request->ajax()){
                return view('front.pagination.search',compact('products','search','category_id','sort'));
            }   
            
            return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id'));    
       }
       else {
        $cat_id         =   @$request->cat_id;
        $sort           =   '';
        $search         =   @$request->search;
        $category_id    =   @$request->category_id;

        $cat     =   DB::table('categories')->where('id','=',$_GET['category_id'])->get()->first();
         if(!$cat){
            return redirect('/');
        }
        $perant_cat     =   $cat->category_id;
        if( $cat->category_id == 0 ){ 
            
            /*$this->main_cat         =[];
            $this->main_cat[]        =   $_GET['category_id'];
            $this->main_cat_data    =    '['.$_GET['category_id'];
            $this->getsubcat($_GET['main_cat']);
            $this->main_cat_data    =   $this->main_cat_data .']';*/
            $min=$request->min;
            $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where category_id=$request->category_id and status = 1 order by id DESC limit 12");
            $price='';
            if(count($minmax))
                {
                    if($request->min=="low"||$request->min=="high")
                    {
                        if($request->min=="low"){
                            $price='asc';
                        }
                        else{
                            $price='des';
                        }
                    }
                  
                    $min=$minmax[0]->min;
                    $max=$minmax[0]->max;
        
                }
            $s=$request->select;
            if($request->min=="low"||$request->min=="high")
            {   if($s)
                { $cat_id=$request->category_id;
                    $products = Product::where('category_id', $_GET['category_id'])->where('name', 'like', '%' . $search . '%')->whereBetween('price', [$min,$s])->where('status', '=', 1)->orderBy('price', $price)->paginate(12);
                }
                else{
                    $products = Product::where('category_id', $_GET['category_id'])->where('name', 'like', '%' . $search . '%')->where('status', '=', 1)->orderBy('price', $min)->paginate(12);
                }
            }
            else if(!$s){
                $cat_id=$request->category_id;
                $products = Product::where('category_id', $_GET['category_id'])->where('name', 'like', '%' . $search . '%')->where('status', '=', 1)->orderBy('id', 'desc')->paginate(12);
            }
            else{
                $cat_id=$request->category_id;
                $products = Product::where('category_id', $_GET['category_id'])->where('name', 'like', '%' . $search . '%')->whereBetween('price', [$min,$s])->where('status', '=', 1)->orderBy('id', 'desc')->paginate(12);
            }
            
        }else{
            $min=$request->min;
            $minmax=DB::select("SELECT min(price) as min,max(price) as max from products where subcategory_id=$request->category_id and status = 1 order by id DESC limit 12");
            $price='';
            if(count($minmax))
            {
                if($request->min=="low"||$request->min=="high")
                    {
                        if($request->min=="low"){
                            $price='asc';
                        }
                        else{
                            $price='des';
                        }
                        
                    }
                $min=$minmax[0]->min;
                $max=$minmax[0]->max;
        
            } 
            $s=$request->select;
            $cat_id=$request->category_id;
            if($request->min=="low"||$request->min=="high")
            {   
                if($s)
                { $cat_id=$request->category_id;
                    $products = Product::where('subcategory_id', $_GET['category_id'])->where('name', 'like', '%' . $search . '%')->whereBetween('price', [$min,$s])->where('status', '=', 1)->orderBy('price', $price)->paginate(12);
                }
                else{
                    $products = Product::where('subcategory_id', $_GET['category_id'])->where('name', 'like', '%' . $search . '%')->where('status', '=', 1)->orderBy('price', $min)->paginate(12);
                }
            }
            else if(!$s){
            $products = Product::where('subcategory_id', $_GET['category_id'])->where('name', 'like', '%' . $search . '%')->where('status','=',1)->orderBy('id','desc')->paginate(12);    
            }
            else{
                
                $products = Product::where('subcategory_id', $_GET['category_id'])->where('name', 'like', '%' . $search . '%')->whereBetween('price', [$min,$s])->where('status', '=', 1)->orderBy('id', 'desc')->paginate(12);
            }
        }
        //$products = Product::where('category_id', 'like', '%' . $category_id . '%')->where('name', 'like', '%' . $search . '%')->where('status','=',1)->orderBy('id','desc')->paginate(12);
        
        if(@$request->ajax()){
            return view('front.pagination.search',compact('products','search','category_id','sort','perant_cat'));

        }   
     
        return view('front.search',compact('products','search','category_id','sort','perant_cat','min','max','s','cat_id'));   

       }

       

// *********************** NORMAL SEARCH SECTION ENDS ******************

        //}

       return view('errors.404');         
    }

    public function getsubcat($cat='')
    {
       $cat     =   DB::table('categories')->where('category_id','=',$cat)->get();
       if( count($cat) > 0 ){
            foreach ($cat as $key => $value) {
                $this->main_cat[] = $value->id;
                 $this->main_cat_data .= ','.$value->id;
                $this->getsubcat($value->id);
            }
       }
       return 1;
    }
// -------------------------------- CATEGORY SECTION ENDS----------------------------------------


// -------------------------------- PRODUCT DETAILS SECTION ----------------------------------------

    public function product($slug)
    {   
        //$this->code_image();
        $productt = Product::where('slug','=',$slug)->first();  
        $productt->views+=1;
        $productt->update(); 
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $product_click =  new ProductClick;
        $product_click->product_id = $productt->id;
        $product_click->date = Carbon::now()->format('Y-m-d');
        $product_click->save();          
        $side_banners = DB::table('banners')->where('page','=','home')->where('type','=','Small')->limit(2)->get();
        $seller_name=DB::table('shop_details')->SELECT('name','owner_name','number','building_no','zone_no','street_no','city','address')->where('id','=',$productt->shop_id)->first();
        $ratings=DB::table('ratings')->join('users','users.id','=','ratings.user_id')->where('ratings.product_id',$productt->id)->get();
        return view('front.product',compact('productt','curr','side_banners','seller_name','ratings'));
    }

    public function quick($id)
    {
        $product = Product::findOrFail($id);   
        if (Session::has('currency')) 
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }       
        return view('load.quick',compact('product','curr'));

    }

// -------------------------------- PRODUCT DETAILS SECTION ENDS----------------------------------------

// -------------------------------- PRODUCT COMMENT SECTION ----------------------------------------

    public function comment(Request $request)
    {
        $comment = new Comment;
        $input = $request->all();
        $comment->fill($input)->save();
        $comments = Comment::where('product_id','=',$request->product_id)->get()->count();
    $data[0] = $comment->user->photo ? url('assets/images/users/'.$comment->user->photo):url('assets/images/noimage.png');
        $data[1] = $comment->user->name;
        $data[2] = $comment->created_at->diffForHumans();
        $data[3] = $comment->text;
        $data[4] = $comments;
        $data[5] = route('product.comment.delete',$comment->id);
        $data[6] = route('product.comment.edit',$comment->id);
        $data[7] = route('product.reply',$comment->id);
        $data[8] = $comment->user->id;
        return response()->json($data);
    }

    public function commentedit(Request $request,$id)
    {
        $comment =Comment::findOrFail($id);
        $comment->text = $request->text;
        $comment->update();
        return response()->json($comment->text);
    } 

    public function commentdelete($id)
    {
        $comment =Comment::findOrFail($id);
        if($comment->replies->count() > 0)
        {
            foreach ($comment->replies as $reply) {
                $reply->delete();
            }
        }
        $comment->delete();
    }     

// -------------------------------- PRODUCT COMMENT SECTION ENDS ----------------------------------------

// -------------------------------- PRODUCT REPLY SECTION ----------------------------------------

    public function reply(Request $request,$id)
    {
        $reply = new Reply;
        $input = $request->all();
        $input['comment_id'] = $id;
        $reply->fill($input)->save();
        $data[0] = $reply->user->photo ? url('assets/images/users/'.$reply->user->photo):url('assets/images/noimage.png');
        $data[1] = $reply->user->name;
        $data[2] = $reply->created_at->diffForHumans();
        $data[3] = $reply->text;
        $data[4] = route('product.reply.delete',$reply->id);
        $data[5] = route('product.reply.edit',$reply->id);
        return response()->json($data);
    } 

    public function replyedit(Request $request,$id)
    {
        $reply = Reply::findOrFail($id);
        $reply->text = $request->text;
        $reply->update();
        return response()->json($reply->text);
    } 

    public function replydelete($id)
    {
        $reply =Reply::findOrFail($id);
        $reply->delete();
    } 

// -------------------------------- PRODUCT REPLY SECTION ENDS----------------------------------------


// ------------------ Rating SECTION --------------------

    public function reviewsubmit(Request $request)
    {
        $ck = 0;
$orders = Order::where('user_id','=',$request->user_id)->where('status','=','completed')->get();

        foreach($orders as $order)
        {
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
            foreach($cart->items as $product)
            {
                if($request->product_id == $product['item']['id'])
                {
                    $ck = 1;
                    break;
                }
            }
        }
        if($ck == 1)
        {
            $user = Auth::guard('web')->user();
            $prev = Rating::where('product_id','=',$request->product_id)->where('user_id','=',$user->id)->get();
            if(count($prev) > 0)
            {
            return response()->json(array('errors' => [ 0 => 'You Have Reviewed Already.' ]));                
            }         
            $Rating = new Rating;
            $Rating->fill($request->all());
            $Rating['review_date'] = date('Y-m-d H:i:s');
            $Rating->save();
            $data[0] = 'Your Rating Submitted Successfully.';
            $data[1] = Rating::rating($request->product_id);
            return response()->json($data);  
        }
        else{
            return response()->json(array('errors' => [ 0 => 'Buy This Product First' ]));
        }
    }


    public function reviews($id){
        $productt = Product::find($id);   
        return view('load.reviews',compact('productt','id'));

    }

// ------------------ Rating SECTION ENDS --------------------



    // Capcha Code Image
    /*private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }*/

}
