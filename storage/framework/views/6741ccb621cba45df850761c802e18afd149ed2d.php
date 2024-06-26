 

<?php $__env->startSection('title'); ?>
   Add new page or post
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <link href="<?php echo e(asset('assets/css/lib/chosen/chosen.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <form action="<?php echo e(route('page.store')); ?>" method="post"  enctype="multipart/form-data" class="form-horizontal">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                       Page
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="name" class=" form-control-label">Menu Name <span class="text-danger">*</span></label>
                            <input type="text" required id="name" name="name" value="<?php echo e(old('name')); ?>" class="form-control" placeholder="Enter page menu name">
                            <?php if($errors->has('name')): ?>
                                <div class="text-danger"><?php echo e($errors->first('name')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span class="text-danger">*</span></label>
                            <input type="text" required id="title" value="<?php echo e(old('title')); ?>" name="title" class="form-control" placeholder="Enter Page title">
                            <?php if($errors->has('title')): ?>
                                <div class="text-danger"><?php echo e($errors->first('title')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="type" class=" form-control-label">Page Type <span class="text-danger">*</span></label>
                            <select type="text" required id="type" name="type" class="form-control">
                                <option value="company">Company</option>
                                <option value="service">Service</option>
                            </select>
                            <?php if($errors->has('type')): ?>
                                <div class="text-danger"><?php echo e($errors->first('type')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="thumb" class=" form-control-label">Upload Photo<span class="text-danger">*</span></label>
                           <input  type="file" name="thumb"   id="thumb" class="form-control" />
                            <?php if($errors->has('thumb')): ?>
                                <div class="text-danger"><?php echo e($errors->first('thumb')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="content" class="form-control-label">Description<span class="text-danger">(optional)</span></label>
                            <textarea name="content" id="content" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="seo_details" class="form-control-label">Description </label>
                            <textarea name="seo_details" cols="5" rows="5" id="seo_details"
                                class="form-control">  <?php echo e(old('seo_details')); ?></textarea>
                        </div>
                          <div class="form-group">
                            <label for="keyword" class=" form-control-label">keyword <span class="text-danger">(optional)</span></label>
                            <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Enter keywords">
                        </div>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script src="<?php echo e(asset('assets/js/lib/chosen/chosen.jquery.min.js')); ?>"></script>
<script>

     CKEDITOR.replace('content', {
            filebrowserUploadUrl: "<?php echo e(asset('/page/uploads?_token=' . csrf_token())); ?>&type=file",
            imageUploadUrl: "<?php echo e(asset('/page/uploads?_token='. csrf_token() )); ?>&type=image",
            filebrowserBrowseUrl: "<?php echo e(asset('/page/file_browser')); ?>",
            filebrowserUploadMethod: 'form'
		});
    jQuery("#category").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/page/add-page.blade.php ENDPATH**/ ?>