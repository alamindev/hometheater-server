@extends('layouts.app')

@section('style')
<link href="{{ asset('assets/css/lib/chosen/chosen.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"
        integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ=="
        crossorigin="anonymous" />
<style>
    table tr td{
        font-size: 14px !important;
    }
</style>
@endsection
@section('title')
     Generate Promo code
@endsection
@section('content')
<div class="content">
  <div class="row">
  <div class="col-lg-4">
     <div class="card">
    <div class="card-header">
      Generate Promo code
    </div>
        <div class="card-body card-block">
            <form action="{{ route('promo.store') }}" method="post" class="form-horizontal" data-parsley-validate>
                @csrf
                <div class="form-group">
                    <label for="percent" class=" form-control-label">Discount Percent(%) <span class="text-danger">*</span></label>
                        <input type="text" autocomplete="off" id="percent" name="percent" class="form-control" placeholder="Discount" required>
                    @if($errors->has('percent'))
                        <div class="text-danger">{{ $errors->first('percent') }}</div>
                    @endif
                </div>
                {{-- <div class="form-group">
                    <label for="category" class=" form-control-label">Select Category <span class="text-danger">*</span></label>
                    <select required data-placeholder="Choose Category" name="category_id" id="category" class="form-control">
                        <option value="" label="default"></option>
                        <option value="0" >All Categories</option>
                        @foreach (App\Models\ServiceCategory::orderBy('created_at','desc')->get() as $cate)
                        <option value="{{ $cate->id }}">{{ $cate->cate_name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category_id'))
                    <div class="text-danger">{{ $errors->first('category_id') }}</div>
                    @endif
                </div> --}}
                <div class="form-group">
                    <label for="end_date" class=" form-control-label">Select End Date <span class="text-danger">*</span></label>
                        <input type="text" autocomplete="off" id="end_date" name="end_date" class="form-control" placeholder="Select Date" required>
                    @if($errors->has('end_date'))
                        <div class="text-danger">{{ $errors->first('end_date') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="status" class=" form-control-label">Status </label>
                     <select name="status" id="status" class="form-control">
                         <option value="1">Active</option>
                         <option value="0">Deactive</option>
                     </select>
                </div>
                <div class="p-2">
                    <button type="submit" class="btn btn-success btn-sm">
                       <i class="fa fa-plus"></i> Add new promo
                    </button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <div class="col-lg-8">
   <div class="card">
    <div class="card-header">
        List of promo code
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered yajra-datatable" id="datatable">
        <thead>
            <tr>
                <th>Code</th>
                <th>Percent</th>
                <th>End Date</th>
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
   <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog"   aria-labelledby="smallmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <form action="{{ route('promo.update') }}" method="post"  class="form-horizontal">
                        @csrf
                        <input type="hidden" value="" id="edit_promo" name="promo_id">
                        <div class="modal-content">
                            <div class="modal-header d-flex">
                                <h5 class="modal-title" id="smallmodalLabel">Edit Service tag</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit_percent" class=" form-control-label">Discount percent (%) <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_percent" name="percent" class="form-control" placeholder="Discount" required>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="edit_category" class=" form-control-label">Select Category <span class="text-danger">*</span></label>
                                    <select required data-placeholder="Choose Category" name="category_id" id="edit_category" class="form-control">
                                        <option value="0">All Categories</option>
                                        @foreach (App\Models\ServiceCategory::orderBy('created_at','desc')->get() as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->cate_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="form-group">
                                    <label for="edit_date" class=" form-control-label">End Date <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_date" name="end_date" class="form-control" placeholder="End date" required>
                                </div>
                                <label for="edit_status" class=" form-control-label">Status</label>
                                <select name="status" id="edit_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
        integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
            integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
            crossorigin="anonymous"></script>
            <script src="{{ asset('assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
<script>
    $(function () {
        jQuery("#category").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
        });
         $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('promo') }}",
        columns: [
            {data: 'code', name: 'Code'},
            // {
            // data: 'category',
            // name: 'category',
            // orderable: true,
            // searchable: true
            // },
            {data: 'percent', name: 'Percent'},
            {
                data: 'end_date',
                name: 'end_date',
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
    var year = (new Date).getFullYear();
        var month = (new Date).getMonth();
        var date = (new Date).getDate();
    $( "#end_date" ).datepicker({
        format: 'YYYY-MM-DD',
        changeMonth: true,
        changeYear: true,
        minDate: new Date(year, month,date),
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
            $('#edit_promo').val(data.id);
            $("#edit_category option[selected]").removeAttr("selected");
            $("#edit_status option[selected]").removeAttr("selected");
            $('#edit_percent').val(data.percent);
            $('#edit_date').val(data.end_date);
            $(`#edit_status option[value=${data.status}]`).attr('selected','selected')
            // if(data.category_id != null){
            //     $(`#edit_category option[value=${data.category_id}]`).attr('selected','selected')
            // }else{
            //     $(`#edit_category option[value=0]`).attr('selected','selected')
            // }
            var year = (new Date).getFullYear();
            var month = (new Date).getMonth();
            var date = (new Date).getDate();
            $( "#edit_date" ).datepicker({
                format: 'YYYY-MM-DD',
                changeMonth: true,
                changeYear: true,
                minDate: new Date(year, month,date),
            });
            $("#smallmodal").modal('show');
        });

    });
    function getBaseUrl() {
    return window.location.href.match(/^.*\//);
}

  });

</script>
@endpush
