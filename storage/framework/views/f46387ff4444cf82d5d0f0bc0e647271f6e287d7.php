<?php $__env->startSection('website-about'); ?>
<form action="<?php echo e(route('website.about.information.store')); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                  About info section
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
                    <div class="form-group">
                        <label for="photo" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                        <input type="file" name="photo" id="photo" class="form-control" />
                        <?php if($errors->has('photo')): ?>
                        <div class="text-danger"><?php echo e($errors->first('photo')); ?></div>
                        <?php endif; ?>
                        <?php if(!empty($edit)): ?>
                            <img class="pt-2" src="<?php echo e(asset('storage'. $edit->image)); ?>" alt="top header image" width="100">
                        <?php endif; ?>

                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('website-about.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/website-about/page/information/information.blade.php ENDPATH**/ ?>