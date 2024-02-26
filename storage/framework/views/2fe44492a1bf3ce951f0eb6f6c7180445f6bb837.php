<?php $__env->startSection('title'); ?>
Custom css and js code
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <form action="<?php echo e(route('custom.css.store')); ?>" method="post" enctype="multipart/form-data"
                class="form-horizontal">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        Write custom css
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <textarea name="css" cols="5" rows="15" id="css"
                                class="form-control">  <?php echo e(!empty($css) ? $css : ''); ?></textarea>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/hometheaterproz.com/admin.hometheaterproz.com/resources/views/pages/custom-codes/custom-codes.blade.php ENDPATH**/ ?>