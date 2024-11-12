<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         //$datas = Subcategory::where('category_id','!=',0)->orderBy('id','desc')->get();
         $datas = DB::table('categories')->where('category_id','!=',0)->orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->addColumn('category', function( $data) {
                                $category_name = DB::table('categories')->where('category_id','=',$data->category_id)->get()->first();
                                return $category_name->name;
                            }) 
                            ->addColumn('status', function( $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list">
                                <select class="process select droplinks '.$class.'">
                                <option data-val="1" value="'. route('admin-subcat-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Active</option>
                                <option data-val="0" value="'. route('admin-subcat-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactive</option>/select></div>';
                            }) 
                            ->addColumn('action', function( $data) {
                                return '<div class="action-list">
                                <a data-href="' . route('admin-subcat-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1">
                                 <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-subcat-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete">
                                 <i class="fas fa-trash-alt"></i></a></div>';
                            }) 
                            ->rawColumns(['status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.subcategory.index');
    }

    //*** GET Request
    public function create()
    {
      	$cats = Category::where('category_id','=',0)->orderBy('id','desc')->get();
        return view('admin.subcategory.create',compact('cats'));
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'slug' => 'unique:subcategories|regex:/^[a-zA-Z0-9\s-]+$/'
                 ];
        $customs = [
            'slug.unique' => 'This slug has already been taken.',
            'slug.regex' => 'Slug Must Not Have Any Special Characters.'
                   ];
        $validator = Validator::make(Input::all(), $rules, $customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Subcategory();
        $input = $request->all();
        //$data->fill($input)->save();
        DB::table('categories')->insert(
                        [
                            'category_id'  => $input['category_id'], 
                            'name'    => $input['name'],
                            'slug'           => $input['slug'],
                            'status'         => '1',
                        ]
                    );
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    //*** GET Request
    public function edit($id)
    {
    	$cats = Category::where('category_id','=',0)->orderBy('id','desc')->get();
        $data = Category::where('id','=',$id)->get()->first();
        return view('admin.subcategory.edit',compact('data','cats'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'slug' => 'unique:subcategories,slug,'.$id.'|regex:/^[a-zA-Z0-9\s-]+$/'
                 ];
        $customs = [
            'slug.unique' => 'This slug has already been taken.',
            'slug.regex' => 'Slug Must Not Have Any Special Characters.'
                   ];
        $validator = Validator::make(Input::all(), $rules, $customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        //$data = Subcategory::findOrFail($id);
        $input = $request->all();
        //$data->update($input);
        DB::table('categories')->where('id','=',$id)->update(
                        [
                            'category_id'  => $input['category_id'], 
                            'name'    => $input['name'],
                            'slug'           => $input['slug'],
                            'status'         => '1',
                        ]
                    );
        //--- Logic Section Ends

        //--- Redirect Section     
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends            
    }

      //*** GET Request Status
      public function status($id1,$id2)
        {
            $data = Subcategory::findOrFail($id1);
            $data->status = $id2;
            $data->update();
        }

    //*** GET Request
    public function load($id)
    {        
        //$cat = Category::findOrFail($id);
        $cat = DB::table('categories')->where('category_id', '=', $id)->get();
        return view('load.subcategory',compact('cat'));
    }
    
    //*** GET Request Delete
    public function destroy($id)
    {
        /*$data = Subcategory::findOrFail($id);

        if($data->childs->count()>0)
        {
        //--- Redirect Section     
        $msg = 'Remove the subcategories first !!!!';
        return response()->json($msg);      
        //--- Redirect Section Ends    
        } */
        /*if($data->products->count()>0)
        {
        //--- Redirect Section     
        $msg = 'Remove the products first !!!!';
        return response()->json($msg);      
        //--- Redirect Section Ends    
        }*/

            DB::table('categories')->where('id','=',$id)->delete();
        //$data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends     
    }
}
