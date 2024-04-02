<?php $__env->startSection('title'); ?>
Edit User photo
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <form action="<?php echo e(route('user.update', $edit->id)); ?>" method="post" enctype="multipart/form-data"
        class="form-horizontal">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Edit user photo
                    </div>
                    <div class="card-body card-block">

                        <div class="form-group">
                            <label for="photo" class=" form-control-label">Upload Photo<span
                                    class="text-danger">*</span></label>
                            <input type="file" name="photo" id="photo" class="form-control" />
                            <img src="<?php echo e(asset($edit->photo)); ?>" width="150" class="mt-2"
                                alt="photo">
                            <?php if($errors->has('photo')): ?>
                            <div class="text-danger"><?php echo e($errors->first('photo')); ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/user/edit.blade.php ENDPATH**/ ?>