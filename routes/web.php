<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaServiceController;

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

Route::get('/', function () {

   return view('welcome');
});

Route::get('/','IndexController@index');

Route::match(['get', 'post'], '/admin','AdminController@login');

Route::get('/admin-register','AdminController@adminRegister');

// Users Register Form Submit
Route::post('/admin-register','AdminController@register');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Category/Listing Page
Route::get('/products/{url}','ProductsController@products');

// Product Detail Page
//Route::get('/product/{id}','ProductsController@product');
Route::get('/product/{slug}','ProductsController@product')->name('products.detail');


// Cart Page
Route::match(['get', 'post'],'/cart','ProductsController@cart');
Route::get('/getrate/{country}','ProductsController@getrate');

// Add to Cart Route
Route::match(['get', 'post'], '/add-cart', 'ProductsController@addtocart');

// Delete Product from Cart Route
Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct');

// Update Product Quantity from Cart
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity');

// Get Product Attribute Price
Route::any('/get-product-price','ProductsController@getProductPrice');

// Apply Coupon
Route::post('/cart/apply-coupon','ProductsController@applyCoupon');

// Users Login/Register Page
Route::get('/login-register','UsersController@userLoginRegister');

// Users Register Form Submit
Route::post('/user-register','UsersController@register');

Route::post('captcha-validation', 'UsersController@capthcaFormValidate');
Route::get('reload-captcha', 'UsersController@reloadCaptcha');


// Forgot Password
Route::match(['get', 'post'],'/forgot-password','UsersController@forgotPassword');

// Confirm Account
Route::get('confirm/{code}','UsersController@confirmAccount');

// Users Login Form Submit
Route::post('user-login','UsersController@login');

// Users logout
Route::get('/user-logout','UsersController@logout');

// Search Products
Route::post('/search-products','ProductsController@searchProducts');


Route::get('/about', 'FrontController@about')->name('about');
Route::get('/promotion', 'FrontController@promotion')->name('promotion');
Route::get('/software-app-development', 'FrontController@webdev')->name('webdev');
Route::get('/hosting-internet', 'FrontController@hosting')->name('hosting');
Route::get('/manuscript-submissions', 'FrontController@submission')->name('submission');

Route::get('newsletter','NewsletterController@create');
Route::post('newsletter','NewsletterController@store');

// Display Contact Page
Route::match(['get','post'],'contact','IndexController@contact');

Route::get('/contact', 'FrontController@getContact')->name('contact');
Route::post('/contact', 'FrontController@postContact')->name('contact');
Route::get('/blog', 'BlogController@blog')->name('blog');


Route::get('/services', 'FrontController@services')->name('services');
Route::get('/author', 'FrontController@author')->name('author');
Route::get('/writer', 'FrontController@writer')->name('writer');
Route::get('/support', 'FrontController@support')->name('support');


Route::get('/terms-and-conditions', 'IndexController@terms')->name('terms.and.conditions');
Route::get('/privacy-policy', 'IndexController@privacy')->name('privacy.policy');
Route::get('/shipping-policy', 'IndexController@shipping')->name('shipping.policy');
Route::get('cancellation-refund','IndexController@cancellation')->name('cancellation');

// Reviews
Route::post('reviews/{product_id}', ['uses' => 'ReviewsController@store', 'as' => 'reviews.store']);
Route::get('reviews/{id}/edit', ['uses' => 'ReviewsController@edit', 'as' => 'reviews.edit']);
Route::put('reviews/{id}', ['uses' => 'reviewsController@update', 'as' => 'reviews.update']);
Route::delete('reviews/{id}', ['uses' => 'ReviewsController@destroy', 'as' => 'reviews.destroy']);
Route::get('reviews/{id}/delete', ['uses' => 'ReviewsController@delete', 'as' => 'reviews.delete']);

