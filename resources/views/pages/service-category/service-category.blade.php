@extends('layouts.app')

@section('style')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
@endsection
@section('content')
<div class="content">
  <div class="row">
  <div class="col-lg-4">
     <div class="card">
    <div class="card-header">
      Add new service category
    </div>
        <div class="card-body card-block">
            <form action="{{ route('serviceCategory.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal"> 
                @csrf 
                <div class="form-group">
                    <label for="cate_name" class=" form-control-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" id="cate_name" name="cate_name" class="form-control" placeholder="Category name"> 
                    @if($errors->has('cate_name'))
                        <div class="text-danger">{{ $errors->first('cate_name') }}</div>
                    @endif   
                </div> 
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control type"> 
                        <option value="0">Icon</option>
                        <option value="1">Image</option>
                    </select>
                </div>
                <div class="form-group icon">
                    <label for="icon" class=" form-control-label">Icon</label>
                        <input type="text" id="icon" name="icon" class="form-control">
                        <small class="text-danger">fontawesome icon classname</small>  
                </div> 
                <div class="form-group image d-none">
                    <label for="cate_img" class=" form-control-label">Category Image  </label>
                        <input type="file" id="cate_img" name="cate_img" class="form-control">  
                </div> 
                <div class="p-2">
                    <button type="submit" class="btn btn-success btn-sm">
                       <i class="fa fa-plus"></i> Add new Category
                    </button> 
                </div>
            </form>
        </div> 
    </div>
  </div>
  <div class="col-lg-8">
   <div class="card">
    <div class="card-header">
        List of service category
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered yajra-datatable" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Category name</th>
                <th>Category image/icon</th> 
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
                    <form action="{{ route('serviceCategory.update') }}" method="post" enctype="multipart/form-data" class="form-horizontal"> 
                        @csrf
                        <input type="hidden" value="" id="edit_serviceCate" name="cate_id">
                        <div class="modal-content">
                            <div class="modal-header d-flex">
                                <h5 class="modal-title" id="smallmodalLabel">Edit Service Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit_cate_name" class=" form-control-label">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_cate_name" name="cate_name" class="form-control" placeholder="Category name"> 
                                    @if($errors->has('cate_name'))
                                        <div class="text-danger">{{ $errors->first('cate_name') }}</div>
                                    @endif   
                                </div> 
                                 <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control type-edit"> 
                                        <option value="0">Icon</option>
                                        <option value="1">Image</option>
                                    </select>
                                </div>
                                <div class="form-group icon-edit">
                                    <label for="icon" class=" form-control-label">Icon</label>
                                        <input type="text" id="icon" name="icon" class="form-control">
                                        <small class="text-danger">fontawesome icon classname</small>  
                                </div> 
                                <div class="form-group image-edit d-none">
                                    <label for="cate_img" class=" form-control-label">Category Image  </label>
                                        <input type="file" id="cate_img" name="cate_img" class="form-control">  
                                         <div class="showing_img py-3">
                                    </div>
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
        ajax: "{{ route('serviceCategory') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'cate_name', name: 'cate_name'}, 
            {
                data: 'cate_img', 
                name: 'category image', 
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
            $('#edit_serviceCate').val(data.id);
            $('#edit_cate_name').val(data.cate_name);
            $('.type-edit').val(data.type);
            $('.icon-edit #icon').val(data.icon);
            $('.showing_img').html(`<img width="100" src="${getBaseUrl()}storage/${data.cate_img}" alt="Service categor image "/>`); 
             $("#smallmodal").modal('show');
              if(data.type == 1){
                $('.image-edit').removeClass('d-none') 
                $('.icon-edit').addClass('d-none')
            }else{
                $('.icon-edit').removeClass('d-none')
                $('.image-edit').addClass('d-none') 
            }
        });
       
    });
    function getBaseUrl() {
    return window.location.href.match(/^.*\//);
}  

$('.type').change(function(){
     var id= $(this).val();
     if(id == 1){
        $('.image').removeClass('d-none') 
        $('.icon').addClass('d-none')
     }else{
         $('.icon').removeClass('d-none')
           $('.image').addClass('d-none') 
     }
  
    
})
$('.type-edit').change(function(){
     var id= $(this).val();
     if(id == 1){
        $('.image-edit').removeClass('d-none') 
        $('.icon-edit').addClass('d-none')
     }else{
         $('.icon-edit').removeClass('d-none')
           $('.image-edit').addClass('d-none') 
     }
  
    
})
  });
  
</script>
@endpush
