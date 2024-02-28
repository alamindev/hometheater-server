<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => 'https://hometheaterproz.com/users/booking/'. $order->id .'/details']); ?>
<div style="display: flex; align-items: center;">  <strong
    style="margin-left: 30px; text-decoration: underline">Notification for booking status</strong>
</div>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>

Dear  <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></br>, <br>

<?php if($status == 'approved'): ?>
<strong>Your appointment status in now marked as <span style="color: #4e81ee">approved</span>. We will see you on:</strong>
<table class="table table-bordered">
    <?php $__currentLoopData = $order->orderdate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td>
            <strong><?php echo e(\Carbon\Carbon::parse($date->date)->format('d M Y')); ?>

                <?php echo e(\Carbon\Carbon::parse($date->time)->format('g:i A')); ?></strong>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php elseif($status == 'cancel'): ?>
<strong>Your appointment status in now marked as <span style="color: red">cancelled</span>.</strong>
<?php elseif($status == 'complete'): ?>
<strong>Your task is now <span style="color: green">completed</span>. Please take the time to leave a review for your installer.</strong>
<?php endif; ?>


<br>
Thanks, <br>
<a href="mailto:admin@hometheaterproz.com" style="text-decoration: none; border-bottom: 1px dotted rgb(133, 133, 133)">admin@hometheaterproz.com</a>

</br>
</br>

<?php if($status == 'complete'): ?>
<div style="text-align: center; withd: 100%">
    <a style="margin-top: 20px;padding: 6px 20px; border-radius:5px; background-color: #4e81ee; color: white; display:inline-block; text-decoration: none;"
        href="https://hometheaterproz.com/users/booking/<?php echo e($order->id); ?>/review">Leave a review</a>
</div>
<?php endif; ?>
<?php if(!$status == 'complete'): ?>
<?php $__env->startComponent('mail::button', ['url' => 'https://hometheaterproz.com/users/booking/'. $order->id .'/details']); ?>
Please login to see more details
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH F:\hometheater-proz\server\resources\views/emails/send-status.blade.php ENDPATH**/ ?>