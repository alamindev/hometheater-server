<?php $__env->startSection('title'); ?>
About more
<?php $__env->stopSection(); ?>
<?php $__env->startSection('website-about'); ?>
<form action="<?php echo e(route('website.about.aboutmore.store')); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                  About more section
                </div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="title" class=" form-control-label">Title <span
                                class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="<?php echo e(!empty($edit) ? $edit->title : ''); ?>"
                            placeholder="Enter title">
                            <?php if(!empty($edit)): ?>
                            <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($edit->id); ?>">
                            <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="details" class="form-control-label">Description<span
                                class="text-danger"> *</span></label>
                        <textarea name="details" cols="5" rows="5" id="details" class="form-control">  <?php echo e(!empty($edit) ? $edit->details : ''); ?></textarea>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

    <?php $__env->startPush('script'); ?>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script src="<?php echo e(asset('assets/js/lib/chosen/chosen.jquery.min.js')); ?>"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        CKEDITOR.replace( 'details' );
    </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('website-about.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/website-about/page/aboutmore/aboutmore.blade.php ENDPATH**/ ?>