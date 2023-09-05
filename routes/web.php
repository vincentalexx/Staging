<?php

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

Route::post('upload',                                       'App\Http\Controllers\Admin\FileUploadController@upload')->name('brackets/media::upload');
Route::prefix('/')->namespace('App\Http\Controllers\Admin')->name('/')->group(static function() {
    Route::get('/',                                             'SignUpController@index')->name('index');
    Route::post('signup',                                       'SignUpController@store')->name('store');
    Route::get('/thankyou',                                     'SignUpController@thankyou')->name('thankyou');
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('users')->name('users/')->group(static function() {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::post('/',                                            'UsersController@store')->name('store');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/{user}',                                      'UsersController@update')->name('update');
            Route::delete('/{user}',                                    'UsersController@destroy')->name('destroy');
            Route::get('{user}/password',                               'UsersController@password')->name('admin/users/password');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('congregations')->name('congregations/')->group(static function() {
            Route::get('/',                                             'CongregationsController@index')->name('index');
            Route::get('/export-excel',                                 'CongregationsController@exportExcel')->name('export-excel');
            Route::get('/create',                                       'CongregationsController@create')->name('create');
            Route::post('/',                                            'CongregationsController@store')->name('store');
            Route::get('/{congregation}/edit',                          'CongregationsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CongregationsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{congregation}',                              'CongregationsController@update')->name('update');
            Route::delete('/{congregation}',                            'CongregationsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('roles')->name('roles/')->group(static function() {
            Route::get('/',                                             'RolesController@index')->name('roles_index');
            Route::get('/create',                                       'RolesController@create')->name('create_role');
            Route::post('/',                                            'RolesController@store');
            Route::get('/{role}/edit',                                  'RolesController@edit')->name('edit_role');
            Route::post('/bulk-destroy',                                'RolesController@bulkDestroy')->name('roles/bulk-destroy');
            Route::post('/{role}',                                      'RolesController@update')->name('roles/update');
            Route::delete('/{role}',                                    'RolesController@destroy')->name('roles/destroy');
        });
    });
});

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('congregation-attendances')->name('congregation-attendances/')->group(static function() {
            Route::get('/',                                             'CongregationAttendancesController@index')->name('index');
            Route::get('/export-excel/{year}/{month}',                  'CongregationAttendancesController@exportExcel')->name('export-excel');
            Route::get('/edit',                                         'CongregationAttendancesController@edit')->name('edit');
            Route::post('/update',                                      'CongregationAttendancesController@update')->name('update');
            Route::get('/get-congregation-list',                        'CongregationAttendancesController@getCongregationList');
            Route::get('/get-total-hadir',                              'CongregationAttendancesController@getTotalHadir');
            Route::get('/edit/{congregationId}/{tanggal}',              'CongregationAttendancesController@editDetail')->name('editDetail');
            Route::post('/update/{congregationId}/{tanggal}',           'CongregationAttendancesController@updateDetail')->name('editDetail');
            Route::delete('/delete/{id}',                               'CongregationAttendancesController@destroyDetail')->name('editDetail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('budgets')->name('budgets/')->group(static function() {
            Route::get('/',                                             'BudgetsController@index')->name('index');
            Route::get('/create',                                       'BudgetsController@create')->name('create');
            Route::get('/export-excel/{id}',                            'BudgetsController@exportExcel')->name('export-excel');
            Route::get('/download-bon-zip/{id}',                        'BudgetsController@downloadBonZip')->name('download-bon-zip');
            Route::post('/',                                            'BudgetsController@store')->name('store');
            Route::get('/{budget}/edit',                                'BudgetsController@edit')->name('edit');
            Route::post('/{budget}/duplicate',                          'BudgetsController@duplicate')->name('duplicate');
            Route::post('/bulk-destroy',                                'BudgetsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{budget}',                                    'BudgetsController@update')->name('update');
            Route::delete('/{budget}',                                  'BudgetsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('budget-usages')->name('budget-usages/')->group(static function() {
            Route::get('/get-budget-detail-by-tanggal/{divisi}',        'BudgetUsagesController@getBudgetDetailByTanggal');
            Route::get('/{divisi}',                                     'BudgetUsagesController@index')->name('index');
            Route::get('/create/{divisi}',                              'BudgetUsagesController@create')->name('create');
            Route::post('/save/{divisi}',                               'BudgetUsagesController@store')->name('store');
            Route::get('/{budgetUsage}/{divisi}/edit',                  'BudgetUsagesController@edit')->name('edit');
            Route::post('/{budgetUsage}/{divisi}',                      'BudgetUsagesController@update')->name('update');
            Route::delete('/{budgetUsage}/{divisi}',                    'BudgetUsagesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('discipleships')->name('discipleships/')->group(static function() {
            Route::get('/',                                             'DiscipleshipsController@index')->name('index');
            Route::get('/create',                                       'DiscipleshipsController@create')->name('create');
            Route::post('/',                                            'DiscipleshipsController@store')->name('store');
            Route::get('/{discipleship}/edit',                          'DiscipleshipsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DiscipleshipsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{discipleship}',                              'DiscipleshipsController@update')->name('update');
            Route::delete('/{discipleship}',                            'DiscipleshipsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('discipleship-details')->name('discipleship-details/')->group(static function() {
            Route::get('/get-congregation-list',                        'DiscipleshipDetailsController@getCongregationList');
            Route::get('/get-discipleship-list',                        'DiscipleshipDetailsController@getDiscipleshipList');
            Route::get('/get-total-hadir',                              'DiscipleshipDetailsController@getTotalHadir');
            Route::get('/{divisi}',                                     'DiscipleshipDetailsController@index')->name('index');
            Route::get('/create/{divisi}',                              'DiscipleshipDetailsController@create')->name('create');
            Route::post('/{divisi}',                                    'DiscipleshipDetailsController@store')->name('store');
            Route::get('/{discipleshipDetail}/edit',                    'DiscipleshipDetailsController@edit')->name('edit');
            Route::get('/edit/{congregationId}/{tanggal}/{id}',         'DiscipleshipDetailsController@editDetail')->name('editDetail');
            Route::post('/bulk-destroy',                                'DiscipleshipDetailsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{discipleshipDetailId}/{congregationId}/update','DiscipleshipDetailsController@update')->name('update');
            Route::delete('/{discipleshipDetail}',                      'DiscipleshipDetailsController@destroy')->name('destroy');
            Route::delete('/delete/{id}/detail',                        'DiscipleshipDetailsController@destroyDetail');
        });
    });
});