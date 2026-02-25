@extends('backend.layouts.master')
@section('content')
    <!--start content-->
    
    <style>
        .page-breadcrumb-delivery{
            padding: 15px;
    background: white;
    border-radius: 5px;
        }
    </style>
    <main class="page-content">
   
        <!--breadcrumb-->
        <div class="page-breadcrumb page-breadcrumb-delivery  align-items-center mb-3">
                                   
            <div class="row">  
            
                 <div class="col-md-12"> 
                        <h2 class="breadcrumb-title pe-3 w-100">Delivery Partner Lists</h2>
                </div>
            </div>
                <div class="row">     
                 <div class="col-md-6">  
                    <div class="ms-auto">
                        <form action="{{url('import_delivery_data')}}" class="d-flex justify-content-end" method="POST" enctype="multipart/form-data">
                                   @csrf
                            <input type="file" name="file" class="custom-file-input m-3 " id="customFile">
                            <button type="submit" class="btn btn-primary m-3  mb-3 mb-lg-0">Import Delivery Partners</button> 
                        </form>
                    </div>
                 </div>
                 
                 <div class="col-md-3"> 
                    <div class="ms-auto">
                        <form action="{{url('get_distributor_data')}}" class="d-flex justify-content-end" method="POST">
                                   @csrf
                            <button class="btn btn-primary m-3 mb-3 mb-lg-0">Export Delivery Partners</button> 
                        </form>
                    </div>
                </div>
                
             <div class="col-md-3"> 
                <div class="ms-auto">
                   <a class="btn btn-primary m-3 mb-3 mb-lg-0" href="{{ route('delivery_agent.create') }}">
                        <i class="bi bi-plus-square-fill"></i>Add Delivery Partner </a>
                </div>
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-4">
       
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">{{ $message }}</div>
                    @endif
                <div class="table-responsive">
                    <table id="example" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Shop Details</th>
                                <th>Delivery ID</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Otp</th>
                                <th>User Status</th>
                                <th>Shop Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($delivery_agent as $key=>$delivery_agent)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    <h6><strong>{{$delivery_agent->name}}</strong></h6>
                                    <h6 class="mb-0"><i class='bx bxs-store'></i>{{!empty($delivery_agent->name_of_shop) ? $delivery_agent->name_of_shop : ''}}</h6>
                                    <h6 class="mb-0"><span class="d-flex"><i class='bx bx-map'></i> <p style="width: 300px; white-space: pre-wrap;">{{!empty($delivery_agent->full_address) ? $delivery_agent->full_address : ''}}</p> </span></h6>
                                </td>
                                <td>{{$delivery_agent->unique_id}}</td>
                                <td>{{$delivery_agent->phone}}</td>
                                <td>{{$delivery_agent->email}}</td>
                                <td>{{$delivery_agent->otp}}</td>
                                <td><input type="checkbox" data-name="Distributor" data-user_id="{{$delivery_agent->u_id}}" class="user_status" data-toggle="toggle" data-on="Active" data-off="In Active" data-onstyle="success" data-offstyle="danger"  {{$delivery_agent->user_status==1 ? 'checked' : ''}} ></td>
                                <td>
                                   <span class="badge  {{$delivery_agent->status == '1' ? 'bg-light-success text-success' : 'bg-light-danger text-danger'}}">{{$delivery_agent->status == '0' ? 'Inactive' : 'Active'}}</span>
                                </td>
                                <td>
                                {{-- @foreach($owners as $owner) --}}
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <a href="{{ route('delivery_agent.show',$delivery_agent->o_id) }}" class="text-primary"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i
                                                class="bi bi-eye-fill bg-view"></i></a>
                                        <a href="{{ route('delivery_agent.edit',$delivery_agent->o_id) }}" class="text-warning"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i
                                                class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal"></i></a>
                                        <form action="{{route('delivery_agent.destroy',$delivery_agent->o_id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Delete"><i
                                                    class="bi bi-trash-fill  bg-delete"></i></button>
                                        </form>
                                    </div>
                                 {{-- @endforeach --}}
                                </td>
                            </tr>
                        @endforeach
                            {{-- <tr>
                                <td>2</td>

                                <td>
                                    <h6><strong>Pandian</strong></h6>
                                    <h6 class="mb-0"><i class='bx bxs-store'></i> Nethra Coffee Shop</h6>
                                    <h6 class="mb-0"><span><i class='bx bx-map'></i> Bangalore 601263</span></h6>
                                </td>
                                <td>#LV123456</td>
                                <td>740143906</td>
                                <td>nethra@gmail.com</td>
                                <td><span class="badge bg-light-danger text-danger">Pending</span></td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <a href="{{ url('/delivery-view') }}" class="text-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="View"><i
                                                class="bi bi-eye-fill bg-view"></i></a>
                                        <a href="{{ url('/deliveryboyedit') }}" class="text-warning"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i
                                                class="bi bi-pencil-fill bg-edit"></i></a>
                                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Delete"><i
                                                class="bi bi-trash-fill  bg-delete"></i></a>
                                    </div>
                                </td>
                            </tr> --}}


                        </tbody>
                        <!-- <tfoot>
             <tr>
              <th>Name</th>
              <th>Position</th>
              <th>Office</th>
              <th>Age</th>
              <th>Start date</th>
              <th>Salary</th>
             </tr>
            </tfoot> -->
                    </table>
            </div>
        </div>
    </main>
    <!--end page main-->
@endsection

<!-- Edit -->
<div class="col">
    <!-- Modal -->
    <div class="modal fade" id="exampleLargeModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Name</label>
                            <input class="form-control mb-3" type="text" placeholder=""
                                aria-label="default input example" value="Karthik">
                        </div>
                        <div class="col-lg-6">
                            <label>Shop Name</label>
                            <input class="form-control mb-3" type="text" placeholder=""
                                aria-label="default input example" value="Lavenjal">
                        </div>
                        <div class="col-lg-6">
                            <label>Phone Number</label>
                            <input class="form-control mb-3" type="tel" placeholder=""
                                aria-label="default input example" value="9876543210">
                        </div>
                        <div class="col-lg-6">
                            <label>Email Id</label>
                            <input class="form-control mb-3" type="email" placeholder=""
                                aria-label="default input example" value="karthik@gmail.com">
                        </div>
                        <div class="col-lg-6">
                            <label>Aadhaar Number</label>
                            <input class="form-control mb-3" type="tel" placeholder=""
                                aria-label="default input example" value="1234 5678 9012">
                        </div>
                        <div class="col-lg-6">
                            <label>Shop Address</label>
                            <textarea class="form-control mb-3">Ashok Pillar, Chennai.</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
        $('#example').DataTable({
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [7] }, 
    ]
    });
});
</script>

@endsection