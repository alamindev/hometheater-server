<?php $__env->startSection('website-meta'); ?>
<form action="<?php echo e(route('website.info.store','booking')); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   Booking page meta
                </div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="title" class=" form-control-label">Title </label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="<?php echo e(!empty($edit) ? $edit->title : ''); ?>"
                            placeholder="Enter title">
                            <?php if(!empty($edit)): ?>
                            <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($edit->id); ?>">
                            <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="details" class="form-control-label">Description </label>
                        <textarea name="details" cols="5" rows="5" id="details" class="form-control">  <?php echo e(!empty($edit) ? $edit->description : ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo" class=" form-control-label">Upload Photo</label>
                        <input type="file" name="photo"   id="photo" class="form-control" />
                        <?php if(!empty($edit) && $edit->image != ''): ?>
                            <img class="pt-2" src="<?php echo e(asset('storage'. $edit->image)); ?>" alt="top header image" width="100">
                        <?php endif; ?>

                    </div>
                    <div class="form-group">
                        <label for="keyword" class=" form-control-label">Keyword <span class="text-danger">(keyword by comma)</span></label>
                        <input type="text" id="keyword" name="keyword" class="form-control" value="<?php echo e(!empty($edit) ? $edit->keyword : ''); ?>"
                            placeholder="Enter keyword by comma">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('website-meta-info.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/website-meta-info/page/booking.blade.php ENDPATH**/ ?>