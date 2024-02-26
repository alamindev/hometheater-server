<header  >
    <ul class="website-new-header">
            <li class="{{ Route::is('website.about.slider')  ? 'active' : '' }}"><a href="{{route('website.about.slider')}}">Slider</a></li>
            <li class="{{ Route::is('website.about.information')  ? 'active' : '' }}"><a href="{{route('website.about.information')}}">Information</a></li>
            <li class="{{ Route::is('website.about.member')  ? 'active' : '' }}"><a href="{{route('website.about.member')}}">Member</a></li>
            <li class="{{ Route::is('website.about.counter')  ? 'active' : '' }}"><a href="{{route('website.about.counter')}}">Counter</a></li>
            <li class="{{ Route::is('website.about.aboutmore')  ? 'active' : '' }}"><a href="{{route('website.about.aboutmore')}}">About more</a></li>
    </ul>
</header>
