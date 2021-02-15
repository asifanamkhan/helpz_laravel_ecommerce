<?php

// ************************************ ADMIN SECTION **********************************************


Route::prefix('admin')->group(function() {

  //------------ ADMIN LOGIN SECTION ------------

  Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Admin\LoginController@login')->name('admin.login.submit');
  Route::get('/forgot', 'Admin\LoginController@showForgotForm')->name('admin.forgot');
  Route::post('/forgot', 'Admin\LoginController@forgot')->name('admin.forgot.submit');
  Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');

  //------------ ADMIN LOGIN SECTION ENDS ------------

  //------------ ADMIN NOTIFICATION SECTION ------------

  // User Notification
  Route::get('/user/notf/show', 'Admin\NotificationController@user_notf_show')->name('user-notf-show');
  Route::get('/user/notf/count','Admin\NotificationController@user_notf_count')->name('user-notf-count');
  Route::get('/user/notf/clear','Admin\NotificationController@user_notf_clear')->name('user-notf-clear');
  // User Notification Ends

  // Order Notification
  Route::get('/order/notf/show', 'Admin\NotificationController@order_notf_show')->name('order-notf-show');
  Route::get('/order/notf/count','Admin\NotificationController@order_notf_count')->name('order-notf-count');
  Route::get('/order/notf/clear','Admin\NotificationController@order_notf_clear')->name('order-notf-clear');
  // Order Notification Ends

  // Product Notification
  Route::get('/product/notf/show', 'Admin\NotificationController@product_notf_show')->name('product-notf-show');
  Route::get('/product/notf/count','Admin\NotificationController@product_notf_count')->name('product-notf-count');
  Route::get('/product/notf/clear','Admin\NotificationController@product_notf_clear')->name('product-notf-clear');
  // Product Notification Ends

  // Product Notification
  Route::get('/conv/notf/show', 'Admin\NotificationController@conv_notf_show')->name('conv-notf-show');
  Route::get('/conv/notf/count','Admin\NotificationController@conv_notf_count')->name('conv-notf-count');
  Route::get('/conv/notf/clear','Admin\NotificationController@conv_notf_clear')->name('conv-notf-clear');
  // Product Notification Ends

  //------------ ADMIN NOTIFICATION SECTION ENDS ------------

  //------------ ADMIN DASHBOARD & PROFILE SECTION ------------
  Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
  Route::get('/profile', 'Admin\DashboardController@profile')->name('admin.profile');
  Route::post('/profile/update', 'Admin\DashboardController@profileupdate')->name('admin.profile.update');
  Route::get('/password', 'Admin\DashboardController@passwordreset')->name('admin.password');  
  Route::post('/password/update', 'Admin\DashboardController@changepass')->name('admin.password.update');
  //------------ ADMIN DASHBOARD & PROFILE SECTION ENDS ------------

  //------------ ADMIN ORDER SECTION ------------
  Route::get('/orders/datatables/{slug}', 'Admin\OrderController@datatables')->name('admin-order-datatables'); //JSON REQUEST
  Route::get('/orders', 'Admin\OrderController@index')->name('admin-order-index');
  Route::get('/orders/manage', 'Admin\OrderController@ManageOrder')->name('admin-order-manage');
  Route::get('/order/edit/{id}', 'Admin\OrderController@edit')->name('admin-order-edit');
  Route::post('/order/update/{id}', 'Admin\OrderController@update')->name('admin-order-update');
  Route::get('/orders/pending', 'Admin\OrderController@pending')->name('admin-order-pending');
  Route::get('/orders/processing', 'Admin\OrderController@processing')->name('admin-order-processing');
  Route::get('/orders/completed', 'Admin\OrderController@completed')->name('admin-order-completed');
  Route::get('/orders/declined', 'Admin\OrderController@declined')->name('admin-order-declined');
  Route::get('/order/{id}/show', 'Admin\OrderController@show')->name('admin-order-show');
  Route::get('/order/{id}/invoice', 'Admin\OrderController@invoice')->name('admin-order-invoice');
  Route::get('/order/{id}/print', 'Admin\OrderController@printpage')->name('admin-order-print');
  Route::get('/order/{id1}/status/{status}', 'Admin\OrderController@status')->name('admin-order-status');
  Route::post('/order/email/', 'Admin\OrderController@emailsub')->name('admin-order-emailsub');
  Route::post('/order/{id}/license', 'Admin\OrderController@license')->name('admin-order-license');
  Route::post('/ordered-product-assignTo-Supplier', 'Admin\OrderController@orderedProductAssignToSupplier')->name('ordered-product-assignTo-Supplier');
  Route::post('/ordered-product-assign-Supplier-print', 'Admin\OrderController@adminOrderProductSupplierPrint')->name('admin-order-product-supplier-print');
  Route::get('/ordered-manage-order-history', 'Admin\OrderController@adminManageOrderHistory')->name('manage-order-history');
  Route::get('/admin-ordered-product-assign-to supplier-history', 'Admin\OrderController@adminorderedproductassigntosupplierhistory')->name('admin-ordered-product-assign-to-supplier-history');
  Route::get('/admin-ordered-product-assign-to supplier-details/{id}', 'Admin\OrderController@adminorderedproductassigntosupplierdetails')->name('admin-ordered-product-assign-to-supplier-details');
  Route::get('/admin-orderedProductAssignToSupplierPrint/{id}', 'Admin\OrderController@adminorderedProductAssignToSupplierPrint')->name('admin-orderedProductAssignToSupplierPrint');
  Route::post('/ordered-product-assignTo-Supplier-filter', 'Admin\OrderController@orderedProductAssignToSupplierSearch')->name('ordered-product-assignTo-Supplier-filter');



  // Order Tracking

  Route::get('/order/{id}/track', 'Admin\OrderTrackController@index')->name('admin-order-track');
  Route::get('/order/{id}/trackload', 'Admin\OrderTrackController@load')->name('admin-order-track-load');
  Route::post('/order/track/store', 'Admin\OrderTrackController@store')->name('admin-order-track-store');
  Route::get('/order/track/add', 'Admin\OrderTrackController@add')->name('admin-order-track-add');
  Route::get('/order/track/edit/{id}', 'Admin\OrderTrackController@edit')->name('admin-order-track-edit');
  Route::post('/order/track/update/{id}', 'Admin\OrderTrackController@update')->name('admin-order-track-update');
  Route::get('/order/track/delete/{id}', 'Admin\OrderTrackController@delete')->name('admin-order-track-delete');

  // Order Tracking Ends

  //------------ ADMIN ORDER SECTION ENDS------------

  //------------ ADMIN CATEGORY SECTION ------------

  Route::get('/category/datatables', 'Admin\CategoryController@datatables')->name('admin-cat-datatables'); //JSON REQUEST
  Route::get('/category', 'Admin\CategoryController@index')->name('admin-cat-index');
  Route::get('/category/create', 'Admin\CategoryController@create')->name('admin-cat-create');
  Route::post('/category/create', 'Admin\CategoryController@store')->name('admin-cat-store');
  Route::get('/category/edit/{id}', 'Admin\CategoryController@edit')->name('admin-cat-edit');
  Route::post('/category/edit/{id}', 'Admin\CategoryController@update')->name('admin-cat-update');  
  Route::get('/category/delete/{id}', 'Admin\CategoryController@destroy')->name('admin-cat-delete'); 
  Route::get('/category/status/{id1}/{id2}', 'Admin\CategoryController@status')->name('admin-cat-status');

  //------------ ADMIN CATEGORY SECTION ENDS------------

  //------------ ADMIN SUBCATEGORY SECTION ------------

  Route::get('/subcategory/datatables', 'Admin\SubCategoryController@datatables')->name('admin-subcat-datatables'); //JSON REQUEST
  Route::get('/subcategory', 'Admin\SubCategoryController@index')->name('admin-subcat-index');
  Route::get('/subcategory/create', 'Admin\SubCategoryController@create')->name('admin-subcat-create');
  Route::post('/subcategory/create', 'Admin\SubCategoryController@store')->name('admin-subcat-store');
  Route::get('/subcategory/edit/{id}', 'Admin\SubCategoryController@edit')->name('admin-subcat-edit');
  Route::post('/subcategory/edit/{id}', 'Admin\SubCategoryController@update')->name('admin-subcat-update');  
  Route::get('/subcategory/delete/{id}', 'Admin\SubCategoryController@destroy')->name('admin-subcat-delete'); 
  Route::get('/subcategory/status/{id1}/{id2}', 'Admin\SubCategoryController@status')->name('admin-subcat-status');
  Route::get('/load/subcategories/{id}/', 'Admin\SubCategoryController@load')->name('admin-subcat-load'); //JSON REQUEST

  //------------ ADMIN SUBCATEGORY SECTION ENDS------------

  //------------ ADMIN CHILDCATEGORY SECTION ------------

  Route::get('/childcategory/datatables', 'Admin\ChildCategoryController@datatables')->name('admin-childcat-datatables'); //JSON REQUEST
  Route::get('/childcategory', 'Admin\ChildCategoryController@index')->name('admin-childcat-index');
  Route::get('/childcategory/create', 'Admin\ChildCategoryController@create')->name('admin-childcat-create');
  Route::post('/childcategory/create', 'Admin\ChildCategoryController@store')->name('admin-childcat-store');
  Route::get('/childcategory/edit/{id}', 'Admin\ChildCategoryController@edit')->name('admin-childcat-edit');
  Route::post('/childcategory/edit/{id}', 'Admin\ChildCategoryController@update')->name('admin-childcat-update');  
  Route::get('/childcategory/delete/{id}', 'Admin\ChildCategoryController@destroy')->name('admin-childcat-delete'); 
  Route::get('/childcategory/status/{id1}/{id2}', 'Admin\ChildCategoryController@status')->name('admin-childcat-status');
  Route::get('/load/childcategories/{id}/', 'Admin\ChildCategoryController@load')->name('admin-childcat-load'); //JSON REQUEST

  //------------ ADMIN CHILDCATEGORY SECTION ENDS------------

  //------------ ADMIN PRODUCT SECTION ------------

  Route::get('/products/datatables', 'Admin\ProductController@datatables')->name('admin-prod-datatables'); //JSON REQUEST
  Route::get('/products', 'Admin\ProductController@index')->name('admin-prod-index');

  Route::post('/products/upload/update/{id}', 'Admin\ProductController@uploadUpdate')->name('admin-prod-upload-update');  

  Route::get('/products/deactive/datatables', 'Admin\ProductController@deactivedatatables')->name('admin-prod-deactive-datatables'); //JSON REQUEST
  Route::get('/products/deactive', 'Admin\ProductController@deactive')->name('admin-prod-deactive');

  // CREATE SECTION
  Route::get('/products/types', 'Admin\ProductController@types')->name('admin-prod-types');
  Route::get('/products/physical/create', 'Admin\ProductController@createPhysical')->name('admin-prod-physical-create');
  Route::get('/products/digital/create', 'Admin\ProductController@createDigital')->name('admin-prod-digital-create');
  Route::get('/products/license/create', 'Admin\ProductController@createLicense')->name('admin-prod-license-create');
  Route::post('/products/store', 'Admin\ProductController@store')->name('admin-prod-store');
  Route::get('/products/import', 'Admin\ProductController@import')->name('admin-prod-import');
  Route::post('/products/import-submit', 'Admin\ProductController@importSubmit')->name('admin-prod-importsubmit');
  Route::get('/products/supplier/delete/{id1}/{id2}', 'Admin\ProductController@productSupplierDelete')->name('product-supplier-delete');
  // CREATE SECTION


    //IMPORT SECTION
    Route::get('/products/import/create', 'Admin\ImportController@createImport')->name('admin-import-create');
    Route::get('/products/import/edit/{id}', 'Admin\ImportController@edit')->name('admin-import-edit');
    Route::get('/products/import/csv', 'Admin\ImportController@importCSV')->name('admin-import-csv');

    Route::get('/products/import/datatables', 'Admin\ImportController@datatables')->name('admin-import-datatables'); //JSON REQUEST
    Route::get('/products/import/index', 'Admin\ImportController@index')->name('admin-import-index');

    Route::post('/products/import/store', 'Admin\ImportController@store')->name('admin-import-store');
    Route::post('/products/import/update/{id}', 'Admin\ImportController@update')->name('admin-import-update');

    Route::post('/products/import/csv/store', 'Admin\ImportController@importStore')->name('admin-import-csv-store');
    //IMPORT SECTION


    // EDIT SECTION
  Route::get('/products/edit/{id}', 'Admin\ProductController@edit')->name('admin-prod-edit');  
  Route::post('/products/edit/{id}', 'Admin\ProductController@update')->name('admin-prod-update');  
  // EDIT SECTION ENDS

  // STATUS SECTION  
  Route::get('/products/status/{id1}/{id2}', 'Admin\ProductController@status')->name('admin-prod-status');
  // STATUS SECTION ENDS

  // FEATURE SECTION  
  Route::get('/products/feature/{id}', 'Admin\ProductController@feature')->name('admin-prod-feature');
  Route::post('/products/feature/{id}', 'Admin\ProductController@featuresubmit')->name('admin-prod-feature');  
  // FEATURE SECTION ENDS

  // DELETE SECTION  
  Route::get('/products/delete/{id}', 'Admin\ProductController@destroy')->name('admin-prod-delete'); 
  // DELETE SECTION ENDS  

  //------------ ADMIN PRODUCT SECTION ENDS------------

  //------------ ADMIN GALLERY SECTION ------------

  Route::get('/gallery/show', 'Admin\GalleryController@show')->name('admin-gallery-show');
  Route::post('/gallery/store', 'Admin\GalleryController@store')->name('admin-gallery-store');  
  Route::get('/gallery/delete', 'Admin\GalleryController@destroy')->name('admin-gallery-delete'); 

  //------------ ADMIN GALLERY SECTION ENDS------------

  //------------ ADMIN USER SECTION ------------

  Route::get('/users/datatables', 'Admin\UserController@datatables')->name('admin-user-datatables'); //JSON REQUEST
  Route::get('/users', 'Admin\UserController@index')->name('admin-user-index');
  Route::get('/users/edit/{id}', 'Admin\UserController@edit')->name('admin-user-edit');
  Route::post('/users/edit/{id}', 'Admin\UserController@update')->name('admin-user-update');
  Route::get('/users/delete/{id}', 'Admin\UserController@destroy')->name('admin-user-delete');
  Route::get('/user/{id}/show', 'Admin\UserController@show')->name('admin-user-show');
  Route::get('/users/ban/{id1}/{id2}', 'Admin\UserController@ban')->name('admin-user-ban');
  Route::get('/user/default/image', 'Admin\UserController@image')->name('admin-user-image');

  // WITHDRAW SECTION
  Route::get('/users/withdraws/datatables', 'Admin\UserController@withdrawdatatables')->name('admin-withdraw-datatables'); //JSON REQUEST
  Route::get('/users/withdraws', 'Admin\UserController@withdraws')->name('admin-withdraw-index');
  Route::get('/user/withdraw/{id}/show', 'Admin\UserController@withdrawdetails')->name('admin-withdraw-show');
  Route::get('/users/withdraws/accept/{id}', 'Admin\UserController@accept')->name('admin-withdraw-accept');
  Route::get('/user/withdraws/reject/{id}', 'Admin\UserController@reject')->name('admin-withdraw-reject');
  // WITHDRAW SECTION ENDS

  //------------ ADMIN USER SECTION ENDS ------------


  //------------ ADMIN USER MESSAGE SECTION ------------

  Route::get('/messages/datatables/{type}', 'Admin\MessageController@datatables')->name('admin-message-datatables');
  Route::get('/tickets', 'Admin\MessageController@index')->name('admin-message-index');
  Route::get('/disputes', 'Admin\MessageController@disputes')->name('admin-message-dispute');
  Route::get('/message/{id}', 'Admin\MessageController@message')->name('admin-message-show');
  Route::get('/message/load/{id}', 'Admin\MessageController@messageshow')->name('admin-message-load');
  Route::post('/message/post', 'Admin\MessageController@postmessage')->name('admin-message-store');
  Route::get('/message/{id}/delete', 'Admin\MessageController@messagedelete')->name('admin-message-delete');   
  Route::post('/user/send/message', 'Admin\MessageController@usercontact')->name('admin-send-message');

  //------------ ADMIN USER MESSAGE SECTION ENDS ------------

  Route::get('/ratings/datatables', 'Admin\RatingController@datatables')->name('admin-rating-datatables'); //JSON REQUEST
  Route::get('/ratings', 'Admin\RatingController@index')->name('admin-rating-index');
  Route::get('/ratings/delete/{id}', 'Admin\RatingController@destroy')->name('admin-rating-delete');
  Route::get('/ratings/show/{id}', 'Admin\RatingController@show')->name('admin-rating-show');

  //------------ ADMIN RATING SECTION ENDS------------

  //------------ ADMIN COMMENT SECTION ------------
  Route::get('/comments/datatables', 'Admin\CommentController@datatables')->name('admin-comment-datatables'); //JSON REQUEST
  Route::get('/comments', 'Admin\CommentController@index')->name('admin-comment-index');
  Route::get('/comments/delete/{id}', 'Admin\CommentController@destroy')->name('admin-comment-delete');
  Route::get('/comments/show/{id}', 'Admin\CommentController@show')->name('admin-comment-show');

  //------------ ADMIN COMMENT SECTION ENDS ------------



  //------------ ADMIN REPORT SECTION ------------
  Route::get('/reports/datatables', 'Admin\ReportController@datatables')->name('admin-report-datatables'); //JSON REQUEST
  Route::get('/reports', 'Admin\ReportController@index')->name('admin-report-index');
  Route::get('/reports/delete/{id}', 'Admin\ReportController@destroy')->name('admin-report-delete');
  Route::get('/reports/show/{id}', 'Admin\ReportController@show')->name('admin-report-show');

  //------------ ADMIN REPORT SECTION ENDS ------------

  //------------ ADMIN COUPON SECTION ------------

  Route::get('/coupon/datatables', 'Admin\CouponController@datatables')->name('admin-coupon-datatables'); //JSON REQUEST
  Route::get('/coupon', 'Admin\CouponController@index')->name('admin-coupon-index');
  Route::get('/coupon/create', 'Admin\CouponController@create')->name('admin-coupon-create');
  Route::post('/coupon/create', 'Admin\CouponController@store')->name('admin-coupon-store');
  Route::get('/coupon/edit/{id}', 'Admin\CouponController@edit')->name('admin-coupon-edit');
  Route::post('/coupon/edit/{id}', 'Admin\CouponController@update')->name('admin-coupon-update');  
  Route::get('/coupon/delete/{id}', 'Admin\CouponController@destroy')->name('admin-coupon-delete'); 
  Route::get('/coupon/status/{id1}/{id2}', 'Admin\CouponController@status')->name('admin-coupon-status');

  //------------ ADMIN COUPON SECTION ENDS------------

  //------------ ADMIN Campaign SECTION ------------
  Route::get('/campaign', 'Admin\CampaignController@index')->name('admin-campaign-index');
  Route::post('/campaign', 'Admin\CampaignController@store')->name('admin-campaign-store');
  Route::get('/load/dropdown/{id}', 'Admin\CampaignController@dropdown')->name('admin-campaign-dropdown-load');

  Route::get('/capmaign/status/{id1}/{id2}', 'Admin\CampaignController@campaignStatus')->name('admin-campaign-status');

  Route::get('/campaign/rules/datatables', 'Admin\CampaignController@datatables')->name('campaign-rules-datatables');
  Route::get('/campaign/rules/view/{id}', 'Admin\CampaignController@campaignView')->name('campaign-rules-view');
  Route::get('/admin/campaign/specific/offer/delete/{id1}/{id2}', 'Admin\CampaignController@adminCampaignSpecificOfferDelete')->name('admin-campaign-specific-offer-delete');

  Route::post('/admin/campaign-update/{id}', 'Admin\CampaignController@update')->name('admin-campaign-update');
  Route::get('/campaign/rules/delete/{id}', 'Admin\CampaignController@deleteCampaign')->name('campaign-rules-delete');

  //------------ ADMIN Campaign SECTION ENDS------------

  //------------ ADMIN Reward SECTION ------------
  Route::get('/rewardPoint', 'Admin\RewardController@index')->name('admin-reward-index');
  Route::post('/admin/reward/store', 'Admin\RewardController@store')->name('admin-reward-store');
  Route::get('/admin/reward/status/{id1}/{id2}', 'Admin\RewardController@status')->name('admin-reward-status');
  Route::get('/admin/reward/edit/{id}', 'Admin\RewardController@show')->name('admin-rewards-edit');
  Route::post('/admin/reward/update/{id}', 'Admin\RewardController@update')->name('admin-reward-update');
  Route::get('/admin/reward/delete/{id}', 'Admin\RewardController@delete')->name('admin-rewards-delete');


  //------------ ADMIN Reward SECTION ENDS------------

    //------------ ADMIN Offer SECTION ------------
    Route::get('/admin-offer-create', 'Admin\OfferAsProductController@index')->name('admin-offer-index');



    //------------ ADMIN Reward SECTION ENDS------------

  //------------ ADMIN BLOG SECTION ------------

  Route::get('/blog/datatables', 'Admin\BlogController@datatables')->name('admin-blog-datatables'); //JSON REQUEST
  Route::get('/blog', 'Admin\BlogController@index')->name('admin-blog-index');
  Route::get('/blog/create', 'Admin\BlogController@create')->name('admin-blog-create');
  Route::post('/blog/create', 'Admin\BlogController@store')->name('admin-blog-store');
  Route::get('/blog/edit/{id}', 'Admin\BlogController@edit')->name('admin-blog-edit');
  Route::post('/blog/edit/{id}', 'Admin\BlogController@update')->name('admin-blog-update');  
  Route::get('/blog/delete/{id}', 'Admin\BlogController@destroy')->name('admin-blog-delete'); 
  
  Route::get('/blog/category/datatables', 'Admin\BlogCategoryController@datatables')->name('admin-cblog-datatables'); //JSON REQUEST
  Route::get('/blog/category', 'Admin\BlogCategoryController@index')->name('admin-cblog-index');
  Route::get('/blog/category/create', 'Admin\BlogCategoryController@create')->name('admin-cblog-create');
  Route::post('/blog/category/create', 'Admin\BlogCategoryController@store')->name('admin-cblog-store');
  Route::get('/blog/category/edit/{id}', 'Admin\BlogCategoryController@edit')->name('admin-cblog-edit');
  Route::post('/blog/category/edit/{id}', 'Admin\BlogCategoryController@update')->name('admin-cblog-update');  
  Route::get('/blog/category/delete/{id}', 'Admin\BlogCategoryController@destroy')->name('admin-cblog-delete'); 

  //------------ ADMIN BLOG SECTION ENDS ------------

  //------------ ADMIN SLIDER SECTION ------------

  Route::get('/slider/datatables', 'Admin\SliderController@datatables')->name('admin-sl-datatables'); //JSON REQUEST
  Route::get('/slider', 'Admin\SliderController@index')->name('admin-sl-index');
  Route::get('/slider/create', 'Admin\SliderController@create')->name('admin-sl-create');
  Route::post('/slider/create', 'Admin\SliderController@store')->name('admin-sl-store');
  Route::get('/slider/edit/{id}', 'Admin\SliderController@edit')->name('admin-sl-edit');
  Route::post('/slider/edit/{id}', 'Admin\SliderController@update')->name('admin-sl-update');  
  Route::get('/slider/delete/{id}', 'Admin\SliderController@destroy')->name('admin-sl-delete'); 

  //------------ ADMIN SLIDER SECTION ENDS ------------

  //------------ ADMIN SERVICE SECTION ------------

  Route::get('/service/datatables', 'Admin\ServiceController@datatables')->name('admin-service-datatables'); //JSON REQUEST
  Route::get('/service', 'Admin\ServiceController@index')->name('admin-service-index');
  Route::get('/service/create', 'Admin\ServiceController@create')->name('admin-service-create');
  Route::post('/service/create', 'Admin\ServiceController@store')->name('admin-service-store');
  Route::get('/service/edit/{id}', 'Admin\ServiceController@edit')->name('admin-service-edit');
  Route::post('/service/edit/{id}', 'Admin\ServiceController@update')->name('admin-service-update');  
  Route::get('/service/delete/{id}', 'Admin\ServiceController@destroy')->name('admin-service-delete'); 

  //------------ ADMIN SERVICE SECTION ENDS ------------

  //------------ ADMIN SERVICE SECTION ------------

  Route::get('/banner/datatables/{type}', 'Admin\BannerController@datatables')->name('admin-sb-datatables'); //JSON REQUEST
  Route::get('top/small/banner/', 'Admin\BannerController@index')->name('admin-sb-index');
  Route::get('large/banner/', 'Admin\BannerController@large')->name('admin-sb-large');
  Route::get('landing/banner/', 'Admin\BannerController@landing')->name('admin-sb-landing');
  Route::get('bottom/small/banner/', 'Admin\BannerController@bottom')->name('admin-sb-bottom');
  Route::get('top/small/banner/create', 'Admin\BannerController@create')->name('admin-sb-create');
  Route::get('large/banner/create', 'Admin\BannerController@largecreate')->name('admin-sb-create-large');
  Route::get('landing/banner/create', 'Admin\BannerController@landingcreate')->name('admin-sb-create-landing');
  Route::get('bottom/small/banner/create', 'Admin\BannerController@bottomcreate')->name('admin-sb-create-bottom');


  Route::post('/banner/create', 'Admin\BannerController@store')->name('admin-sb-store');
  Route::get('/banner/edit/{id}', 'Admin\BannerController@edit')->name('admin-sb-edit');
  Route::post('/banner/edit/{id}', 'Admin\BannerController@update')->name('admin-sb-update');  
  Route::get('/banner/delete/{id}', 'Admin\BannerController@destroy')->name('admin-sb-delete'); 

  //------------ ADMIN SERVICE SECTION ENDS ------------

  //------------ ADMIN REVIEW SECTION ------------

  Route::get('/review/datatables', 'Admin\ReviewController@datatables')->name('admin-review-datatables'); //JSON REQUEST
  Route::get('/review', 'Admin\ReviewController@index')->name('admin-review-index');
  Route::get('/review/create', 'Admin\ReviewController@create')->name('admin-review-create');
  Route::post('/review/create', 'Admin\ReviewController@store')->name('admin-review-store');
  Route::get('/review/edit/{id}', 'Admin\ReviewController@edit')->name('admin-review-edit');
  Route::post('/review/edit/{id}', 'Admin\ReviewController@update')->name('admin-review-update');  
  Route::get('/review/delete/{id}', 'Admin\ReviewController@destroy')->name('admin-review-delete'); 

  //------------ ADMIN REVIEW SECTION ENDS ------------

  //------------ ADMIN GENERAL SETTINGS SECTION ------------

  Route::get('/general-settings/logo', 'Admin\GeneralSettingController@logo')->name('admin-gs-logo');
  Route::get('/general-settings/favicon', 'Admin\GeneralSettingController@fav')->name('admin-gs-fav');
  Route::get('/general-settings/loader', 'Admin\GeneralSettingController@load')->name('admin-gs-load');
  Route::get('/general-settings/contents', 'Admin\GeneralSettingController@contents')->name('admin-gs-contents');
  Route::get('/general-settings/header', 'Admin\GeneralSettingController@header')->name('admin-gs-header');
  Route::get('/general-settings/footer', 'Admin\GeneralSettingController@footer')->name('admin-gs-footer');
  Route::get('/general-settings/affilate', 'Admin\GeneralSettingController@affilate')->name('admin-gs-affilate');
  Route::get('/general-settings/error-banner', 'Admin\GeneralSettingController@errorbanner')->name('admin-gs-error-banner');
  Route::get('/general-settings/popup', 'Admin\GeneralSettingController@popup')->name('admin-gs-popup');

// Pickup Location 
  Route::get('/pickup/datatables', 'Admin\PickupController@datatables')->name('admin-pick-datatables'); //JSON REQUEST
  Route::get('/pickup', 'Admin\PickupController@index')->name('admin-pick-index');
  Route::get('/pickup/create', 'Admin\PickupController@create')->name('admin-pick-create');
  Route::post('/pickup/create', 'Admin\PickupController@store')->name('admin-pick-store');
  Route::get('/pickup/edit/{id}', 'Admin\PickupController@edit')->name('admin-pick-edit');
  Route::post('/pickup/edit/{id}', 'Admin\PickupController@update')->name('admin-pick-update');  
  Route::get('/pickup/delete/{id}', 'Admin\PickupController@destroy')->name('admin-pick-delete');

  Route::group(['middleware'=>'admininistrator'],function(){

  //------------ ADMIN GENERAL SETTINGS JSON SECTION ------------

  // General Setting Section
  Route::get('/general-settings/home/{status}', 'Admin\GeneralSettingController@ishome')->name('admin-gs-ishome'); 
  Route::get('/general-settings/disqus/{status}', 'Admin\GeneralSettingController@isdisqus')->name('admin-gs-isdisqus'); 
  Route::get('/general-settings/loader/{status}', 'Admin\GeneralSettingController@isloader')->name('admin-gs-isloader'); 
  Route::get('/general-settings/email-verify/{status}', 'Admin\GeneralSettingController@isemailverify')->name('admin-gs-is-email-verify'); 
  Route::get('/general-settings/popup/{status}', 'Admin\GeneralSettingController@ispopup')->name('admin-gs-ispopup'); 

  Route::get('/general-settings/admin/loader/{status}', 'Admin\GeneralSettingController@isadminloader')->name('admin-gs-is-admin-loader'); 
  Route::get('/general-settings/talkto/{status}', 'Admin\GeneralSettingController@talkto')->name('admin-gs-talkto');

  Route::get('/general-settings/security/{status}', 'Admin\GeneralSettingController@issecure')->name('admin-gs-secure');

  // Payment Setting Section

  Route::get('/general-settings/guest/{status}', 'Admin\GeneralSettingController@guest')->name('admin-gs-guest');
  Route::get('/general-settings/paypal/{status}', 'Admin\GeneralSettingController@paypal')->name('admin-gs-paypal');
  Route::get('/general-settings/instamojo/{status}', 'Admin\GeneralSettingController@instamojo')->name('admin-gs-instamojo');
  Route::get('/general-settings/paystack/{status}', 'Admin\GeneralSettingController@paystack')->name('admin-gs-paystack');
  Route::get('/general-settings/stripe/{status}', 'Admin\GeneralSettingController@stripe')->name('admin-gs-stripe');
  Route::get('/general-settings/cod/{status}', 'Admin\GeneralSettingController@cod')->name('admin-gs-cod');

  //  Comment Section

  Route::get('/general-settings/comment/{status}', 'Admin\GeneralSettingController@comment')->name('admin-gs-iscomment'); 


  //  Language Section

  Route::get('/general-settings/language/{status}', 'Admin\GeneralSettingController@language')->name('admin-gs-islanguage'); 

  //  Currency Section

  Route::get('/general-settings/currency/{status}', 'Admin\GeneralSettingController@currency')->name('admin-gs-iscurrency'); 

  //  Affilte Section

  Route::get('/general-settings/affilate/{status}', 'Admin\GeneralSettingController@isaffilate')->name('admin-gs-isaffilate'); 

  //  Capcha Section

  Route::get('/general-settings/capcha/{status}', 'Admin\GeneralSettingController@iscapcha')->name('admin-gs-iscapcha'); 


  //  Report Section

  Route::get('/general-settings/report/{status}', 'Admin\GeneralSettingController@isreport')->name('admin-gs-isreport'); 

  //------------ ADMIN GENERAL SETTINGS JSON SECTION ENDS------------

  Route::post('/general-settings/update/all', 'Admin\GeneralSettingController@generalupdate')->name('admin-gs-update');

  Route::post('/general-settings/update/payment', 'Admin\GeneralSettingController@generalupdatepayment')->name('admin-gs-update-payment');

  //------------ ADMIN GENERAL SETTINGS SECTION ENDS ------------

});

  //------------ FEATURED LINK SECTION ------------

Route::get('/featuredlink/datatables', 'Admin\FeaturedLinkController@datatables')->name('admin-featuredlink-datatables');
Route::get('/featuredlink', 'Admin\FeaturedLinkController@index')->name('admin-featuredlink-index');
Route::get('/featuredlink/create', 'Admin\FeaturedLinkController@create')->name('admin-featuredlink-create');
Route::post('/featuredlink/create', 'Admin\FeaturedLinkController@store')->name('admin-featuredlink-store');
Route::get('/featuredlink/edit/{id}', 'Admin\FeaturedLinkController@edit')->name('admin-featuredlink-edit');
Route::post('/featuredlink/edit/{id}', 'Admin\FeaturedLinkController@update')->name('admin-featuredlink-update');
Route::get('/featuredlink/delete/{id}', 'Admin\FeaturedLinkController@destroy')->name('admin-featuredlink-delete');


  //------------ FEATURED LINK SECTION ENDS ------------

  //------------ FEATURED BANNER SECTION ------------

Route::get('/featuredbanner/datatables', 'Admin\FeaturedBannerController@datatables')->name('admin-featuredbanner-datatables');
Route::get('/featuredbanner', 'Admin\FeaturedBannerController@index')->name('admin-featuredbanner-index');
Route::get('/featuredbanner/create', 'Admin\FeaturedBannerController@create')->name('admin-featuredbanner-create');
Route::post('/featuredbanner/create', 'Admin\FeaturedBannerController@store')->name('admin-featuredbanner-store');
Route::get('/featuredbanner/edit/{id}', 'Admin\FeaturedBannerController@edit')->name('admin-featuredbanner-edit');
Route::post('/featuredbanner/edit/{id}', 'Admin\FeaturedBannerController@update')->name('admin-featuredbanner-update');
Route::get('/featuredbanner/delete/{id}', 'Admin\FeaturedBannerController@destroy')->name('admin-featuredbanner-delete');

  //------------ FEATURED BANNER SECTION ENDS ------------


  //------------ ADMIN FAQ SECTION ------------

  Route::get('/faq/datatables', 'Admin\FaqController@datatables')->name('admin-faq-datatables'); //JSON REQUEST
  Route::get('/faq', 'Admin\FaqController@index')->name('admin-faq-index');
  Route::get('/faq/create', 'Admin\FaqController@create')->name('admin-faq-create');
  Route::post('/faq/create', 'Admin\FaqController@store')->name('admin-faq-store');
  Route::get('/faq/edit/{id}', 'Admin\FaqController@edit')->name('admin-faq-edit');
  Route::post('/faq/update/{id}', 'Admin\FaqController@update')->name('admin-faq-update');
  Route::get('/faq/delete/{id}', 'Admin\FaqController@destroy')->name('admin-faq-delete');

  //------------ ADMIN FAQ SECTION ENDS ------------

  //------------ ADMIN PARTNER SECTION ------------

  Route::get('/partner/datatables', 'Admin\PartnerController@datatables')->name('admin-partner-datatables');
  Route::get('/partner', 'Admin\PartnerController@index')->name('admin-partner-index');
  Route::get('/partner/create', 'Admin\PartnerController@create')->name('admin-partner-create');
  Route::post('/partner/create', 'Admin\PartnerController@store')->name('admin-partner-store');
  Route::get('/partner/edit/{id}', 'Admin\PartnerController@edit')->name('admin-partner-edit');
  Route::post('/partner/edit/{id}', 'Admin\PartnerController@update')->name('admin-partner-update');
  Route::get('/partner/delete/{id}', 'Admin\PartnerController@destroy')->name('admin-partner-delete');

  //------------ ADMIN PARTNER SECTION ENDS ------------
  

  //------------ ADMIN SHIPPING ------------

Route::get('/shipping/datatables', 'Admin\ShippingController@datatables')->name('admin-shipping-datatables');
Route::get('/shipping', 'Admin\ShippingController@index')->name('admin-shipping-index');
Route::get('/shipping/create', 'Admin\ShippingController@create')->name('admin-shipping-create');
Route::post('/shipping/create', 'Admin\ShippingController@store')->name('admin-shipping-store');
Route::get('/shipping/edit/{id}', 'Admin\ShippingController@edit')->name('admin-shipping-edit');
Route::post('/shipping/edit/{id}', 'Admin\ShippingController@update')->name('admin-shipping-update');
Route::get('/shipping/delete/{id}', 'Admin\ShippingController@destroy')->name('admin-shipping-delete');

  //------------ ADMIN SHIPPING ENDS ------------


  //------------ ADMIN PACKAGE ------------

Route::get('/package/datatables', 'Admin\PackageController@datatables')->name('admin-package-datatables');
Route::get('/package', 'Admin\PackageController@index')->name('admin-package-index');
Route::get('/package/create', 'Admin\PackageController@create')->name('admin-package-create');
Route::post('/package/create', 'Admin\PackageController@store')->name('admin-package-store');
Route::get('/package/edit/{id}', 'Admin\PackageController@edit')->name('admin-package-edit');
Route::post('/package/edit/{id}', 'Admin\PackageController@update')->name('admin-package-update');
Route::get('/package/delete/{id}', 'Admin\PackageController@destroy')->name('admin-package-delete');


  //------------ ADMIN PACKAGE ENDS------------

  //------------ ADMIN PAGE SETTINGS SECTION ------------
// Page Setting Section

  Route::get('/general-settings/contact/{status}', 'Admin\GeneralSettingController@iscontact')->name('admin-gs-iscontact');
  Route::get('/general-settings/faq/{status}', 'Admin\GeneralSettingController@isfaq')->name('admin-gs-isfaq'); 

  Route::get('/page-settings/contact', 'Admin\PageSettingController@contact')->name('admin-ps-contact');
  Route::get('/page-settings/customize', 'Admin\PageSettingController@customize')->name('admin-ps-customize');
  Route::get('/page-settings/big-save', 'Admin\PageSettingController@big_save')->name('admin-ps-big-save');
  Route::get('/page-settings/best-seller', 'Admin\PageSettingController@best_seller')->name('admin-ps-best-seller');
  Route::post('/page-settings/update/all', 'Admin\PageSettingController@update')->name('admin-ps-update');
  Route::post('/page-settings/update/home', 'Admin\PageSettingController@homeupdate')->name('admin-ps-homeupdate');
  //------------ ADMIN PAGE SETTINGS SECTION ENDS ------------

  //------------ ADMIN PAGE SECTION ------------  

  Route::get('/page/datatables', 'Admin\PageController@datatables')->name('admin-page-datatables'); //JSON REQUEST
  Route::get('/page', 'Admin\PageController@index')->name('admin-page-index');
  Route::get('/page/create', 'Admin\PageController@create')->name('admin-page-create');
  Route::post('/page/create', 'Admin\PageController@store')->name('admin-page-store');
  Route::get('/page/edit/{id}', 'Admin\PageController@edit')->name('admin-page-edit');
  Route::post('/page/update/{id}', 'Admin\PageController@update')->name('admin-page-update');
  Route::get('/page/delete/{id}', 'Admin\PageController@destroy')->name('admin-page-delete');
  Route::get('/page/header/{id1}/{id2}', 'Admin\PageController@header')->name('admin-page-header');
  Route::get('/page/footer/{id1}/{id2}', 'Admin\PageController@footer')->name('admin-page-footer');

  //------------ ADMIN PAGE SECTION ENDS------------  

  Route::group(['middleware'=>'admininistrator'],function(){

  //------------ ADMIN EMAIL SETTINGS SECTION ------------

  Route::get('/email-templates/datatables', 'Admin\EmailController@datatables')->name('admin-mail-datatables');
  Route::get('/email-templates', 'Admin\EmailController@index')->name('admin-mail-index');
  Route::get('/email-templates/{id}', 'Admin\EmailController@edit')->name('admin-mail-edit');
  Route::post('/email-templates/{id}', 'Admin\EmailController@update')->name('admin-mail-update');
  Route::get('/email-config', 'Admin\EmailController@config')->name('admin-mail-config');
  Route::get('/groupemail', 'Admin\EmailController@groupemail')->name('admin-group-show');
  Route::post('/groupemailpost', 'Admin\EmailController@groupemailpost')->name('admin-group-submit');
  Route::get('/issmtp/{status}', 'Admin\GeneralSettingController@issmtp')->name('admin-gs-issmtp');

  //------------ ADMIN EMAIL SETTINGS SECTION ENDS ------------

  //------------ ADMIN PAYMENT SETTINGS SECTION ------------

// Payment Informations  

  Route::get('/payment-informations', 'Admin\GeneralSettingController@paymentsinfo')->name('admin-gs-payments');

// Payment Gateways

  Route::get('/paymentgateway/datatables', 'Admin\PaymentGatewayController@datatables')->name('admin-payment-datatables'); //JSON REQUEST
  Route::get('/paymentgateway', 'Admin\PaymentGatewayController@index')->name('admin-payment-index');
  Route::get('/paymentgateway/create', 'Admin\PaymentGatewayController@create')->name('admin-payment-create');
  Route::post('/paymentgateway/create', 'Admin\PaymentGatewayController@store')->name('admin-payment-store');
  Route::get('/paymentgateway/edit/{id}', 'Admin\PaymentGatewayController@edit')->name('admin-payment-edit');
  Route::post('/paymentgateway/update/{id}', 'Admin\PaymentGatewayController@update')->name('admin-payment-update');
  Route::get('/paymentgateway/delete/{id}', 'Admin\PaymentGatewayController@destroy')->name('admin-payment-delete');
  Route::get('/paymentgateway/status/{id1}/{id2}', 'Admin\PaymentGatewayController@status')->name('admin-payment-status');

// Currency Settings

  Route::get('/currency/datatables', 'Admin\CurrencyController@datatables')->name('admin-currency-datatables'); //JSON REQUEST
  Route::get('/currency', 'Admin\CurrencyController@index')->name('admin-currency-index');
  Route::get('/currency/create', 'Admin\CurrencyController@create')->name('admin-currency-create');
  Route::post('/currency/create', 'Admin\CurrencyController@store')->name('admin-currency-store');
  Route::get('/currency/edit/{id}', 'Admin\CurrencyController@edit')->name('admin-currency-edit');
  Route::post('/currency/update/{id}', 'Admin\CurrencyController@update')->name('admin-currency-update');
  Route::get('/currency/delete/{id}', 'Admin\CurrencyController@destroy')->name('admin-currency-delete');
  Route::get('/currency/status/{id1}/{id2}', 'Admin\CurrencyController@status')->name('admin-currency-status');

  //------------ ADMIN PAYMENT SETTINGS SECTION ENDS------------

  //------------ ADMIN SOCIAL SETTINGS SECTION ------------

  Route::get('/social', 'Admin\SocialSettingController@index')->name('admin-social-index');
  Route::post('/social/update', 'Admin\SocialSettingController@socialupdate')->name('admin-social-update');
  Route::post('/social/update/all', 'Admin\SocialSettingController@socialupdateall')->name('admin-social-update-all');
  Route::get('/social/facebook', 'Admin\SocialSettingController@facebook')->name('admin-social-facebook');
  Route::get('/social/google', 'Admin\SocialSettingController@google')->name('admin-social-google');
  Route::get('/social/facebook/{status}', 'Admin\SocialSettingController@facebookup')->name('admin-social-facebookup');
  Route::get('/social/google/{status}', 'Admin\SocialSettingController@googleup')->name('admin-social-googleup');

  //------------ ADMIN SOCIAL SETTINGS SECTION ENDS------------

  //------------ ADMIN LANGUAGE SETTINGS SECTION ------------

  Route::get('/languages/datatables', 'Admin\LanguageController@datatables')->name('admin-lang-datatables'); //JSON REQUEST
  Route::get('/languages', 'Admin\LanguageController@index')->name('admin-lang-index');
  Route::get('/languages/create', 'Admin\LanguageController@create')->name('admin-lang-create');
  Route::get('/languages/edit/{id}', 'Admin\LanguageController@edit')->name('admin-lang-edit');
  Route::post('/languages/create', 'Admin\LanguageController@store')->name('admin-lang-store');
  Route::post('/languages/edit/{id}', 'Admin\LanguageController@update')->name('admin-lang-update');
  Route::get('/languages/status/{id1}/{id2}', 'Admin\LanguageController@status')->name('admin-lang-st');
  Route::get('/languages/delete/{id}', 'Admin\LanguageController@destroy')->name('admin-lang-delete');

  //------------ ADMIN LANGUAGE SETTINGS SECTION ENDS ------------



  //------------ ADMIN PANEL LANGUAGE SETTINGS SECTION ------------

  Route::get('/adminlanguages/datatables', 'Admin\AdminLanguageController@datatables')->name('admin-tlang-datatables'); //JSON REQUEST
  Route::get('/adminlanguages', 'Admin\AdminLanguageController@index')->name('admin-tlang-index');
  Route::get('/adminlanguages/create', 'Admin\AdminLanguageController@create')->name('admin-tlang-create');
  Route::get('/adminlanguages/edit/{id}', 'Admin\AdminLanguageController@edit')->name('admin-tlang-edit');
  Route::post('/adminlanguages/create', 'Admin\AdminLanguageController@store')->name('admin-tlang-store');
  Route::post('/adminlanguages/edit/{id}', 'Admin\AdminLanguageController@update')->name('admin-tlang-update');
  Route::get('/adminlanguages/status/{id1}/{id2}', 'Admin\AdminLanguageController@status')->name('admin-tlang-st');
  Route::get('/adminlanguages/delete/{id}', 'Admin\AdminLanguageController@destroy')->name('admin-tlang-delete');

  //------------ ADMIN PANEL LANGUAGE SETTINGS SECTION ENDS ------------



  //------------ ADMIN SEOTOOL SETTINGS SECTION ------------

  Route::get('/seotools/analytics', 'Admin\SeoToolController@analytics')->name('admin-seotool-analytics');
  Route::post('/seotools/analytics/update', 'Admin\SeoToolController@analyticsupdate')->name('admin-seotool-analytics-update');
  Route::get('/seotools/keywords', 'Admin\SeoToolController@keywords')->name('admin-seotool-keywords');
  Route::post('/seotools/keywords/update', 'Admin\SeoToolController@keywordsupdate')->name('admin-seotool-keywords-update');
  Route::get('/products/popular/{id}','Admin\SeoToolController@popular')->name('admin-prod-popular');
  //------------ ADMIN SEOTOOL SETTINGS SECTION ------------

  //------------ STAFF SECTION ------------
  Route::get('/staff/datatables', 'Admin\StaffController@datatables')->name('admin-staff-datatables');
  Route::get('/staff', 'Admin\StaffController@index')->name('admin-staff-index');
  Route::get('/staff/create', 'Admin\StaffController@create')->name('admin-staff-create');
  Route::post('/staff/create', 'Admin\StaffController@store')->name('admin-staff-store');
  Route::get('/staff/edit/{id}', 'Admin\StaffController@show')->name('admin-staff-show'); 
  Route::get('/staff/delete/{id}', 'Admin\StaffController@destroy')->name('admin-staff-delete'); 

  //------------ STAFF SECTION ENDS------------

   //------------ Vendor SECTION ------------
  Route::get('/vendor/datatables', 'Admin\VendorController@datatables')->name('admin-vendor-datatables');
  Route::get('/vendor', 'Admin\VendorController@index')->name('admin-vendor-index');
  Route::get('/vendor/create', 'Admin\VendorController@create')->name('admin-vendor-create');
  Route::post('/vendor/create', 'Admin\VendorController@store')->name('admin-vendor-store');
  Route::get('/vendor/edit/{id}', 'Admin\VendorController@show')->name('admin-vendor-show'); 
  Route::get('/vendor/delete/{id}', 'Admin\VendorController@destroy')->name('admin-vendor-delete');
  Route::get('/vendor/status/{id1}/{id2}', 'Admin\VendorController@status')->name('admin-vendor-status');

  //------------ Vendor SECTION ENDS------------

  //------------ Supplier SECTION ------------
  Route::get('/supplier/datatables', 'Admin\SupplierController@datatables')->name('admin-supplier-datatables');
  Route::get('/supplier', 'Admin\SupplierController@index')->name('admin-supplier-index');
  Route::get('/supplier/create', 'Admin\SupplierController@create')->name('admin-supplier-create');
  Route::post('/supplier/create', 'Admin\SupplierController@store')->name('admin-supplier-store');
  Route::get('/supplier/edit/{id}', 'Admin\SupplierController@show')->name('admin-supplier-show');
  Route::get('/supplier/delete/{id}', 'Admin\SupplierController@destroy')->name('admin-supplier-delete');


  });
  //------------ ADMIN SUBSCRIBERS SECTION ------------

  Route::get('/subscribers/datatables', 'Admin\SubscriberController@datatables')->name('admin-subs-datatables'); //JSON REQUEST
  Route::get('/subscribers', 'Admin\SubscriberController@index')->name('admin-subs-index');
  Route::get('/subscribers/download', 'Admin\SubscriberController@download')->name('admin-subs-download');  

  //------------ ADMIN SUBSCRIBERS ENDS ------------

});


