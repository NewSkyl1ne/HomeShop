<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Banner::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('photo', function(Banner $data) {
                                $photo = $data->photo ? url('assets/images/banners/'.$data->photo):url('assets/images/noimage.png');
                                return '<img src="' . $photo . '" alt="Image" style="width:100px;height:100px;">';
                            })
                            ->editColumn('platform_type', function(Banner $data) {
                                if ($data->platform_type == 1 ){
                                    $platform_type = "Website";
                                }else{
                                    $platform_type = "App";
                                }
                                return $platform_type;
                            })
                            ->editColumn('app_slug', function(Banner $data) {
                                return $data->app_slug;
                            })
                             ->editColumn('page', function(Banner $data) {
                                return $data->page;
                            })
                            ->addColumn('action', function(Banner $data) {
                                return '<div class="action-list">
                                <a data-href="' . route('admin-sb-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> 
                                <i class="fas fa-edit"></i>Edit</a>
                                <a href="javascript:;" data-href="' . route('admin-sb-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete">
                                <i class="fas fa-trash-alt"></i></a></div>';
                            }) 
                            ->rawColumns(['photo', 'platform_type', 'app_slug', 'page', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.banner.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.banner.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
               'photo'      => 'required|mimes:jpeg,jpg,png,svg,webp',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Banner();
        $input = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/banners',$name);           
            $input['photo'] = $name;
        } 
        
        DB::table('banners')->insert(
                                [
                                    'platform_type'     => @$input['platform_type'], 
                                    'app_slug'          => @$input['app_slug'],
                                    'photo'             => @$input['photo'],
                                    'link'              => @$input['link'],
                                    'page'              => @$input['page'],
                                    'type'              => @$input['type']
                                ]
                            );
        //$data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Banner::findOrFail($id);        
        return view('admin.banner.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
               'photo'      => 'mimes:jpeg,jpg,png,svg,webp',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Banner::findOrFail($id);
        $input = $request->all();
            if ($file = $request->file('photo')) 
            {              
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/banners',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/../assets/images/banners/'.$data->photo)) {
                        unlink(public_path().'/../assets/images/banners/'.$data->photo);
                    }
                }            
            $input['photo'] = $name;
            } 
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section     
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends            
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Banner::findOrFail($id);
        //If Photo Doesn't Exist
        if($data->photo == null){
            $data->delete();
            //--- Redirect Section     
            $msg = 'Data Deleted Successfully.';
            return response()->json($msg);      
            //--- Redirect Section Ends     
        }
        //If Photo Exist
        if (file_exists(public_path().'/../assets/images/banners/'.$data->photo)) {
            unlink(public_path().'/../assets/images/banners/'.$data->photo);
        }
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends     
    }
}
