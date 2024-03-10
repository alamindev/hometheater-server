<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => '']); ?>
<div style="position: relative;">
    <strong style="text-decoration: underline; font-size: 26px;">Payment Notification</strong>
</div>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
Hi <b><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></b></br>, <br>

<p>Your transaction of <strong><?php echo e($price); ?></strong> for <strong>
    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($key + 1); ?>. <?php echo e($service->title); ?>,
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</strong> was successful.
Thank you for your payment.  </p>


<br>
Thanks, <br>
<a href="mailto:noreply@hometheaterproz.com"
    style="text-decoration: none; border-bottom: 1px dotted rgb(133, 133, 133)">noreply@hometheaterproz.com</a>
<br />


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH F:\hometheater-proz\server\resources\views/emails/paymentstatus.blade.php ENDPATH**/ ?>