<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Auth::routes();
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    return 'ok';
});
Route::redirect('/register', '/login');
/** for order */
Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('order');
Route::get('/product-orders', [App\Http\Controllers\OrderController::class, 'product'])->name('productorder');
Route::get('/order/details/{id}', [App\Http\Controllers\OrderController::class, 'OrderDetails'])->name('order.details');
Route::post('/order/status', [App\Http\Controllers\OrderController::class, 'UpdateStatus'])->name('order.status');
Route::get('/order/service/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('order.show');
Route::delete('/order/destroy/{id}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('order.destroy');

/** for order */
Route::get('/schedule', [App\Http\Controllers\ScheduleController::class, 'index'])->name('schedule');
Route::post('/schedule/store', [App\Http\Controllers\ScheduleController::class, 'store'])->name('schedule.store');
Route::get('/calendar/attributes', [App\Http\Controllers\ScheduleController::class, 'CalendarAttr'])->name('schedule.CalendarAttr');
Route::post('/calendar/time', [App\Http\Controllers\ScheduleController::class, 'CalendarTime'])->name('schedule.CalendarTime');

/**route for user */
Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
Route::get('/user/view/{id}', [App\Http\Controllers\UsersController::class, 'show'])->name('user.show');
Route::get('/user/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('user.edit');
Route::post('/user/update/{id}', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');
Route::delete('/users/destroy/{id}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('user.destroy');

/**route for reviews */
Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews');
Route::delete('/review/destroy/{id}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('review.destroy');

/**route for comments */
Route::get('/comments', [App\Http\Controllers\CommentController::class, 'index'])->name('comments');
Route::delete('/comment/destroy/{id}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comment.destroy');

// route for setting
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting');
Route::post('/setting/update', [App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');
Route::get('/zipcode', [App\Http\Controllers\ZipcodeController::class, 'index'])->name('zipcode');
Route::post('/zipcode/store', [App\Http\Controllers\ZipcodeController::class, 'store'])->name('zipcode.store');
Route::get('/zipcode/edit/{id}', [App\Http\Controllers\ZipcodeController::class, 'edit'])->name('zipcode.edit');
Route::post('/zipcode/update/{id}', [App\Http\Controllers\ZipcodeController::class, 'update'])->name('zipcode.update');
Route::delete('/zipcode/destroy/{id}', [App\Http\Controllers\ZipcodeController::class, 'destroy'])->name('zipcode.destroy');

Route::get('/service-category', [App\Http\Controllers\ServiceCategoryController::class, 'index'])->name('serviceCategory');
Route::post('/service-category/store', [App\Http\Controllers\ServiceCategoryController::class, 'store'])->name('serviceCategory.store');
Route::get('/service-category/edit/{id}', [App\Http\Controllers\ServiceCategoryController::class, 'edit'])->name('serviceCategory.edit');
Route::post('/service-category/update', [App\Http\Controllers\ServiceCategoryController::class, 'update'])->name('serviceCategory.update');
Route::delete('/service-category/destroy/{id}', [App\Http\Controllers\ServiceCategoryController::class, 'destroy'])->name('serviceCategory.destroy');

Route::get('/album', [App\Http\Controllers\AlbumController::class, 'index'])->name('album');
Route::post('/album/store', [App\Http\Controllers\AlbumController::class, 'store'])->name('album.store');
Route::get('/album/edit/{id}', [App\Http\Controllers\AlbumController::class, 'edit'])->name('album.edit');
Route::post('/album/update', [App\Http\Controllers\AlbumController::class, 'update'])->name('album.update');
Route::delete('/album/destroy/{id}', [App\Http\Controllers\AlbumController::class, 'destroy'])->name('album.destroy');

Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services');
Route::get('/service/create-service', [App\Http\Controllers\ServiceController::class, 'create'])->name('services.create');
Route::post('/service/store', [App\Http\Controllers\ServiceController::class, 'store'])->name('services.store');
Route::get('/service/edit/{id}', [App\Http\Controllers\ServiceController::class, 'edit'])->name('service.edit');
Route::get('/service/view/{id}', [App\Http\Controllers\ServiceController::class, 'show'])->name('service.show');
Route::post('/service/update/{id}', [App\Http\Controllers\ServiceController::class, 'update'])->name('service.update');
Route::delete('/services/destroy/{id}', [App\Http\Controllers\ServiceController::class, 'destroy'])->name('service.destroy');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::get('/product/create-service', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
Route::get('/product/view/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::post('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::delete('/products/destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');

Route::get('/galleries', [App\Http\Controllers\GalleryController::class, 'index'])->name('galleries');
Route::get('/gallery/create', [App\Http\Controllers\GalleryController::class, 'create'])->name('gallery.create');
Route::post('/gallery/store', [App\Http\Controllers\GalleryController::class, 'store'])->name('gallery.store');
Route::get('/gallery/edit/{id}', [App\Http\Controllers\GalleryController::class, 'edit'])->name('gallery.edit');
Route::get('/gallery/view/{id}', [App\Http\Controllers\GalleryController::class, 'show'])->name('gallery.show');
Route::post('/gallery/update/{id}', [App\Http\Controllers\GalleryController::class, 'update'])->name('gallery.update');
Route::delete('/gallery/destroy/{id}', [App\Http\Controllers\GalleryController::class, 'destroy'])->name('gallery.destroy');

Route::get('/pages', [App\Http\Controllers\PageController::class, 'index'])->name('pages');
Route::get('/page/create', [App\Http\Controllers\PageController::class, 'create'])->name('page.create');
Route::post('/page/store', [App\Http\Controllers\PageController::class, 'store'])->name('page.store');
Route::get('/page/edit/{id}', [App\Http\Controllers\PageController::class, 'edit'])->name('page.edit');
Route::get('/page/view/{id}', [App\Http\Controllers\PageController::class, 'show'])->name('page.show');
Route::post('/page/update/{id}', [App\Http\Controllers\PageController::class, 'update'])->name('page.update');
Route::delete('/page/destroy/{id}', [App\Http\Controllers\PageController::class, 'destroy'])->name('page.destroy');
Route::post('/page/uploads',  [App\Http\Controllers\PageController::class, 'upload']);
Route::get('/page/file_browser', [App\Http\Controllers\PageController::class, 'fileBrowser']);

Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'index'])->name('contacts');
// Route::get('/contact/create', [App\Http\Controllers\PageController::class, 'create'])->name('contact.create');
// Route::post('/contact/store', [App\Http\Controllers\PageController::class, 'store'])->name('contact.store');
// Route::get('/contact/edit/{id}', [App\Http\Controllers\PageController::class, 'edit'])->name('contact.edit');
Route::get('/contact/view/{id}', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
Route::delete('/contact/destroy/{id}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('contact.destroy');


Route::get('/blog-category', [App\Http\Controllers\BlogCategoryController::class, 'index'])->name('blogCategory');
Route::post('/blog-category/store', [App\Http\Controllers\BlogCategoryController::class, 'store'])->name('blogCategory.store');
Route::get('/blog-category/edit/{id}', [App\Http\Controllers\BlogCategoryController::class, 'edit'])->name('blogCategory.edit');
Route::post('/blog-category/update', [App\Http\Controllers\BlogCategoryController::class, 'update'])->name('blogCategory.update');
Route::delete('/blog-category/destroy/{id}', [App\Http\Controllers\BlogCategoryController::class, 'destroy'])->name('blogCategory.destroy');
Route::get('/tag', [App\Http\Controllers\TagController::class, 'index'])->name('tag');
Route::post('/tag/store', [App\Http\Controllers\TagController::class, 'store'])->name('tag.store');
Route::get('/tag/edit/{id}', [App\Http\Controllers\TagController::class, 'edit'])->name('tag.edit');
Route::post('/tag/update', [App\Http\Controllers\TagController::class, 'update'])->name('tag.update');
Route::delete('/tag/destroy/{id}', [App\Http\Controllers\TagController::class, 'destroy'])->name('tag.destroy');

Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts');
Route::get('/post/create', [App\Http\Controllers\PostController::class, 'create'])->name('post.create');
Route::post('/post/store', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
Route::get('/post/edit/{id}', [App\Http\Controllers\PostController::class, 'edit'])->name('post.edit');
Route::get('/post/view/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('post.show');
Route::post('/post/update/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update');
Route::delete('/post/destroy/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.destroy');
Route::post('/post/uploads',  [App\Http\Controllers\PostController::class, 'upload']);
Route::get('/post/file_browser', [App\Http\Controllers\PostController::class, 'fileBrowser']);


// Route::get('/social-address-info', [App\Http\Controllers\SocialInfoController::class, 'index'])->name('socialinfos');
// Route::post('/social-address-info/update', [App\Http\Controllers\SocialInfoController::class, 'update'])->name('socialinfo.update');
Route::get('/promo-code', [App\Http\Controllers\PromoController::class, 'index'])->name('promo');
Route::post('/promo-code/store', [App\Http\Controllers\PromoController::class, 'store'])->name('promo.store');
Route::get('/promo-code/edit/{id}', [App\Http\Controllers\PromoController::class, 'edit'])->name('promo.edit');
Route::post('/promo-code/update', [App\Http\Controllers\PromoController::class, 'update'])->name('promo.update');
Route::delete('/promo-code/destroy/{id}', [App\Http\Controllers\PromoController::class, 'destroy'])->name('promo.destroy');

Route::get('/contact-page', [App\Http\Controllers\ContactPageController::class, 'index'])->name('contactpage');
Route::post('/contact-page/store', [App\Http\Controllers\ContactPageController::class, 'store'])->name('contactpage.store');

Route::get('/custom-codes', [App\Http\Controllers\CustomCodesController::class, 'index'])->name('customcodes');
Route::post('/custom-codes/css/store', [App\Http\Controllers\CustomCodesController::class, 'cssStore'])->name('custom.css.store');
Route::post('/custom-codes/js/store', [App\Http\Controllers\CustomCodesController::class, 'jsStore'])->name('custom.js.store');

/**change password route */


Route::get('/change-password', [App\Http\Controllers\Auth\ChangePasswordController::class, 'index'])->name('changepassword');
Route::post('/change-password/store', [App\Http\Controllers\Auth\ChangePasswordController::class, 'changePassword'])->name('customcodes.store');


/**
 * star coding for website home
 */

Route::group(['prefix' => 'website-home'], function () {
    Route::get('/', [App\Http\Controllers\WebsiteHome\HomeController::class, 'index'])->name('website.home.index');
    Route::get('/top-header', [App\Http\Controllers\WebsiteHome\TopHeaderController::class, 'index'])->name('website.home.topheader');
    Route::post('/top-header/store', [App\Http\Controllers\WebsiteHome\TopHeaderController::class, 'store'])->name('website.home.topheader.store');
    Route::get('/blog-header', [App\Http\Controllers\WebsiteHome\BlogController::class, 'index'])->name('website.home.blog');
    Route::post('/blog-header/store', [App\Http\Controllers\WebsiteHome\BlogController::class, 'store'])->name('website.home.blog.store');

    Route::get('/service-header', [App\Http\Controllers\WebsiteHome\ServiceHeaderController::class, 'index'])->name('website.home.serviceheader');
    Route::post('/service-header/store', [App\Http\Controllers\WebsiteHome\ServiceHeaderController::class, 'store'])->name('website.home.serviceheader.store');

    Route::get('/product-header', [App\Http\Controllers\WebsiteHome\ProductHeaderController::class, 'index'])->name('website.home.productheader');
    Route::post('/product-header/store', [App\Http\Controllers\WebsiteHome\ProductHeaderController::class, 'store'])->name('website.home.productheader.store');

    Route::get('/choose-us', [App\Http\Controllers\WebsiteHome\ChooseUsController::class, 'index'])->name('website.home.chooseus');
    Route::get('/choose-us/create', [App\Http\Controllers\WebsiteHome\ChooseUsController::class, 'create'])->name('website.home.chooseus.create');
    Route::post('/choose-us/header/store', [App\Http\Controllers\WebsiteHome\ChooseUsController::class, 'storeHeader'])->name('website.home.chooseus.header.store');
    Route::post('/choose-us/store', [App\Http\Controllers\WebsiteHome\ChooseUsController::class, 'store'])->name('website.home.chooseus.store');
    Route::get('/choose-us/show/{id}', [App\Http\Controllers\WebsiteHome\ChooseUsController::class, 'show'])->name('website.home.chooseus.show');
    Route::get('/choose-us/edit/{id}', [App\Http\Controllers\WebsiteHome\ChooseUsController::class, 'edit'])->name('website.home.chooseus.edit');
    Route::post('/choose-us/update/{id}', [App\Http\Controllers\WebsiteHome\ChooseUsController::class, 'update'])->name('website.home.chooseus.update');
    Route::delete('/choose-us/destroy/{id}', [App\Http\Controllers\WebsiteHome\ChooseUsController::class, 'destroy'])->name('website.home.chooseus.destroy');

    Route::get('/affiliation', [App\Http\Controllers\WebsiteHome\AffiliationController::class, 'index'])->name('website.home.affiliation');
    Route::get('/affiliation/create', [App\Http\Controllers\WebsiteHome\AffiliationController::class, 'create'])->name('website.home.affiliation.create');
    Route::post('/affiliation/header/store', [App\Http\Controllers\WebsiteHome\AffiliationController::class, 'storeHeader'])->name('website.home.affiliation.header.store');
    Route::post('/affiliation/store', [App\Http\Controllers\WebsiteHome\AffiliationController::class, 'store'])->name('website.home.affiliation.store');
    Route::get('/affiliation/edit/{id}', [App\Http\Controllers\WebsiteHome\AffiliationController::class, 'edit'])->name('website.home.affiliation.edit');
    Route::post('/affiliation/update/{id}', [App\Http\Controllers\WebsiteHome\AffiliationController::class, 'update'])->name('website.home.affiliation.update');
    Route::delete('/affiliation/destroy/{id}', [App\Http\Controllers\WebsiteHome\AffiliationController::class, 'destroy'])->name('website.home.affiliation.destroy');

    Route::get('/portfolio', [App\Http\Controllers\WebsiteHome\PortfolioController::class, 'index'])->name('website.home.portfolio');
    Route::get('/portfolio/create', [App\Http\Controllers\WebsiteHome\PortfolioController::class, 'create'])->name('website.home.portfolio.create');
    Route::post('/portfolio/header/store', [App\Http\Controllers\WebsiteHome\PortfolioController::class, 'storeHeader'])->name('website.home.portfolio.header.store');
    Route::post('/portfolio/store', [App\Http\Controllers\WebsiteHome\PortfolioController::class, 'store'])->name('website.home.portfolio.store');
    Route::get('/portfolio/show/{id}', [App\Http\Controllers\WebsiteHome\PortfolioController::class, 'show'])->name('website.home.portfolio.show');
    Route::get('/portfolio/edit/{id}', [App\Http\Controllers\WebsiteHome\PortfolioController::class, 'edit'])->name('website.home.portfolio.edit');
    Route::post('/portfolio/update/{id}', [App\Http\Controllers\WebsiteHome\PortfolioController::class, 'update'])->name('website.home.portfolio.update');
    Route::delete('/portfolio/destroy/{id}', [App\Http\Controllers\WebsiteHome\PortfolioController::class, 'destroy'])->name('website.home.portfolio.destroy');

    Route::get('/dumy-review', [App\Http\Controllers\WebsiteHome\DummyReviewController::class, 'index'])->name('website.home.review');
    Route::get('/dumy-review/create', [App\Http\Controllers\WebsiteHome\DummyReviewController::class, 'create'])->name('website.home.review.create');
    Route::post('/dumy-review/header/store', [App\Http\Controllers\WebsiteHome\DummyReviewController::class, 'storeHeader'])->name('website.home.review.header.store');
    Route::post('/dumy-review/store', [App\Http\Controllers\WebsiteHome\DummyReviewController::class, 'store'])->name('website.home.review.store');
    Route::get('/dumy-review/show/{id}', [App\Http\Controllers\WebsiteHome\DummyReviewController::class, 'show'])->name('website.home.review.show');
    Route::get('/dumy-review/edit/{id}', [App\Http\Controllers\WebsiteHome\DummyReviewController::class, 'edit'])->name('website.home.review.edit');
    Route::post('/dumy-review/update/{id}', [App\Http\Controllers\WebsiteHome\DummyReviewController::class, 'update'])->name('website.home.review.update');
    Route::delete('/dumy-review/destroy/{id}', [App\Http\Controllers\WebsiteHome\DummyReviewController::class, 'destroy'])->name('website.home.review.destroy');
});
Route::group(['prefix' => 'website-about'], function () {

    Route::get('/', [App\Http\Controllers\WebsiteHome\HomeController::class, 'about'])->name('website.about.index');

    Route::get('/about-slider', [App\Http\Controllers\WebsiteAbout\AboutSliderController::class, 'index'])->name('website.about.slider');
    Route::get('/about-slider/create', [App\Http\Controllers\WebsiteAbout\AboutSliderController::class, 'create'])->name('website.about.slider.create');
    Route::post('/about-slider/store', [App\Http\Controllers\WebsiteAbout\AboutSliderController::class, 'store'])->name('website.about.slider.store');
    Route::get('/about-slider/show/{id}', [App\Http\Controllers\WebsiteAbout\AboutSliderController::class, 'show'])->name('website.about.slider.show');
    Route::get('/about-slider/edit/{id}', [App\Http\Controllers\WebsiteAbout\AboutSliderController::class, 'edit'])->name('website.about.slider.edit');
    Route::post('/about-slider/update/{id}', [App\Http\Controllers\WebsiteAbout\AboutSliderController::class, 'update'])->name('website.about.slider.update');
    Route::delete('/about-slider/destroy/{id}', [App\Http\Controllers\WebsiteAbout\AboutSliderController::class, 'destroy'])->name('website.about.slider.destroy');


    Route::get('/information', [App\Http\Controllers\WebsiteAbout\InformationController::class, 'index'])->name('website.about.information');
    Route::post('/information/store', [App\Http\Controllers\WebsiteAbout\InformationController::class, 'store'])->name('website.about.information.store');


    Route::get('/member', [App\Http\Controllers\WebsiteAbout\MemberController::class, 'index'])->name('website.about.member');
    Route::get('/member/create', [App\Http\Controllers\WebsiteAbout\MemberController::class, 'create'])->name('website.about.member.create');
    Route::post('/member/header/store', [App\Http\Controllers\WebsiteAbout\MemberController::class, 'storeHeader'])->name('website.about.member.header.store');
    Route::post('/member/store', [App\Http\Controllers\WebsiteAbout\MemberController::class, 'store'])->name('website.about.member.store');
    Route::get('/member/edit/{id}', [App\Http\Controllers\WebsiteAbout\MemberController::class, 'edit'])->name('website.about.member.edit');
    Route::post('/member/update/{id}', [App\Http\Controllers\WebsiteAbout\MemberController::class, 'update'])->name('website.about.member.update');
    Route::delete('/member/destroy/{id}', [App\Http\Controllers\WebsiteAbout\MemberController::class, 'destroy'])->name('website.about.member.destroy');

    Route::get('/counter', [App\Http\Controllers\WebsiteAbout\CounterController::class, 'index'])->name('website.about.counter');
    Route::get('/counter/create', [App\Http\Controllers\WebsiteAbout\CounterController::class, 'create'])->name('website.about.counter.create');
    Route::post('/counter/header/store', [App\Http\Controllers\WebsiteAbout\CounterController::class, 'storeHeader'])->name('website.about.counter.header.store');
    Route::post('/counter/store', [App\Http\Controllers\WebsiteAbout\CounterController::class, 'store'])->name('website.about.counter.store');
    Route::get('/counter/edit/{id}', [App\Http\Controllers\WebsiteAbout\CounterController::class, 'edit'])->name('website.about.counter.edit');
    Route::post('/counter/update/{id}', [App\Http\Controllers\WebsiteAbout\CounterController::class, 'update'])->name('website.about.counter.update');
    Route::delete('/counter/destroy/{id}', [App\Http\Controllers\WebsiteAbout\CounterController::class, 'destroy'])->name('website.about.counter.destroy');

    Route::get('/aboutmore', [App\Http\Controllers\WebsiteAbout\AboutController::class, 'index'])->name('website.about.aboutmore');
    Route::post('/aboutmore/store', [App\Http\Controllers\WebsiteAbout\AboutController::class, 'store'])->name('website.about.aboutmore.store');
});
Route::group(['prefix' => 'website-info'], function () {
    Route::get('/', [App\Http\Controllers\MetaInfoController::class, 'homepage'])->name('website.info.home');
    Route::get('/service', [App\Http\Controllers\MetaInfoController::class, 'service'])->name('website.info.service');
    Route::get('/product', [App\Http\Controllers\MetaInfoController::class, 'product'])->name('website.info.product');
    Route::get('/portfolio', [App\Http\Controllers\MetaInfoController::class, 'portfolio'])->name('website.info.portfolio');
    Route::get('/booking', [App\Http\Controllers\MetaInfoController::class, 'booking'])->name('website.info.booking');
    Route::get('/blog', [App\Http\Controllers\MetaInfoController::class, 'blog'])->name('website.info.blog');
    Route::get('/gallery', [App\Http\Controllers\MetaInfoController::class, 'gallery'])->name('website.info.gallery');
    Route::get('/contact', [App\Http\Controllers\MetaInfoController::class, 'contact'])->name('website.info.contact');
    Route::get('/login', [App\Http\Controllers\MetaInfoController::class, 'login'])->name('website.info.login');
    Route::get('/register', [App\Http\Controllers\MetaInfoController::class, 'register'])->name('website.info.register');
    Route::post('/store/{type}', [App\Http\Controllers\MetaInfoController::class, 'store'])->name('website.info.store');
});
