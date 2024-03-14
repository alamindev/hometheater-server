<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/auth', ['middleware' => 'throttle:20,5', 'cors']], function () {
    Route::post('/registers',  [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
    Route::get('/check-fields/{user_id}',  [App\Http\Controllers\Api\Auth\RegisterController::class, 'checkFields']);
    Route::post('/login',  [App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
    Route::post('/forgot-password',  [App\Http\Controllers\Api\Auth\ForgotController::class, 'forgotPass']);
    Route::post('/verify',  [App\Http\Controllers\Api\Auth\ForgotController::class, 'verify']);
    Route::post('/change-password',  [App\Http\Controllers\Api\Auth\ForgotController::class, 'changePassword']);

    Route::get('/login/{service}', [App\Http\Controllers\Api\Auth\SocialLoginController::class, 'redirect']);
    Route::get('/login/{service}/callback', [App\Http\Controllers\Api\Auth\SocialLoginController::class, 'callback']);
});

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/me',  [App\Http\Controllers\Api\MeController::class, 'index']);
    Route::get('/auth/logout',  [App\Http\Controllers\Api\MeController::class, 'logout']);
    Route::get('/users/{id}/setting',  [App\Http\Controllers\Api\UserController::class, 'profile']);
    Route::post('/users/{id}/update',  [App\Http\Controllers\Api\UserController::class, 'update']);
    Route::get('/user/required-info/{user_id}',  [App\Http\Controllers\Api\UserController::class, 'getRequirdInfo']);
    Route::post('/user/required-fields/update',  [App\Http\Controllers\Api\UserController::class, 'RequirdInfoUpdate']);
    Route::post('/promo/match',  [App\Http\Controllers\Api\CheckoutController::class, 'MatchPromo']);
    Route::get('/calendar/attributes',  [App\Http\Controllers\Api\CheckoutController::class, 'CalendarAttr']);
    Route::post('/calendar/time',  [App\Http\Controllers\Api\CheckoutController::class, 'CalendarTime']);
    Route::post('/order/store',  [App\Http\Controllers\Api\OrderController::class, 'finishedCheckout']);
    Route::post('/order/payment-intents',  [App\Http\Controllers\Api\OrderController::class, 'StripePaymentIntents']);

    Route::get('/cart/payment-intents',  [App\Http\Controllers\Api\OrderController::class, 'GetStripeToken']);
    Route::get('/users/dashboard/{id}',  [App\Http\Controllers\Api\DashboardController::class, 'FetchDatas']); 
    Route::get('/users/recent-orders/{id}',  [App\Http\Controllers\Api\DashboardController::class, 'RecentOrders']); 
    Route::get('/bookings/{id}',  [App\Http\Controllers\Api\BookingController::class, 'Bookings']);
    Route::get('/products/{id}',  [App\Http\Controllers\Api\BookingController::class, 'Products']);

    Route::get('/booking/{id}/edit',  [App\Http\Controllers\Api\BookingController::class, 'EditBooking']);
    Route::post('/booking/update',  [App\Http\Controllers\Api\BookingController::class, 'UpdateBooking']);
    Route::get('/booking/{id}/details',  [App\Http\Controllers\Api\BookingController::class, 'BookingDetails']);
    Route::post('/booking/canceled',  [App\Http\Controllers\Api\BookingController::class, 'Canceled']);
    Route::post('/booking/delete',  [App\Http\Controllers\Api\BookingController::class, 'delete']);
    Route::get('/booking/{id}/orderservice',  [App\Http\Controllers\Api\ReviewController::class, 'OrderServices']);
    Route::post('/booking/rating/store',  [App\Http\Controllers\Api\ReviewController::class, 'Reviewstore']);
    Route::get('/booking/reviews/{id}',  [App\Http\Controllers\Api\ReviewController::class, 'Reviews']);
    Route::get('/booking/review/edit/{id}',  [App\Http\Controllers\Api\ReviewController::class, 'editReview']);
    Route::post('/booking/review/update',  [App\Http\Controllers\Api\ReviewController::class, 'updateReview']);
    Route::get('/booking/review/details/{id}',  [App\Http\Controllers\Api\ReviewController::class, 'detailsReview']);
    Route::get('/booking/review/delete-image/{id}',  [App\Http\Controllers\Api\ReviewController::class, 'delete_image']);
});

Route::post('/service/questions',  [App\Http\Controllers\Api\CheckoutController::class, 'ServiceQuestions']);
// public api
Route::get('/fetch/data',  [App\Http\Controllers\Api\HomeController::class, 'fetchData']);
Route::get('/portfolios',  [App\Http\Controllers\Api\PortfolioController::class, 'fetchData']);
Route::get('/portfolio/{id}/details',  [App\Http\Controllers\Api\PortfolioController::class, 'portfolioDetails']);
Route::get('/setting',  [App\Http\Controllers\Api\HomeController::class, 'FetchSetting']);

