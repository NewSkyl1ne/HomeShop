<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rating;

class RatingController extends Controller
{
	public function __construct()
	    {
	        $this->middleware('auth:admin');
	    }

	    //*** JSON Request
	    public function datatables()
	    {
	         $datas = Rating::orderBy('id')->get();
	         //--- Integrating This Collection Into Datatables
	         return Datatables::of($datas)
	                            ->addColumn('product', function(Rating $data) {
	                                $name = strlen(strip_tags($data->product->name)) > 50 ? substr(strip_tags($data->product->name),0,50).'...' : strip_tags($data->product->name);
	                                $product = '<a href="'.route('front.product',['id' => $data->product->id,'slug' => $data->product->name]).'" target="_blank">'.$name.'</a>';
	                                return $product;
	                            })
								->addColumn('title', function(Rating $data) {
	                                $name = $data->title;
	                                return $name;
	                            })
	                            ->addColumn('reviewer', function(Rating $data) {
	                                $name = $data->user->name;
	                                return $name;
	                            })
								->addColumn('rating', function(Rating $data) {
	                                $name = $data->rating;
	                                return $name;
	                            })
	                            ->addColumn('review', function(Rating $data) {
	                                $text = strlen(strip_tags($data->review)) > 250 ? substr(strip_tags($data->review),0,250).'...' : strip_tags($data->review);
	                                return $text;
	                            })
	                            ->addColumn('action', function(Rating $data) {
	                                return '<div class="action-list"><a data-href="' . route('admin-rating-show',$data->id) . '" class="view" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i>View Details</a><a href="javascript:;" data-href="' . route('admin-rating-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
	                            }) 
	                            ->rawColumns(['product','action'])
	                            ->toJson(); //--- Returning Json Data To Client Side
	    }
	    //*** GET Request
	    public function index()
	    {
	        return view('admin.rating.index');
	    }

	    //*** GET Request
	    public function show($id)
	    {
	        $data = Rating::findOrFail($id);
	        return view('admin.rating.show',compact('data'));
	    }


	    //*** GET Request Delete
		public function destroy($id)
		{
		    $rating = Rating::findOrFail($id);
		    $rating->delete();
		    //--- Redirect Section     
		    $msg = 'Data Deleted Successfully.';
		    return response()->json($msg);      
		    //--- Redirect Section Ends    
		}
}
