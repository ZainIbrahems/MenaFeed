<?php

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Api\v1\AppointmentsController;
use App\Http\Controllers\Api\v1\BlogsController;
use App\Http\Controllers\Api\v1\BloodRequestController;
use App\Http\Controllers\Api\v1\ChatController;
use App\Http\Controllers\Api\v1\ConfigController;
use App\Http\Controllers\Api\v1\EServicesController;
use App\Http\Controllers\Api\v1\FeedController;
use App\Http\Controllers\Api\v1\JobsController;
use App\Http\Controllers\Api\v1\LiveController;
use App\Http\Controllers\Api\v1\MeetingController;
use App\Http\Controllers\Api\v1\PlatformController;
use App\Http\Controllers\Api\v1\MarketPlaceController;
use App\Http\Controllers\Api\v1\ProfessionalController;
use App\Http\Controllers\Api\v1\ProviderAwardController;
use App\Http\Controllers\Api\v1\ProviderCertificateController;
use App\Http\Controllers\Api\v1\ProviderCmeController;
use App\Http\Controllers\Api\v1\ProviderController;
use App\Http\Controllers\Api\v1\ProviderEducationController;
use App\Http\Controllers\Api\v1\ProviderExperienceController;
use App\Http\Controllers\Api\v1\ProviderMembershipController;
use App\Http\Controllers\Api\v1\ProviderPublicationController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\LiveStreamReactionController;
use App\Http\Controllers\Api\v1\LiveStreamCommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => ['api_lang']], function () {

    Route::get('/start', [ConfigController::class, 'start']);
    Route::get('/countries', [ConfigController::class, 'countries']);
    Route::get('/home-section/{id}', [ConfigController::class, 'home_section']);
    Route::get('/categories/{id}', [ConfigController::class, 'categories']);
    Route::get('/chat/last-message/{id}', [ChatController::class, 'getLastMessage']);
    Route::get('/chat-gpt', [ConfigController::class, 'chatGPT']);
    Route::get('/provider-types', [ConfigController::class, 'providerTypes']);
    Route::get('/platformsList', [ConfigController::class, 'platformsList']);
    Route::get('/categories/{provider_id}/{platform_id}', [ConfigController::class, 'categoriesList']);
    Route::get('/getSubCategories/{category_id}', [ConfigController::class, 'getSubCategories']);
    Route::get('/getSubSubCategories/{sub_category_id}', [ConfigController::class, 'getSubSubCategories']);
    Route::get('/getSpecialty/{sub_category_id}', [ConfigController::class, 'getSpecialty']);
    Route::post('/checkusername', [UserController::class, 'checkUserName']);
    Route::get('/send_code/{email}', [UserController::class, 'sendCodes']);
    Route::get('/out_api/{key}', [ApiController::class, 'api']);


    Route::group(['prefix' => 'users'], function () {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/register/send-code', [UserController::class, 'sendCode']);
        Route::post('/register/verify-code', [UserController::class, 'verifyCode']);
        Route::post('/forget-password', [UserController::class, 'forgetPassword']);
        Route::post('/reset-password', [UserController::class, 'resetPassword']);

        Route::post('/forget-verify-code', [UserController::class, 'forgetVerifyCode']);

    });

    Route::group(['prefix' => 'professional'], function () {
        Route::get('/get-all', [ProfessionalController::class, 'getAll']);
    });

    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/info', [BlogsController::class, 'getInfo']);
        Route::get('/all/{category_id?}', [BlogsController::class, 'getAll']);
        Route::get('/details/{id}', [BlogsController::class, 'getDetails']);
        Route::get('/provider/{provider_id}/{category_id?}', [BlogsController::class, 'provider']);
    });

    Route::group(['prefix' => 'jobs'], function () {
        Route::get('/info', [JobsController::class, 'getInfo']);
        Route::get('/all', [JobsController::class, 'getAll']);
        Route::get('/details/{id}', [JobsController::class, 'getDetails']);
    });

    Route::group(['prefix' => 'e-services'], function () {
        Route::get('/info', [EServicesController::class, 'getInfo']);
    });

    Route::group(['prefix' => 'blood-requests'], function () {
        Route::post('/send', [BloodRequestController::class, 'send']);
        Route::post('/call', [BloodRequestController::class, 'call']);
        Route::post('/direction', [BloodRequestController::class, 'direction']);
    });


    Route::group(['prefix' => 'live'], function () {
        Route::get('/live-categories', [LiveController::class, 'getLiveCategories']);
        Route::get('/upcoming-categories', [LiveController::class, 'getUpcomingCategories']);
        Route::get('/get-categories', [LiveController::class, 'getCategories']);
        Route::get('/info', [LiveController::class, 'info']);
        Route::get('/get-lives', [LiveController::class, 'getLives']);
        Route::get('/details/{code}', [LiveController::class, 'getLiveDetails']);
    });


    Route::group(['prefix' => 'feeds'], function () {
        Route::get('/get-all', [FeedController::class, 'getAll']);
        Route::get('/get-all/videos', [FeedController::class, 'withVideos']);
        Route::get('/comment', [FeedController::class, 'getComments']);
    });

    Route::group(['prefix' => 'meeting'], function () {
        Route::get('/start', [MeetingController::class, 'start']);
        Route::get('/my', [MeetingController::class, 'my']);
        Route::post('/save', [MeetingController::class, 'save']);
        Route::post('/edit', [MeetingController::class, 'edit']);
        Route::post('/delete', [MeetingController::class, 'delete']);
    });

    Route::group(['prefix' => 'platforms'], function () {
        Route::get('fields', [PlatformController::class, 'fields']);
        Route::get('data/{id?}', [PlatformController::class, 'data']);
        Route::get('plans/{id?}', [PlatformController::class, 'plans']);
        Route::get('sections/{id?}', [PlatformController::class, 'sections']);
        Route::get('categories/{platform_id?}', [PlatformController::class, 'categories']);
        Route::get('categories-select2/{platform_id?}', [PlatformController::class, 'categoriesSelect2'])->name('platform_categories');
        Route::get('category/{id?}', [PlatformController::class, 'category']);
        Route::get('sub-category/{id?}', [PlatformController::class, 'sub_category']);
        Route::get('sub-sub-category/{id?}', [PlatformController::class, 'sub_sub_category']);
    });
    Route::group(['prefix' => 'markets'], function () {
        //        Route::get('fields', [PlatformController::class, 'fields']);
//        Route::get('data/{id?}', [PlatformController::class, 'data']);
//        Route::get('plans/{id?}', [PlatformController::class, 'plans']);
//        Route::get('sections/{id?}', [PlatformController::class, 'sections']);
        Route::get('categories', [MarketPlaceController::class, 'categories']);
        //        Route::get('categories-select2/{platform_id?}', [PlatformController::class, 'categoriesSelect2'])->name('platform_categories');
        Route::get('category/{id?}', [MarketPlaceController::class, 'category']);
        Route::get('sub-category/{id?}', [MarketPlaceController::class, 'sub_category']);
        Route::get('sub-sub-category/{id?}', [MarketPlaceController::class, 'sub_sub_category']);
    });


    Route::group(['prefix' => 'providers'], function () {
        Route::get('', [ProviderController::class, 'list']);
        Route::get('details/{id}', [ProviderController::class, 'details']);
        Route::get('category-details', [ProviderController::class, 'categoryDetails']);

        Route::group(['prefix' => 'about'], function () {
            Route::post('edit', [ProviderController::class, 'updateProviderAbout']);
        });

        Route::group(['prefix' => 'personal_picture'], function () {
            Route::post('edit', [ProviderController::class, 'updateProviderImage']);
        });

        Route::group(['prefix' => 'educations'], function () {
            Route::post('', [ProviderEducationController::class, 'saveEducation']);
            Route::post('edit', [ProviderEducationController::class, 'editEducation']);
            Route::post('delete', [ProviderEducationController::class, 'deleteEducation']);
        });

        Route::group(['prefix' => 'experiences'], function () {
            Route::post('', [ProviderExperienceController::class, 'save']);
            Route::post('edit', [ProviderExperienceController::class, 'edit']);
            Route::post('delete', [ProviderExperienceController::class, 'delete']);
        });

        Route::group(['prefix' => 'cme'], function () {
            Route::post('', [ProviderCmeController::class, 'save']);
        });

        Route::group(['prefix' => 'publications'], function () {
            Route::post('', [ProviderPublicationController::class, 'save']);
            Route::post('edit', [ProviderPublicationController::class, 'edit']);
            Route::post('delete', [ProviderPublicationController::class, 'delete']);
        });

        Route::group(['prefix' => 'certificates'], function () {
            Route::post('', [ProviderCertificateController::class, 'save']);
            Route::post('edit', [ProviderCertificateController::class, 'edit']);
            Route::post('delete', [ProviderCertificateController::class, 'delete']);
        });

        Route::group(['prefix' => 'memberships'], function () {
            Route::post('', [ProviderMembershipController::class, 'save']);
            Route::post('edit', [ProviderMembershipController::class, 'edit']);
            Route::post('delete', [ProviderMembershipController::class, 'delete']);
        });

        Route::group(['prefix' => 'awards'], function () {
            Route::post('', [ProviderAwardController::class, 'save']);
            Route::post('edit', [ProviderAwardController::class, 'edit']);
            Route::post('delete', [ProviderAwardController::class, 'delete']);
        });
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::group(['prefix' => 'users'], function () {
            Route::get('/info', [UserController::class, 'info']);
            Route::post('/update', [UserController::class, 'update']);
            Route::post('/update-platform-fields', [UserController::class, 'updatePlatformFields']);
            Route::post('/logout', [UserController::class, 'logout']);
            Route::post('/delete', [UserController::class, 'delete']);
            Route::get('/all/{type}', [UserController::class, 'all']);
            Route::post('/follow', [UserController::class, 'follow']);
            Route::get('/counters', [UserController::class, 'counters']);
            Route::get('/test', [UserController::class, 'test']);
        });

        Route::group(['prefix' => 'chat'], function () {
            Route::post('/send', [ChatController::class, 'send']);
            Route::get('/get', [ChatController::class, 'get']);
            Route::get('/messages', [ChatController::class, 'messages']);
            Route::get('/online', [ChatController::class, 'online']);
            Route::post('/delete', [ChatController::class, 'delete']);
            Route::post('/mark-as-read', [ChatController::class, 'markAsRead']);
            Route::post('/report-to-mena', [ChatController::class, 'reportToMena']);
            Route::post('/block-user-chat', [ChatController::class, 'blockUserInChat']);
            Route::post('/clear-chat', [ChatController::class, 'clearChat']);
            Route::post('/my-contact', [ChatController::class, 'myContact']);
        });

        Route::group(['prefix' => 'blogs'], function () {
            Route::get('/my/{category_id?}', [BlogsController::class, 'my']);
            Route::post('/add', [BlogsController::class, 'add']);
            Route::post('/delete', [BlogsController::class, 'delete']);
            Route::post('/like', [BlogsController::class, 'like']);
            Route::post('/share', [BlogsController::class, 'share']);
        });

        Route::group(['prefix' => 'jobs'], function () {
            Route::get('/my', [JobsController::class, 'my']);
            Route::post('/add', [JobsController::class, 'add']);
            Route::post('/delete', [JobsController::class, 'delete']);
            Route::post('/like', [JobsController::class, 'like']);
        });

        Route::group(['prefix' => 'feeds'], function () {
            Route::get('/get', [FeedController::class, 'get']);
            Route::post('/post', [FeedController::class, 'send']);
            Route::post('/update', [FeedController::class, 'update']);
            Route::post('/delete', [FeedController::class, 'delete']);
            Route::post('/comment', [FeedController::class, 'saveComment']);
            Route::post('/report', [FeedController::class, 'saveReport']);
            Route::post('/comment/like', [FeedController::class, 'likeComment']);
            Route::post('/comment/delete', [FeedController::class, 'deleteComment']);
            Route::post('/like', [FeedController::class, 'like']);
        });

        Route::group(['prefix' => 'professional'], function () {
            Route::get('/get-my', [ProfessionalController::class, 'getMy']);
        });

        Route::group(['prefix' => 'live'], function () {
            Route::post('/go-live', [LiveController::class, 'goLive']);
            Route::post('/set-live', [LiveController::class, 'setLive']);
            Route::post('/set-not-live', [LiveController::class, 'setNotLive']);
            Route::post('/report', [LiveController::class, 'report']);
            Route::post('/react', [LiveStreamReactionController::class, 'store']);
            Route::delete('/react/delete', [LiveStreamReactionController::class, 'destroy']);
            Route::post('/comment', [LiveStreamCommentController::class, 'store']);
            Route::delete('/comment/delete', [LiveStreamCommentController::class, 'destroy']);
        });

        Route::group(['prefix' => 'appointments'], function () {
            Route::post('/search', [AppointmentsController::class, 'search']);
            Route::post('/insurance_providers', [AppointmentsController::class, 'insurance_providers']);
            Route::post('/slots', [AppointmentsController::class, 'slots']);
            Route::post('/save', [AppointmentsController::class, 'save']);


            Route::get('/client-appointments', [AppointmentsController::class, 'clientAppointments']);
            Route::get('/my-slots', [AppointmentsController::class, 'mySlots']);
            Route::get('/history', [AppointmentsController::class, 'history']);
            Route::post('/slots/delete', [AppointmentsController::class, 'slotsDelete']);
            Route::post('/client-appointments/update', [AppointmentsController::class, 'clientAppointmentsUpdate']);


            Route::post('/slots/prof-fac', [AppointmentsController::class, 'slotProfFac']);
            Route::post('/slots/create', [AppointmentsController::class, 'slotCreate']);
            Route::post('/slots/update', [AppointmentsController::class, 'slotUpdate']);
        });
    });
});

