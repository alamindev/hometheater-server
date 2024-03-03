<?php $__env->startSection('title'); ?>
Dashboard
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card color-purple">
                    <div class="card-body">
                        <div class="stat-widget-five ">
                            <div class="stat-icon dib flat-color-4">
                                <i class="pe-7s-users text-white"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text text-white"><span class="count"><?php echo e($user_count); ?></span></div>
                                    <div class="stat-heading text-white">Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card color-blue">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-4">
                               <i class="fa fa-book text-white" aria-hidden="true"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text text-white"><span class="count"><?php echo e($order_count); ?></span></div>
                                    <div class="stat-heading text-white">All Orders</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card color-red">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-4">
                             <i class="fa fa-refresh text-white"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text text-white"><span class="count"><?php echo e($pending_order); ?></span></div>
                                    <div class="stat-heading text-white">Pending order</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card color-green">
                    <div class="card-body">
                        <div class="stat-widget-five ">
                            <div class="stat-icon dib flat-color-4">
                            <i class="fa fa-usd text-white" aria-hidden="true"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text text-white">$<span class="count"><?php echo e($payments ? $payments : ''); ?></span></div>
                                    <div class="stat-heading text-white">Payments</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Widgets -->

        <!--  /Traffic -->
        <div class="clearfix"></div>
        <!-- Orders -->
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title">Recent Service Booking</h4>
                        </div>
                        <div class="card-body--">
                            <?php if(count($orders) > 0): ?>
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial">#</th>
                                            <th class="avatar">Avatar</th>
                                            <th>Order ID</th>
                                            <th>Name</th>
                                            <th>Customer Phone no.</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        ?>
                                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="serial"><?php echo e($i++); ?>.</td>
                                            <td class="avatar">
                                                <div class="round-img">
                                                    <?php if($order->user && $order->user->photo!= null): ?>
                                                        <img class="rounded-circle" src="<?php echo e(asset($order->user->photo)); ?>" alt="">
                                                        <?php else: ?>
                                                        <img class="rounded-circle" src="<?php echo e(asset('storage/uploads/avater.svg')); ?>" alt="">
                                                   <?php endif; ?>
                                                </div>
                                            </td>
                                            <td> #<?php echo e($order->order_id); ?> </td>
                                            <td>  <span class="name"><?php echo e($order->user->first_name); ?> <?php echo e($order->user->last_name); ?></span> </td>
                                            <td> <span class="product"><?php echo e($order->user->phone); ?></span> </td>
                                            <td><span class="count"><?php echo e(collect($order->quantity)->pluck('quantity')->sum()); ?></span></td>
                                            <td><?php echo e(\carbon\carbon::parse($order->created_at)->format('d M y h:i:s A')); ?></td>
                                            <td>
                                                <?php if($order->status == 'pending'): ?>
                                                <span class="badge btn-yellow"><?php echo e($order->status); ?></span>
                                                <?php elseif($order->status == 'complete'): ?>
                                                    <span class="badge btn-blue"><?php echo e($order->status); ?></span>
                                                <?php elseif($order->status == 'approved'): ?>
                                                    <span class="badge btn-green "><?php echo e($order->status); ?></span>
                                                <?php elseif($order->status == 'cancel'): ?>
                                                    <span class="badge btn-red"><?php echo e($order->status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                               <a href="<?php echo e(route('order.details', $order->order_id)); ?>" class="btn btn-info btn-blue">Order Details</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </tbody>
                                </table>
                            </div> <!-- /.table-stats -->
                            <?php else: ?> 
                               <h4 class="text-center p-3">No Data availble</h4>
                            <?php endif; ?>
                        </div>
                    </div> <!-- /.card --> 
                    <?php if(count($orders) > 0): ?>
                    <div class="card">
                        <div class="card-body d-flex justify-content-center">
                            <a href="<?php echo e(route('order')); ?>" class="btn btn-success">Show all</a>
                        </div>
                    </div> 
                    <?php endif; ?>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="box-title">Recent Product Order</h4>
                            </div>
                            <div class="card-body--">
                                <?php if(count($products) > 0): ?>
                                <div class="table-stats order-table ov-h">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th class="serial">#</th>
                                                <th class="avatar">Avatar</th>
                                                <th>Order ID</th>
                                                <th>Name</th>
                                                <th>Customer Phone no.</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            ?>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="serial"><?php echo e($i++); ?>.</td>
                                                <td class="avatar">
                                                    <div class="round-img">
                                                        <?php if($order->user && $order->user->photo!= null): ?>
                                                            <img class="rounded-circle" src="<?php echo e(asset($order->user->photo)); ?>" alt="">
                                                            <?php else: ?>
                                                            <img class="rounded-circle" src="<?php echo e(asset('storage/uploads/avater.svg')); ?>" alt="">
                                                       <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td> #<?php echo e($order->order_id); ?> </td>
                                                <td>  <span class="name"><?php echo e($order->user->first_name); ?> <?php echo e($order->user->last_name); ?></span> </td>
                                                <td> <span class="product"><?php echo e($order->user->phone); ?></span> </td>
                                                <td><span class="count"><?php echo e(collect($order->quantity)->pluck('quantity')->sum()); ?></span></td>
                                                <td><?php echo e(\carbon\carbon::parse($order->created_at)->format('d M y h:i:s A')); ?></td>
                                                <td>
                                                    <?php if($order->status == 'pending'): ?>
                                                    <span class="badge btn-yellow"><?php echo e($order->status); ?></span>
                                                    <?php elseif($order->status == 'complete'): ?>
                                                        <span class="badge btn-blue"><?php echo e($order->status); ?></span>
                                                    <?php elseif($order->status == 'approved'): ?>
                                                        <span class="badge btn-green "><?php echo e($order->status); ?></span>
                                                    <?php elseif($order->status == 'cancel'): ?>
                                                        <span class="badge btn-red"><?php echo e($order->status); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                   <a href="<?php echo e(route('order.details', $order->order_id)); ?>" class="btn btn-info btn-blue">Order Details</a>
                                                </td>
                                            </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div> <!-- /.table-stats -->
                                <?php else: ?> 
                               <h4 class="text-center p-3">No Data availble</h4>
                            <?php endif; ?>
                            </div>
                        </div> <!-- /.card -->
                        
                        <?php if(count($products) > 0): ?>
                    <div class="card">
                        <div class="card-body d-flex justify-content-center">
                            <a href="<?php echo e(route('order')); ?>" class="btn btn-success">Show all</a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>  <!-- /.col-lg-8 -->

            </div>
        </div> 
    </div>
    <!-- .animated -->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\hometheater-proz\server\resources\views/pages/index.blade.php ENDPATH**/ ?>