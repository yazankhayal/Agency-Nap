<?php
/**
 * Created by PhpStorm.
 * User: Napster
 * Date: 6/20/2020
 * Time: 5:17 PM
 */

// Dashboard
Route::group(['prefix' => 'dashboard', 'middleware' => 'dashboard'], function () {

    // Dashboard user_payment
    Route::group(['prefix' => '/user_payment'], function () {
        Route::get('/index', 'Dashboard\UserPaymentController@index')->name('dashboard_user_payment.index');
        Route::get('/eye/{id?}', 'Dashboard\UserPaymentController@eye')->name('dashboard_user_payment.eye');
        Route::get('/deleted', 'Dashboard\UserPaymentController@deleted')->name('dashboard_user_payment.deleted');
        Route::get('/details', 'Dashboard\UserPaymentController@details')->name('dashboard_user_payment.details');
        Route::post('/get_data', 'Dashboard\UserPaymentController@get_data')->name('dashboard_user_payment.get_data');
        Route::post('/edit', 'Dashboard\UserPaymentController@edit')->name('dashboard_user_payment.edit');
    });

    // Dashboard address
    Route::group(['prefix' => '/address'], function () {
        Route::get('', 'Dashboard\AddressController@index')->name('dashboard_address.index');
        Route::get('/add_edit/{id?}', 'Dashboard\AddressController@add_edit')->name('dashboard_address.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\AddressController@get_data_by_id')->name('dashboard_address.get_data_by_id');
        Route::get('/deleted', 'Dashboard\AddressController@deleted')->name('dashboard_address.deleted');
        Route::post('/get_data', 'Dashboard\AddressController@get_data')->name('dashboard_address.get_data');
        Route::post('/post_data', 'Dashboard\AddressController@post_data')->name('dashboard_address.post_data');
    });

    // Dashboard address_translate
    Route::group(['prefix' => '/address_translate'], function () {
        Route::post('/post_data', 'Dashboard\AddressTranslateController@post_data')->name('dashboard_address_translate.post_data');
        Route::get('/get_data', 'Dashboard\AddressTranslateController@get_data_by_id')->name('dashboard_address_translate.get_data_by_id');
    });

    // Dashboard payment_method
    Route::group(['prefix' => '/payment_method'], function () {
        Route::get('', 'Dashboard\PaymentMethodController@index')->name('dashboard_payment_method.index');
        Route::post('/post_data', 'Dashboard\PaymentMethodController@post_data')->name('dashboard_payment_method.post_data');
        Route::get('/get_data_by_id', 'Dashboard\PaymentMethodController@get_data_by_id')->name('dashboard_payment_method.get_data_by_id');
    });

    Route::get('/', 'Dashboard\DashboardController@index')->name('dashboard_admin.index');
    Route::get('/send_email', 'Dashboard\DashboardController@send_email')->name('dashboard_send_email.index');
    Route::get('/newsletter', 'Dashboard\DashboardController@newsletter')->name('dashboard_send_email.newsletter');

    Route::post('/send_email_send', 'Dashboard\DashboardController@send_email_send')->name('dashboard_send_email.send');
    Route::get('/dashboard/languages', 'Dashboard\DashboardController@languages')->name('dashboard_admin.languages');
    Route::get('/dashboard/languages_exption_em', 'Dashboard\DashboardController@languages_exption_em')->name('dashboard_admin.languages_exption_em');
    Route::get('/dashboard/currencies_dolar', 'Dashboard\DashboardController@currencies_dolar')->name('dashboard_admin.currencies_dolar');
    Route::post('/currency_conversions', 'Dashboard\DashboardController@currency_conversions')->name('dashboard_admin.currency_conversions');
    Route::get('/currency_save', 'Dashboard\DashboardController@currency')->name('dashboard_admin.currency');

    // Dashboard currency
    Route::group(['prefix' => '/currency'], function () {
        Route::get('/index', 'Dashboard\CurrencyController@index')->name('dashboard_currency.index');
        Route::get('/add_edit/{id?}', 'Dashboard\CurrencyController@add_edit')->name('dashboard_currency.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CurrencyController@get_data_by_id')->name('dashboard_currency.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CurrencyController@deleted')->name('dashboard_currency.deleted');
        Route::post('/get_data', 'Dashboard\CurrencyController@get_data')->name('dashboard_currency.get_data');
        Route::post('/post_data', 'Dashboard\CurrencyController@post_data')->name('dashboard_currency.post_data');
    });

    // Dashboard shipping_methods
    Route::group(['prefix' => '/shipping_methods'], function () {
        Route::get('/', 'Dashboard\ShippingmethodsController@index')->name('dashboard_shipping_methods.index');
        Route::get('/add_edit/{id?}', 'Dashboard\ShippingmethodsController@add_edit')->name('dashboard_shipping_methods.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\ShippingmethodsController@get_data_by_id')->name('dashboard_shipping_methods.get_data_by_id');
        Route::get('/deleted', 'Dashboard\ShippingmethodsController@deleted')->name('dashboard_shipping_methods.deleted');
        Route::post('/get_data', 'Dashboard\ShippingmethodsController@get_data')->name('dashboard_shipping_methods.get_data');
        Route::post('/post_data', 'Dashboard\ShippingmethodsController@post_data')->name('dashboard_shipping_methods.post_data');
    });

    // Dashboard Copuon
    Route::group(['prefix' => '/copuon'], function () {
        Route::get('/', 'Dashboard\CopuonController@index')->name('dashboard_copuon.index');
        Route::get('/add_edit/{id?}', 'Dashboard\CopuonController@add_edit')->name('dashboard_copuon.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CopuonController@get_data_by_id')->name('dashboard_copuon.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CopuonController@deleted')->name('dashboard_copuon.deleted');
        Route::post('/get_data', 'Dashboard\CopuonController@get_data')->name('dashboard_copuon.get_data');
        Route::post('/post_data', 'Dashboard\CopuonController@post_data')->name('dashboard_copuon.post_data');
    });

    // Dashboard country
    Route::group(['prefix' => '/country'], function () {
        Route::get('', 'Dashboard\CountryController@index')->name('dashboard_country.index');
        Route::get('/add_edit/{id?}', 'Dashboard\CountryController@add_edit')->name('dashboard_country.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CountryController@get_data_by_id')->name('dashboard_country.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CountryController@deleted')->name('dashboard_country.deleted');
        Route::post('/get_data', 'Dashboard\CountryController@get_data')->name('dashboard_country.get_data');
        Route::post('/post_data', 'Dashboard\CountryController@post_data')->name('dashboard_country.post_data');
        Route::post('/btn_import', 'Dashboard\CountryController@btn_import')->name('dashboard_country.btn_import');
    });

    // Dashboard users
    Route::group(['prefix' => '/users'], function () {
        Route::get('', 'Dashboard\UsersController@index')->name('dashboard_users.index');
        Route::get('/add_edit/{id?}', 'Dashboard\UsersController@add_edit')->name('dashboard_users.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\UsersController@get_data_by_id')->name('dashboard_users.get_data_by_id');
        Route::get('/deleted', 'Dashboard\UsersController@deleted')->name('dashboard_users.deleted');
        Route::post('/get_data', 'Dashboard\UsersController@get_data')->name('dashboard_users.get_data');
        Route::post('/post_data', 'Dashboard\UsersController@post_data')->name('dashboard_users.post_data');
        Route::get('/confirm_email', 'Dashboard\UsersController@confirm_email')->name('dashboard_users.confirm_email');
        Route::get('/suspended', 'Dashboard\UsersController@suspended')->name('dashboard_users.suspended');
    });

    // Dashboard language
    Route::group(['prefix' => '/language'], function () {
        Route::get('', 'Dashboard\LanguageController@index')->name('dashboard_language.index');
        Route::get('/lang/{id?}', 'Dashboard\LanguageController@lang')->name('dashboard_language.lang');
        Route::post('/lang_post', 'Dashboard\LanguageController@lang_post')->name('dashboard_language.lang_post');
        Route::get('/add_edit/{id?}', 'Dashboard\LanguageController@add_edit')->name('dashboard_language.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\LanguageController@get_data_by_id')->name('dashboard_language.get_data_by_id');
        Route::get('/deleted', 'Dashboard\LanguageController@deleted')->name('dashboard_language.deleted');
        Route::post('/get_data', 'Dashboard\LanguageController@get_data')->name('dashboard_language.get_data');
        Route::post('/post_data', 'Dashboard\LanguageController@post_data')->name('dashboard_language.post_data');
    });

    // Dashboard request_products
    Route::group(['prefix' => '/request_products'], function () {
        Route::get('/index', 'Dashboard\RequestProductsController@index')->name('dashboard_request_products.index');
        Route::get('/deleted', 'Dashboard\RequestProductsController@deleted')->name('dashboard_request_products.deleted');
        Route::get('/details', 'Dashboard\RequestProductsController@details')->name('dashboard_request_products.details');
        Route::get('/read', 'Dashboard\RequestProductsController@read')->name('dashboard_request_products.read');
        Route::post('/get_data', 'Dashboard\RequestProductsController@get_data')->name('dashboard_request_products.get_data');
    });

    // Dashboard setting
    Route::group(['prefix' => '/setting'], function () {
        Route::get('', 'Dashboard\SettingController@index')->name('dashboard_setting.index');
        Route::post('/post_data', 'Dashboard\SettingController@post_data')->name('dashboard_setting.post_data');
        Route::get('/get_data_by_id', 'Dashboard\SettingController@get_data_by_id')->name('dashboard_setting.get_data_by_id');
    });

    // Dashboard setting_translate
    Route::group(['prefix' => '/setting_translate'], function () {
        Route::post('/post_data', 'Dashboard\SettingTranslateController@post_data')->name('dashboard_setting_translate.post_data');
        Route::get('/get_data', 'Dashboard\SettingTranslateController@get_data_by_id')->name('dashboard_setting_translate.get_data_by_id');
    });

    // Dashboard posts
    Route::group(['prefix' => '/posts'], function () {
        Route::get('', 'Dashboard\PostsController@index')->name('dashboard_posts.index');
        Route::get('/add_edit/{id?}', 'Dashboard\PostsController@add_edit')->name('dashboard_posts.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\PostsController@get_data_by_id')->name('dashboard_posts.get_data_by_id');
        Route::get('/deleted', 'Dashboard\PostsController@deleted')->name('dashboard_posts.deleted');
        Route::post('/get_data', 'Dashboard\PostsController@get_data')->name('dashboard_posts.get_data');
        Route::post('/post_data', 'Dashboard\PostsController@post_data')->name('dashboard_posts.post_data');
        Route::get('/featured', 'Dashboard\PostsController@featured')->name('dashboard_posts.featured');
    });

    // Dashboard posts_translate
    Route::group(['prefix' => '/posts_translate'], function () {
        Route::post('/post_data', 'Dashboard\PostsTranslateController@post_data')->name('dashboard_posts_translate.post_data');
        Route::get('/get_data', 'Dashboard\PostsTranslateController@get_data_by_id')->name('dashboard_posts_translate.get_data_by_id');
    });

    // Dashboard category
    Route::group(['prefix' => '/category'], function () {
        Route::get('', 'Dashboard\CategoryController@index')->name('dashboard_category.index');
        Route::get('/add_edit/{id?}', 'Dashboard\CategoryController@add_edit')->name('dashboard_category.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CategoryController@get_data_by_id')->name('dashboard_category.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CategoryController@deleted')->name('dashboard_category.deleted');
        Route::get('/sort', 'Dashboard\CategoryController@sort')->name('dashboard_category.sort');
        Route::post('/get_data', 'Dashboard\CategoryController@get_data')->name('dashboard_category.get_data');
        Route::post('/post_data', 'Dashboard\CategoryController@post_data')->name('dashboard_category.post_data');
    });

    // Dashboard category_translate
    Route::group(['prefix' => '/category_translate'], function () {
        Route::post('/post_data', 'Dashboard\CategoryTranslateController@post_data')->name('dashboard_category_translate.post_data');
        Route::get('/get_data', 'Dashboard\CategoryTranslateController@get_data_by_id')->name('dashboard_category_translate.get_data_by_id');
    });

    // Dashboard city
    Route::group(['prefix' => '/city'], function () {
        Route::get('', 'Dashboard\CityController@index')->name('dashboard_city.index');
        Route::get('/add_edit/{id?}', 'Dashboard\CityController@add_edit')->name('dashboard_city.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CityController@get_data_by_id')->name('dashboard_city.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CityController@deleted')->name('dashboard_city.deleted');
        Route::post('/get_data', 'Dashboard\CityController@get_data')->name('dashboard_city.get_data');
        Route::post('/post_data', 'Dashboard\CityController@post_data')->name('dashboard_city.post_data');
    });

    // Dashboard city_translate
    Route::group(['prefix' => '/city_translate'], function () {
        Route::post('/post_data', 'Dashboard\CityTranslateController@post_data')->name('dashboard_city_translate.post_data');
        Route::get('/get_data', 'Dashboard\CityTranslateController@get_data_by_id')->name('dashboard_city_translate.get_data_by_id');
    });

    // Dashboard products
    Route::group(['prefix' => '/products'], function () {
        Route::get('', 'Dashboard\ProductsController@index')->name('dashboard_products.index');
        Route::get('/copy', 'Dashboard\ProductsController@copy')->name('dashboard_products.copy');
        Route::get('/add_edit/{id?}', 'Dashboard\ProductsController@add_edit')->name('dashboard_products.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\ProductsController@get_data_by_id')->name('dashboard_products.get_data_by_id');
        Route::get('/deleted', 'Dashboard\ProductsController@deleted')->name('dashboard_products.deleted');
        Route::post('/get_data', 'Dashboard\ProductsController@get_data')->name('dashboard_products.get_data');
        Route::post('/post_data', 'Dashboard\ProductsController@post_data')->name('dashboard_products.post_data');
        Route::get('/featured', 'Dashboard\ProductsController@featured')->name('dashboard_products.featured');
        Route::get('/trending', 'Dashboard\ProductsController@trending')->name('dashboard_products.trending');

        Route::post('/related_products', 'Dashboard\ProductsController@related_products')->name('dashboard_products.related_products');
        Route::post('/get_related_products', 'Dashboard\ProductsController@get_related_products')->name('dashboard_products.get_related_products');

        Route::post('/post_data_rating', 'Dashboard\ProductsController@post_data_rating')->name('dashboard_products.post_data_rating');

        Route::post('/uploadjquery', 'Dashboard\ProductsController@uploadjquery')->name('dashboard_products.uploadjquery');
        Route::get('/deleteuploadjquery', 'Dashboard\ProductsController@deleteuploadjquery')->name('dashboard_products.deleteuploadjquery');

        Route::get('/gallery/{id?}', 'Dashboard\ProductsController@gallery')->name('dashboard_products.gallery');
        Route::get('/attachments', 'Dashboard\GalleryProductsController@attachments')->name('dashboard_products.attachments');
        Route::get('/file_deleted/{id?}', 'Dashboard\GalleryProductsController@file_deleted')->name('dashboard_products.file_deleted');
        Route::get('/file_deleted_by_id/{id?}', 'Dashboard\GalleryProductsController@file_deleted_by_id')->name('dashboard_products.file_deleted_by_id');
        Route::post('/express_mail_file', 'Dashboard\GalleryProductsController@express_mail_file')->name('dashboard_products.certificate_file');
    });

    // Dashboard products_translate
    Route::group(['prefix' => '/products_translate'], function () {
        Route::post('/post_data', 'Dashboard\ProductsTranslateController@post_data')->name('dashboard_products_translate.post_data');
        Route::get('/get_data', 'Dashboard\ProductsTranslateController@get_data_by_id')->name('dashboard_products_translate.get_data_by_id');
    });

    // Dashboard testimonials
    Route::group(['prefix' => '/testimonials'], function () {
        Route::get('', 'Dashboard\TestimonialsController@index')->name('dashboard_testimonials.index');
        Route::get('/add_edit/{id?}', 'Dashboard\TestimonialsController@add_edit')->name('dashboard_testimonials.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\TestimonialsController@get_data_by_id')->name('dashboard_testimonials.get_data_by_id');
        Route::get('/deleted', 'Dashboard\TestimonialsController@deleted')->name('dashboard_testimonials.deleted');
        Route::post('/get_data', 'Dashboard\TestimonialsController@get_data')->name('dashboard_testimonials.get_data');
        Route::post('/post_data', 'Dashboard\TestimonialsController@post_data')->name('dashboard_testimonials.post_data');
    });

    // Dashboard testimonials_translate
    Route::group(['prefix' => '/testimonials_translate'], function () {
        Route::post('/post_data', 'Dashboard\TestimonialsTranslateController@post_data')->name('dashboard_testimonials_translate.post_data');
        Route::get('/get_data', 'Dashboard\TestimonialsTranslateController@get_data_by_id')->name('dashboard_testimonials_translate.get_data_by_id');
    });

    // Dashboard newsletter
    Route::group(['prefix' => '/newsletter'], function () {
        Route::get('', 'Dashboard\NewsletterController@index')->name('dashboard_newsletter.index');
        Route::get('/deleted', 'Dashboard\NewsletterController@deleted')->name('dashboard_newsletter.deleted');
        Route::post('/get_data', 'Dashboard\NewsletterController@get_data')->name('dashboard_newsletter.get_data');
    });

    // Dashboard contact_us
    Route::group(['prefix' => '/contact_us'], function () {
        Route::get('', 'Dashboard\ContactUSController@index')->name('dashboard_contact_us.index');
        Route::get('/deleted', 'Dashboard\ContactUSController@deleted')->name('dashboard_contact_us.deleted');
        Route::get('/details', 'Dashboard\ContactUSController@details')->name('dashboard_contact_us.details');
        Route::post('/get_data', 'Dashboard\ContactUSController@get_data')->name('dashboard_contact_us.get_data');
    });

    // Dashboard order
    Route::group(['prefix' => '/order'], function () {
        Route::get('/deleted', 'Dashboard\OrderController@deleted')->name('dashboard_order.deleted');
        Route::get('/details', 'Dashboard\OrderController@details')->name('dashboard_order.details');
        Route::post('/get_data', 'Dashboard\OrderController@get_data')->name('dashboard_order.get_data');
    });

    // Dashboard hp_words
    Route::group(['prefix' => '/hp_words'], function () {
        Route::get('', 'Dashboard\HPWordsController@index')->name('dashboard_hp_words.index');
        Route::post('/post_data', 'Dashboard\HPWordsController@post_data')->name('dashboard_hp_words.post_data');
        Route::get('/get_data_by_id', 'Dashboard\HPWordsController@get_data_by_id')->name('dashboard_hp_words.get_data_by_id');
    });

    // Dashboard hp_words_translate
    Route::group(['prefix' => '/hp_words_translate'], function () {
        Route::post('/post_data', 'Dashboard\HPWordsTranslateController@post_data')->name('dashboard_hp_words_translate.post_data');
        Route::get('/get_data', 'Dashboard\HPWordsTranslateController@get_data_by_id')->name('dashboard_hp_words_translate.get_data_by_id');
    });

    // Dashboard hp_contact_us
    Route::group(['prefix' => '/hp_contact_us'], function () {
        Route::get('', 'Dashboard\HPContactUSController@index')->name('dashboard_hp_contact_us.index');
        Route::post('/post_data', 'Dashboard\HPContactUSController@post_data')->name('dashboard_hp_contact_us.post_data');
        Route::get('/get_data_by_id', 'Dashboard\HPContactUSController@get_data_by_id')->name('dashboard_hp_contact_us.get_data_by_id');
    });

    // Dashboard forms
    Route::group(['prefix' => '/forms'], function () {
        Route::get('', 'Dashboard\FormsController@index')->name('dashboard_forms.index');
        Route::post('/post_data', 'Dashboard\FormsController@post_data')->name('dashboard_forms.post_data');
        Route::get('/get_data_by_id', 'Dashboard\FormsController@get_data_by_id')->name('dashboard_forms.get_data_by_id');
    });

    // Dashboard slider
    Route::group(['prefix' => '/slider'], function () {
        Route::get('', 'Dashboard\SliderController@index')->name('dashboard_slider.index');
        Route::get('/add_edit/{id?}', 'Dashboard\SliderController@add_edit')->name('dashboard_slider.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\SliderController@get_data_by_id')->name('dashboard_slider.get_data_by_id');
        Route::get('/deleted', 'Dashboard\SliderController@deleted')->name('dashboard_slider.deleted');
        Route::post('/get_data', 'Dashboard\SliderController@get_data')->name('dashboard_slider.get_data');
        Route::post('/post_data', 'Dashboard\SliderController@post_data')->name('dashboard_slider.post_data');
    });

    // Dashboard slider_translate
    Route::group(['prefix' => '/slider_translate'], function () {
        Route::post('/post_data', 'Dashboard\SliderTranslateController@post_data')->name('dashboard_slider_translate.post_data');
        Route::get('/get_data', 'Dashboard\SliderTranslateController@get_data_by_id')->name('dashboard_slider_translate.get_data_by_id');
    });

    // Dashboard contact_page
    Route::group(['prefix' => '/contact_page'], function () {
        Route::get('', 'Dashboard\Contact_pageController@index')->name('dashboard_contact_page.index');
        Route::post('/post_data', 'Dashboard\Contact_pageController@post_data')->name('dashboard_contact_page.post_data');
        Route::get('/get_data_by_id', 'Dashboard\Contact_pageController@get_data_by_id')->name('dashboard_contact_page.get_data_by_id');
    });

    // Dashboard contact_page_translate
    Route::group(['prefix' => '/contact_page_translate'], function () {
        Route::post('/post_data', 'Dashboard\Contact_pageTranslateController@post_data')->name('dashboard_contact_page_translate.post_data');
        Route::get('/get_data', 'Dashboard\Contact_pageTranslateController@get_data_by_id')->name('dashboard_contact_page_translate.get_data_by_id');
    });

    // Dashboard partners
    Route::group(['prefix' => '/partners'], function () {
        Route::get('', 'Dashboard\PartnersController@index')->name('dashboard_partners.index');
        Route::get('/attachments', 'Dashboard\PartnersController@attachments')->name('dashboard_partners.attachments');
        Route::get('/file_deleted/{id?}', 'Dashboard\PartnersController@file_deleted')->name('dashboard_partners.file_deleted');
        Route::get('/file_deleted_by_id/{id?}', 'Dashboard\PartnersController@file_deleted_by_id')->name('dashboard_partners.file_deleted_by_id');
        Route::post('/express_mail_file', 'Dashboard\PartnersController@express_mail_file')->name('dashboard_partners.certificate_file');
    });

    // Dashboard gallery
    Route::group(['prefix' => '/gallery'], function () {
        Route::get('', 'Dashboard\GalleryController@index')->name('dashboard_gallery.index');
        Route::get('/attachments', 'Dashboard\GalleryController@attachments')->name('dashboard_gallery.attachments');
        Route::get('/file_deleted/{id?}', 'Dashboard\GalleryController@file_deleted')->name('dashboard_gallery.file_deleted');
        Route::get('/file_deleted_by_id/{id?}', 'Dashboard\GalleryController@file_deleted_by_id')->name('dashboard_gallery.file_deleted_by_id');
        Route::post('/express_mail_file', 'Dashboard\GalleryController@express_mail_file')->name('dashboard_gallery.certificate_file');
    });


    // Dashboard about
    Route::group(['prefix' => '/about'], function () {
        Route::get('', 'Dashboard\AboutController@index')->name('dashboard_about.index');
        Route::post('/post_data', 'Dashboard\AboutController@post_data')->name('dashboard_about.post_data');
        Route::get('/get_data_by_id', 'Dashboard\AboutController@get_data_by_id')->name('dashboard_about.get_data_by_id');
    });

    // Dashboard about_translate
    Route::group(['prefix' => '/about_translate'], function () {
        Route::post('/post_data', 'Dashboard\AboutTranslateController@post_data')->name('dashboard_about_translate.post_data');
        Route::get('/get_data', 'Dashboard\AboutTranslateController@get_data_by_id')->name('dashboard_about_translate.get_data_by_id');
    });

    // Dashboard why
    Route::group(['prefix' => '/why'], function () {
        Route::get('', 'Dashboard\WhyController@index')->name('dashboard_why.index');
        Route::post('/post_data', 'Dashboard\WhyController@post_data')->name('dashboard_why.post_data');
        Route::get('/get_data_by_id', 'Dashboard\WhyController@get_data_by_id')->name('dashboard_why.get_data_by_id');
    });

    // Dashboard about_translate
    Route::group(['prefix' => '/why_translate'], function () {
        Route::post('/post_data', 'Dashboard\WhyTranslateController@post_data')->name('dashboard_why_translate.post_data');
        Route::get('/get_data', 'Dashboard\WhyTranslateController@get_data_by_id')->name('dashboard_why_translate.get_data_by_id');
    });

    // Dashboard fact
    Route::group(['prefix' => '/fact'], function () {
        Route::get('', 'Dashboard\factController@index')->name('dashboard_fact.index');
        Route::post('/post_data', 'Dashboard\factController@post_data')->name('dashboard_fact.post_data');
        Route::get('/get_data_by_id', 'Dashboard\factController@get_data_by_id')->name('dashboard_fact.get_data_by_id');
    });

    // Dashboard fact_translate
    Route::group(['prefix' => '/fact_translate'], function () {
        Route::post('/post_data', 'Dashboard\factTranslateController@post_data')->name('dashboard_fact_translate.post_data');
        Route::get('/get_data', 'Dashboard\factTranslateController@get_data_by_id')->name('dashboard_fact_translate.get_data_by_id');
    });

    //agency
    Route::group(['prefix' => '/agency'], function () {
        Route::get('', 'Dashboard\agencyController@index')->name('dashboard_agency.index');
        Route::post('/post_data', 'Dashboard\agencyController@post_data')->name('dashboard_agency.post_data');
        Route::get('/get_data_by_id', 'Dashboard\agencyController@get_data_by_id')->name('dashboard_agency.get_data_by_id');
    });

    // Dashboard agency_translate
    Route::group(['prefix' => '/agency_translate'], function () {
        Route::post('/post_data', 'Dashboard\agencyTranslateController@post_data')->name('dashboard_agency_translate.post_data');
        Route::get('/get_data', 'Dashboard\agencyTranslateController@get_data_by_id')->name('dashboard_agency_translate.get_data_by_id');
    });

    // Dashboard special
    Route::group(['prefix' => '/special'], function () {
        Route::get('', 'Dashboard\specialController@index')->name('dashboard_special.index');
        Route::post('/post_data', 'Dashboard\specialController@post_data')->name('dashboard_special.post_data');
        Route::get('/get_data_by_id', 'Dashboard\specialController@get_data_by_id')->name('dashboard_special.get_data_by_id');
    });

    // Dashboard special_translate
    Route::group(['prefix' => '/special_translate'], function () {
        Route::post('/post_data', 'Dashboard\specialTranslateController@post_data')->name('dashboard_special_translate.post_data');
        Route::get('/get_data', 'Dashboard\specialTranslateController@get_data_by_id')->name('dashboard_special_translate.get_data_by_id');
    });

    // Dashboard how_work
    Route::group(['prefix' => '/how_work'], function () {
        Route::get('', 'Dashboard\how_workController@index')->name('dashboard_how_work.index');
        Route::post('/post_data', 'Dashboard\how_workController@post_data')->name('dashboard_how_work.post_data');
        Route::get('/get_data_by_id', 'Dashboard\how_workController@get_data_by_id')->name('dashboard_how_work.get_data_by_id');
    });

    // Dashboard how_work_translate
    Route::group(['prefix' => '/how_work_translate'], function () {
        Route::post('/post_data', 'Dashboard\how_workTranslateController@post_data')->name('dashboard_how_work_translate.post_data');
        Route::get('/get_data', 'Dashboard\how_workTranslateController@get_data_by_id')->name('dashboard_how_work_translate.get_data_by_id');
    });

    // Dashboard about_list
    Route::group(['prefix' => '/about_list'], function () {
        Route::get('', 'Dashboard\AboutListController@index')->name('dashboard_about_list.index');
        Route::get('/add_edit/{id?}', 'Dashboard\AboutListController@add_edit')->name('dashboard_about_list.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\AboutListController@get_data_by_id')->name('dashboard_about_list.get_data_by_id');
        Route::get('/deleted', 'Dashboard\AboutListController@deleted')->name('dashboard_about_list.deleted');
        Route::post('/get_data', 'Dashboard\AboutListController@get_data')->name('dashboard_about_list.get_data');
        Route::post('/post_data', 'Dashboard\AboutListController@post_data')->name('dashboard_about_list.post_data');
    });

    // Dashboard about_list_translate
    Route::group(['prefix' => '/about_list_translate'], function () {
        Route::post('/post_data', 'Dashboard\AboutListTranslateController@post_data')->name('dashboard_about_list_translate.post_data');
        Route::get('/get_data', 'Dashboard\AboutListTranslateController@get_data_by_id')->name('dashboard_about_list_translate.get_data_by_id');
    });

    // Dashboard faqs
    Route::group(['prefix' => '/faqs'], function () {
        Route::get('', 'Dashboard\FAQSController@index')->name('dashboard_faqs.index');
        Route::get('/add_edit/{id?}', 'Dashboard\FAQSController@add_edit')->name('dashboard_faqs.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\FAQSController@get_data_by_id')->name('dashboard_faqs.get_data_by_id');
        Route::get('/deleted', 'Dashboard\FAQSController@deleted')->name('dashboard_faqs.deleted');
        Route::post('/get_data', 'Dashboard\FAQSController@get_data')->name('dashboard_faqs.get_data');
        Route::post('/post_data', 'Dashboard\FAQSController@post_data')->name('dashboard_faqs.post_data');
    });

    // Dashboard faqs
    Route::group(['prefix' => '/faqs_translate'], function () {
        Route::post('/post_data', 'Dashboard\FAQSTranslateController@post_data')->name('dashboard_faqs_translate.post_data');
        Route::get('/get_data', 'Dashboard\FAQSTranslateController@get_data_by_id')->name('dashboard_faqs_translate.get_data_by_id');
    });

    // Dashboard email_setting
    Route::group(['prefix' => '/email_setting'], function () {
        Route::get('', 'Dashboard\EmailSettingController@index')->name('dashboard_email_setting.index');
        Route::post('/post_data', 'Dashboard\EmailSettingController@post_data')->name('dashboard_email_setting.post_data');
        Route::get('/get_data_by_id', 'Dashboard\EmailSettingController@get_data_by_id')->name('dashboard_email_setting.get_data_by_id');
    });

    // Dashboard scripts
    Route::group(['prefix' => '/scripts'], function () {
        Route::get('', 'Dashboard\ScriptsSettingController@index')->name('dashboard_scripts.index');
        Route::post('/post_data', 'Dashboard\ScriptsSettingController@post_data')->name('dashboard_scripts.post_data');
        Route::get('/get_data_by_id', 'Dashboard\ScriptsSettingController@get_data_by_id')->name('dashboard_scripts.get_data_by_id');
    });

    // Dashboard adv_block
    Route::group(['prefix' => '/adv_block'], function () {
        Route::get('', 'Dashboard\AdvBlockController@index')->name('dashboard_adv_block.index');
        Route::post('/post_data', 'Dashboard\AdvBlockController@post_data')->name('dashboard_adv_block.post_data');
        Route::get('/get_data_by_id', 'Dashboard\AdvBlockController@get_data_by_id')->name('dashboard_adv_block.get_data_by_id');
    });

    // Dashboard banner
    Route::group(['prefix' => '/banner'], function () {
        Route::get('', 'Dashboard\BannerController@index')->name('dashboard_banner.index');
        Route::post('/post_data', 'Dashboard\BannerController@post_data')->name('dashboard_banner.post_data');
        Route::get('/get_data_by_id', 'Dashboard\BannerController@get_data_by_id')->name('dashboard_banner.get_data_by_id');
    });

    // Dashboard deal
    Route::group(['prefix' => '/edit_home_page'], function () {

        Route::get('/header_1', 'Dashboard\EditHomePageController@header_1')->name('dashboard_home_page.header_1');
        Route::get('/header_2', 'Dashboard\EditHomePageController@header_2')->name('dashboard_home_page.header_2');
        Route::get('/header_3', 'Dashboard\EditHomePageController@header_3')->name('dashboard_home_page.header_3');
        Route::get('/header_4', 'Dashboard\EditHomePageController@header_4')->name('dashboard_home_page.header_4');

        Route::get('/get_data_header_by_id', 'Dashboard\EditHomePageController@get_data_header_by_id')->name('dashboard_home_page.get_data_header_by_id');
        Route::get('/get_data_header2_by_id', 'Dashboard\EditHomePageController@get_data_header2_by_id')->name('dashboard_home_page.get_data_header2_by_id');
        Route::get('/get_data_header3_by_id', 'Dashboard\EditHomePageController@get_data_header3_by_id')->name('dashboard_home_page.get_data_header3_by_id');
        Route::get('/get_data_header4_by_id', 'Dashboard\EditHomePageController@get_data_header4_by_id')->name('dashboard_home_page.get_data_header4_by_id');
        Route::post('/post_header', 'Dashboard\EditHomePageController@post_header')->name('dashboard_home_page.post_header');


        Route::get('/sort', 'Dashboard\EditHomePageController@sort')->name('dashboard_home_page.sort');
        Route::get('/get_data_sort_by_id', 'Dashboard\EditHomePageController@get_data_sort_by_id')->name('dashboard_home_page.get_data_sort_by_id');
        Route::post('/post_sort', 'Dashboard\EditHomePageController@post_sort')->name('dashboard_home_page.post_sort');

        Route::get('/hot_tags', 'Dashboard\EditHomePageController@hot_tags')->name('dashboard_home_page.hot_tags');
        Route::get('/get_data_hot_tags_by_id', 'Dashboard\EditHomePageController@get_data_hot_tags_by_id')->name('dashboard_home_page.get_data_hot_tags_by_id');
        Route::get('/post_hot_tags', 'Dashboard\EditHomePageController@post_hot_tags')->name('dashboard_home_page.post_hot_tags');

        Route::get('/deal', 'Dashboard\EditHomePageController@deal')->name('dashboard_home_page.deal');
        Route::get('/deal_featured', 'Dashboard\EditHomePageController@deal_featured')->name('dashboard_home_page.deal_featured');
        Route::post('/get_data', 'Dashboard\EditHomePageController@get_data')->name('dashboard_home_page.get_data');

        Route::get('/last_products', 'Dashboard\EditHomePageController@last_products')->name('dashboard_home_page.last_products');
        Route::get('/deal_trending', 'Dashboard\EditHomePageController@deal_trending')->name('dashboard_home_page.deal_trending');
        Route::post('/get_data_last_products', 'Dashboard\EditHomePageController@get_data_last_products')->name('dashboard_home_page.get_data_last_products');

        Route::get('/our_products_1', 'Dashboard\EditHomePageController@our_products_1')->name('dashboard_home_page.our_products_1');
        Route::get('/our_products_2', 'Dashboard\EditHomePageController@our_products_2')->name('dashboard_home_page.our_products_2');
        Route::get('/our_products_3', 'Dashboard\EditHomePageController@our_products_3')->name('dashboard_home_page.our_products_3');
        Route::get('/our_trending_products_4', 'Dashboard\EditHomePageController@our_trending_products_4')->name('dashboard_home_page.our_trending_products_4');
        Route::get('/our_trending_products_5', 'Dashboard\EditHomePageController@our_trending_products_5')->name('dashboard_home_page.our_trending_products_5');
        Route::get('/our_trending_products_6', 'Dashboard\EditHomePageController@our_trending_products_6')->name('dashboard_home_page.our_trending_products_6');

        Route::get('/save_cat', 'Dashboard\EditHomePageController@save_cat')->name('dashboard_home_page.save_cat');
        Route::post('/get_products', 'Dashboard\EditHomePageController@get_products')->name('dashboard_home_page.get_products');
        Route::get('/save_pro', 'Dashboard\EditHomePageController@save_pro')->name('dashboard_home_page.save_pro');

    });

    // Dashboard colors
    Route::group(['prefix' => '/colors'], function () {
        Route::get('', 'Dashboard\ColorsController@index')->name('dashboard_colors.index');
        Route::get('/add_edit/{id?}', 'Dashboard\ColorsController@add_edit')->name('dashboard_colors.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\ColorsController@get_data_by_id')->name('dashboard_colors.get_data_by_id');
        Route::get('/deleted', 'Dashboard\ColorsController@deleted')->name('dashboard_colors.deleted');
        Route::post('/get_data', 'Dashboard\ColorsController@get_data')->name('dashboard_colors.get_data');
        Route::post('/post_data', 'Dashboard\ColorsController@post_data')->name('dashboard_colors.post_data');
    });

    // Dashboard sizes
    Route::group(['prefix' => '/sizes'], function () {
        Route::get('', 'Dashboard\SizesController@index')->name('dashboard_sizes.index');
        Route::get('/add_edit/{id?}', 'Dashboard\SizesController@add_edit')->name('dashboard_sizes.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\SizesController@get_data_by_id')->name('dashboard_sizes.get_data_by_id');
        Route::get('/deleted', 'Dashboard\SizesController@deleted')->name('dashboard_sizes.deleted');
        Route::post('/get_data', 'Dashboard\SizesController@get_data')->name('dashboard_sizes.get_data');
        Route::post('/post_data', 'Dashboard\SizesController@post_data')->name('dashboard_sizes.post_data');
    });

    // Dashboard category_portfolio
    Route::group(['prefix' => '/category_portfolio'], function () {
        Route::get('', 'Dashboard\category_portfolioController@index')->name('dashboard_category_portfolio.index');
        Route::get('/add_edit/{id?}', 'Dashboard\category_portfolioController@add_edit')->name('dashboard_category_portfolio.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\category_portfolioController@get_data_by_id')->name('dashboard_category_portfolio.get_data_by_id');
        Route::get('/deleted', 'Dashboard\category_portfolioController@deleted')->name('dashboard_category_portfolio.deleted');
        Route::post('/get_data', 'Dashboard\category_portfolioController@get_data')->name('dashboard_category_portfolio.get_data');
        Route::post('/post_data', 'Dashboard\category_portfolioController@post_data')->name('dashboard_category_portfolio.post_data');
    });

    // Dashboard category_portfolio_translate
    Route::group(['prefix' => '/category_portfolio_translate'], function () {
        Route::post('/post_data', 'Dashboard\category_portfolioTranslateController@post_data')->name('dashboard_category_portfolio_translate.post_data');
        Route::get('/get_data', 'Dashboard\category_portfolioTranslateController@get_data_by_id')->name('dashboard_category_portfolio_translate.get_data_by_id');
    });

    // Dashboard portfolio
    Route::group(['prefix' => '/portfolio'], function () {
        Route::get('', 'Dashboard\portfolioController@index')->name('dashboard_portfolio.index');
        Route::get('/add_edit/{id?}', 'Dashboard\portfolioController@add_edit')->name('dashboard_portfolio.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\portfolioController@get_data_by_id')->name('dashboard_portfolio.get_data_by_id');
        Route::get('/deleted', 'Dashboard\portfolioController@deleted')->name('dashboard_portfolio.deleted');
        Route::post('/get_data', 'Dashboard\portfolioController@get_data')->name('dashboard_portfolio.get_data');
        Route::post('/post_data', 'Dashboard\portfolioController@post_data')->name('dashboard_portfolio.post_data');
    });

    // Dashboard portfolio_translate
    Route::group(['prefix' => '/portfolio_translate'], function () {
        Route::post('/post_data', 'Dashboard\portfolioTranslateController@post_data')->name('dashboard_portfolio_translate.post_data');
        Route::get('/get_data', 'Dashboard\portfolioTranslateController@get_data_by_id')->name('dashboard_portfolio_translate.get_data_by_id');
    });
});
