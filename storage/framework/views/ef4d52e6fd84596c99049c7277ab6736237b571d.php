<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?php echo e(Route::is('home') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('home')); ?>"><i class="menu-icon fa fa-dashboard"></i> Dashboard </a>
                </li>

                <li class="<?php echo e(Route::is('schedule') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('schedule')); ?>"><i class="menu-icon fa fa-calendar-check-o"></i> Schedule </a>
                </li>
                <li class="<?php echo e(Route::is('order') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('order')); ?>"><i class="menu-icon fa fa-bookmark"></i> Booking Orders </a>
                </li>
                <li class="<?php echo e(Route::is('productorder') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('productorder')); ?>"><i class="menu-icon fa fa-bookmark"></i> Product Orders  </a>
                </li>
                <li class="<?php echo e(Route::is('zipcode') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('zipcode')); ?>"><i class="menu-icon fa fa-grav"></i> Zipcode </a>
                </li>
                <li class="<?php echo e(Route::is('serviceCategory') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('serviceCategory')); ?>"><i class="menu-icon fa fa-meetup"></i> Categories </a>
                </li>
                <li class="<?php echo e(Route::is('album') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('album')); ?>"><i class="menu-icon fa fa-book"></i> Album </a>
                </li>
                <li class="<?php echo e((Route::is('galleries') || Route::is('gallery.create')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('galleries')); ?>"><i class="menu-icon fa fa-photo"></i> Galleries </a>
                </li>
                <li class="<?php echo e((Route::is('services') || Route::is('service.create')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('services')); ?>"><i class="menu-icon fa fa-server"></i> Services </a>
                </li>
                <li class="<?php echo e((Route::is('products') || Route::is('service.create')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('products')); ?>"><i class="menu-icon fa fa-sliders"></i> Products</a>
                </li>
                <li class="<?php echo e((Route::is('users') || Route::is('users.show')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('users')); ?>"><i class="menu-icon fa fa-users"></i> Users </a>
                </li>
                <li class="<?php echo e((Route::is('reviews') || Route::is('review.show')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('reviews')); ?>"><i class="menu-icon fa fa-registered"></i> Reviews </a>
                </li>
                <li class="<?php echo e((Route::is('comments') || Route::is('comment.show')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('comments')); ?>"><i class="menu-icon fa fa-commenting-o"></i> Comments </a>
                </li>
                <li class="<?php echo e((Route::is('promo') || Route::is('promo.create')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('promo')); ?>"><i class="menu-icon fa fa-ad"></i> Promo Code </a>
                </li>

                <li class="<?php echo e((Route::is('pages') || Route::is('page.create')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('pages')); ?>"><i class="menu-icon fa fa-address-book-o "></i> Pages </a>
                </li>
                <li class="<?php echo e((Route::is('contacts') || Route::is('page.view')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('contacts')); ?>"><i class="menu-icon fa fa-address-book "></i> Messages </a>
                </li>
                <li class="<?php echo e(Route::is('blogCategory') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('blogCategory')); ?>"><i class="menu-icon fas fa-list"></i> Blog Categories </a>
                </li>
                <li class="<?php echo e(Route::is('tag') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('tag')); ?>"><i class=" menu-icon fas fa-tags"></i> Tags </a>
                </li>
                <li
                    class="<?php echo e((Route::is('posts') || Route::is('post.create') ||  Route::is('post.show')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('posts')); ?>"><i class=" menu-icon fas fa-tags"></i> Posts </a>
                </li>
                
                <li class="<?php echo e(Route::is('website.info.home') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('website.info.home')); ?>"> <i class="menu-icon fa fa-info" aria-hidden="true"></i>
                        Website Meta
                        Info </a>
                </li>
                <li class="<?php echo e(Route::is('website.home.topheader') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('website.home.topheader')); ?>"><i class="menu-icon fa fa-home"></i> Website Global page
                    </a>
                </li>

                <li class="<?php echo e(Route::is('website.about.slider') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('website.about.slider')); ?>"><i class="menu-icon fa fa-adjust"></i> Website About
                    </a>
                </li>
                <li class="<?php echo e(Route::is('contactpage') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('contactpage')); ?>"><i class="menu-icon fa fa-compress"></i> Contact Page </a>
                </li>
                <li class="<?php echo e(Route::is('setting') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('setting')); ?>"><i class="menu-icon fa fa-cogs"></i> Setting </a>
                </li>
                <li class="<?php echo e(Route::is('customcodes') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('customcodes')); ?>"><i class="menu-icon fa fa-cogs"></i> Custom CSS </a>
                </li>
                <li class="<?php echo e(Route::is('changepassword') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('changepassword')); ?>"><i class="menu-icon fa fa-unlock-alt"></i> Change Password
                    </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<?php /**PATH F:\hometheater-proz\server\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>