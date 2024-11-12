@extends('layouts.admin') 



@section('content')
                    <div class="content-area">

                @include('includes.form-success')



                        @if($activation_notify != "")

                            <div class="alert alert-danger validation">

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

                                <h3 class="text-center">{!! $activation_notify !!}</h3>

                            </div>

                        @endif



                        <div class="row row-cards-one">

                                <div class="col-md-12 col-lg-6 col-xl-4">

                                    <div class="mycard bg1">

                                        <div class="left">

                                            <h5 class="title" style="min-height: 64px;">Orders Pending! </h5>

                                            <span class="number">{{count($pending)}}</span>

                                            <a href="{{route('admin-order-pending')}}" class="link">View All</a>

                                        </div>

                                        <div class="right d-flex align-self-center">

                                            <div class="icon" style="font-size: 31px;">

                                                <!-- <i class="icofont-dollar"></i> -->

                                                ₹

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-12 col-lg-6 col-xl-4">

                                    <div class="mycard bg2">

                                        <div class="left">

                                            <h5 class="title" style="min-height: 64px;">Orders Procsessing!</h5>

                                            <span class="number">{{count($processing)}}</span>

                                            <a href="{{route('admin-order-processing')}}" class="link">View All</a>

                                        </div>

                                        <div class="right d-flex align-self-center">

                                            <div class="icon">

                                                <i class="icofont-truck-alt"></i>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <div class="col-md-12 col-lg-6 col-xl-4">

                                    <div class="mycard bg3">

                                        <div class="left">

                                            <h5 class="title" style="min-height: 64px;">Orders Completed!</h5>

                                            <span class="number">{{count($completed)}}</span>

                                            <a href="{{route('admin-order-completed')}}" class="link">View All</a>

                                        </div>

                                        <div class="right d-flex align-self-center">

                                            <div class="icon">

                                                <i class="icofont-check-circled"></i>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                    <div class="col-md-12 col-lg-6 col-xl-4">

                                    <div class="mycard bg4">

                                        <div class="left">

                                            <h5 class="title">Total Products!</h5>

                                            <span class="number">{{count($products)}}</span>

                                            <a href="{{route('admin-prod-index')}}" class="link">View All</a>

                                        </div>

                                        <div class="right d-flex align-self-center">

                                            <div class="icon">

                                                <i class="icofont-cart-alt"></i>

                                            </div>

                                        </div>

                                    </div>

                                </div>  

                                <div class="col-md-12 col-lg-6 col-xl-4">

                                    <div class="mycard bg5">

                                        <div class="left">

                                            <h5 class="title">Total Customers!</h5>

                                            <span class="number">{{count($users)}}</span>

                                            <a href="{{route('admin-user-index')}}" class="link">View All</a>

                                        </div>

                                        <div class="right d-flex align-self-center">

                                            <div class="icon">

                                                <i class="icofont-users-alt-5"></i>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-12 col-lg-6 col-xl-4">

                                    <div class="mycard bg6">

                                        <div class="left">

                                            <h5 class="title">Total Posts!</h5>

                                            <span class="number">{{count($blogs)}}</span>

                                            <a href="{{ route('admin-blog-index') }}" class="link">View All</a>

                                        </div>

                                        <div class="right d-flex align-self-center">

                                            <div class="icon">

                                                <i class="icofont-newspaper"></i>

                                            </div>

                                        </div>

                                    </div>

                                </div>



                            </div>



                        <div class="row row-cards-one">



<div class="col-md-6 col-lg-6 col-xl-6">

<div class="card">

  <h5 class="card-header">Recent Order(s)</h5>

  <div class="card-body">



                                        <div class="table-responsiv">

                                                <table class="table table-hover dt-responsive" cellspacing="0" width="100%">

                                                    <thead>

                                                        <tr>

                                                            <th>Customer Email</th>

                                                            <th>Order Number</th>

                                                        </tr>

                                                        @foreach($rorders as $data)

                                                        <tr>

                                                            <td>{{ $data->customer_email }}</td>

                                                            <td>{{ $data->order_number }}</td>

                                                            <td><div class="action-list"><a href="{{ route('admin-order-show',$data->id) }}"><i class="fas fa-eye"></i> <!-- View Details --></a>

                                                            </div>

                                                            </td>

                                                        </tr>

                                                        @endforeach

                                                    </thead>

                                                </table>

                                        </div>



  </div>

</div>



</div>









<div class="col-md-6 col-lg-6 col-xl-6">

<div class="card">

  <h5 class="card-header">Popular Product(s)</h5>

  <div class="card-body">



                                        <div class="table-responsiv">

                                                <table class="table table-hover dt-responsive" cellspacing="0" width="100%">

                                                    <thead>

                                                        <tr>

                                                            <th>Name</th>

                                                            <th>Type</th>

                                                        </tr>

                                                        @foreach($pproducts as $data)

                                                        <tr>

                                                            <td>{{  strlen(strip_tags($data->name)) > 50 ? substr(strip_tags($data->name),0,50).'...' : strip_tags($data->name) }}</td>

                                                            <td>{{ $data->type }}</td>

                                                            <td><div class="action-list"><a href="{{ route('admin-prod-edit',$data->id) }}"><i class="fas fa-eye"></i> <!-- View Details --></a>

                                                            </div>

                                                            </td>

                                                        </tr>

                                                        @endforeach

                                                    </thead>

                                                </table>

                                        </div>



  </div>

</div>



</div>

</div>




                        <div class="row row-cards-one">



<div class="col-md-12 col-lg-12 col-xl-12">

<div class="card">

  <h5 class="card-header">Total Sales in Last 30 Days</h5>

  <div class="card-body">



        <canvas id="lineChart"></canvas>



  </div>

</div>



</div>





</div>

                    </div>
@endsection
@section('scripts')
    <script language="JavaScript">
        displayLineChart();
        function displayLineChart() {
            var data = {
                labels: [
                    {!! $days !!}
                ],
                datasets: [
                    {
                        label: "Prime and Fibonacci",
                        fillColor: "#3dbcff",
                        strokeColor: "#0099ff",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: [
                            {!! $sales !!}
                        ]
                    }
                ]
            };
            var ctx = document.getElementById("lineChart").getContext("2d");
            var options = {
                responsive: true
            };
            var lineChart = new Chart(ctx).Line(data, options);
        }
        </script>
@endsection