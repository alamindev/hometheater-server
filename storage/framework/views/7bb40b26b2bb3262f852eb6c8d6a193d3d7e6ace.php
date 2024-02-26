<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="./"><img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="<?php echo e(asset('/assets/images/logo2.png')); ?>" alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu"> 
            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="<?php echo e(asset('assets/images/admin.jpg')); ?>" alt="User Avatar">
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a> 
                    <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a> 
                    <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                                  <i class="fa fa-power -off"></i>
                                  <?php echo e(__('Logout')); ?>

                                </a>  <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form> 
                </div>
            </div>

        </div>
    </div>
</header><?php /**PATH /var/www/vhosts/hometheaterproz.com/admin.hometheaterproz.com/resources/views/partials/header.blade.php ENDPATH**/ ?>