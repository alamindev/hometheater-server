<?php $__env->startSection('title'); ?>
Edit Product
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(asset('assets/css/lib/chosen/chosen.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <form action="<?php echo e(route('product.update', $edit->id)); ?>" method="post" enctype="multipart/form-data"
        class="form-horizontal">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Product
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="title" class=" form-control-label">Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" required id="title" name="title" value="<?php echo e($edit->title); ?>"
                                class="form-control" placeholder="Enter service title">
                            <?php if($errors->has('title')): ?>
                            <div class="text-danger"><?php echo e($errors->first('title')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="slug" class=" form-control-label">Slug <span class="text-danger">* (slug should
                                    small letter and no space example:- indoor-outdoor-speaker-installation-single )
                                </span></label>
                            <input type="text" required id="slug" name="slug" value="<?php echo e($edit->slug); ?>"
                                class="form-control" placeholder="Enter service slug">
                            <?php if($errors->has('slug')): ?>
                            <div class="text-danger"><?php echo e($errors->first('slug')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="service_type" class="form-control-label">SKU <span
                                    class="text-danger">*</span></label>
                            <input type="text" required id="service_type" name="service_type"
                                value="<?php echo e($edit->service_type); ?>" class="form-control" placeholder="Example:- TV1001">
                            <?php if($errors->has('service_type')): ?>
                            <div class="text-danger"><?php echo e($errors->first('service_type')); ?></div>
                            <?php endif; ?>
                        </div> 
                        <div class="form-group">
                            <label for="basic_price" class="form-control-label">Regular price <span
                                    class="text-danger">*</span></label>
                            <input type="number" required id="basic_price" name="basic_price"
                                value="<?php echo e($edit->basic_price); ?>" class="form-control">
                            <?php if($errors->has('basic_price')): ?>
                            <div class="text-danger"><?php echo e($errors->first('basic_price')); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="discount_price" class="form-control-label">Price Discount   <span
                                    class="text-danger">(optional)</span></label>
                            <input type="number"  maxlength="2" minlength="1" min="1" max="99" placeholder="10%"  id="discount_price" name="discount_price"
                            value="<?php echo e($edit->discount_price); ?>" class="form-control">
                            <?php if($errors->has('discount_price')): ?>
                            <div class="text-danger"><?php echo e($errors->first('discount_price')); ?></div>
                            <?php endif; ?>
                        </div>
                       <div class="form-group" id="fonticon">
                            <label for="icon" class="form-control-label">  Icon <span class="text-danger">(fontawesome icon class
                                    name)</span></label>
                            <input type="text" id="icon" name="icon" value="<?php echo e($edit->icon); ?>" class="form-control">
                        </div>
                     
                        <div class="form-group">
                            <label for="category" class=" form-control-label">Select Category <span
                                    class="text-danger">*</span></label>
                            <select required data-placeholder="Choose Category" name="category_id" id="category"
                                class="form-control">
                                <option label="default"></option>
                                <?php $__currentLoopData = App\Models\ServiceCategory::orderBy('created_at','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cate->id); ?>" <?php if($cate->id == $edit->category_id): ?> selected
                                    <?php endif; ?>><?php echo e($cate->cate_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('category_id')): ?>
                            <div class="text-danger"><?php echo e($errors->first('category_id')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                                <label for="thumbnail" class="form-control-label">Upload Thumbnail<span class="text-danger">*</span></label>
                                <input type="file"  id="thumbnail" name="thumbnail" value="<?php echo e(old('thumbnail')); ?>" class="form-control">
                                <?php if($errors->has('thumbnail')): ?>
                                <div class="text-danger"><?php echo e($errors->first('thumbnail')); ?></div>
                                <?php endif; ?>
                                <img class="pt-2 " width="100" src="<?php echo e(asset('storage'. $edit->thumbnail )); ?>" alt="service-thumbnail">
                            </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Upload photo<span
                                        class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-info update-new-photo"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="photos">
                                <div class="list-group list-group-img">
                                    <?php $__currentLoopData = $edit->serviceImage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <input type="file" name="image[<?php echo e($key); ?>][img]" data-key="<?php echo e($key); ?>"
                                                data-id="<?php echo e($image->id); ?>" id="image"
                                                class="form-control mr-1 select_img" />
                                            <input type="hidden" name="update_img[]" value="" />
                                            <input type="hidden" name="image[<?php echo e($key); ?>][id]" value="<?php echo e($image->id); ?>" />
                                            <div class="photo__trash bg-danger text-white p-2"><i
                                                    class="fa fa-trash"></i></div>
                                        </div>
                                        <img class="pt-2 " width="100" src="<?php echo e(asset('storage'. $image->image )); ?>"
                                            alt="service-image">
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <?php if($errors->has('image')): ?>
                            <div class="text-danger"><?php echo e($errors->first('image')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group pb-3">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Service Includes <span
                                        class="text-danger">(optional)</span></label>
                                <button type="button" class="btn btn-sm btn-info add-new-feature"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="feature">
                                <?php
                                $features = explode('||#||', $edit->datas);
                                array_pop($features);
                                ?>
                                <div class="list-group">
                                    <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item d-flex align-items-center">
                                        <div class="px-1 w-100"><input type="text" name="feature[]"
                                                placeholder="Feature details" value="<?php echo e($data); ?>" class="form-control">
                                        </div>
                                        <div class="feature__trash bg-danger text-white p-2"><i class="fa fa-trash"></i>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pb-3">
                            <div class="d-flex justify-content-between pb-2">
                                <label for="image" class=" form-control-label">Colors<span
                                        class="text-danger">(optional)</span></label>
                                <button type="button" class="btn btn-sm btn-info add-new-color"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="color">
                                <?php
                                $colors = explode('||#||', $edit->color);
                                array_pop($colors); 
                                ?>
                                <div class="list-group">
                                    <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item d-flex align-items-center">
                                        <?php
                                        $color = explode('||*||', $data);  
                                        ?>
                                        <div class="d-flex w-100">
                                            <div class="px-1 w-50">
                                                <input type="text" name="color_name[]" value="<?php echo e(array_key_exists(0, $color) ? $color[0] : ''); ?>" placeholder="Color Name" class="form-control">
                                            </div>
                                            <div class="px-1 w-50">
                                                <input type="text" name="color_code[]" value="<?php echo e(array_key_exists(1, $color) ? $color[1] : ''); ?>" placeholder="Color Code" class="form-control">
                                            </div>
                                        </div>
                                        <div class="color__trash bg-danger text-white p-2 flex-shrink-0">
                                            <i class="fa fa-trash"></i>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="conditions" class="form-control-label">Condition<span
                                    class="text-danger">*</span></label>
                           <select name="conditions" id="conditions" required class="form-control">
                            <option value="new" <?php if($edit->conditions === 'new'): ?> selected
                                <?php endif; ?>>New</option>
                            <option value="used" <?php if($edit->conditions === 'used'): ?> selected
                                <?php endif; ?>>Used</option>
                            <option value="out of box" <?php if($edit->conditions === 'out of box'): ?> selected
                                <?php endif; ?>>Out of Box</option>
                            <option value="refurbished" <?php if($edit->conditions === 'refurbished'): ?> selected
                                <?php endif; ?>>Refurbished</option> 
                           </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="details" class="form-control-label">Description<span
                                    class="text-danger">(optional)</span></label>
                            <textarea name="details" id="details" class="form-control"><?php echo e($edit->details); ?></textarea>
                        </div>
                    </div>
                </div> 
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="delivery_time" class="form-control-label">Delivery Date<span
                                    class="text-danger">*</span></label>
                           <select name="delivery_time" id="delivery_time" required class="form-control">
                            <option value="1" <?php if($edit->delivery_time === 1): ?> selected
                                <?php endif; ?>>01 Days</option>
                            <option value="2" <?php if($edit->delivery_time === 2): ?> selected
                                <?php endif; ?>>02 Days</option>
                            <option value="3" <?php if($edit->delivery_time === 3): ?> selected
                                <?php endif; ?>>03 Days</option>
                            <option value="4" <?php if($edit->delivery_time === 4): ?> selected
                                <?php endif; ?>> 04 Days</option>
                            <option value="5" <?php if($edit->delivery_time === 5): ?> selected
                                <?php endif; ?>>05 Days</option>
                            <option value="6" <?php if($edit->delivery_time === 6): ?> selected
                                <?php endif; ?>>06 Days</option>
                            <option value="7" <?php if($edit->delivery_time === 7): ?> selected
                                <?php endif; ?>>07 Days</option>
                            <option value="8" <?php if($edit->delivery_time === 8): ?> selected
                                <?php endif; ?>>08 Days</option>
                            <option value="9"<?php if($edit->delivery_time === 9): ?> selected
                                <?php endif; ?>>09 Days</option>
                            <option value="10"<?php if($edit->delivery_time === 10): ?> selected
                                <?php endif; ?>>10 Days</option>
                           </select>
                        </div>
                        <div class="form-group">
                            <label for="seo_details" class="form-control-label">Seo Description </label>
                            <textarea name="seo_details" cols="5" rows="5" id="seo_details"
                                class="form-control"> <?php echo e(!empty($edit) ? $edit->seo_details : ''); ?>								</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class=" form-control-label">Keyword <span class="text-danger">(keyword
                                    by comma)</span></label>
                            <textarea name="keyword" cols="5" rows="5" id="keyword" class="form-control"
                                placeholder="Enter keyword by comma"> <?php echo e(!empty($edit) ? $edit->keyword : ''); ?></textarea>
                        </div>
                        <div class="form-group">
                            <?php
                            $suggestion_id = explode(',', $edit->suggestion);
                            ?>
                            <label for="keyword" class=" form-control-label">Suggestion</label>
                            <select data-placeholder="Suggestion" multiple name="suggestion[]" id="suggestion"
                                class="form-control">
                                <option label="default"></option>
                                <?php $__currentLoopData = App\Models\Service::where('id','!=',
                                $edit->id)->where('type', 1)->orderBy('created_at','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if(in_array($service->id, $suggestion_id)): ?> selected <?php endif; ?> value="<?php echo e($service->id); ?>"><?php echo e($service->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="card">
            <div class="card-body d-flex justify-content-center">
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script src="<?php echo e(asset('assets/js/lib/chosen/chosen.jquery.min.js')); ?>"></script>
<script>
    CKEDITOR.replace( 'details' );
    jQuery("#category").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });
   jQuery("#suggestion").chosen();
   document.getElementById('type').addEventListener('change', function () {
    controlType(this.value)
    });

    controlType(document.getElementById('type').value)
    function controlType(value){
    if(value == 1){
    document.getElementById('svg').style.display = 'block';
    document.getElementById('fonticon').style.display = 'none';
    }else{
    document.getElementById('fonticon').style.display = 'block';
    document.getElementById('svg').style.display = 'none';
    }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/product/edit-product.blade.php ENDPATH**/ ?>