// ************************************ ADMIN SECTION ENDS**********************************************

// ************************************ USER SECTION **********************************************

Route::prefix('user')->group(function() {

  // User Dashboard
  Route::get('/dashboard', 'User\UserController@index')->name('user-dashboard');

  // User Login
  Route::get('/login', 'User\LoginController@showLoginForm')->name('user.login');
  Route::post('/login', 'User\LoginController@login')->name('user.login.submit');
  // User Login End

  // User Register
  Route::get('/register', 'User\RegisterController@showRegisterForm')->name('user-register');
  Route::post('/register', 'User\RegisterController@register')->name('user-register-submit');
  Route::get('/register/verify/{token}', 'User\RegisterController@token')->name('user-register-token');
  // User Register End

  // User Reset 
  Route::get('/reset', 'User\UserController@resetform')->name('user-reset');
  Route::post('/reset', 'User\UserController@reset')->name('user-reset-submit');
  // User Reset End

  // User Profile 
  Route::get('/profile', 'User\UserController@profile')->name('user-profile'); 
  Route::post('/profile', 'User\UserController@profileupdate')->name('user-profile-update'); 
  // User Profile Ends

  // User Forgot
  Route::get('/forgot', 'User\ForgotController@showforgotform')->name('user-forgot');
  Route::post('/forgot', 'User\ForgotController@forgot')->name('user-forgot-submit');  
  // User Forgot Ends

  // User Wishlist
  Route::get('/wishlists','User\WishlistController@wishlists')->name('user-wishlists');
  Route::get('/wishlist/add/{id}','User\WishlistController@addwish')->name('user-wishlist-add');
  Route::get('/wishlist/remove/{id}','User\WishlistController@removewish')->name('user-wishlist-remove');
  // User Wishlist Ends

  // User Review
  Route::post('/review/submit','User\UserController@reviewsubmit')->name('front.review.submit');
  // User Review Ends

// User Orders

  Route::get('/orders', 'User\OrderController@orders')->name('user-orders'); 
  Route::get('/order/tracking', 'User\OrderController@ordertrack')->name('user-order-track');
  Route::get('/order/trackings/{id}', 'User\OrderController@trackload')->name('user-order-track-search');
  Route::get('/order/{id}', 'User\OrderController@order')->name('user-order');
  Route::get('/download/order/{slug}/{id}', 'User\OrderController@orderdownload')->name('user-order-download');
  Route::get('print/order/print/{id}', 'User\OrderController@orderprint')->name('user-order-print'); 
  Route::get('/json/trans','User\OrderController@trans');

// User Orders Ends

// User Admin Send Message


// Tickets
  Route::get('admin/tickets', 'User\MessageController@adminmessages')->name('user-message-index');
// Disputes  
  Route::get('admin/disputes', 'User\MessageController@adminDiscordmessages')->name('user-dmessage-index');

  Route::get('admin/message/{id}', 'User\MessageController@adminmessage')->name('user-message-show');
  Route::post('admin/message/post', 'User\MessageController@adminpostmessage')->name('user-message-store');
  Route::get('admin/message/{id}/delete', 'User\MessageController@adminmessagedelete')->name('user-message-delete1');   
  Route::post('admin/user/send/message', 'User\MessageController@adminusercontact')->name('user-send-message');
  Route::get('admin/message/load/{id}', 'User\MessageController@messageload')->name('user-message-load');
// User Admin Send Message Ends

  Route::get('/affilate/code', 'User\WithdrawController@affilate_code')->name('user-affilate-code');
  Route::get('/affilate/withdraw', 'User\WithdrawController@index')->name('user-wwt-index');
  Route::get('/affilate/withdraw/create', 'User\WithdrawController@create')->name('user-wwt-create');
  Route::post('/affilate/withdraw/create', 'User\WithdrawController@store')->name('user-wwt-store');

  // User Logout
  Route::get('/logout', 'User\LoginController@logout')->name('user-logout');
  // User Logout Ends

});

