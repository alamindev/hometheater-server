<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => 'https://hometheaterproz.com/users/dashboard']); ?>
<div style="display: flex; align-items: center;">
    <strong style="text-decoration: underline; font-size: 26px;">Order Details</strong>
</div>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
Dear <b><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></b></br>, <br>

<p>Thank you for your order listed below.  </p>
 

<?php if($service): ?>
<strong style="padding-bottom: 8px">1. Service appointment scheduled for: </strong> <br>
<?php $__currentLoopData = $service->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $ser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
      $serv = \App\Models\Service::where('id', $ser->service_id)->first();
?>
<?php if($serv): ?>
<strong>#<?php echo e($key+1); ?></strong> <?php echo e($serv->title); ?> 
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <br>  <br>
<strong>Date Time: </strong>  
<table style="padding: 0; margin: 0;">
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

<strong style="padding-bottom: 8px">2. Product shipment: </strong> <br>
<?php $__currentLoopData = $product->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
      $prod = \App\Models\Service::where('id', $pro->service_id)->first();
?>
<?php if($prod): ?>
<strong>#<?php echo e($key+1); ?> </strong> <?php echo e($prod->title); ?> 
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
Estimated arrival date-time:  <strong><?php echo e($product->delivery_time); ?></strong>
<?php endif; ?>
<br>
<br>
Thanks, <br>
<a href="mailto:admin@hometheaterproz.com"
    style="text-decoration: none; border-bottom: 1px dotted rgb(133, 133, 133)">admin@hometheaterproz.com</a>
    <br/>


<?php $__env->startComponent('mail::button', ['url' => 'https://hometheaterproz.com/users/dashboard']); ?>
Please login to see more details
<?php echo $__env->renderComponent(); ?>


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH F:\hometheater-proz\server\resources\views/emails/user-notification.blade.php ENDPATH**/ ?>