<header  >
    <ul class="website-new-header">
            <li class="<?php echo e(Route::is('website.about.slider')  ? 'active' : ''); ?>"><a href="<?php echo e(route('website.about.slider')); ?>">Slider</a></li>
            <li class="<?php echo e(Route::is('website.about.information')  ? 'active' : ''); ?>"><a href="<?php echo e(route('website.about.information')); ?>">Information</a></li>
            <li class="<?php echo e(Route::is('website.about.member')  ? 'active' : ''); ?>"><a href="<?php echo e(route('website.about.member')); ?>">Member</a></li>
            <li class="<?php echo e(Route::is('website.about.counter')  ? 'active' : ''); ?>"><a href="<?php echo e(route('website.about.counter')); ?>">Counter</a></li>
            <li class="<?php echo e(Route::is('website.about.aboutmore')  ? 'active' : ''); ?>"><a href="<?php echo e(route('website.about.aboutmore')); ?>">About more</a></li>
    </ul>
</header>
<?php /**PATH F:\hometheater-proz\server\resources\views/website-about/partials/header.blade.php ENDPATH**/ ?>