<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagesetting extends Model
{
    protected $fillable = ['contact_success','contact_email','contact_title','contact_text','street','phone','fax','email','site','side_title','side_text','slider','service','featured','small_banner','best','top_rated','large_banner','big','hot_sale','review_blog','best_seller_banner','best_seller_banner_link','big_save_banner','big_save_banner_link'];

    public $timestamps = false;

    public function upload($name,$file,$oldname)
    {
                $file->move('assets/images',$name);
                if($oldname != null)
                {
                    if (file_exists(public_path().'/../assets/images/'.$oldname)) {
                        unlink(public_path().'/../assets/images/'.$oldname);
                    }
                }  
    }

}