// ************************************ USER SECTION ENDS**********************************************


Route::get('admin/check/movescript', 'Admin\DashboardController@movescript')->name('admin-move-script');
Route::get('admin/generate/backup', 'Admin\DashboardController@generate_bkup')->name('admin-generate-backup');
Route::get('admin/activation', 'Admin\DashboardController@activation')->name('admin-activation-form');
Route::post('admin/activation', 'Admin\DashboardController@activation_submit')->name('admin-activate-purchase');
Route::get('admin/clear/backup', 'Admin\DashboardController@clear_bkup')->name('admin-clear-backup');

Route::post('the/genius/ocean/2441139', 'Front\FrontendController@subscription');
Route::get('finalize', 'Front\FrontendController@finalize');



// ************************************ FRONT SECTION **********************************************

  Route::get('/', 'Front\FrontendController@index')->name('front.index');
  Route::get('/extras', 'Front\FrontendController@extraIndex')->name('front.extraIndex');
  Route::get('/currency/{id}', 'Front\FrontendController@currency')->name('front.currency');
  Route::get('/language/{id}', 'Front\FrontendController@language')->name('front.language');

  // BLOG SECTION
  Route::get('/blog','Front\FrontendController@blog')->name('front.blog');
  Route::get('/blog/{id}','Front\FrontendController@blogshow')->name('front.blogshow');
  Route::get('/blog/category/{slug}','Front\FrontendController@blogcategory')->name('front.blogcategory');
  Route::get('/blog/tag/{slug}','Front\FrontendController@blogtags')->name('front.blogtags');  
  Route::get('/blog-search','Front\FrontendController@blogsearch')->name('front.blogsearch');
  Route::get('/blog/archive/{slug}','Front\FrontendController@blogarchive')->name('front.blogarchive');
  // BLOG SECTION ENDS

  // FAQ SECTION  
  Route::get('/faq','Front\FrontendController@faq')->name('front.faq');
  // FAQ SECTION ENDS

  // CONTACT SECTION  
  Route::get('/contact','Front\FrontendController@contact')->name('front.contact');
  Route::post('/contact','Front\FrontendController@contactemail')->name('front.contact.submit');
  Route::get('/contact/refresh_code','Front\FrontendController@refresh_code');
  // CONTACT SECTION  ENDS

  // PRODCT AUTO SEARCH SECTION  
  Route::get('/autosearch/product/{slug}','Front\FrontendController@autosearch');
  // PRODCT AUTO SEARCH SECTION ENDS

  // CATEGORY SECTION  
  Route::get('/category/{slug}','Front\CatalogController@category')->name('front.category');
  Route::get('/category/{slug1}/{slug2}','Front\CatalogController@subcategory')->name('front.subcat');
  Route::get('/category/{slug1}/{slug2}/{slug3}','Front\CatalogController@childcategory')->name('front.childcat');
  Route::get('/categories/','Front\CatalogController@categories')->name('front.categories');
  // CATEGORY SECTION ENDS

  // TAG SECTION
  Route::get('/tag/{slug}','Front\CatalogController@tag')->name('front.tag');
  // TAG SECTION ENDS

  // TAG SECTION
  Route::get('/search/','Front\CatalogController@search')->name('front.search');
  // TAG SECTION ENDS



  // PRODCT SECTION  
  Route::get('/item/{slug}','Front\CatalogController@product')->name('front.product');
  Route::get('/afbuy/{slug}','Front\CatalogController@affProductRedirect')->name('affiliate.product');
  Route::get('/item/quick/view/{id}/','Front\CatalogController@quick')->name('product.quick');
  Route::post('/item/review','Front\CatalogController@reviewsubmit')->name('front.review.submit');
  Route::get('/item/view/review/{id}','Front\CatalogController@reviews')->name('front.reviews');
  // PRODCT SECTION ENDS

  // COMMENT SECTION
  Route::post('/item/comment/store', 'Front\CatalogController@comment')->name('product.comment');
  Route::post('/item/comment/edit/{id}', 'Front\CatalogController@commentedit')->name('product.comment.edit');
  Route::get('/item/comment/delete/{id}', 'Front\CatalogController@commentdelete')->name('product.comment.delete');
  // COMMENT SECTION ENDS

  // REPORT SECTION
  Route::post('/item/report', 'Front\CatalogController@report')->name('product.report');
  // REPORT SECTION ENDS


  // COMPARE SECTION
  Route::get('/item/compare/view', 'Front\CompareController@compare')->name('product.compare');
  Route::get('/item/compare/add/{id}', 'Front\CompareController@addcompare')->name('product.compare.add');
  Route::get('/item/compare/remove/{id}', 'Front\CompareController@removecompare')->name('product.compare.remove');
  // COMPARE SECTION ENDS

  // REPLY SECTION 
  Route::post('/item/reply/{id}', 'Front\CatalogController@reply')->name('product.reply');  
  Route::post('/item/reply/edit/{id}', 'Front\CatalogController@replyedit')->name('product.reply.edit');
  Route::get('/item/reply/delete/{id}', 'Front\CatalogController@replydelete')->name('product.reply.delete');
  // REPLY SECTION ENDS

  // CART SECTION  
  Route::get('/carts/view','Front\CartController@cartview');
  Route::get('/carts/','Front\CartController@cart')->name('front.cart');
  Route::get('/addcart/{id}','Front\CartController@addcart')->name('product.cart.add');
  Route::get('/addtocart/{id}','Front\CartController@addtocart')->name('product.cart.quickadd');
  Route::get('/addnumcart','Front\CartController@addnumcart');
  Route::get('/addbyone','Front\CartController@addbyone');
  Route::get('/reducebyone','Front\CartController@reducebyone');
  Route::get('/upcolor','Front\CartController@upcolor');
  Route::get('/removecart/{id}','Front\CartController@removecart')->name('product.cart.remove');
  Route::get('/carts/coupon','Front\CartController@coupon');
  Route::get('/carts/coupon/check','Front\CartController@couponcheck');
  // CART SECTION ENDS

  // CHECKOUT SECTION  
  Route::get('/checkout/','Front\CheckoutController@checkout')->name('front.checkout');
  Route::get('/checkout/payment/{slug1}/{slug2}','Front\CheckoutController@loadpayment')->name('front.load.payment');
  Route::get('/order/track/{id}','Front\FrontendController@trackload')->name('front.track.search');
  Route::get('/checkout/payment/return', 'Front\PaymentController@payreturn')->name('payment.return');
  Route::get('/checkout/payment/cancle', 'Front\PaymentController@paycancle')->name('payment.cancle');
  Route::get('/checkout/payment/notify', 'Front\PaymentController@notify')->name('payment.notify');
  Route::get('/checkout/instamojo/notify', 'Front\InstamojoController@notify')->name('instamojo.notify');

  Route::post('/paystack/submit', 'Front\PaystackController@store')->name('paystack.submit');
  Route::post('/instamojo/submit', 'Front\InstamojoController@store')->name('instamojo.submit');
  Route::post('/paypal-submit', 'Front\PaymentController@store')->name('paypal.submit');
  Route::post('/stripe-submit', 'Front\StripeController@store')->name('stripe.submit');
  Route::post('/cashondelivery', 'Front\CheckoutController@cashondelivery')->name('cash.submit');
  Route::post('/gateway', 'Front\CheckoutController@gateway')->name('gateway.submit');
  // CHECKOUT SECTION ENDS

  // TAG SECTION
  Route::get('/search/','Front\CatalogController@search')->name('front.search');
  // TAG SECTION ENDS

  // SUBSCRIBE SECTION

  Route::post('/subscriber/store', 'Front\FrontendController@subscribe')->name('front.subscribe');

  // SUBSCRIBE SECTION ENDS


  // LOGIN WITH FACEBOOK OR GOOGLE SECTION  
  Route::get('auth/{provider}', 'User\SocialRegisterController@redirectToProvider')->name('social-provider');
  Route::get('auth/{provider}/callback', 'User\SocialRegisterController@handleProviderCallback');
  // LOGIN WITH FACEBOOK OR GOOGLE SECTION ENDS


  // PAGE SECTION
  Route::get('/{slug}','Front\FrontendController@page')->name('front.page');
  // PAGE SECTION ENDS
  
// ************************************ FRONT SECTION ENDS**********************************************