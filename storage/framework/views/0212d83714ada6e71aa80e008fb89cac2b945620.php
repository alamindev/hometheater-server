<?php $__env->startSection('title'); ?>
  View Users
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
  <div class="row">
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
       <h4>View Users</h4>
       <a href="<?php echo e(route('users')); ?>" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
    </div>
        <div class="card-body card-block">
             <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Photo</td>
                        <td>:</td>
                        <td>
                           <?php if($view->photo): ?>
                        <img src='<?php echo e(asset($row->photo)); ?>' width="100" alt="user-image">
                        <?php else: ?>
                        no photo
                        <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td><p class="badge badge-danger"><?php echo e($view->address); ?>, <?php echo e($view->city); ?>, <?php echo e($view->state); ?> <?php echo e($view->zipcode); ?></p></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td><?php echo e($view->first_name); ?> <?php echo e($view->last_name); ?></td>
                    </tr>
                    <tr>
                        <td>Total Orders</td>
                        <td>:</td>
                        <td><?php echo e($view->orders->count()); ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo e($view->email); ?></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>:</td>
                       <td><?php echo $view->phone; ?></td>
                    </tr>
                    <tr>
                        <td>Bio</td>
                        <td>:</td>
                       <td><?php echo $view->bio; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/user/view-user.blade.php ENDPATH**/ ?>