Route::get('/galleries/{slug?}',  [App\Http\Controllers\Api\GalleryController::class, 'index']);
Route::get('/albums/{slug?}',  [App\Http\Controllers\Api\GalleryController::class, 'albums']);
Route::get('/gallery/{slug}/{album_slug}',  [App\Http\Controllers\Api\GalleryController::class, 'Gallery']);
Route::post('gallery/delete',  [App\Http\Controllers\Api\GalleryController::class, 'deleteComment']);
Route::get('/categories',  [App\Http\Controllers\Api\GalleryController::class, 'Categories']);
Route::get('/filterbycategory/{slug}',  [App\Http\Controllers\Api\GalleryController::class, 'filterByCategory']);
Route::get('/sortby/{slug}/{cate_slug?}',  [App\Http\Controllers\Api\GalleryController::class, 'sortBy']);
Route::get('/suggest/{slug}',  [App\Http\Controllers\Api\GalleryController::class, 'SuggestGalleries']);
Route::post('/comment/store',  [App\Http\Controllers\Api\CommentController::class, 'store']);
Route::post('/like/store',  [App\Http\Controllers\Api\LikeController::class, 'store']);
Route::post('/share-count/store',  [App\Http\Controllers\Api\GalleryController::class, 'ShareCount']);
Route::post('/contact/store',  [App\Http\Controllers\Api\ContactController::class, 'store']);
Route::get('/user/{id}/profile',  [App\Http\Controllers\Api\ProfileController::class, 'Profile']);
Route::post('/user/delete',  [App\Http\Controllers\Api\ProfileController::class, 'Delete']);
Route::get('/post/random',  [App\Http\Controllers\Api\PostController::class, 'PostRandom']);
Route::get('/post/recent',  [App\Http\Controllers\Api\PostController::class, 'PostRecent']);
Route::get('/post/categories',  [App\Http\Controllers\Api\PostController::class, 'Categories']);
Route::get('/postbycategory/{slug}',  [App\Http\Controllers\Api\PostController::class, 'filterByCategory']);
Route::get('/posts/{slug?}',  [App\Http\Controllers\Api\PostController::class, 'Post']);
Route::post('/post/like',  [App\Http\Controllers\Api\PostController::class, 'SubmitLike']);
Route::get('/post/{slug}',  [App\Http\Controllers\Api\PostController::class, 'singlePost']);
Route::post('/post/subscribe',  [App\Http\Controllers\Api\PostController::class, 'Subscribe']);
Route::get('/service-lists',  [App\Http\Controllers\Api\ServiceController::class, 'ServiceLists']);
Route::get('/service-header',  [App\Http\Controllers\Api\ServiceController::class, 'ServiceHeader']);
Route::get('/services-home',  [App\Http\Controllers\Api\HomeController::class, 'Services']);

Route::get('/services',  [App\Http\Controllers\Api\ServiceController::class, 'Services']);
Route::get('/products',  [App\Http\Controllers\Api\ProductController::class, 'Products']);
Route::post('/check/quantity',  [App\Http\Controllers\Api\ProductController::class, 'CheckQuantity']);

Route::get('/product-details/{slug}',  [App\Http\Controllers\Api\ProductController::class, 'ProductDetails']);
Route::get('/service-details/{slug}',  [App\Http\Controllers\Api\ServiceController::class, 'ServiceDetails']);

Route::get('/review/{id}',  [App\Http\Controllers\Api\ServiceController::class, 'Review']);
Route::get('/fetch-reviews/{slug}',  [App\Http\Controllers\Api\ServiceController::class, 'FetchReviewPage']);

Route::get('fetch/about',  [App\Http\Controllers\Api\AboutController::class, 'FetchAllData']);
Route::get('page/{slug}',  [App\Http\Controllers\Api\PageController::class, 'getPageBySlug']);
Route::get('contact',  [App\Http\Controllers\Api\ContactPageController::class, 'ContactPageData']);
Route::get('activities',  [App\Http\Controllers\Api\ActivityController::class, 'Activities']);
Route::get('activity/user/{id}',  [App\Http\Controllers\Api\ActivityController::class, 'userActivities']);
Route::get('fetch-meta/{type}',  [App\Http\Controllers\Api\MetaController::class, 'Meta']);
Route::post('/check/zipcode',  [App\Http\Controllers\Api\CheckoutController::class, 'CheckZipcode']);

Route::post('crepto/createCharge',  [App\Http\Controllers\Api\CheckoutController::class, 'createCharge']);

Route::get('livesearch',  [App\Http\Controllers\Api\SearchController::class, 'LiveSearch']);
Route::get('blog/search',  [App\Http\Controllers\Api\SearchController::class, 'blogSearch']);
Route::get('service/search',  [App\Http\Controllers\Api\SearchController::class, 'serviceSearch']);
Route::post('cart/suggest',  [App\Http\Controllers\Api\CartController::class, 'index']);
Route::get('cart/taxes',  [App\Http\Controllers\Api\CartController::class, 'Taxes']);
Route::get('/cart/booking/{id}',  [App\Http\Controllers\Api\CartController::class, 'getService']);


Route::post('anything',  function () {
    return true;
});
