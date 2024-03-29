<?php $__env->startSection('title'); ?>
Product view
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>View Product</h4>
                    <a href="<?php echo e(route('products')); ?>" class="btn btn-success"> <i class="fa  fa-arrow-left "></i>
                        Back</a>
                </div>
                <div class="card-body card-block">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Product title</td>
                                <td>:</td>
                                <td><?php echo e($view->title); ?></td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>:</td>
                                <td>$<?php echo e($view->basic_price); ?></td>
                            </tr> 
                            <tr>
                                <td>Discount Price</td>
                                <td>:</td>
                                <td>$<?php echo e($view->discount_price); ?></td>
                            </tr> 
                            <tr>
                                <td>Product Category</td>
                                <td>:</td>
                                <td><?php echo e($view->category->cate_name); ?></td>
                            </tr>
                            <tr>
                                <td>Product details</td>
                                <td>:</td>
                                <td><?php echo $view->details; ?></td>
                            </tr>
                            <tr>
                                <td>Seo details</td>
                                <td>:</td>
                                <td><?php echo $view->seo_details; ?></td>
                            </tr>
                            <tr>
                                <td>Keyword</td>
                                <td>:</td>
                                <td><?php echo $view->keyword; ?></td>
                            </tr>
                            <tr>
                                <td>Suggestion</td>
                                <td>:</td>
                                <?php
                                $suggestion_id = explode(',', $view->suggestion)
                                ?>
                                <td>
                                    <?php $__currentLoopData = App\Models\Service::whereIn('id', $suggestion_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <p class="font-weight-bold"><?php echo e($service->title); ?>,</p> <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Thumbnail</td>
                                <td>:</td>
                                <td>
                                 <img class="pt-2 " width="100" src="<?php echo e(asset('storage'. $view->thumbnail )); ?>" alt="service-thumbnail">
                                </td>
                            </tr>
                            <tr>
                                <td><b style="color: red">Delivery Time</b></td>
                                <td>:</td>
                                <td>
                                  <strong class="display-5"> <?php echo e($view->delivery_time); ?> Days</strong> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Product Images</h4>
                </div>
                <div class="card-body card-block">
                    <div class="row">
                        <?php $__currentLoopData = $view->serviceImage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4">
                            <img src="<?php echo e(asset('storage'. $image->image )); ?>" alt="service-image">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Product Feature</h4>
                </div>
                <div class="card-body card-block">
                    <table class="table table-bordered">
                        <tbody>
                            <?php
                            $features = explode('||#||', $view->datas);
                            array_pop($features);
                            ?>
                            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($feature); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/product/view-product.blade.php ENDPATH**/ ?>