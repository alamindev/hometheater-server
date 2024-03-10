<?php $__env->startSection('title'); ?>
Order details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/magnific-popup/magnific-popup.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                   
                    <?php if($order->type === 0): ?>
                    <h4>Booking Details</h4>
                    <?php else: ?> 
                    <h4>Order Details</h4>
                    <?php endif; ?> 
                    <?php if($order->type === 0): ?>
                    <a href="<?php echo e(route('order')); ?>" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                    <?php else: ?>
                    <a href="<?php echo e(route('productorder')); ?>" class="btn btn-success"> <i class="fa  fa-arrow-left "></i> Back</a>
                    <?php endif; ?> 
                </div>
                <div class="card-body card-block">
                        <div class="row">
                            <div class="col-lg-6 pb-4 pb-md-0">
                                <?php if($order->status !== 'cancel'): ?>
                                <form class="d-flex align-items-center flex-wrap" action="<?php echo e(route('order.status')); ?>" method="post"
                                    class="form-horizontal">
                                    <?php echo csrf_field(); ?>
                                    <h4>Order Status</h4>
                                    <div class="form-group pl-3 mb-0 pb-4 pb-md-0">
                                        <input type="hidden" name="id" value="<?php echo e($order->id); ?>">
                                        <input type="hidden" name="order_id" value="<?php echo e($order->order_id); ?>">
                                        <select name="status" id="statusbox" class="form-control">
                                            <option value="cancel" <?php if($order->status =='cancel'): ?> selected <?php endif; ?>>Cancel</option>
                                            <option value="pending" <?php if($order->status =='pending'): ?> selected <?php endif; ?>>Pending</option>
                                            <?php if($order->type === 0): ?>
                                            <option value="approved" <?php if($order->status =='approved'): ?> selected <?php endif; ?>>Approved</option>
                                            <?php else: ?> 
                                            <option value="approved" <?php if($order->status =='approved'): ?> selected <?php endif; ?>>Shipped</option>
                                            <?php endif; ?>
                                            <option value="complete" <?php if($order->status =='complete'): ?> selected <?php endif; ?>>Complete</option>
                                        </select>
                                    </div>
                                    <?php if($order->type === 1): ?>
                                        <?php if($order->status =='approved'): ?>
                                        <div class="pl-2 ">
                                            <input type="url" value="<?php echo e($order->tracking_link); ?>" required name="tracking_link" placeholder="Tracking link" class="form-control">
                                        </div>
                                        <?php else: ?> 
                                        <div class="pl-2 option-content" id="approvedContent" >
                                            <input type="url" required name="tracking_link" placeholder="Tracking link" class="form-control">
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <button type="submit" onclick="return confirm('Are you sure!')" class="btn btn-success ml-5"> Update </button>
                                </form>
                                <?php else: ?>
                                <button type="submit" disabled  class="btn btn-danger ml-5"> Canceled </button>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-6">
                                <?php if($order->type === 0): ?>
                                <h4 class="pb-3">Appointment Booked At: <strong><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d M Y')); ?> <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('g:i A')); ?></strong></h4>
                                <?php else: ?> 
                                <h4 class="pb-3">Ordered At: <strong><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d M Y')); ?> <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('g:i A')); ?></strong></h4>
                                <?php endif; ?>
                                <div class="d-flex"> 
                                    <h4>Payment Methods: <strong class="text-danger"><?php echo e($order->payment); ?> Payment</strong></h4>
                                </div>
                            </div>
                        </div>
                    <table class="table mt-3">
                        <tr>
                            <td>Order ID</td>
                            <td>:</td>
                            <td><strong>#<?php echo e($order->order_id); ?></strong></td>
                        </tr> 
                        <tr>
                            <td>Order Quantity</td>
                            <td>:</td>
                            <td><strong><?php echo e(collect($order->quantity)->pluck('quantity')->sum()); ?></strong></td>
                        </tr>
                        <?php if($order->discount): ?>
                            <tr>
                                <td>Discount</td>
                                <td>:</td>
                                <td><strong><?php echo e($order->discount); ?>%</strong></td>
                            </tr>
                        <?php endif; ?>
                        <?php if($order->addon_price): ?>
                            <tr>
                                <td>Addons</td>
                                <td>:</td>
                                <td><strong>$<?php echo e($order->addon_price); ?></strong></td>
                            </tr>
                        <?php endif; ?>
                        
                        <tr>
                            <td>Total  </td>
                            <td>:</td>
                            <?php if($order->discount): ?>
                            <td><strong>$<?php echo e(($order->price + $order->addon_price) - $order->discount_price); ?></strong>  <sub>(Discount Includes) </sub></td>
                            <?php else: ?> 
                            <td><strong>$<?php echo e($order->price); ?></strong></td>
                            <?php endif; ?>
                            
                        </tr>
                    <?php if($order->payment === 'online'): ?>
                        <tr>
                            <td>Taxes</td>
                            <td>:</td>
                            <td><strong><?php echo e($order->taxes); ?>%</strong></td>
                        </tr>
                        
                        <tr>
                            <td>Total Price</td>
                            <td>:</td>
                            <?php if($order->discount): ?> 
                            <?php 
                                $total =  ($order->price + $order->addon_price) - $order->discount_price;
                            ?>
                            <?php else: ?> 
                            <?php 
                                $total =  ($order->price + $order->addon_price);
                            ?>
                            <?php endif; ?>
                            <td><strong>$<?php echo e(round($total +  $total * ($order->taxes / 100), 2)); ?></strong> <?php if($order->payment === 'online'): ?> <b class="text-primary">(Paid)</b> <?php else: ?> <b class="text-danger">(Not Paid)</b> <?php endif; ?> <sub>(Texes Includes) </sub></td>
                            
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <?php if($order->type === 0): ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Appointment Date</h4>
                </div>
                <div class="card-body card-block">
                    <table class="table table-bordered">
                        <?php $__currentLoopData = $order->orderdate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>Item #<?php echo e($key+1); ?></td>
                            <td>:</td>
                            <td>
                                <strong><?php echo e(\Carbon\Carbon::parse($date->date)->format('d M Y')); ?>

                                    <?php echo e(\Carbon\Carbon::parse($date->time)->format('g:i A')); ?></strong>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>
                    <?php else: ?> 
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 style="color: red">Deliver Date</h4>
                        </div>
                        <div class="card-body card-block">
                            <div class="row"> 
                                    <?php
                                        $collection = collect($order->services);
                                        $ids = $collection->pluck('service_id');
                                       
                                        $delivery_time = \App\Models\Service::whereIn('id', $ids)->avg('delivery_time');
                                        $startDate = carbon\carbon::parse($order->created_at);
 
                                        $date = $startDate->copy()->addDays(round($delivery_time))->format('d M y - h:i:s A');
                                    ?> 
                                <h3 class="px-3 text-danger"><strong><?php echo e($date); ?></strong></h3>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Service Details</h4>
                        </div>
                        <div class="card-body card-block">
                            <div class="row">
                                <?php $__currentLoopData = $order->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                          $service = \App\Models\Service::where('id', $ser->service_id)->first();
                                    ?>
                                    <?php if($service): ?>
                                    <div class="col-lg-6">
                                        <a href="<?php echo e(route('order.show', $service->id)); ?>">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="pb-3"><strong><?php echo e($service->title); ?></strong></h4>
                                                    <?php if($service->type === 0): ?>
                                                    <h4 class="pb-3">Price: <strong>$<?php echo e($service->basic_price); ?></strong></h4>
                                                    <?php endif; ?>
                                                    <?php
                                                        $quantity = \App\Models\OrderQuantity::where('order_id', $order->id)->where('service_id', $service->id)->first();
                                                        $price = \App\Models\OrderPrice::where('order_id', $order->id)->where('service_id', $service->id)->first();
                                                        $varient = \App\Models\OrderVarient::where('order_id', $order->id)->where('service_id', $service->id)->first();
                                                    ?>
                                                    <h4 class="pb-3">Qualtity: <strong><?php echo e($quantity ? $quantity->quantity : ''); ?></strong></h4>
                                                    <?php if($price): ?>
                                                    <h4 class="pb-3">Total Price: <strong>$<?php echo e($price ? $price->item_price   : ''); ?></strong></h4>
                                                    <?php endif; ?>
                                                    <?php if($varient): ?>
                                                        <h4 class="font-weight-bold">User Selected Varient</h4>
                                                        <p>Name: <?php echo e($varient->name); ?></p>
                                                        <p style="background-color: <?php echo e($varient->value); ?>; width: 40px; height: 40px" ></p>
                                                    <?php endif; ?>
                                                   <?php if($service->type === 0): ?>
                                                   <h4 class="pb-3">Duration: <strong><?php echo e($service->duration == 1 ? $service->duration. ' hour' : $service->duration .' hours'); ?></strong></h4>
                                                   <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Delivery Location</h4>
                </div>
                <div class="card-body card-block"> 
                    <?php if($order->address): ?>
                    <h4><?php echo e($order->address->address ? $order->address->address . ',' : $order->user->address. ','); ?>

                        <?php echo e($order->address->city ? $order->address->city . ',' : $order->user->city. ','); ?>

                        <?php echo e($order->address->state ? $order->address->state . ',' : $order->user->state. ','); ?>

                        <?php echo e($order->address->zipcode ? $order->address->zipcode . ',' : $order->user->zipcode. ','); ?> USA</h4>
                        <?php else: ?> <h4>
                        <?php echo e($order->user->address ? $order->user->address. ',': ''); ?>

                        <?php echo e($order->user->city ? $order->user->city. ',': ''); ?>

                        <?php echo e($order->user->state ? $order->user->state. ',': ''); ?>

                        <?php echo e($order->user->zipcode ? $order->user->zipcode. ',': ''); ?> USA </h4>

                        <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>User Details</h4>
                </div>
                <div class="card-body card-block">
                    <table class="table">
                        <tr>
                            <td>Photo</td>
                            <td>:</td>
                            <td class="avatar">
                                <div class="round-img">
                                    <?php if($order->user && $order->user->photo!= null): ?>
                                    <img width="60" class="rounded-circle" src="<?php echo e(asset($order->user->photo)); ?>" alt="">
                                    <?php else: ?>
                                    <img width="60" class="rounded-circle" src="<?php echo e(asset('storage/uploads/avater.svg')); ?>" alt="">
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td><strong><?php echo e($order->user->first_name); ?> <?php echo e($order->user->last_name); ?></strong></td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td>:</td>
                            <td><strong>
                                <?php if($order->user): ?>
                                    <?php echo e($order->user->address ? $order->user->address. ',': ''); ?>

                                    <?php echo e($order->user->city ? $order->user->city. ',': ''); ?>

                                    <?php echo e($order->user->state ? $order->user->state. ',': ''); ?>

                                    <?php echo e($order->user->zipcode ? $order->user->zipcode. ',': ''); ?>

                                <?php endif; ?>
                         </strong></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><strong><?php echo e($order->user->phone); ?> </strong></td>
                        </tr>
                    </table>
                    <a href="https://hometheaterproz.com/users/<?php echo e($order->user->id); ?>/profile" target="_blank" class="btn btn-info">Full Details</a>
                </div>
            </div>

            
            <?php if($order->type === 0): ?>  
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Service Questions</h4>
                </div>
                <div class="card-body card-block">
                    <div class="row">
                        <?php $__currentLoopData = $order->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $que): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-6">
                               <div class="card">
                                   <div class="card-body">
                                       <?php
                                        $question = \App\Models\ServiceQuestion::with('question_option')->where('id', $que->question_id)->where('service_id',
                                        $que->service_id)->first();
                                        ?>
                                        <style>
                                            .service--details span{
                                               color: rgb(78, 129, 238);
                                                padding-left: 5px;
                                            }
                                        </style>
                                        <?php if($question): ?>
                                        <h1 class="pb-3 service--details" style="font-size: 20px"><strong><?php echo $que->service_title; ?></strong></h1>
                                        <h4 class="pb-4">Question: <strong><?php echo e($question->name); ?></strong></h4>
                                        <?php
                                            $option = \App\Models\QuestionOption::where('id', $que->option_id)->where('question_id', $question->id)->first();
                                        ?>
                                        <?php if(!empty($option)): ?>
                                            <h4 class="pb-2">Answer: <strong><?php echo e($option->title); ?></strong></h4>
                                            <h4>Price: <strong>$<?php echo e($option->price); ?></strong></h4>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                   </div>
                               </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
           
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>User provide images</h4>
                </div>
                <div class="card-body card-block">
                    <div class="row parent-container">
                        <?php $__empty_1 = true; $__currentLoopData = $order->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a class="col-lg-4"href="<?php echo e(asset($img->image)); ?>">
                            <div class="card">
                                <div class="card-body ">
                                    <img src="<?php echo e(asset($img->image)); ?>" alt="image">
                                </div>
                            </div>
                      </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="pl-2">No photo provide</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Magnific Popup core JS file -->
<script src="<?php echo e(asset('assets/magnific-popup/jquery.magnific-popup.js')); ?>"></script>
<script>
 $('.parent-container').magnificPopup({
    delegate: 'a', // child items selector, by clicking on it popup will open
    type: 'image'
    // other options
    });
    $(document).ready(function(){
    $('.option-content').hide(); // Hide all content initially
    $('#statusbox').change(function(){
        $('.option-content').hide(); // Hide all content when selection changes
        var selectedOption = $(this).val(); // Get the selected value
        $('#' + selectedOption + 'Content').show(); // Show content based on selected value
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/order/order-details.blade.php ENDPATH**/ ?>