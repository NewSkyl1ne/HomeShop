<?php 
$order = DB::table('orders')->where('order_number','=',$data)->get()->first();
$cart = DB::table('order_products')->where('order_number','=',$data)->get()->all();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">  
<title>basket</title>
<style>
  body{margin: 0; padding: 0;    font-family: "Open Sans", sans-serif;} 
</style>  
</head>

<body>
  
  <div>
     <h3 style="margin: 0 0 20px; padding-bottom: 10px; border-bottom: 2px solid #cf2336; font-size: 22px">
      <img src="{{url('/new_asstes/images/logo.jpg')}}">
      </h3>
    <h3 style="margin: 0 0 20px;font-size: 22px; text-align: center; text-transform: uppercase">Invoice</h3>
    <div style="display: flex; flex-wrap: wrap">
      <div >
        <h4 style="text-transform: uppercase;margin: 0 0 10px; font-size: 17px; font-weight: 500">Bill to</h4>
        <div style="padding-left: 40px; font-size: 14px; margin-bottom: 20px">
          {{$order->customer_name}},<br> {{$order->customer_email}}, <br> {{$order->customer_phone}},<br>
          Building No: {{$order->customer_building_no}}<br>
          Street: {{$order->customer_street_no}}<br>
          Zone: {{$order->customer_zone_no}}<br>
        </div>
      </div>
      
      <div >
        <div style="/*border: 1px solid #ccc; border-width: 2px 0;*/ padding: 10px 0; text-align: right">
          <p style="margin: 0; font-size: 15px; padding: 2px 0">Invoice Date: {{date('M d, Y',strtotime($order->created_at))}}</p>
          <p style="margin: 0; font-size: 15px; padding: 2px 0">Invoice #{{$order->order_number}}</p>
        </div>
        <div style="border-bottom: 2px solid #333; padding: 5px 0; text-align: right">
          
          <p style="margin: 0; font-size: 15px; padding: 2px 0">Ordered Date: Dec 22, 2018</p><br><br><br>
        </div>
      </div>
      </div>
  <!--   <div style="display: flex; flex-wrap: wrap">
     <div style="font-weight: 700; font-size: 16px; padding: 10px 0 20px; width: 100%">Project Description: Baskert</div>
    </div>
    <div style="display: flex; flex-wrap: wrap">
    <h4 style="padding: 5px 10px; background: #ccc; margin: 0; width: 100%; font-size: 16px">Basic Service</h4>
  </div> -->
    <table  style="width:100%;">
      <tr>
        <th style="width:5%;"><h5 style="text-align: left;margin: 0; text-decoration: underline; font-size: 15px; font-weight: 500">Sl.No</h5></th>
        <th style="width:40%;"><h5 style="text-align: left;margin: 0; text-decoration: underline; font-size: 15px; font-weight: 500">Product</h5></th>
        <th style="width:20%;"><h5 style="text-align: left;margin: 0; text-decoration: underline; font-size: 15px; font-weight: 500">Price</h5></th>
        <th style="width:15%;"><h5 style="text-align: left;margin: 0; text-decoration: underline; font-size: 15px; font-weight: 500">Qunatity</h5></th>
        <th style="width:20%;"><h5 style="text-align: left;margin: 0; text-decoration: underline; font-size: 15px; font-weight: 500">Total Price</h5></th>
      </tr>
      @php $i =0; $total=0; @endphp 
      @foreach($cart as $product)
      @php $i++; 
      $product_data = DB::table('products')->where('id', '=', $product->product_id)->get()->first();          
      @endphp
      <tr>
        <td style="width:5%;"><p style="margin: 0; font-size: 15px">{{$i}}</p></td>
        <td style="width:40%;"><p style="margin: 0; font-size: 15px">{{$product_data->name}}</p></td>
        <td style="width:20%;"><p style="margin: 0; font-size: 15px">₹{{$product->price}}</p></td>
        <td style="width:15%;"><p style="margin: 0; font-size: 15px">{{$product->qty}}</p></td>
        <td style="width:20%;"><p style="margin: 0; font-size: 15px">₹ @php echo $product->price*$product->qty;
          $total  = $total+($product->price*$product->qty);
         @endphp</p></td>
      </tr>
      @endforeach
     
      <tr>
        <td colspan="5" style="width: 100%;padding: 5px 0;border-top: 2px solid #333;margin: 10px 0 0;"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><p style="margin: 0; font-size: 15px">Sub Total</p></td>
        <td><p style="margin: 0; font-size: 15px">₹ {{$total}}/-</p></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><p style="margin: 0; font-size: 15px"> Total</p></td>
        <td><p style="margin: 0; font-size: 15px">₹ {{$total}}/-</p></td>
      </tr>
    </table>
      
    </div>
  </div>
  
</body>
</html>
