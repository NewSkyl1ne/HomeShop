<?php

namespace App\Http\Controllers\Admin;
use App\Models\Pagesetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class PageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    protected $rules =
    [
        'best_seller_banner' => 'mimes:jpeg,jpg,png,svg,webp',
        'big_save_banner'    => 'mimes:jpeg,jpg,png,svg,webp'
    ];


    // Page Settings All post requests will be done in this method
    public function update(Request $request)
    {
        $data = Pagesetting::findOrFail(1);
        $input = $request->all();
        
            if ($file = $request->file('best_seller_banner')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->best_seller_banner);
                $input['best_seller_banner'] = $name;
            }    
            if ($file = $request->file('big_save_banner')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->big_save_banner);           
                $input['big_save_banner'] = $name;
            } 

        $data->update($input);
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);      
    }


    public function homeupdate(Request $request)
    {
        $data = Pagesetting::findOrFail(1);
        $input = $request->all();
        
        if ($request->slider == ""){
            $input['slider'] = 0;
        }
        if ($request->service == ""){
            $input['service'] = 0;
        }
        if ($request->featured == ""){
            $input['featured'] = 0;
        }
        if ($request->small_banner == ""){
            $input['small_banner'] = 0;
        }
        if ($request->best == ""){
            $input['best'] = 0;
        }
        if ($request->top_rated == ""){
            $input['top_rated'] = 0;
        }
        if ($request->large_banner == ""){
            $input['large_banner'] = 0;
        }
        if ($request->big == ""){
            $input['big'] = 0;
        }
        if ($request->hot_sale == ""){
            $input['hot_sale'] = 0;
        }
        if ($request->review_blog == ""){
            $input['review_blog'] = 0;
        }

        $data->update($input);
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);      
    }


    public function contact()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.contact',compact('data'));
    }

    public function customize()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.customize',compact('data'));
    }

    public function best_seller()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.best_seller',compact('data'));
    }

    public function big_save()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.big_save',compact('data'));
    }


    //Upadte About Page Section Settings


    //Upadte FAQ Page Section Settings
    public function faqupdate($status)
    {
        $page = Pagesetting::findOrFail(1);
        $page->f_status = $status;
        $page->update();
        Session::flash('success', 'FAQ Status Upated Successfully.');
        return redirect()->back();
    }

    public function contactup($status)
    {
        $page = Pagesetting::findOrFail(1);
        $page->c_status = $status;
        $page->update();
        Session::flash('success', 'Contact Status Upated Successfully.');
        return redirect()->back();
    }

    //Upadte Contact Page Section Settings
    public function contactupdate(Request $request)
    {
        $page = Pagesetting::findOrFail(1);
        $input = $request->all();
        $page->update($input);
        Session::flash('success', 'Contact page content updated successfully.');
        return redirect()->route('admin-ps-contact');;
    }

}
