<header  >
    <ul class="website-new-header">
        <li class="<?php echo e(Route::is('website.home.topheader') | Route::is('website.home.index') ? 'active' : ''); ?>"><a href="<?php echo e(route('website.home.topheader')); ?>">Top header</a></li>
        <li class="<?php echo e(Route::is('website.home.serviceheader')   ? 'active' : ''); ?>"><a href="<?php echo e(route('website.home.serviceheader')); ?>">Service header</a></li>
        <li class="<?php echo e(Route::is('website.home.chooseus')   ? 'active' : ''); ?>"><a href="<?php echo e(route('website.home.chooseus')); ?>">Choose us</a></li>
        <li class="<?php echo e(Route::is('website.home.affiliation')   ? 'active' : ''); ?>"><a href="<?php echo e(route('website.home.affiliation')); ?>">Affiliation</a></li>
        <li class="<?php echo e(Route::is('website.home.portfolio')   ? 'active' : ''); ?>"><a href="<?php echo e(route('website.home.portfolio')); ?>">Portfolio</a></li>
        
        <li class="<?php echo e(Route::is('website.home.blog')   ? 'active' : ''); ?>"><a href="<?php echo e(route('website.home.blog')); ?>">Blog header</a></li>
    </ul>
</header>
<?php /**PATH /var/www/vhosts/hometheaterproz.com/admin.hometheaterproz.com/resources/views/website-home/partials/header.blade.php ENDPATH**/ ?>