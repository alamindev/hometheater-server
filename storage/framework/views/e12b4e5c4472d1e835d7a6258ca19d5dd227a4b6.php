<?php $__env->startSection('title'); ?>
Contact page
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('contactpage.store')); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
<div class="content">
   <div class="card">
    <div class="card-header">
       Contact Page details
    </div>
        <div class="card-body card-block">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($edit ? $edit->id : ''); ?>"/>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="title" class=" form-control-label">Contact Header Title</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo e($edit ? $edit->title : old('title')); ?>" >
                        <?php if($errors->has('title')): ?>
                            <div class="text-danger"><?php echo e($errors->first('title')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="image" class=" form-control-label">Contact Page Image</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="file" id="image" name="image" class="form-control-file">
                        <?php if($errors->has('image')): ?>
                                <div class="alert alert-danger"><?php echo e($errors->first('image')); ?></div>
                            <?php endif; ?>
                            <div  class="py-2">
                        <?php if(!empty($edit) && $edit->image != ''): ?>
                            <img src="<?php echo e(url('storage'. $edit->image)); ?>" alt="site logo" width="100">
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="phone" class=" form-control-label">Contact page Phone</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="phone" name="phone" class="form-control"
                            value="<?php echo e($edit ? $edit->phone : old('phone')); ?>">
                        <?php if($errors->has('phone')): ?>
                        <div class="text-danger"><?php echo e($errors->first('phone')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="email" class=" form-control-label">Contact page Email</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="email" name="email" class="form-control"
                            value="<?php echo e($edit ? $edit->email : old('email')); ?>">
                        <?php if($errors->has('email')): ?>
                        <div class="text-danger"><?php echo e($errors->first('email')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-info">Update</button>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/contact-page/contact.blade.php ENDPATH**/ ?>