@extends('backend.layouts.master')
@section('content')
   <!--start content-->
   <main class="page-content cuustomerinfo">
        <div class="row">
					
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb">Order</h6>
                    </div>
                    <div class="card-body">
                            <ul class="nav nav-pills ordernav" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link Processing active" id="ordertabs1" data-bs-toggle="tab" data-bs-target="#orders1" type="button" role="tab" aria-controls="home" aria-selected="true">All Orders</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ordertabs2" data-bs-toggle="tab" data-bs-target="#orders2" type="button" role="tab" aria-controls="profile" aria-selected="false">Customer Orders</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ordertabs3" data-bs-toggle="tab" data-bs-target="#orders3" type="button" role="tab" aria-controls="contact" aria-selected="false">Retailer Orders</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ordertabs4" data-bs-toggle="tab" data-bs-target="#orders4" type="button" role="tab" aria-controls="delivery" aria-selected="false">Delivery boy Orders</button>
                            </li>
                            </ul>
                            <div class="tab-content mt-4" id="myTabContent">
                                <!-- tabs 1 -->
                                    <div class="tab-pane fade show Processing active" id="orders1" role="tabpanel" aria-labelledby="ordertabs1">

                                            <div class="table-responsive">
                                                <table id="example" class="table table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>  S.no</th>
                                                              <th>Order ID</th>
                                                            <th>Customer / Retailer Name</th>
                                                            <th>Water Suppliers</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody>
                                                        <tr>
                                                        <td>1</td>
                                                            <td><div><a href="{{url('/resheduled')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/resheduled')}}" class="text-danger">Sakthi Water Suppliers</a>
                                                                            <div> <span class="badge bg-secondary">Delivery Boy</span></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td>
                                                                     <!-- <a href="{{url('/resheduled')}}"><span class="badge status-orderplace ">Order Place</span></a>
                                                                     <a href="{{url('/resheduled')}}"><span class="badge status-processing">Processing</span></a>
                                                                     <a href="{{url('/resheduled')}}"><span class="badge status-ongoing">Ongoing</span></a> 
                                                                     <a href="{{url('/resheduled')}}"><span class="badge status-completed">Completed</span></a> 
                                                                     <a href="{{url('/resheduled')}}"><span class="badge status-cancel ">Canceled</span></a>
                                                                     <a href="{{url('/resheduled')}}"><span class="badge status-return ">Return</span></a> -->
                                                                    
                                                                     <a href="{{url('/resheduled')}}"><span class="badge status-reshedule">Resheduled</span></a>
                                                                    </td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/resheduled')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                        <td>2</td>
                                                                            <td><div><a href="{{url('/canceled')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                            <p class="opacity-50  mb-0">Order Date : 15.11.2022</p></div></td>
                                                                        <td>Pandian
                                                                        <p><strong>#123</strong></p></td>
                                                                            <td>
                                                                                <a href="{{url('/canceled')}}" class="text-danger">Ram Water Suppliers</a>
                                                                            <div> <span class="badge bg-secondary">Dealers</span></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td><a href="{{url('/canceled')}}"><span class="badge status-cancel">Canceled</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/canceled')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                      
                                                                        <tr>
                                                                        <td>4</td>
                                                            <td><div><a href="{{url('/customer-orders')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/customer-orders')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            <div> <span class="badge bg-secondary">Delivery Boy</span></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td><a href="{{url('/customer-orders')}}"><span class="badge status-ongoing">Ongoing</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/customer-orders')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>5</td>
                                                            <td><div><a href="{{url('/retailer-orders')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/retailer-orders')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            <div> <span class="badge bg-secondary">Dealers</span></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                        <td>   <a href="{{url('/retailer-orders')}}" class="text-danger"><span class="badge status-completed">Completed</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/retailer-orders')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>6</td>
                                                            <td><div><a href="{{url('/retailer-orders')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/retailer-orders')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            <div> <span class="badge bg-secondary">Dealers</span></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                        <td>   <a href="{{url('/retailer-orders')}}" class="text-danger"><span class="badge status-orderplace">Order Place</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/retailer-orders')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>7</td>
                                                            <td><div><a href="{{url('/retailer-orders')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/retailer-orders')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            <div> <span class="badge bg-secondary">Dealers</span></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                        <td>   <a href="{{url('/retailer-orders')}}" class="text-danger"><span class="badge status-processing">Processing</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/retailer-orders')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>                                                                                   
                                                                        
                                                                    


                                                    </tbody>
                                                </table>
                                            </div>

                                    </div>
                                <!-- tabs 1 -->

                                <!-- tabs 2 -->
                                    <div class="tab-pane fade" id="orders2" role="tabpanel" aria-labelledby="ordertabs2">

                                        <div class="table-responsive">
                                                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                        <tr>
                                                          <th>  S.no</th>
                                                            <th>Order ID</th>
                                                            <th>Customer Name</th>
                                                            <th>Delivery Boy</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody>
                                                        <tr> <td>1 </td>
                                                            <td><div><a href="{{url('/resheduled')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/resheduled')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            <div></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td> <a href="{{url('/resheduled')}}" ><span class="badge bg-light-success text-success">Resheduled</span></a>
                                                                            
                                                                            
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/resheduled')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>3 </td>
                                                            <td><div><a href="{{url('/canceled')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/canceled')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            <div></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td> <a href="{{url('/canceled')}}" ><span class="badge bg-light-danger text-danger">Canceled</span></a>
                                                                            </td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/canceled')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                        </table>
                                        </div>

                                    </div>
                                <!-- tabs 2 -->

                                <!-- tabs 3 -->
                                    <div class="tab-pane fade" id="orders3" role="tabpanel" aria-labelledby="ordertabs3">

                                            <div class="table-responsive">
                                                                <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                                <thead>
                                                        <tr>
                                                        <th>S.no</th>
                                                            <th>Order ID</th>
                                                            <th>Retailer Name</th>
                                                            <th>Distributors</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody>
                                                        <tr>
                                                        <td>1</td>
                                                            <td><div><a href="{{url('/resheduled')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/resheduled')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            <div></div>
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td>
                                                                               <a href="{{url('/resheduled')}}"><span class="badge status-reshedule">Resheduled</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/resheduled')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                        <td>2</td>
                                                                            <td><div><a href="{{url('/canceled')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                        <p class="opacity-50  mb-0">Order Date : 15.11.2022</p></div></td>
                                                                        <td>Pandian
                                                                        <p><strong>#123</strong></p></td>
                                                                            <td>
                                                                                <a href="{{url('/canceled')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td><a href="{{url('/canceled')}}"><span class="badge bg-light-danger text-danger">Canceled</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/canceled')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>3</td>
                                                            <td><div><a href="{{url('/retailer-view')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/retailer-view')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td>
                                                                         <a href="{{url('/retailer-view')}}"><span class="badge status-ongoing">Ongoing</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/retailer-view')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>4</td>
                                                            <td><div><a href="{{url('/customer-orders')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/customer-orders')}}" class="text-danger">Selva Water Suppliers</a>
                                                                           
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                        <td><a href="{{url('/retailer-orders')}}"><span class="badge status-ongoing">Ongoing</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/retailer-orders')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>5</td>
                                                            <td><div><a href="{{url('/retailer-orders')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/retailer-orders')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td>   <a href="{{url('/retailer-orders')}}" class="text-danger"><span class="badge status-completed">Completed</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/retailer-orders')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                    


                                                    </tbody>
                                                                </table>
                                            </div>
                                    </div>
                                <!-- tabs 3 -->

                                <!-- tabs 4 -->
                                    <div class="tab-pane fade" id="orders4" role="tabpanel" aria-labelledby="ordertabs4">
                                            <div class="table-responsive">
                                                                    <table id="example4" class="table table-striped table-bordered" style="width:100%">
                                                                    <thead>
                                                        <tr>
                                                       
                                                        <th>S.no</th>
                                                            <th>Order ID</th>
                                                            <th>Delivery Boy Name</th>
                                                            <th>Water Suppliers</th>
                                                            <th>Retailers</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody>
                                                        <tr>
                                                        <td>1</td>
                                                            <td><div><a href="{{url('/resheduled')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                <p class="opacity-50 mb-0">Order Date : 15.11.2022</p></div></td>
                                                                            <td>Pandian
                                                                                <p><strong>#123</strong></p>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{url('/resheduled')}}" class="text-danger">Selva Water Suppliers</a>
                                                                          
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td>
                                                                <a href="{{url('/resheduled')}}"><span class="badge status-reshedule">Resheduled</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/resheduled')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                        <td>2</td>
                                                                            <td><div><a href="{{url('delivery-orders')}}"><h6 class="mb-0">#LV123456</h6></a>
                                                                        
                                                                        <p class="opacity-50  mb-0">Order Date : 15.11.2022</p></div></td>
                                                                        <td>Pandian
                                                                        <p><strong>#123</strong></p></td>
                                                                            <td>
                                                                                <a href="{{url('/canceled')}}" class="text-danger">Selva Water Suppliers</a>
                                                                            
                                                                        </td>
                                                                        <td><span class="">15.11.2022 / 6am- 8am</span></td>
                                                                            <td><a href="{{url('/canceled')}}"><span class="badge bg-light-danger text-danger">Canceled</span></a></td>
                                                                            <td>
                                                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/canceled')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                                                            </div>
                                                                            </td>
                                                                        </tr>  </tbody>
                                                                    </table>
                                            </div>
                                    </div>
                                <!-- tabs 4 -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
   </main>
        <!--end page main-->
      
@endsection