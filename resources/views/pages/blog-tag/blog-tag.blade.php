@extends('layouts.app')
@section('title')
Blog Tag
@endsection
@section('style')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
@endsection
@section('title')
     Blog tag
@endsection
@section('content')
<div class="content">
  <div class="row">
  <div class="col-lg-4">
     <div class="card">
    <div class="card-header">
      Add new blog tag
    </div>
        <div class="card-body card-block">
            <form action="{{ route('tag.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label for="name" class=" form-control-label">tag Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tag name">
                    @if($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="p-2">
                    <button type="submit" class="btn btn-success btn-sm">
                       <i class="fa fa-plus"></i> Add new tag
                    </button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <div class="col-lg-8">
   <div class="card">
    <div class="card-header">
        List of service tag
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered yajra-datatable" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Tag name</th>
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        </div>
    </div>
  </div>
  </div>
   <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <form action="{{ route('tag.update') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <input type="hidden" value="" id="edit_tag" name="cate_id">
                        <div class="modal-content">
                            <div class="modal-header d-flex">
                                <h5 class="modal-title" id="smallmodalLabel">Edit Service tag</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit_name" class=" form-control-label">tag Name <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_name" name="name" class="form-control" placeholder="Tag name">
                                    @if($errors->has('name'))
                                        <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="Submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</div>
@endsection
@push('script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script>
    $(function () {
         $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('tag') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'slug', name: 'slug'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });
    $('#datatable').on('click', '.delete', function (e) {
    Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this Data!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    e.preventDefault();
                        var url = $(this).data('remote');
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            dataType: 'json',
                            data: {method: '_DELETE', submit: true}
                        }).always(function (data) {
                            if(data.message == 'error'){
                            Swal.fire(
                                'Error!',
                                'Something went wrong',
                                'error'
                                )
                            }else{
                                Swal.fire(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                                )
                            $('#datatable').DataTable().draw(false);
                            }

                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                    'Cancelled',
                    'Your Data file is safe :)',
                    'error'
                    )
                }
            })
    });
    $('#datatable').on('click', '.edit', function (e) {
        var url = $(this).data('remote');
        $.ajax({
            url:url ,
            type: 'get',
            dataType: 'json',
            data: {method: '_GET', submit: false}
        }).always(function (data) {
            $("#smallmodal").trigger("reset");
            $('#edit_tag').val(data.id);
            $('#edit_name').val(data.name);
            $("#smallmodal").modal('show');
        });

    });
    function getBaseUrl() {
    return window.location.href.match(/^.*\//);
}

  });

</script>
@endpush
