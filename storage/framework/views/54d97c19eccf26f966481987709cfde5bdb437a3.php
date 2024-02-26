<?php $__env->startSection('title'); ?>
  Clients and Affiliations
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('website-home'); ?>
<div class="content">
  <div class="row">
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h3> List of Clients and Affiliations</h3>
       <a href="<?php echo e(route('website.home.affiliation.create')); ?>" class="btn btn-success"> <i class="fa fa-plus"></i> Add new</a>
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered yajra-datatable" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Link</th>
                <th>photo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        </div>
    </div>
    <form action="<?php echo e(route('website.home.affiliation.header.store')); ?>" method="post"
        class="form-horizontal">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Top header title details
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control"
                                value="<?php echo e(!empty($edit) ? $edit->title : ''); ?>" placeholder="Enter title">
                            <?php if(!empty($edit)): ?>
                            <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($edit->id); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="details" class="form-control-label">Description<span class="text-danger">
                                    *</span></label>
                            <textarea name="details" cols="5" rows="5" id="details"
                                class="form-control">  <?php echo e(!empty($edit) ? $edit->details : ''); ?></textarea>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
  </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
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
        ajax: "<?php echo e(route('website.home.affiliation')); ?>",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {
                data: 'link',
                name: 'Link',
                orderable: true,
                searchable: true
            },
            {
                data: 'photo',
                name: 'Photo',
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
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('website-home.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/hometheaterproz.com/admin.hometheaterproz.com/resources/views/website-home/page/affiliation/affiliation.blade.php ENDPATH**/ ?>