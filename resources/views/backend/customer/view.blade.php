@extends('backend.layouts.master')
@section('content')
  <!--start content-->
  <main class="page-content cuustomerinfo">
                <div class="row">
					<div class="col-xl-3">
                        <div class="card">
                            <div class="card-header">
  <h6 class="mb">Profile</h6>
                                </div>
                            <div class="card-body">
              <div class="product-box mb-3 text-center">
                                                <img src="{{asset('backend/assets/images/avatars/lavenjal-user.png')}}" alt="User image" style="width:5em;">
                                            </div>
<div class="text-center">
    <h5><strong>{{$user->name}}</strong></h5>
     <div class="customer-detail">
                   <h6 class="mb-0"><i class="lni lni-phone me-2"></i>{{$user->phone}}<h6>
        <h6 class="mb-0"><i class="fadeIn animated bx bx-message-alt-detail me-2 mb-3"></i>{{$user->email}}<h6>
   </div>
  <hr />

</div>
    <h4>Address</h4>
@foreach($addresses as $address)
<div class="address-customer mb-4">
  <span class="type"><b class="badge bg-success me-2">{{$address->address_type=="home"?"Home":"Apartment"}}</b><b class="Default badge bg-dark">{{$address->is_default=="true"?"Default":""}}</b></span>
    <h5>{{$user->name}}</h5>
  <p>No {{$address->door_no}}</p>
  <p> {{$address->address}}</p>
  <p> {{$address->city}}</p>
  <p> {{$address->state}} - {{$address->zip_code}}</p>
  <!--<p><a class="mapview" href="#">View Map</a></p>-->

</div>
    <hr />
@endforeach


</div>
</div>
</div>
<div class="col-xl-9">
  <div class="card">
    <div class="card-header">
      <h6 class="mb">Order</h6>
    </div>
    <div class="card-body">

      <div class="table-responsive">
        <!-- <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer Name</th>
              <th>Water Suppliers</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="mc-table-profile">
                  <p><a href="{{url('/orders-view')}}">#LV123456</a></p>
                </div>
              </td>
              <td>Pandian</td>
              <td><a href="{{url('/orders-view')}}" class="text-danger">Vetri Water Suppliers</a> </td>
              <td><span class="badge bg-light-success text-success">Active</span></td>
              <td>
                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                  <a href="{{url('/orders-view')}}" class="text-primary" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                  <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal"
                      data-bs-target="#exampleLargeModal"></i></a>
                </div>
              </td>
            </tr>

          </tbody>

        </table> -->
        @php
            $deposit_amount=0;
        @endphp
        
        <table id="example" class="table table-bordered" style="width:100%">
                     <thead>
                      <tr>
                          <th>Order ID</th>
                          <th>Customer Name</th>
                          <th>Delivery boy</th>
                          <th>Delivery Date</th>
                          <th>Status</th>
                          <!--<th>Action</th>-->
                        </tr>                               
                     </thead>                           				
                     <tbody>
                     @foreach($orders as $order)
                        @php
                          $deposit_amount+=$order->deposit_amount;

                          $delivery_boy=\App\Models\User::where('id',$order->assigned_deliveryboy)->first();
                          
                        @endphp
                          <tr>
                            <td><div><a href="{{url('customer-orders').'/'.$order->order_id}}"><h6 class="mb-0">#{{$order->order_id}}</h6></a>
                                                                            
                            <p class="opacity-50 mb-0">Order Date : {{$order->order_created}}</p></div></td>
                            <td>{{$order->name}}
                            <p><strong>#123</strong></p>
                            </td>
                            <td>
                              <a href="{{url('customer-orders').'/'.$order->order_id}}" class="text-danger">{{!empty($delivery_boy->name) ? $delivery_boy->name : ''}}</a>
                              <div> <span class="badge bg-secondary">Delivery Boy</span></div>
                            </td>
                            <td><span class="">{{$order->delivery_date}} / {{$order->delivery_time}} </span></td>
                            <td><span class="badge bg-light-success text-success">{{$order->order_status}}</span></td>
                            <!--<td>-->
                            <!--<div class="table-actions d-flex align-items-center gap-3 fs-6">-->
                            <!--<a href="{{url('/orders-view')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>-->
                            <!--<a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>-->
                            <!--</div>-->
                            <!--</td>-->
                          </tr>
                     @endforeach
                                                                
                                                                        
                                                    </tbody>
                                                </table>   
      </div>
    </div>
  </div>
  
         <div class="card">
                <div class="card-header">
                    <h6 class="mb">Details</h6>
                </div>
                 <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Total Deposit Amount:</h6>
                            <span>{{$deposit_amount}}</span>
                        </div>
                        
                        <div class="col-md-6">
                        <h6>Total Returnable Jars:</h6>
                            <span>{{!empty($user)?$user->returnablejar_qty:''}}</span>
                        </div>
                    </div>
                    
        
                </div>
        </div>
</div>




   



</div>
</main>
<!--end page main-->

@endsection
