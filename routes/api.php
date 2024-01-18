<?php
use Illuminate\Http\Request;

Route::post('webhook', function(Request $request){
	\App\Jobs\ResolveWhatsappRequest::dispatch($request->all());
    logger($request->all());
	return response()->noContent();
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Departments
    Route::apiResource('departments', 'DepartmentsApiController');

    // Cities
    Route::apiResource('cities', 'CitiesApiController');

    // Devices
    Route::apiResource('devices', 'DevicesApiController');

    // Document Type
    Route::apiResource('document-types', 'DocumentTypeApiController');

    // Background Processes
    Route::post('background-processes/media', 'BackgroundProcessesApiController@storeMedia')->name('background-processes.storeMedia');
    Route::apiResource('background-processes', 'BackgroundProcessesApiController');

    // Reference Types
    Route::apiResource('reference-types', 'ReferenceTypesApiController');

    // Entities
    Route::apiResource('entities', 'EntitiesApiController');

    // Courses Hooks
    Route::post('courses-hooks/media', 'CoursesHooksApiController@storeMedia')->name('courses-hooks.storeMedia');
    Route::apiResource('courses-hooks', 'CoursesHooksApiController');

    // Courses
    Route::post('courses/media', 'CoursesApiController@storeMedia')->name('courses.storeMedia');
    Route::apiResource('courses', 'CoursesApiController');

    // Challenges
    Route::post('challenges/media', 'ChallengesApiController@storeMedia')->name('challenges.storeMedia');
    Route::apiResource('challenges', 'ChallengesApiController');

    // Course Schedules
    Route::apiResource('course-schedules', 'CourseSchedulesApiController');

    // Courses Users
    Route::post('courses-users/media', 'CoursesUsersApiController@storeMedia')->name('courses-users.storeMedia');
    Route::apiResource('courses-users', 'CoursesUsersApiController');

    // Challenges Users
    Route::post('challenges-users/media', 'ChallengesUsersApiController@storeMedia')->name('challenges-users.storeMedia');
    Route::apiResource('challenges-users', 'ChallengesUsersApiController');

    // Resources Categories
    Route::apiResource('resources-categories', 'ResourcesCategoriesApiController');

    // Resources Subcategories
    Route::apiResource('resources-subcategories', 'ResourcesSubcategoriesApiController');

    // Tag Category
    Route::apiResource('tag-categories', 'TagCategoryApiController');

    // Tag
    Route::apiResource('tags', 'TagApiController');

    // Resources
    Route::post('resources/media', 'ResourcesApiController@storeMedia')->name('resources.storeMedia');
    Route::apiResource('resources', 'ResourcesApiController');

    // Events Schedules
    Route::post('events-schedules/media', 'EventsSchedulesApiController@storeMedia')->name('events-schedules.storeMedia');
    Route::apiResource('events-schedules', 'EventsSchedulesApiController');

    // Events Attendants
    Route::apiResource('events-attendants', 'EventsAttendantsApiController');

    // Technical Referrers
    Route::apiResource('technical-referrers', 'TechnicalReferrersApiController');

    // Meetings
    Route::post('meetings/media', 'MeetingsApiController@storeMedia')->name('meetings.storeMedia');
    Route::apiResource('meetings', 'MeetingsApiController');

    // Meeting Attendants
    Route::apiResource('meeting-attendants', 'MeetingAttendantsApiController');

    // Self Interested Users
    Route::apiResource('self-interested-users', 'SelfInterestedUsersApiController');

    // Resources Audits
    Route::apiResource('resources-audits', 'ResourcesAuditsApiController');

    // Whatsapp Words
    Route::post('whatsapp-words/media', 'WhatsappWordsApiController@storeMedia')->name('whatsapp-words.storeMedia');
    Route::apiResource('whatsapp-words', 'WhatsappWordsApiController');

    // Profiles
    Route::apiResource('profiles', 'ProfilesApiController');

    // Banners
    Route::post('banners/media', 'BannersApiController@storeMedia')->name('banners.storeMedia');
    Route::apiResource('banners', 'BannersApiController');

    // User Fav Resources
    Route::apiResource('user-fav-resources', 'UserFavResourcesApiController');

    // Searches
    Route::apiResource('searches', 'SearchesApiController');

    // Close Image
    Route::post('close-images/media', 'CloseImageApiController@storeMedia')->name('close-images.storeMedia');
    Route::apiResource('close-images', 'CloseImageApiController');
});
