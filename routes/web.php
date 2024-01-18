<?php
  
use App\Http\Controllers\Cpe\ResourcesSearchController;
//Route::redirect('/', '/login');
Route::view('/', 'welcome',['counter' => App\Models\User::get()->count()+App\Models\SelfInterestedUser::get()->count()]);
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});
Route::get('ftp',function(){
    $files = Storage::disk('ftp')->allfiles();
    dd($files);
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::post('permissions/parse-csv-import', 'PermissionsController@parseCsvImport')->name('permissions.parseCsvImport');
    Route::post('permissions/process-csv-import', 'PermissionsController@processCsvImport')->name('permissions.processCsvImport');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::post('roles/parse-csv-import', 'RolesController@parseCsvImport')->name('roles.parseCsvImport');
    Route::post('roles/process-csv-import', 'RolesController@processCsvImport')->name('roles.processCsvImport');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Departments
    Route::delete('departments/destroy', 'DepartmentsController@massDestroy')->name('departments.massDestroy');
    Route::post('departments/parse-csv-import', 'DepartmentsController@parseCsvImport')->name('departments.parseCsvImport');
    Route::post('departments/process-csv-import', 'DepartmentsController@processCsvImport')->name('departments.processCsvImport');
    Route::resource('departments', 'DepartmentsController');

    // Cities
    Route::delete('cities/destroy', 'CitiesController@massDestroy')->name('cities.massDestroy');
    Route::post('cities/parse-csv-import', 'CitiesController@parseCsvImport')->name('cities.parseCsvImport');
    Route::post('cities/process-csv-import', 'CitiesController@processCsvImport')->name('cities.processCsvImport');
    Route::resource('cities', 'CitiesController');

    // Devices
    Route::delete('devices/destroy', 'DevicesController@massDestroy')->name('devices.massDestroy');
    Route::post('devices/parse-csv-import', 'DevicesController@parseCsvImport')->name('devices.parseCsvImport');
    Route::post('devices/process-csv-import', 'DevicesController@processCsvImport')->name('devices.processCsvImport');
    Route::resource('devices', 'DevicesController');

    // Document Type
    Route::delete('document-types/destroy', 'DocumentTypeController@massDestroy')->name('document-types.massDestroy');
    Route::post('document-types/parse-csv-import', 'DocumentTypeController@parseCsvImport')->name('document-types.parseCsvImport');
    Route::post('document-types/process-csv-import', 'DocumentTypeController@processCsvImport')->name('document-types.processCsvImport');
    Route::resource('document-types', 'DocumentTypeController');

    // Background Processes
    Route::delete('background-processes/destroy', 'BackgroundProcessesController@massDestroy')->name('background-processes.massDestroy');
    Route::post('background-processes/media', 'BackgroundProcessesController@storeMedia')->name('background-processes.storeMedia');
    Route::post('background-processes/ckmedia', 'BackgroundProcessesController@storeCKEditorImages')->name('background-processes.storeCKEditorImages');
    Route::post('background-processes/parse-csv-import', 'BackgroundProcessesController@parseCsvImport')->name('background-processes.parseCsvImport');
    Route::post('background-processes/process-csv-import', 'BackgroundProcessesController@processCsvImport')->name('background-processes.processCsvImport');
    Route::resource('background-processes', 'BackgroundProcessesController');

    // Reference Types
    Route::delete('reference-types/destroy', 'ReferenceTypesController@massDestroy')->name('reference-types.massDestroy');
    Route::post('reference-types/parse-csv-import', 'ReferenceTypesController@parseCsvImport')->name('reference-types.parseCsvImport');
    Route::post('reference-types/process-csv-import', 'ReferenceTypesController@processCsvImport')->name('reference-types.processCsvImport');
    Route::resource('reference-types', 'ReferenceTypesController');

    // Entities
    Route::delete('entities/destroy', 'EntitiesController@massDestroy')->name('entities.massDestroy');
    Route::post('entities/parse-csv-import', 'EntitiesController@parseCsvImport')->name('entities.parseCsvImport');
    Route::post('entities/process-csv-import', 'EntitiesController@processCsvImport')->name('entities.processCsvImport');
    Route::resource('entities', 'EntitiesController');

    // Courses Hooks
    Route::delete('courses-hooks/destroy', 'CoursesHooksController@massDestroy')->name('courses-hooks.massDestroy');
    Route::post('courses-hooks/media', 'CoursesHooksController@storeMedia')->name('courses-hooks.storeMedia');
    Route::post('courses-hooks/ckmedia', 'CoursesHooksController@storeCKEditorImages')->name('courses-hooks.storeCKEditorImages');
    Route::post('courses-hooks/parse-csv-import', 'CoursesHooksController@parseCsvImport')->name('courses-hooks.parseCsvImport');
    Route::post('courses-hooks/process-csv-import', 'CoursesHooksController@processCsvImport')->name('courses-hooks.processCsvImport');
    Route::resource('courses-hooks', 'CoursesHooksController');
    Route::get('chooks-hide', 'CoursesHooksController@hide')->name('courses-hooks.hide');

    // Courses
    Route::delete('courses/destroy', 'CoursesController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/media', 'CoursesController@storeMedia')->name('courses.storeMedia');
    Route::post('courses/ckmedia', 'CoursesController@storeCKEditorImages')->name('courses.storeCKEditorImages');
    Route::post('courses/parse-csv-import', 'CoursesController@parseCsvImport')->name('courses.parseCsvImport');
    Route::post('courses/process-csv-import', 'CoursesController@processCsvImport')->name('courses.processCsvImport');
    Route::resource('courses', 'CoursesController');
    Route::get('courses-hide', 'CoursesController@hide')->name('courses.hide');

    // Challenges
    Route::delete('challenges/destroy', 'ChallengesController@massDestroy')->name('challenges.massDestroy');
    Route::post('challenges/media', 'ChallengesController@storeMedia')->name('challenges.storeMedia');
    Route::post('challenges/ckmedia', 'ChallengesController@storeCKEditorImages')->name('challenges.storeCKEditorImages');
    Route::post('challenges/parse-csv-import', 'ChallengesController@parseCsvImport')->name('challenges.parseCsvImport');
    Route::post('challenges/process-csv-import', 'ChallengesController@processCsvImport')->name('challenges.processCsvImport');
    Route::resource('challenges', 'ChallengesController');

    // Course Schedules
    Route::delete('course-schedules/destroy', 'CourseSchedulesController@massDestroy')->name('course-schedules.massDestroy');
    Route::post('course-schedules/parse-csv-import', 'CourseSchedulesController@parseCsvImport')->name('course-schedules.parseCsvImport');
    Route::post('course-schedules/process-csv-import', 'CourseSchedulesController@processCsvImport')->name('course-schedules.processCsvImport');
    Route::resource('course-schedules', 'CourseSchedulesController');

    // Courses Users
    Route::delete('courses-users/destroy', 'CoursesUsersController@massDestroy')->name('courses-users.massDestroy');
    Route::post('courses-users/media', 'CoursesUsersController@storeMedia')->name('courses-users.storeMedia');
    Route::post('courses-users/ckmedia', 'CoursesUsersController@storeCKEditorImages')->name('courses-users.storeCKEditorImages');
    Route::post('courses-users/parse-csv-import', 'CoursesUsersController@parseCsvImport')->name('courses-users.parseCsvImport');
    Route::post('courses-users/process-csv-import', 'CoursesUsersController@processCsvImport')->name('courses-users.processCsvImport');
    Route::resource('courses-users', 'CoursesUsersController');

    // Challenges Users
    Route::delete('challenges-users/destroy', 'ChallengesUsersController@massDestroy')->name('challenges-users.massDestroy');
    Route::post('challenges-users/media', 'ChallengesUsersController@storeMedia')->name('challenges-users.storeMedia');
    Route::post('challenges-users/ckmedia', 'ChallengesUsersController@storeCKEditorImages')->name('challenges-users.storeCKEditorImages');
    Route::post('challenges-users/parse-csv-import', 'ChallengesUsersController@parseCsvImport')->name('challenges-users.parseCsvImport');
    Route::post('challenges-users/process-csv-import', 'ChallengesUsersController@processCsvImport')->name('challenges-users.processCsvImport');
    Route::resource('challenges-users', 'ChallengesUsersController');

    // Resources Categories
    Route::delete('resources-categories/destroy', 'ResourcesCategoriesController@massDestroy')->name('resources-categories.massDestroy');
    Route::post('resources-categories/parse-csv-import', 'ResourcesCategoriesController@parseCsvImport')->name('resources-categories.parseCsvImport');
    Route::post('resources-categories/process-csv-import', 'ResourcesCategoriesController@processCsvImport')->name('resources-categories.processCsvImport');
    Route::resource('resources-categories', 'ResourcesCategoriesController');

    // Resources Subcategories
    Route::delete('resources-subcategories/destroy', 'ResourcesSubcategoriesController@massDestroy')->name('resources-subcategories.massDestroy');
    Route::post('resources-subcategories/parse-csv-import', 'ResourcesSubcategoriesController@parseCsvImport')->name('resources-subcategories.parseCsvImport');
    Route::post('resources-subcategories/process-csv-import', 'ResourcesSubcategoriesController@processCsvImport')->name('resources-subcategories.processCsvImport');
    Route::resource('resources-subcategories', 'ResourcesSubcategoriesController');

    // Tag Category
    Route::delete('tag-categories/destroy', 'TagCategoryController@massDestroy')->name('tag-categories.massDestroy');
    Route::post('tag-categories/parse-csv-import', 'TagCategoryController@parseCsvImport')->name('tag-categories.parseCsvImport');
    Route::post('tag-categories/process-csv-import', 'TagCategoryController@processCsvImport')->name('tag-categories.processCsvImport');
    Route::resource('tag-categories', 'TagCategoryController');

    // Tag
    Route::delete('tags/destroy', 'TagController@massDestroy')->name('tags.massDestroy');
    Route::post('tags/parse-csv-import', 'TagController@parseCsvImport')->name('tags.parseCsvImport');
    Route::post('tags/process-csv-import', 'TagController@processCsvImport')->name('tags.processCsvImport');
    Route::resource('tags', 'TagController');

    // Resources
    Route::delete('resources/destroy', 'ResourcesController@massDestroy')->name('resources.massDestroy');
    Route::post('resources/media', 'ResourcesController@storeMedia')->name('resources.storeMedia');
    Route::post('resources/ckmedia', 'ResourcesController@storeCKEditorImages')->name('resources.storeCKEditorImages');
    Route::post('resources/parse-csv-import', 'ResourcesController@parseCsvImport')->name('resources.parseCsvImport');
    Route::post('resources/process-csv-import', 'ResourcesController@processCsvImport')->name('resources.processCsvImport');
    Route::resource('resources', 'ResourcesController');

    // Events Schedules
    Route::delete('events-schedules/destroy', 'EventsSchedulesController@massDestroy')->name('events-schedules.massDestroy');
    Route::post('events-schedules/media', 'EventsSchedulesController@storeMedia')->name('events-schedules.storeMedia');
    Route::post('events-schedules/ckmedia', 'EventsSchedulesController@storeCKEditorImages')->name('events-schedules.storeCKEditorImages');
    Route::post('events-schedules/parse-csv-import', 'EventsSchedulesController@parseCsvImport')->name('events-schedules.parseCsvImport');
    Route::post('events-schedules/process-csv-import', 'EventsSchedulesController@processCsvImport')->name('events-schedules.processCsvImport');
    Route::resource('events-schedules', 'EventsSchedulesController');

    // Events Attendants
    Route::delete('events-attendants/destroy', 'EventsAttendantsController@massDestroy')->name('events-attendants.massDestroy');
    Route::post('events-attendants/parse-csv-import', 'EventsAttendantsController@parseCsvImport')->name('events-attendants.parseCsvImport');
    Route::post('events-attendants/process-csv-import', 'EventsAttendantsController@processCsvImport')->name('events-attendants.processCsvImport');
    Route::resource('events-attendants', 'EventsAttendantsController');

    // Technical Referrers
    Route::delete('technical-referrers/destroy', 'TechnicalReferrersController@massDestroy')->name('technical-referrers.massDestroy');
    Route::post('technical-referrers/parse-csv-import', 'TechnicalReferrersController@parseCsvImport')->name('technical-referrers.parseCsvImport');
    Route::post('technical-referrers/process-csv-import', 'TechnicalReferrersController@processCsvImport')->name('technical-referrers.processCsvImport');
    Route::resource('technical-referrers', 'TechnicalReferrersController');

    // Meetings
    Route::delete('meetings/destroy', 'MeetingsController@massDestroy')->name('meetings.massDestroy');
    Route::post('meetings/media', 'MeetingsController@storeMedia')->name('meetings.storeMedia');
    Route::post('meetings/ckmedia', 'MeetingsController@storeCKEditorImages')->name('meetings.storeCKEditorImages');
    Route::resource('meetings', 'MeetingsController');
    Route::get('meetings-hide', 'MeetingsController@hide')->name('meetings.hide');

    // Meeting Attendants
    Route::delete('meeting-attendants/destroy', 'MeetingAttendantsController@massDestroy')->name('meeting-attendants.massDestroy');
    Route::post('meeting-attendants/parse-csv-import', 'MeetingAttendantsController@parseCsvImport')->name('meeting-attendants.parseCsvImport');
    Route::post('meeting-attendants/process-csv-import', 'MeetingAttendantsController@processCsvImport')->name('meeting-attendants.processCsvImport');
    Route::resource('meeting-attendants', 'MeetingAttendantsController');

    // Self Interested Users
    Route::delete('self-interested-users/destroy', 'SelfInterestedUsersController@massDestroy')->name('self-interested-users.massDestroy');
    Route::post('self-interested-users/parse-csv-import', 'SelfInterestedUsersController@parseCsvImport')->name('self-interested-users.parseCsvImport');
    Route::post('self-interested-users/process-csv-import', 'SelfInterestedUsersController@processCsvImport')->name('self-interested-users.processCsvImport');
    Route::resource('self-interested-users', 'SelfInterestedUsersController');
    Route::get('empty-interested-users', 'SelfInterestedUsersController@softTruncate')->name('empty-interested-users');

    // Resources Audits
    Route::delete('resources-audits/destroy', 'ResourcesAuditsController@massDestroy')->name('resources-audits.massDestroy');
    Route::post('resources-audits/parse-csv-import', 'ResourcesAuditsController@parseCsvImport')->name('resources-audits.parseCsvImport');
    Route::post('resources-audits/process-csv-import', 'ResourcesAuditsController@processCsvImport')->name('resources-audits.processCsvImport');
    Route::resource('resources-audits', 'ResourcesAuditsController');

    // Educational Bg Reports
    Route::delete('educational-bg-reports/destroy', 'EducationalBgReportsController@massDestroy')->name('educational-bg-reports.massDestroy');
    Route::resource('educational-bg-reports', 'EducationalBgReportsController');
    Route::resource('ver-reporte-ciclo', 'CourseReportsController');


    // Whatsapp Words
    Route::delete('whatsapp-words/destroy', 'WhatsappWordsController@massDestroy')->name('whatsapp-words.massDestroy');
    Route::post('whatsapp-words/media', 'WhatsappWordsController@storeMedia')->name('whatsapp-words.storeMedia');
    Route::post('whatsapp-words/ckmedia', 'WhatsappWordsController@storeCKEditorImages')->name('whatsapp-words.storeCKEditorImages');
    Route::post('whatsapp-words/parse-csv-import', 'WhatsappWordsController@parseCsvImport')->name('whatsapp-words.parseCsvImport');
    Route::post('whatsapp-words/process-csv-import', 'WhatsappWordsController@processCsvImport')->name('whatsapp-words.processCsvImport');
    Route::resource('whatsapp-words', 'WhatsappWordsController');

    // Profiles
    Route::delete('profiles/destroy', 'ProfilesController@massDestroy')->name('profiles.massDestroy');
    Route::post('profiles/parse-csv-import', 'ProfilesController@parseCsvImport')->name('profiles.parseCsvImport');
    Route::post('profiles/process-csv-import', 'ProfilesController@processCsvImport')->name('profiles.processCsvImport');
    Route::resource('profiles', 'ProfilesController');

    // Banners
    Route::delete('banners/destroy', 'BannersController@massDestroy')->name('banners.massDestroy');
    Route::post('banners/media', 'BannersController@storeMedia')->name('banners.storeMedia');
    Route::post('banners/ckmedia', 'BannersController@storeCKEditorImages')->name('banners.storeCKEditorImages');
    Route::resource('banners', 'BannersController');

    // User Fav Resources
    Route::delete('user-fav-resources/destroy', 'UserFavResourcesController@massDestroy')->name('user-fav-resources.massDestroy');
    Route::post('user-fav-resources/parse-csv-import', 'UserFavResourcesController@parseCsvImport')->name('user-fav-resources.parseCsvImport');
    Route::post('user-fav-resources/process-csv-import', 'UserFavResourcesController@processCsvImport')->name('user-fav-resources.processCsvImport');
    Route::resource('user-fav-resources', 'UserFavResourcesController');

    // Searches
    Route::delete('searches/destroy', 'SearchesController@massDestroy')->name('searches.massDestroy');
    Route::post('searches/parse-csv-import', 'SearchesController@parseCsvImport')->name('searches.parseCsvImport');
    Route::post('searches/process-csv-import', 'SearchesController@processCsvImport')->name('searches.processCsvImport');
    Route::resource('searches', 'SearchesController');

    // Close Image
    Route::delete('close-images/destroy', 'CloseImageController@massDestroy')->name('close-images.massDestroy');
    Route::post('close-images/media', 'CloseImageController@storeMedia')->name('close-images.storeMedia');
    Route::post('close-images/ckmedia', 'CloseImageController@storeCKEditorImages')->name('close-images.storeCKEditorImages');
    Route::resource('close-images', 'CloseImageController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});

Route::group(['as' => 'cpe.', 'namespace' => 'Cpe', 'middleware' => ['auth']], function () {
	
//	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('mi-perfil', 'ProfileController');
	Route::resource('editar-perfil', 'EditProfileController');
    Route::resource('reto-unico', 'UniqueChallengesController');
	Route::post('preferencias-ciclo', 'CoursesPreferencesController@guardarPreferencias')->name('preferencias-ciclo.guardarPreferencias');
//	Route::resource('tipo-ciclo', 'CourseTypeController');
	Route::resource('mostrar-ciclo', 'CourseShowController');
	Route::post('resultado-busqueda-temas', 'ResultadoBusquedaTemasController@index')->name('resultado-busqueda-temas');
	Route::post('resultado-busqueda-encuentros', 'ResultadoBusquedaEncuentrosController@index')->name('resultado-busqueda-encuentros');
	Route::resource('crear-encuentro', 'MeetingsCreationController');
	Route::resource('unirme-encuentro', 'MeetingsRegistrationController');
	Route::post('actualizar-perfil', 'UpdateProfileController@index')->name('actualizar-perfil');
    Route::resource('inscripcion-ciclo', 'CoursesRegisterController');
	
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Route::resource('ofertas-formacion', 'Cpe\CoursesHookViewController');
Route::post('busquedaOfertas', 'Cpe\CoursesHookViewController@search')->name('cpe.busquedaOfertas');
Route::post('inscribirOfertas', 'Cpe\CoursesHookViewController@store')->name('cpe.inscribirOfertas');
Route::get('cities/get_by_department', 'Admin\CitiesController@get_by_department')->name('admin.cities.get_by_department');
Route::get('subcategory/get_by_category', 'Admin\ResourcesSubcategoriesController@get_by_category')->name('admin.subcategory.get_by_category');
Route::resource('ciclos-retos', 'Cpe\BackgroundProcessController');
Route::resource('eventos-encuentros', 'Cpe\CommunityLearningController');
Route::resource('eventos-institucionales', 'Cpe\IncomingEventsController');
Route::resource('memorias-grabaciones', 'Cpe\PastEventsController');
Route::resource('encuentros-practica', 'Cpe\MeetingsViewController');
Route::resource('recursos', 'Cpe\ResourcesCategoriesController');
Route::get('resultado-busqueda-recursos', 'Cpe\ResultadoBusquedaRecursosController@index')->name('resultado-busqueda-recursos');
Route::resource('ver-categoria', 'Cpe\ResourcesCategoriesViewController');
Route::resource('ver-subcategoria', 'Cpe\ResourcesSubcategoriesViewController');
Route::get('resources/favorite', 'Admin\ResourcesController@favorite')->name('admin.resources.favorite');
Route::get('resources/access', 'Admin\ResourcesController@accessResource')->name('admin.resources.accessResource');
Route::get('busqueda', 'Cpe\ResourcesSearchController@index')->name('cpe.busqueda');
Route::get('autocomplete', 'Cpe\ResourcesSearchController@autocomplete')->name('cpe.autocomplete');
Route::post('resultado-busqueda-memorias', 'Cpe\ResultadoBusquedaMemoriasController@index')->name('resultado-busqueda-memorias');
Route::resource('terminos', 'Cpe\PrivacyPageController');
Route::resource('linea-tiempo-ofertas', 'Cpe\LifeTimeController');
Route::resource('ciclos-de-retos', 'Cpe\CoursesController');
Route::resource('detalle-ciclo', 'Cpe\CoursesDetailController');
Route::post('mts','Cpe\MtsController@validateMts')->name('mts.validate');
Route::get('gestion','Cpe\MtsController@index')->name('cpe.gestion');