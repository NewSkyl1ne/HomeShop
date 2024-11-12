<?php 
namespace App\Helpers;
require base_path().'/smtp_php/PHPMailer.php'; 
require base_path().'/smtp_php/SMTP.php';    
require base_path().'/smtp_php/Exception.php';    
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Helper 
{
    public static function UserEmail($to,$subject,$body,$name="")
    {  
        $mail = new PHPMailer();
    $mail->isSMTP();      
    //$mail->SMTPDebug  = 1; 
    $mail->Host       = 'giowm1117.siteground.biz';
    $mail->SMTPAuth   = 'true';  
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->Username   = 'alerts@basket.qa';
    $mail->Password   = 'c4,@b#~$%2%l';
    $mail->Subject    = $subject;
    $mail->setFrom('alerts@basket.qa', 'Basket');
    $mail->isHTML(true);   
    $mail->Body       = $body;
    $mail->addAddress($to,$name); 
    $mail->send();
    
    }
    public static function uploadFile($req) { //call this function with req object
        // $this->validate($request, [
        //     'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
    //    dd($req);
       try{
        if ($req->hasFile('file')) {
            $image = $req->file('file');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            return '/images/'.$name;
        }
        return 0;
       }
       catch(\Exception $e)
       {
           return 0;
       }  
    }
}