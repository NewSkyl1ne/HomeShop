<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\CheckoutModel;
use Auth;
use DB;
use Validator;
use App\Models\Generalsetting;

class PaymentController extends Controller
{
	public function paycancle()
	{
		echo "error";
	}
	public function success()
	{
		echo "success";
	}
	public function qpay_action_payemnt($order_id='',$q_id='',$token='')
	{
		
    	$token 						=	@$token;
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
		        if ($q_id=='' || $order_id=='') {
		             return redirect()->route('api.payment.cancle');
		        } 
		        $order_data                     =   DB::table('orders')->where('id',$order_id)->get()->first();
				//echo $order_data->pay_amount;exit;
		        $order_number 					=	$order_data->order_number;
		        $QPAY_MERCHANT_AUTH_ID			=	'merchant.BATQNB01';
		        $QPAY_MERCHANT_AUTH_PASSWORD	=	'3cfa287f4f35640752ea6c8993a6c3a6';//b9eaada72668d6d686fa77d2e935012b';
		        $QAPY_MERCHANT_ID				=	'BATQNB01';
		        $QAPY_MERCHANT_NAME				=	'BASKET TRADING IPG';
		        $user                       	= 	$user;
		        ?>
		        <?php /*<script type="text/javascript">
		        var url ="https://basket.qa/checkout/payment/success";
		        window.location.replace("https://basket.qa/checkout/payment/success");
		        </script>  */ ?>
	            <html>
	                <head>
	                    <script src="https://ap-gateway.mastercard.com/checkout/version/56/checkout.js"
	                            data-error="errorCallback"
	                            data-cancel="cancelCallback"
	                    data-complete="<?php echo url('/api/v1/qpay_action_return'); ?>">
	                        </script>

	                    <script type="text/javascript">
	                        function errorCallback(error) {
	                             // console.log(JSON.stringify(error));
	                             window.location.href =  "<?php echo url('/checkout/payment/cancle'); ?>";
	                        }
	                        function cancelCallback() {
	                             window.location.href =  "<?php echo url('/checkout/payment/cancle'); ?>";
	                        }
	                        
	                        Checkout.configure({
	                            merchant:'<?php echo $QAPY_MERCHANT_ID; ?>',
	                            customer:{
	                               
	                                email:'<?php echo $user->email; ?>',
	                                firstName:'<?php echo str_replace(" ","",$user->name); ?>',
	                                lastName:'<?php echo str_replace(" ","",$user->name); ?>',
	                                phone:'<?php echo $user->phone; ?>'
	                            },
	                            order: {
	                                amount: <?php echo $order_data->pay_amount; ?>,
	                                currency: '₹',
	                                description: 'Basket New Order',
	                               id: '<?php echo $order_number; ?>'
	                                },
	                                session: {
	                                  id: '<?php echo $q_id; ?>'
	                                },
	                            interaction: {
	                                operation: 'PURCHASE',
	                                merchant: {
	                                    name: '<?php echo $QAPY_MERCHANT_NAME; ?>',
	                                    address: {
	                                        line1: 'Basket',
	                                        line2: ''     
	                                    }    
	                                }
	                            }
	                        });
	                    </script>
	                </head>
	                <body style="text-align: center;vertical-align: middle;margin: 11%;">
	                    <input style="font-size: 19px;font-weight: 700;padding: 21px;border-radius: 16px;" type="button" class="showPaymentPage" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" style="display: none1;"/>
	                </body>
	            </html>
	            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	            <script type="text/javascript">
	            $( document ).ready(function() {
	                setTimeout(function(){ $(".showPaymentPage").click(); },0);
	            });
	            </script>
	            <?php 

	        }else{
                return redirect()->route('api.payment.cancle');
            }
	    }else{
    		 return redirect()->route('api.payment.cancle');
    	}
	}
	public function qpay_action_return($order_id='',$q_id='',$token='')
    {
    	$token 						=	@$token;
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
		        $order_id                       =   $order_id;
		        $q_id                   		=   $q_id;
		        if($order_id!='' && $q_id!='' && Session('q_id') !='' ) {
		            $order_data                     =   DB::table('orders')->where('id',$order_id)->get()->first();
		        	$order_number 					=	$order_data->order_number;
		            $QPAY_MERCHANT_AUTH_ID='merchant.BATQNB01';
		            $QPAY_MERCHANT_AUTH_PASSWORD='3cfa287f4f35640752ea6c8993a6c3a6';//b9eaada72668d6d686fa77d2e935012b';
		            $QAPY_MERCHANT_ID='BATQNB01';
		            $QAPY_MERCHANT_NAME='BASKET TRADING IPG';

		            $ch = curl_init();
		            $ch = curl_init('https://ap-gateway.mastercard.com/api/rest/version/56/merchant/'.$QAPY_MERCHANT_ID.'/order/'.$order_number);                                                                      
		            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                   
		            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		                'Content-Type: application/json')                                                                       
		            );    
		            curl_setopt($ch, CURLOPT_USERPWD, $QPAY_MERCHANT_AUTH_ID . ":" . $QPAY_MERCHANT_AUTH_PASSWORD);                                                                                                               
		                                                                                                                                 
		            $result = curl_exec($ch);
		            $result = json_decode($result);
		            if(@$result->status=='CAPTURED'){
		                $order_status       =   [];
		                $order_status['payment_status']   =   'paid';
		                DB::table('orders')->where('id',$order_id)->update($order_status);		            
		                $success_url    = action('Api\PaymentController@success');
		                return redirect($success_url);
		            }else{
		              return redirect()->route('api.payment.cancle');  
		            }

		        }else{
		            return redirect()->route('api.payment.cancle');
		        }
        	}else{
                 return redirect()->route('api.payment.cancle');
            }
	    }else{
    		 return redirect()->route('api.payment.cancle');
    	}

        
    }
	public function checkToken( $token =    '' )
    {
        if( $token == '' ){
            return false;
        }
        $all                        =   DB::table('users')->where('app_token', $token)->first();
        return $all;
    }
}
?>