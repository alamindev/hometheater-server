<header  >
    <ul class="website-new-header">
        <li class="{{ Route::is('website.info.home') | Route::is('website.info.home') ? 'active' : '' }}"><a href="{{route('website.info.home')}}">Home</a></li>
        <li class="{{ Route::is('website.info.service') | Route::is('website.info.service') ? 'active' : '' }}"><a href="{{route('website.info.service')}}">Service</a></li>
        <li class="{{ Route::is('website.info.product') | Route::is('website.info.product') ? 'active' : '' }}"><a href="{{route('website.info.product')}}">Product</a></li>
        <li class="{{ Route::is('website.info.portfolio') | Route::is('website.info.portfolio') ? 'active' : '' }}"><a href="{{route('website.info.portfolio')}}">Portfolio</a></li>
        <li class="{{ Route::is('website.info.booking') | Route::is('website.info.booking') ? 'active' : '' }}"><a href="{{route('website.info.booking')}}">Booking</a></li>
        <li class="{{ Route::is('website.info.blog') | Route::is('website.info.blog') ? 'active' : '' }}"><a href="{{route('website.info.blog')}}">Blog</a></li>
        <li class="{{ Route::is('website.info.gallery') | Route::is('website.info.gallery') ? 'active' : '' }}"><a href="{{route('website.info.gallery')}}">Gallery</a></li>
        <li class="{{ Route::is('website.info.contact') | Route::is('website.info.contact') ? 'active' : '' }}"><a href="{{route('website.info.contact')}}">Contact</a></li>
        <li class="{{ Route::is('website.info.login') | Route::is('website.info.login') ? 'active' : '' }}"><a href="{{route('website.info.login')}}">Login</a></li>
        <li class="{{ Route::is('website.info.register') | Route::is('website.info.register') ? 'active' : '' }}"><a href="{{route('website.info.register')}}">Register</a></li>
    </ul>
</header>
