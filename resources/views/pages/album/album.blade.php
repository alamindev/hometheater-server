@extends('layouts.app')

@section('style')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Add new Album
                </div>
                <div class="card-body card-block">
                    <form action="{{ route('album.store') }}" method="post" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label for="name" class=" form-control-label">Album Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Album name">
                            @if($errors->has('name'))
                            <div class="text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="category" class=" form-control-label">Select Category <span
                                    class="text-danger">*</span></label>
                            <select required data-placeholder="Choose Category" name="category_id" id="category"
                                class="form-control">
                                <option label="default"></option>
                                @foreach (App\Models\ServiceCategory::orderBy('created_at','desc')->get() as $cate)
                                <option value="{{ $cate->id }}">{{ $cate->cate_name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id'))
                            <div class="text-danger">{{ $errors->first('category_id') }}</div>
                            @endif
                        </div>
                        <div class="p-2">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add new Album
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    List of Album
                </div>
                <div class="card-body card-block">
                    <table class="table table-bordered yajra-datatable" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Album name</th>
                                <th>Category name</th>
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
    <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <form action="{{ route('album.update') }}" method="post" enctype="multipart/form-data"
                class="form-horizontal">
                @csrf
                <input type="hidden" value="" id="edit_album" name="id">
                <div class="modal-content">
                    <div class="modal-header d-flex">
                        <h5 class="modal-title" id="smallmodalLabel">Edit Service Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_album" class=" form-control-label">Category Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="edit_album_name" name="name" class="form-control"
                                placeholder="Album name">
                            @if($errors->has('album'))
                            <div class="text-danger">{{ $errors->first('album') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="category" class=" form-control-label">Select Category <span
                                    class="text-danger">*</span></label>
                            <select required data-placeholder="Choose Category" name="category_id" id="edit_category"
                                class="form-control">
                                <option label="default"></option>
                                @foreach (App\Models\ServiceCategory::orderBy('created_at','desc')->get() as $cate)
                                <option value="{{ $cate->id }}">{{ $cate->cate_name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id'))
                            <div class="text-danger">{{ $errors->first('category_id') }}</div>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
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
        ajax: "{{ route('album') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {
            data: 'category',
            name: 'Category',
            orderable: true,
            searchable: true
            },
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
            $('#edit_album').val(data.id);
            $('#edit_album_name').val(data.name);
            $('#edit_category').val(data.category_id);
            $("#smallmodal").modal('show');
        });

    });
    function getBaseUrl() {
    return window.location.href.match(/^.*\//);
}

jQuery("#category").chosen({
    no_results_text: "Oops, nothing found!",
    width: "100%"
    });
  });

</script>
@endpush
