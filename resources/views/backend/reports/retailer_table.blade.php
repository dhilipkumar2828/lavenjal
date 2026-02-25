  <table id="example" class="table table-bordered" style="width:100%">
                                         <thead>
                                             <tr>
                                               <th>  S.no</th>
                                               <th>Order ID</th>
                                               <th>Customer Name</th>
                                               <th>Distributor</th>
                                               <th>Delivery Date</th>
                                               <th>Status</th>
                                               <th>Action</th>
                                              </tr>
                                          </thead>				
                                                    <tbody>
                                        @foreach($orders as $key=>$order)          
                                        <tr>
                                            
                                         <td>{{$key+1}}</td>
                                         
                                         <td>
                                             <div><a href="{{url('/customer-orders'.'/'.$order->order_id)}}"><h6 class="mb-0">#{{$order->order_id}}</h6></a>
                                            <p class="opacity-50 mb-0">Order Date : {{($order->order_created)}}</p></div>
                                        </td>
                                        
                                         <td>{{$order->name}}
                                        </td>
                                        
                                        <td> <a href="{{url('/customer-orders'.'/'.$order->order_id)}}" class="text-danger">{{$order->assigned_distributor_name}}</a>
                                        </td>
                                        
                                         <td>
                                             <span class="">{{$order->delivery_date}} / {{$order->delivery_time}}</span>
                                         </td>
                                         
                                         <td>  
                                         <a href="{{url('/customer-orders'.'/'.$order->order_id)}}" class="text-danger"><span class="badge status-orderplace">{{$order->order_status}}</span></a>
                                         </td>
                                         
                                         
                                          <td>
                                              <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="{{url('/customer-orders'.'/'.$order->order_id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                  
                                                      </div>
                                            </td>
                                         </tr>
                                         @endforeach
                                                                                                                                             
                                                                        
                                                                    


                                                    </tbody>
                                                </table>