// Comments
Route::post('comments/{post_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
Route::put('comments/{id}', ['uses' => 'CommentsController@update', 'as' => 'comments.update']);
Route::delete('comments/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
Route::get('comments/{id}/delete', ['uses' => 'CommentsController@delete', 'as' => 'comments.delete']);


Route::get('/books', 'BookController@books')->name('books');

Route::get('books/{slug}', ['as' => 'books.single', 'uses' => 'BookController@product'])->where('slug', '[\w\d\-\_]+');

//ebook
Route::get('/ebooks', 'EbookController@ebook')->name('ebook');


Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])->where('slug', '[\w\d\-\_]+');

Route::get('/blog', 'BlogController@blog')->name('blog');

Route::get('questions/{slug}', ['as' => 'questions.show', 'uses' => 'QuestionController@show'])->where('slug', '[\w\d\-\_]+');

Route::get('/questions', 'QuestionController@index')->name('questions.index');


Route::get('post/{id}','PostController@getPost')->name('posts.show');
Route::get('/posts/cats/{cat}','CategoryPostsController@index');

// Check Subscriber Email
Route::post('/check-subscriber-email','NewsletterController@checkSubscriber');

// Add Subscriber Email
Route::post('/add-subscriber-email','NewsletterController@addSubscriber');

//EBook download link
Route::get('product/ebook/{token}',array(
    'uses'=>'ProductsController@download',
    'as'=>'product.download_ebook',
));
// All Routes after Login
Route::group(['middleware'=>['frontlogin']],function(){
    // Users Account Page
    Route::match(['get','post'],'account','UsersController@account');
    // Check User Current Password
    Route::post('/check-user-pwd','UsersController@chkUserPassword');
    // Update User Password
    Route::post('/update-user-pwd','UsersController@updatePassword');
    // Checkout Page
    Route::match(['get','post'],'checkout','ProductsController@checkout');
    // Order Review Page
    Route::match(['get','post'],'/order-review','ProductsController@orderReview');
    // Place Order
    Route::match(['get','post'],'/place-order','ProductsController@placeOrder');
    // Thanks Page
    Route::get('/thanks','ProductsController@thanks');
    // Paypal Page
    Route::get('/payfast','ProductsController@payfast');
    // Users Orders Page
    Route::get('/orders','ProductsController@userOrders');
    // User Ordered Products Page
    Route::get('/orders/{id}','ProductsController@userOrderDetails');
    // Paypal Thanks Page
    Route::get('/payfast/thanks','ProductsController@thanksPaypal');
    // Paypal Cancel Page
    Route::get('/cancel','ProductsController@cancelPaypal');
    Route::post('/itn','ProductsController@itn');


});


// Check if User already exists
Route::match(['GET','POST'],'/check-email','UsersController@checkEmail');

