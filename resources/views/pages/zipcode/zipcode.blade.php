@extends('layouts.app')
@section('title')
Zipcode
@endsection
@section('style')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="content">
  <div class="row">
  <div class="col-lg-4">
     <div class="card">
    <div class="card-header">
      Add new Zip code
    </div>
        <div class="card-body card-block">
            <form action="{{ route('zipcode.store') }}" method="post"   class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label for="area_name" class=" form-control-label">Area Name <span class="text-danger">(optional)</span></label>
                        <input type="text" id="area_name" name="area_name" class="form-control" placeholder="Area name">
                    @if($errors->has('area_name'))
                        <div class="text-danger">{{ $errors->first('area_name') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="zipcode" class=" form-control-label">Zip code <span class="text-danger">*</span></label>
                        <input type="number" id="zipcode" name="zipcode" class="form-control" placeholder="Zipcode">
                    @if($errors->has('zipcode'))
                        <div class="text-danger">{{ $errors->first('zipcode') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="amount" class=" form-control-label">Min amount for service <span class="text-danger">(*)</span></label>
                        <input type="number" id="amount" name="amount" class="form-control" placeholder="Set amount">
                        @if($errors->has('amount'))
                        <div class="text-danger">{{ $errors->first('amount') }}</div>
                        @endif
                </div>
                <div class="p-2">
                    <button type="submit" class="btn btn-success btn-sm">
                       <i class="fa fa-plus"></i> Add new code
                    </button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <div class="col-lg-8">
   <div class="card">
    <div class="card-header">
        List of zip code
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered yajra-datatable" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Area name</th>
                <th>Amount</th>
                <th>Zipcode</th>
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
</div>
@endsection
@push('script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
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
        ajax: "{{ route('zipcode') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'area_name', name: 'area_name'},
            {data: 'amount', name: 'amount'},
            {data: 'zipcode', name: 'zipcode'},
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
                            url:url ,
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
  });
</script>
@endpush
