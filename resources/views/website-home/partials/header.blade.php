<header  >
    <ul class="website-new-header">
        <li class="{{ Route::is('website.home.topheader') | Route::is('website.home.index') ? 'active' : '' }}"><a href="{{route('website.home.topheader')}}">Top header</a></li>
        <li class="{{ Route::is('website.home.serviceheader')   ? 'active' : '' }}"><a href="{{route('website.home.serviceheader')}}">Service header</a></li>
        <li class="{{ Route::is('website.home.productheader')   ? 'active' : '' }}"><a href="{{route('website.home.productheader')}}">Product header</a></li>
        <li class="{{ Route::is('website.home.chooseus')   ? 'active' : '' }}"><a href="{{route('website.home.chooseus')}}">Choose us</a></li>
        <li class="{{ Route::is('website.home.affiliation')   ? 'active' : '' }}"><a href="{{route('website.home.affiliation')}}">Affiliation</a></li>
        <li class="{{ Route::is('website.home.portfolio')   ? 'active' : '' }}"><a href="{{route('website.home.portfolio')}}">Portfolio</a></li>
        {{-- <li class="{{ Route::is('website.home.review')   ? 'active' : '' }}"><a href="{{route('website.home.review')}}">Dummy Review</a></li> --}}
        <li class="{{ Route::is('website.home.blog')   ? 'active' : '' }}"><a href="{{route('website.home.blog')}}">Blog header</a></li>
    </ul>
</header>