Route::group(['middleware' => ['adminlogin']], function () {
    Route::get('/admin/dashboard','AdminController@dashboard');
    Route::get('/admin/settings','AdminController@settings');
    Route::get('/admin/check-pwd','AdminController@chkPassword');
    Route::match(['get', 'post'],'/admin/update-pwd','AdminController@updatePassword');

    // Admin Categories Routes
    Route::match(['get', 'post'], '/admin/add-category','CategoryController@addCategory');
    Route::match(['get', 'post'], '/admin/edit-category/{id}','CategoryController@editCategory');
    Route::match(['get', 'post'], '/admin/delete-category/{id}','CategoryController@deleteCategory');
    Route::get('/admin/view-categories','CategoryController@viewCategories');

    

    // Admin Products Routes
    Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');
    Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
    Route::get('/admin/delete-product/{id}','ProductsController@deleteProduct');
    Route::get('/admin/view-products','ProductsController@viewProducts');
    Route::get('/admin/export-products','ProductsController@exportProducts');
    Route::get('/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
    Route::get('/admin/product/approve/{id}','ProductsController@approveProduct');
    Route::get('/admin/product/disapprove/{id}','ProductsController@disapproveProduct');
    Route::match(['get', 'post'], '/admin/add-images/{id}','ProductsController@addImages');
    Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteProductAltImage');

    // Admin Attributes Routes
    Route::match(['get', 'post'], '/admin/add-attributes/{id}','ProductsController@addAttributes');
    Route::match(['get', 'post'], '/admin/edit-attributes/{id}','ProductsController@editAttributes');
    Route::get('/admin/delete-attribute/{id}','ProductsController@deleteAttribute');

    // Admin Coupon Routes
    Route::match(['get','post'],'/admin/add-coupon','CouponsController@addCoupon');
    Route::match(['get','post'],'/admin/edit-coupon/{id}','CouponsController@editCoupon');
    Route::get('/admin/view-coupons','CouponsController@viewCoupons');
    Route::get('/admin/delete-coupon/{id}','CouponsController@deleteCoupon');

    // Admin Banners Routes
    Route::match(['get','post'],'/admin/add-banner','BannersController@addBanner');
    Route::match(['get','post'],'/admin/edit-banner/{id}','BannersController@editBanner');
    Route::get('admin/view-banners','BannersController@viewBanners');
    Route::get('/admin/delete-banner/{id}','BannersController@deleteBanner');


 // Admin Posters Routes
    Route::match(['get','post'],'/admin/add-poster','PostersController@addPoster');
    Route::match(['get','post'],'/admin/edit-poster/{id}','PostersController@editPoster');
    Route::get('admin/view-poster','PostersController@viewPosters');
    Route::get('/admin/delete-poster/{id}','PostersController@deletePoster');

    // Admin Orders Routes
    Route::get('/admin/view-orders','ProductsController@viewOrders');

        // Manual Orders (Admin) — ProductsController
    Route::match(['get','post'], '/admin/add-manual-order', 'ProductsController@addManualOrder');
    Route::match(['get','post'], '/admin/edit-manual-order/{id}', 'ProductsController@editManualOrder');
    Route::get('/admin/delete-manual-order/{id}', 'ProductsController@deleteManualOrder');



    // Admin Orders Charts Route
    Route::get('/admin/view-orders-charts','ProductsController@viewOrdersCharts');

    // Admin Order Details Route
    Route::get('/admin/view-order/{id}','ProductsController@viewOrderDetails');

    // Order Invoice
    Route::get('/admin/view-order-invoice/{id}','ProductsController@viewOrderInvoice');

    // PDF Invoice
    Route::get('/admin/view-pdf-invoice/{id}','ProductsController@viewPDFInvoice');

    // Update Order Status
    Route::post('/admin/update-order-status','ProductsController@updateOrderStatus');

    //ebook link
    Route::get('/admin/generate_ebook_link/{id}','ProductsController@SendEbookLink');


    // Admin Users Route
    // Allow GET form + POST submit (already added earlier, keep them)
    Route::match(['get','post'], '/admin/add-users', 'UsersController@addUser');
    Route::match(['get','post'], '/admin/edit-user/{id}', 'UsersController@editUser');

    // NEW: bulk hard delete
    Route::post('/admin/users/bulk-delete', 'UsersController@bulkDeleteUsers');

    Route::get('/admin/view-users','UsersController@viewUsers');
    Route::get('/admin/delete-user/{id}','UsersController@deleteUser');
    


    // Admin Users Charts Route
    Route::get('/admin/view-users-charts','UsersController@viewUsersCharts');

    // Admin Users Countries Charts Route
    Route::get('/admin/view-users-countries-charts','UsersController@viewUsersCountriesCharts');

    // Export Users Route
    Route::get('/admin/export-users','UsersController@exportUsers');

    // Admin/SubAdmin Route
   Route::get('/admin/view-admins','AdminController@viewAdmins');
   Route::match(['get','post'],'/admin/add-admin','AdminController@addAdmin');
   Route::match(['get', 'post'], '/admin/edit-admin/{id}','AdminController@editAdmin');
   Route::match(['get', 'post'], '/admin/delete-admin/{id}','AdminController@deleteAdmin');

   //posts
   Route::resource('posts', 'PostController');
   Route::get('/admin/posts/approve/{id}',['uses' => 'PostController@approve','as' => 'admin.posts.approve']);
   Route::get('/admin/posts/disapprove/{id}',['uses' => 'PostController@disapprove','as' => 'admin.posts.disapprove']);

    //Product Category which is Cat
   Route::resource('cats', CatController::class);
    Route::post('/admin/cats/bulk-delete', 'CatController@bulkDeleteCats');


    // TAGS
    //Product Tags which is Cat
    Route::resource('tags', TagController::class);
 
    Route::post('/admin/tags/bulk-delete', 'TagController@bulkDeleteTags');

    Route::get('/admin/view-tags', 'TagController@viewTags');
    Route::get('/admin/delete-tag/{id}', 'TagController@deleteTag');


    // Admin CMS Pages
    Route::match(['get','post'],'/admin/add-cms-page','CmsController@addCmsPage');
    Route::match(['get','post'],'/admin/edit-cms-page/{id}','CmsController@editCmsPage');
    Route::get('admin/view-cms-pages','CmsController@viewCmsPages');
    Route::get('/admin/delete-cms-page/{id}','CmsController@deleteCmsPage');


    // Admin Shipping Details
    Route::get('/admin/view-shipping', 'ShippingController@viewShipping');
    Route::match(['get','post'],'/admin/edit-shipping/{id}','ShippingController@editShipping');

     // Get Enquiries
    Route::get('/admin/get-enquiries','CmsController@getEnquiries');

    // View Enquiries
    Route::get('/admin/view-enquiries','CmsController@viewEnquiries');

    // Currencies Routes
    // Add Currency Route
    Route::match(['get','post'],'/admin/add-currency','CurrencyController@addCurrency');

    // Edit Currency Route
    Route::match(['get','post'],'/admin/edit-currency/{id}','CurrencyController@editCurrency');

    // Delete Currency Route
    Route::get('/admin/delete-currency/{id}','CurrencyController@deleteCurrency');

    // View Currencies Route
    Route::get('/admin/view-currencies','CurrencyController@viewCurrencies');

    // View Newsletter Subscribers
    Route::get('admin/view-newsletter-subscribers','NewsletterController@viewNewsletterSubscribers');

    // Update Newsletter Status
    Route::get('admin/update-newsletter-status/{id}/{status}','NewsletterController@updateNewsletterStatus');

    // Delete Newsletter Email
    Route::get('admin/delete-newsletter-email/{id}','NewsletterController@deleteNewsletterEmail');

    // Export Newsletter Emails
    Route::get('/admin/export-newsletter-emails','NewsletterController@exportNewsletterEmails');


});


Route::get('/logout','AdminController@logout');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::match(['get','post'],'/page/contact','CmsController@contact');
// Display CMS Page
Route::match(['get','post'],'/page/{url}','CmsController@cmsPage');

/*******************
 *
 * Author routes here
 *
 */


Route::get('/test', function () {

});

Route::group(['prefix' => 'author','as' => 'author.'],function () {

   /*Route::get('', function () {
        return view('welcome');
    });*/
    Route::get('dashboard/', [
        'uses' => 'Author\DashboardController@index',
        'as' => 'dashboard'
    ]);

    //Manuscript
    Route::resource('manuscripts', 'Author\ManuscriptController')->only([
        'index', 'create','store','show'
    ]);

    //Subscription
    Route::get('subscriptions/browse',array(
        'uses'=>'Author\SubscriptionController@browse',
        'as'=>'subscriptions.browse',
    ));
    Route::get('subscriptions',array(
        'uses'=>'Author\SubscriptionController@index',
        'as'=>'subscriptions.index',
    ));
    Route::get('subscriptions/billing',array(
        'uses'=>'Author\SubscriptionController@billing',
        'as'=>'subscriptions.billing',
    ));

    Route::post('subscriptions/itn',array(
        'uses'=>'Author\SubscriptionController@itn',
        'as'=>'subscriptions.itn',
    ));

    Route::get('subscriptions/success',array(
        'uses'=>'Author\SubscriptionController@success',
        'as'=>'subscriptions.success',
    ));

    Route::get('subscriptions/cancel',array(
        'uses'=>'Author\SubscriptionController@cancel',
        'as'=>'subscriptions.cancel',
    ));

    Route::post('subscriptions',array(
        'uses'=>'Author\SubscriptionController@store',
        'as'=>'subscriptions.store',
    ));



    //Order
    Route::get('orders/{id}',array(
        'uses'=>'Author\OrderController@show',
        'as'=>'orders.show',
    ));

    Route::get('orders',array(
        'uses'=>'Author\OrderController@index',
        'as'=>'orders.index',
    ));

    //Profile
    Route::get('edit-profile',array(
        'uses'=>'Author\AuthorController@editProfile',
        'as'=>'edit-profile',
    ));

    Route::get('profile/{slug}',array(
        'uses'=>'Author\AuthorController@showPublicProfile',
        'as'=>'public-profile',
    ));

    Route::get('filter',array(
        'uses'=>'Author\AuthorController@filter',
        'as'=>'filter',
    ));


    Route::post('update-profile',array(
        'uses'=>'Author\AuthorController@updateProfile',
        'as'=>'update-profile',
    ));

    Route::post('update-profile-image',array(
        'uses'=>'Author\AuthorController@updateProfileImage',
        'as'=>'update-profile-image',
    ));

    Route::post('update-password',array(
        'uses'=>'Author\AuthorController@updatePassword',
        'as'=>'update-password',
    ));


    //Manuscript Payment
    Route::post('manuscript/payments',array(
        'uses'=>'Author\ManuscriptPaymentController@store',
        'as'=>'manuscript.payments.store',
    ));
    Route::get('manuscript/payments/{id}',array(
        'uses'=>'Author\ManuscriptPaymentController@show',
        'as'=>'manuscript.payments.show',
    ));

    Route::post('manuscript/itn',array(
        'uses'=>'Author\ManuscriptPaymentController@itn',
        'as'=>'manuscript.payments.itn',
    ));

    Route::get('manuscript/success',array(
        'uses'=>'Author\ManuscriptPaymentController@success',
        'as'=>'manuscript.payments.success',
    ));

    Route::get('manuscript/cancel',array(
        'uses'=>'Author\ManuscriptPaymentController@cancel',
        'as'=>'manuscript.payments.cancel',
    ));

    //Questions
    Route::resource('questions', 'Author\QuestionController')->only([
        'create','store'
    ]);

    //Blogs
    Route::resource('blogs', 'Author\BlogController')->only([
        'create','store',
    ]);

    //Product
    Route::resource('products', 'Author\ProductController')->only([
        'index', 'create','store','show','update','edit'
    ]);
    Route::put('products/image/update/{id}',array(
        'uses'=>'Author\ProductController@updateImage',
        'as'=>'products.image.update',
    ));
    Route::put('products/ebook/update/{id}',array(
        'uses'=>'Author\ProductController@updateEbook',
        'as'=>'products.ebook.update',
    ));
    Route::put('products/attribute/update/{id}',array(
        'uses'=>'Author\ProductController@updateAttribute',
        'as'=>'products.attribute.update',
    ));
    Route::delete('products/attribute/delete/{id}',array(
        'uses'=>'Author\ProductController@deleteAttribute',
        'as'=>'products.attribute.delete',
    ));

    //Author Product Orders
    Route::get('product/orders/{id}',array(
        'uses'=>'Author\ProductOrderController@show',
        'as'=>'product.orders.show',
    ));

    Route::get('product/orders/all/{product_id}',array(
        'uses'=>'Author\ProductOrderController@index',
        'as'=>'product.orders.index',
    ));

    //generate link for author
    Route::get('generate_ebook_link/{id}','Author\ProductOrderController@SendEbookLink');


    // Author Product Orders
    Route::get('product/orders/{id}', [
        'uses' => 'Author\ProductOrderController@show',
        'as'   => 'product.orders.show',
    ]);

    Route::get('product/orders/all/{product_id}', [
        'uses' => 'Author\ProductOrderController@index',
        'as'   => 'product.orders.index',
    ]);

    // generate link for author (legacy)
    Route::get('generate_ebook_link/{id}', 'Author\ProductOrderController@SendEbookLink');

    // Author Sales (read-only summary)
    Route::get('sales', [
        'uses' => 'Author\AuthorSalesController@index',
        'as'   => 'sales.index',
    ]);
    // Author Sales Exports
    Route::get('sales/export/csv', [
        'uses' => 'Author\AuthorSalesController@exportCsv',
        'as'   => 'sales.csv',
    ]);
    Route::get('sales/export/pdf', [
        'uses' => 'Author\AuthorSalesController@exportPdf',
        'as'   => 'sales.pdf',
    ]);

    
    // Author Payouts
    Route::get('payouts', [
        'uses' => 'Author\PayoutController@index',
        'as'   => 'payouts.index',
    ]);
    Route::get('payouts/{id}', [
        'uses' => 'Author\PayoutController@show',
        'as'   => 'payouts.show',
    ]);


    // Sales & Royalties (view)
    Route::get('/reports/sales', [\App\Http\Controllers\Author\SalesController::class, 'index'])
        ->name('sales.index');

    // Exports
    Route::get('/reports/sales.csv', [\App\Http\Controllers\Author\SalesController::class, 'csv'])
        ->name('sales.csv');

    Route::get('/reports/sales.pdf', [\App\Http\Controllers\Author\SalesController::class, 'pdf'])
        ->name('sales.pdf');

});

/*******************
 *
 * Backend routes here
 *
 */


Route::group(['prefix' => 'admin','as' => 'admin.'],function () {

    //Manuscript
    Route::resource('manuscripts', 'Backend\ManuscriptController')->only([
        'index', 'edit','update','destroy','show'
    ]);;

    //subscriptions
    Route::get('subscriptions',array(
        'uses'=>'Backend\SubscriptionController@index',
        'as'=>'subscriptions.index',
    ));
    Route::get('subscriptions/create',array(
        'uses'=>'Backend\SubscriptionController@create',
        'as'=>'subscriptions.create',
    ));

    Route::get('subscriptions/edit/{id}',array(
        'uses'=>'Backend\SubscriptionController@edit',
        'as'=>'subscriptions.edit',
    ));

    Route::post('subscriptions',array(
        'uses'=>'Backend\SubscriptionController@store',
        'as'=>'subscriptions.store',
    ));

    Route::put('subscriptions/{id}',array(
        'uses'=>'Backend\SubscriptionController@update',
        'as'=>'subscriptions.update',
    ));

    Route::post('update-subscription-file',array(
        'uses'=>'Backend\SubscriptionController@updateSubscriptionFile',
        'as'=>'admin.shop.update-subscription-file',
    ));

    Route::delete('subscriptions/{id}',array(
        'uses'=>'Backend\SubscriptionController@destroy',
        'as'=>'subscriptions.destroy',
    ));

    //subscription benefits
    Route::get('subscription/benefits',array(
        'uses'=>'Backend\BenefitController@index',
        'as'=>'subscription.benefits.index',
    ));
    Route::get('subscription/benefits/create',array(
        'uses'=>'Backend\BenefitController@create',
        'as'=>'subscription.benefits.create',
    ));

    Route::get('subscription/benefits/{id}',array(
        'uses'=>'Backend\BenefitController@edit',
        'as'=>'subscription.benefits.edit',
    ));

    Route::post('subscription/benefits',array(
        'uses'=>'Backend\BenefitController@store',
        'as'=>'subscription.benefits.store',
    ));

    Route::put('subscription/benefits/{id}',array(
        'uses'=>'Backend\BenefitController@update',
        'as'=>'subscription.benefits.update',
    ));


    Route::delete('subscription/benefits/{id}',array(
        'uses'=>'Backend\BenefitController@destroy',
        'as'=>'subscription.benefits.destroy',
    ));



    //Works for website
    Route::get('works',array(
        'uses'=>'WorkController@index',
        'as'=>'work.index',
    ));
    Route::get('works/create',array(
        'uses'=>'WorkController@create',
        'as'=>'works.create',
    ));

    Route::get('works/{id}',array(
        'uses'=>'WorkController@edit',
        'as'=>'works.edit',
    ));

    Route::post('works',array(
        'uses'=>'WorkController@store',
        'as'=>'works.store',
    ));

    Route::put('works/{id}',array(
        'uses'=>'WorkController@update',
        'as'=>'works.update',
    ));


    Route::delete('works/{id}',array(
        'uses'=>'WorkController@destroy',
        'as'=>'works.destroy',
    ));



    //Hosting
    Route::get('websites',array(
        'uses'=>'WebsiteController@index',
        'as'=>'websites.index',
    ));
    Route::get('websites/create',array(
        'uses'=>'WebsiteController@create',
        'as'=>'websites.create',
    ));

    Route::get('websites/edit/{id}',array(
        'uses'=>'WebsiteController@edit',
        'as'=>'websites.edit',
    ));

    Route::post('websites',array(
        'uses'=>'WebsiteController@store',
        'as'=>'websites.store',
    ));

    Route::put('websites/{id}',array(
        'uses'=>'WebsiteController@update',
        'as'=>'websites.update',
    ));

    Route::post('update-subscription-file',array(
        'uses'=>'WebsiteController@updateHostFile',
        'as'=>'admin.shop.update-subscription-file',
    ));

    Route::delete('websites/{id}',array(
        'uses'=>'WebsiteController@destroy',
        'as'=>'websites.destroy',
    ));


    Route::delete('websites/{id}',array(
        'uses'=>'WebsiteController@destroy',
        'as'=>'websites.destroy',
    ));


    //Functions/Capacity For Hosting
    Route::get('capacities',array(
        'uses'=>'CapacityController@index',
        'as'=>'capacity.index',
    ));
    Route::get('capacities/create',array(
        'uses'=>'CapacityController@create',
        'as'=>'capacities.create',
    ));

    Route::get('capacities/{id}',array(
        'uses'=>'CapacityController@edit',
        'as'=>'capacities.edit',
    ));

    Route::post('capacities',array(
        'uses'=>'CapacityController@store',
        'as'=>'capacities.store',
    ));

    Route::put('capacities/{id}',array(
        'uses'=>'CapacityController@update',
        'as'=>'capacities.update',
    ));


    Route::delete('capacities/{id}',array(
        'uses'=>'CapacityController@destroy',
        'as'=>'capacities.destroy',
    ));


    //Hosting
    Route::get('hosts',array(
        'uses'=>'HostController@index',
        'as'=>'hosts.index',
    ));
    Route::get('hosts/create',array(
        'uses'=>'HostController@create',
        'as'=>'hosts.create',
    ));

    Route::get('hosts/edit/{id}',array(
        'uses'=>'HostController@edit',
        'as'=>'hosts.edit',
    ));

    Route::post('hosts',array(
        'uses'=>'HostController@store',
        'as'=>'hosts.store',
    ));

    Route::put('hosts/{id}',array(
        'uses'=>'HostController@update',
        'as'=>'hosts.update',
    ));

    Route::post('update-subscription-file',array(
        'uses'=>'HostController@updateHostFile',
        'as'=>'admin.shop.update-subscription-file',
    ));

    Route::delete('hosts/{id}',array(
        'uses'=>'HostController@destroy',
        'as'=>'hosts.destroy',
    ));

    //Orders
    Route::get('manuscript/orders',array(
        'uses'=>'Backend\ManuscriptOrderController@index',
        'as'=>'manuscript.orders.index',
    ));


    Route::get('manuscript/orders/{id}',array(
        'uses'=>'Backend\ManuscriptOrderController@show',
        'as'=>'manuscript.orders.show',
    ));


    Route::delete('manuscript/orders/{id}',array(
        'uses'=>'Backend\ManuscriptOrderController@destroy',
        'as'=>'manuscript.orders.destroy',
    ));

    //authors subscription
    Route::get('subscription/authors',array(
        'uses'=>'Backend\ActiveSubscriptionController@index',
        'as'=>'subscription.authors.index',
    ));

    Route::delete('subscription/authors/cancel',array(
        'uses'=>'Backend\ActiveSubscriptionController@destroy',
        'as'=>'subscription.authors.destroy',
    ));

});





