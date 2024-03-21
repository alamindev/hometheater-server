<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => 'https://admin.hometheaterproz.com/dashboard']); ?>
<div style="display: flex; align-items: center;">
<strong style="text-decoration: underline">New Order Received</strong>
</div>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<strong></strong><br>

Dear <b>Admin </b></br>, <br>

<p><strong><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></strong> Ordered Services / Products</p>

<?php if($service): ?>
<strong>1. Service appointment scheduled for: </strong> <br>
<?php $__currentLoopData = $service->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $ser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
      $serv = \App\Models\Service::where('id', $ser->service_id)->first();
?>
<?php if($serv): ?>
#<?php echo e($key+1); ?> <?php echo e($serv->title); ?> 
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <br>
<strong>Date Time: </strong>  
<table >
    <?php $__currentLoopData = $service->orderdate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
<br><br>
<?php endif; ?> 
<?php if($product): ?>

<strong>2. Product shipment  date for: </strong> <br>
<?php $__currentLoopData = $product->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
      $prod = \App\Models\Service::where('id', $pro->service_id)->first();
?>
<?php if($prod): ?>
#<?php echo e($key+1); ?>  <?php echo e($prod->title); ?> 
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
 Need to deliver order to -  <strong><?php echo e($product->delivery_time); ?></strong>
<?php endif; ?>
<br>

<?php $__env->startComponent('mail::button', ['url' => 'https://admin.hometheaterproz.com/home']); ?>
Please login to see more details
<?php echo $__env->renderComponent(); ?>


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH F:\hometheater-proz\server\resources\views/emails/admin-new-booking-status.blade.php ENDPATH**/ ?>