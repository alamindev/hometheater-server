<?php $__env->startSection('website-home'); ?>
<form action="<?php echo e(route('website.home.productheader.store')); ?>" method="post" 
    class="form-horizontal">
    <?php echo csrf_field(); ?> 
    <div class="card">
        <div class="card-header">
           Shop header
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
                <label for="description" class="form-control-label">Description<span class="text-danger">
                        *</span></label>
                <textarea name="description" id="description"
                    class="form-control">  <?php echo e(!empty($edit) ? $edit->description : ''); ?></textarea>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <button type="submit" class="btn btn-info">Update</button>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('website-home.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/website-home/page/product-header/product-header.blade.php ENDPATH**/ ?>