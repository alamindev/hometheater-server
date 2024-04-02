
<?php $__env->startSection('title'); ?>
   Contact view
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
<div class="content">
  <div class="row"> 
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h4>View contact</h4>
       <a href="<?php echo e(route('contacts')); ?>" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered"> 
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td><?php echo e($view->name); ?></td>
                    </tr> 
                    <tr>
                        <td>Phone</td>
                        <td>:</td>
                        <td><?php echo e($view->phone); ?></td>
                    </tr> 
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo e($view->email); ?></td>
                    </tr> 
                    <tr>
                        <td>Contact Reason</td>
                        <td>:</td>
                        <td><?php echo e($view->reason); ?></td>
                    </tr> 
                    <tr>
                        <td>Content</td>
                        <td>:</td>
                       <td><?php echo $view->details; ?></td>
                    </tr>
                    <tr>
                        <td>Contact Date</td>
                        <td>:</td>
                       <td><?php echo e(Carbon\Carbon::parse($view->created_at)->format('d-m-Y')); ?></td>
                    </tr>
              </tbody>
            </table>
        </div> 
    </div>
    
  </div>
  </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/contact/view-contact.blade.php ENDPATH**/ ?>