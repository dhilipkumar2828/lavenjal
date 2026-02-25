@extends('backend.layouts.master')
@section('content')
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Distributor List</div>
                         <div class="ms-auto">
                <form action="{{url('import_distributor_data')}}" class="d-flex justify-content-end" method="POST" enctype="multipart/form-data">
                           @csrf
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    <button type="submit" class="btn btn-primary mb-3 mb-lg-0">Import Distributor</button> 
                </form>
            </div>
            <div class="ms-auto">
                <form action="{{url('get_distributor_data')}}" class="d-flex justify-content-end" method="POST">
                           @csrf
                    <button class="btn btn-primary mb-3 mb-lg-0">Export Distributors</button> 
                </form>
            </div>
            <div class="ms-auto">
                <a class="btn btn-primary mb-3 mb-lg-0" href="{{ route('distributor.create') }}">
                    <i class="bi bi-plus-square-fill"></i>Add Distributor </a>
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
                                <th>Distributor ID</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>User Status</th>
                                <th>Shop Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($distributors as $key=>$distributor)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    <h6><strong>{{$distributor->name}}</strong></h6>
                                    <h6 class="mb-0"><i class='bx bxs-store'></i>{{!empty($distributor->name_of_shop) ? $distributor->name_of_shop : ''}}</h6>
                                    <h6 class="mb-0"><span class="d-flex"><i class='bx bx-map'></i> <p style="width: 300px; white-space: pre-wrap;">{{!empty($distributor->full_address) ? $distributor->full_address : ''}}</p> </span></h6>
                                </td>
                                <td>{{$distributor->u_id}}</td>
                                <td>{{$distributor->phone}}</td>
                                <td>{{$distributor->email}}</td>
                                <td><input type="checkbox" data-name="Distributor" data-user_id="{{$distributor->u_id}}" class="user_status" data-toggle="toggle" data-on="Active" data-off="In Active" data-onstyle="success" data-offstyle="danger"  {{$distributor->user_status==1 ? 'checked' : ''}} ></td>
                                <td>
                                   <span class="badge  {{$distributor->status == '1' ? 'bg-light-success text-success' : 'bg-light-danger text-danger'}}">{{$distributor->status == '0' ? 'Inactive' : 'Active'}}</span>
                                </td>
                                <td>
                      
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <a href="{{ route('distributor.show',$distributor->o_id) }}" class="text-primary"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i
                                                class="bi bi-eye-fill bg-view"></i></a>
                                        <a href="{{ route('distributor.edit',$distributor->o_id) }}" class="text-warning"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i
                                                class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal"></i></a>
                                        <form action="{{route('distributor.destroy',$distributor->o_id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Delete"><i class="bi bi-trash-fill  bg-delete"></i></button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                          

                          

                        </tbody>
       
                    </table>

                </div>
            </div>
    </main>
    <!--end page main-->
    
@endsection

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
