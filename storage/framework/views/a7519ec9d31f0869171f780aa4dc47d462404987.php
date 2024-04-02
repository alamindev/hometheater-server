<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => 'https://admin.hometheaterproz.com/contact/view/'. $contact->id]); ?>
    <div style="display: flex; align-items: center;">
        <strong style="text-decoration: underline; font-size: 24px;">
            New Message from Website</strong>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
Dear <b>Admin,</b>
<br>
<b><?php echo e($contact->name); ?></b>, sent you a message.<br>

<?php echo e($contact->details); ?> <br>

<p>Option selected: <strong><?php echo e($contact->reason); ?></strong></p>
<p>Phone Number: <strong><?php echo e($contact->phone); ?></strong></p>
 <br>
<?php $__env->startComponent('mail::button', ['url' => 'https://admin.hometheaterproz.com/contact/view/'. $contact->id]); ?>
Please login to see more details
<?php echo $__env->renderComponent(); ?>


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH F:\hometheater-proz\server\resources\views/emails/user-contact.blade.php ENDPATH**/ ?>