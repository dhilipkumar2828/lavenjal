@extends('backend.layouts.master')
@section('content')
   <!--start content-->
   <main class="page-content cuustomerinfo">
        <div class="row">
					
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-3">
                          <h6 class="mb">Distributor Report</h6>
                        </div>
                        <div class="col-9">
                           <form action="{{url('get_distributor_data')}}" class="d-flex justify-content-end" method="POST">
                               @csrf
                               <div class="mx-1">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control start_date" name="start_date" id="start_date">
                               </div>
                               <div  class="mx-1">
                                   <label>End Date</label>
                                   <input type="date" class="form-control end_date" name="end_date" id="end_date">
                               </div>
                               <div class="m-1">
                                <h6 class="mb">Time Slot</h6>
                                <select name="time_slot" id="time_slot" class="form-control">
                                    <option value="">Select Slot</option>
                                    <option value="Any time" {{(!empty($time_slot) && $time_slot=="Any time" ? 'selected' :'')}}>Any time</option>
                                    <!--<option value="8am - 12pm" {{(!empty($time_slot) && $time_slot=="8am - 12pm" ? 'selected' :'')}}>8 - 12</option>-->
                                    <!--<option value="12pm - 8pm" {{(!empty($time_slot) && $time_slot=="12pm - 8pm" ? 'selected' :'')}}>12 - 8</option>-->
                                    <option value="8am - 11am" {{(!empty($time_slot)&& $time_slot=="8am - 11am" ? 'selected' :'')}}>8 - 11</option>
                                    <option value="11am - 2pm" {{(!empty($time_slot)&& $time_slot=="11am - 2pm" ? 'selected' :'')}}>11 - 2</option>
                                    <option value="2pm - 5pm" {{(!empty($time_slot)&& $time_slot=="2pm - 5pm" ? 'selected' :'')}}>2 - 5</option>
                                    <option value="5pm - 8pm" {{(!empty($time_slot)&& $time_slot=="5pm - 8pm" ? 'selected' :'')}}>5 - 8</option>
                                </select>
                              </div>
                               <div class="d-flex  align-items-end">
                                   <button type="button" class="btn btn-secondary search_data mx-1" data-user_type="distributor">Filter</button>
                                   <button type="submit" class="btn btn-primary mx-1">Export</button>
                                    <button type="button" class="btn btn-danger clear_date  mx-1">Clear</button>
                               </div>
                         </form>
                        </div>
                        
                        </div>
                    </div>
                    <div class="card-body">

                            <div class="tab-content mt-4" id="myTabContent">
                                <!-- tabs 1 -->
                                    <div class="tab-pane fade show Processing active" id="orders1" role="tabpanel" aria-labelledby="ordertabs1">

                                            <div class="table-responsive table_render">
                                                @include('backend.reports.distributor_table')
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
                                                            <th>Distributor</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody class="order_table">
                                                    
                                                                        
                                                                             
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
                                                            <th>Customer Name</th>
                                                            <th>Delivery Boy</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody class="order_table">
                                                     
                                                                       
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
                                                            <th>Customer Name</th>
                                                            <th>Delivery Boy</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody class="order_table">
                                                   
                                                                    </tbody>
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

@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
        $('#example').DataTable({
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [6] }, 
    ]
    });
});

$(document).on("click",".clear_date",function(){
    $('.start_date').val("");
     $('.end_date').val("");
})
</script>

@endsection