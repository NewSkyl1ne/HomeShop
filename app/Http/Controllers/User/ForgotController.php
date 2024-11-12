<?php

namespace App\Http\Controllers\User;
if (!class_exists('PHPMailer\PHPMailer\Exception'))
{
require base_path().'/smtp_php/PHPMailer.php';
require base_path().'/smtp_php/SMTP.php';
require base_path().'/smtp_php/Exception.php';
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


use App\Models\Generalsetting;
use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class ForgotController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showForgotForm()
    {
      return view('user.forgot');
    }

    public function forgot(Request $request)
    {
      $gs = Generalsetting::findOrFail(1);
      $input =  $request->all();
      if (User::where('email', '=', $request->email)->count() > 0) {
      // user found
      $admin = User::where('email', '=', $request->email)->firstOrFail();
      $autopass = str_random(8);
      $input['password'] = bcrypt($autopass);
      $admin->update($input);
      $subject = "Reset Password Request";
      $msg = "Your New Password is : ".$autopass;
      // To send HTML mail, the Content-type header must be set
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
        $mail->Body       = $msg;
        $mail->addAddress($admin->email,$admin->name); 
        $mail->send();
      /*if($gs->is_smtp == 1)
      {
          $data = [
                  'to' => $request->email,
                  'subject' => $subject,
                  'body' => $msg,
          ];

          $mailer = new GeniusMailer();
          $mailer->sendCustomMail($data);                
      }
      else
      {
          $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
          mail($request->email,$subject,$msg,$headers);            
      }*/
      return response()->json('Your Password Reseted Successfully. Please Check your email for new Password.');
      }
      else{
      // user not found
      return response()->json(array('errors' => [ 0 => 'No Account Found With This Email.' ]));    
      }  
    }

}
