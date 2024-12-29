<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\EngineerController;
Route::get('/pilot/LogSheet', function () {
    session_start();
    if($_SESSION ['role']==1){
        return  redirect()->route('engineer');
      }
      elseif($_SESSION ['role']==0){
        return redirect()->route('admin') ;
      }
    return view('Pilot.create');
})->middleware(['auth', 'verified'])->name('pilot');
Route::get('/admin/dashboard', function () {
    session_start();
    if($_SESSION ['role']==1){
        return  redirect()->route('engineer');
      }
      elseif($_SESSION ['role']==2){
        return redirect()->route('pilot') ;
      }
    return view('analytics');
})->middleware(['auth', 'verified'])->name('admin');


Route::get('/engineer/dashboard', function () {
    session_start();
    if($_SESSION ['role']==0){
        return  redirect()->route('admin');
      }
      elseif($_SESSION ['role']==2){
        return redirect()->route('pilot') ;
      }
    return view('analytics');
})->middleware(['auth', 'verified'])->name('engineer');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
 Route::resource('LogSheet','LogSheetController');


use App\Http\Controllers\CycleAController;
use App\Http\Controllers\CycleBController;
use App\Http\Controllers\CycleCController;
use App\Http\Controllers\HourController;
use App\Http\Controllers\HourBController;
use App\Http\Controllers\HourcController;
use App\Http\Controllers\DateAController;
use App\Http\Controllers\DateBController;
use App\Http\Controllers\DateCController;





// Common routes for roles 0 and 1
Route::middleware(['auth', 'verified'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        session_start();
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 0 || $_SESSION['role'] == 1)) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }], function () {
        Route::resource('cycleA', 'CycleAController');
        Route::resource('cycleB', 'CycleBController');
        Route::resource('cycleC', 'CycleCController');
        Route::resource('hour', 'HourController');
        Route::resource('hourb', 'HourBController');
        Route::resource('hourc', 'HourcController');
        Route::resource('dateA', 'DateAController');
        Route::resource('dateB', 'DateBController');
        Route::resource('dateC', 'DateCController');
        Route::view('/analytics', 'analytics')->name('analytics');
        Route::resource('LogSheet','LogSheetController');
Route::put('/LogSheet/{logSheet}', [LogSheetController::class, 'update'])->name('LogSheet.update');
Route::put('/logsheet/{logSheet}', [LogSheetController::class, 'update'])->name('LogSheet.update');
Route::get('/LogSheet', [LogSheetController::class, 'index'])->name('logsheet.index');
// /
///
///

//cycleA
Route::get('cycleA/soft/delete/{id}', 'CycleAController@softDelete')
->name('soft.delete');
Route::get('cycleA/soft/delete/{id}', 'CycleAController@softDelete')
->name('softa.delete');

Route::get('/test-notifications', [CycleAController::class, 'checkCycles']);
Route::get('/trash', 'App\Http\Controllers\CycleAController@trash')->name('cycleA.trash');

Route::get('/back/{id}', 'App\Http\Controllers\CycleAController@backSoftDelete')->name('cycleA.back.trash');
Route::get('/delte/{id}', 'App\Http\Controllers\CycleAController@deleteForEver')->name('cycleA.delete.trash');

//cycleB

Route::get('cycleB/soft/delete/{id}', 'CycleBController@softDelete')
->name('soft.delete');
Route::get('cycleB/soft/delete/{id}', 'CycleBController@softDelete')
->name('softcb.delete');
Route::get('/trashb', 'App\Http\Controllers\CycleBController@trash')->name('cycleB.trash');

Route::get('/backb/{id}', 'App\Http\Controllers\CycleBController@backSoftDelete')->name('cycleB.back.trash');
Route::get('/delteb/{id}', 'App\Http\Controllers\CycleBController@deleteForEver')->name('cycleB.delete.trash');

//cycle C

Route::get('cycleC/soft/delete/{id}', 'CycleCController@softDelete')
->name('soft.delete');
Route::get('cycleC/soft/delete/{id}', 'CycleCController@softDelete')
->name('softcc.delete');
Route::get('/trashc', 'App\Http\Controllers\CycleCController@trash')->name('cycleC.trash');

Route::get('/backc/{id}', 'App\Http\Controllers\CycleCController@backSoftDelete')->name('cycleC.back.trash');
Route::get('/deltec/{id}', 'App\Http\Controllers\CycleCController@deleteForEver')->name('cycleC.delete.trash');

//HourA
Route::get('hour/soft/delete/{id}', 'HourController@softDelete')
->name('soft.delete');
Route::get('hour/soft/delete/{id}', 'HourController@softDelete')
->name('softh.delete');

Route::get('/trashh', 'App\Http\Controllers\HourController@trash')->name('hour.trash');

Route::get('/backh/{id}', 'App\Http\Controllers\HourController@backSoftDelete')->name('hour.back.trash');
Route::get('/delteh/{id}', 'App\Http\Controllers\HourController@deleteForEver')->name('hour.delete.trash');

//HourB
Route::get('hourb/soft/delete/{id}', 'HourBController@softDelete')
->name('soft.delete');
Route::get('hourb/soft/delete/{id}', 'HourBController@softDelete')
->name('softhb.delete');

Route::get('/trashhb', 'App\Http\Controllers\HourBController@trash')->name('hourb.trash');

Route::get('/backhb/{id}', 'App\Http\Controllers\HourBController@backSoftDelete')->name('hourb.back.trash');
Route::get('/deltehb/{id}', 'App\Http\Controllers\HourBController@deleteForEver')->name('hourb.delete.trash');
//HourC
Route::get('hourc/soft/delete/{id}', 'HourcController@softDelete')
->name('soft.delete');
Route::get('hourc/soft/delete/{id}', 'HourcController@softDelete')
->name('softhc.delete');

Route::get('/trashhc', 'App\Http\Controllers\HourcController@trash')->name('hourc.trash');

Route::get('/backhc/{id}', 'App\Http\Controllers\HourcController@backSoftDelete')->name('hourc.back.trash');
Route::get('/deltehc/{id}', 'App\Http\Controllers\HourcController@deleteForEver')->name('hourc.delete.trash');
//dateA
Route::get('dateA/soft/delete/{id}', 'dateAController@softDelete')
->name('soft.delete');
Route::get('dateA/soft/delete/{id}', 'dateAController@softDelete')
->name('softda.delete');

Route::get('/trashda', 'App\Http\Controllers\dateAController@trash')->name('dateA.trash');

Route::get('/backda/{id}', 'App\Http\Controllers\dateAController@backSoftDelete')->name('dateA.back.trash');
Route::get('/delteda/{id}', 'App\Http\Controllers\dateAController@deleteForEver')->name('dateA.delete.trash');
//dateB
Route::get('dateB/soft/delete/{id}', 'dateBController@softDelete')
->name('soft.delete');
Route::get('dateB/soft/delete/{id}', 'dateBController@softDelete')
->name('softdb.delete');

Route::get('/trashdb', 'App\Http\Controllers\dateBController@trash')->name('dateB.trash');

Route::get('/backdb/{id}', 'App\Http\Controllers\dateBController@backSoftDelete')->name('dateB.back.trash');
Route::get('/deltedb/{id}', 'App\Http\Controllers\dateBController@deleteForEver')->name('dateB.delete.trash');
//dateC
Route::get('dateC/soft/delete/{id}', 'dateCController@softDelete')
->name('soft.delete');
Route::get('dateCe/soft/delete/{id}', 'dateCController@softDelete')
->name('softdc.delete');

Route::get('/trashdc', 'App\Http\Controllers\dateCController@trash')->name('dateC.trash');

Route::get('/backdc/{id}', 'App\Http\Controllers\dateCController@backSoftDelete')->name('dateC.back.trash');
Route::get('/deltedc/{id}', 'App\Http\Controllers\dateCController@deleteForEver')->name('dateC.delete.trash');
//LogSheet
Route::get('LogSheet/soft/delete/{id}', 'LogSheetController@softDelete')
->name('soft.delete');
Route::get('dateC/soft/delete/{id}', 'LogSheetController@softDelete')
->name('softl.delete');
//Route::delete('/logsheet/delete/{id}', [LogSheetController::class, 'deleteForEver'])->name('LogSheet.delete.trash');
Route::delete('/logsheet/delete/{id}', 'App\Http\Controllers\LogSheetController@deleteForEver')->name('LogSheet.delete.trash');





    });
});
//routing for Admin just

Route::get('/trashl', 'App\Http\Controllers\LogSheetController@trash')->name('LogSheet.trash');

Route::get('/backl/{id}', 'App\Http\Controllers\LogSheetController@backSoftDelete')->name('LogSheet.back.trash');
Route::get('/deltel/{id}', 'App\Http\Controllers\LogSheetController@deleteForEver')->name('LogSheet.delete.trash');

use App\Http\Controllers\LogSheetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationsController;

// Routes for role 0
Route::middleware(['auth', 'verified'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        session_start();
        if (isset($_SESSION['role']) && $_SESSION['role'] == 0) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }], function () {
        // Define resource routes for UserController


Route::resource('User', UserController::class);
Route::get('/users', [User::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
// Show the form for editing the specified user
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// Update the specified user in storage
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
// Remove the specified user from storage
//Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Display the specified user
//Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
//user delet
Route::get('user/soft/delete/{id}', 'UserController@softDelete')
->name('soft.delete');
Route::get('user/soft/delete/{id}', 'UserController@softDelete')
->name('softu.delete');
Route::get('/trashu', 'App\Http\Controllers\UserController@trash')->name('users.trash');
Route::get('/test', 'App\Http\Controllers\UserController@test')->name('users.test');
Route::get('/backu/{id}', 'App\Http\Controllers\UserController@backSoftDelete')->name('users.back.trash');
Route::get('/deleteu/{id}', 'App\Http\Controllers\UserController@deleteForEver')->name('users.delete.trash');
//Notifications` pages
Route::get('/notifications/view', [NotificationsController::class, 'view'])->name('notification.index');
Route::delete('/notifications/{id}', [NotificationsController::class, 'destroy'])->name('notifications.destroy');


Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');

Route::post('/notifications/{id}/read', [NotificationsController::class, 'markAsRead'])->name('notifications.markAsRead');
    });
});




Route::resource('LogSheet','LogSheetController');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        session_start();
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 0 || $_SESSION['role'] == 2)) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }], function () {
        //Route::resource('LogSheet','LogSheetController');

        Route::post('/logsheet/store', [LogSheetController::class, 'store'])->name('logsheet.store');
        Route::view('/logsheet/store', 'pilot.create')->name('logsheet.get');
        Route::get('/logsheet/create', [LogSheetController::class, 'create'])->name('logsheet.create');
    });
});


//Notifications






Route::get('/test-end-dates', [NotificationsController::class, 'checkEndDates']);
//Route::get('/send-test-email', [App\Http\Controllers\AnalyticsController::class, 'sendTestEmail']);
Route::get('/send-test-email', [App\Http\Controllers\NotificationsController::class, 'sendUserReport']);
Route::get('/test-user-report', [App\Http\Controllers\NotificationsController::class, 'sendUserReport']);





use App\Http\Controllers\ReportController;

Route::get('/export', [ReportController::class, 'export']);

Route::get('/export-hours', [ReportController::class, 'exportHours']);
Route::get('/export-dates', [ReportController::class, 'exportDates']);
Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('export.excel');

//Route::get('/export/{plane}/{filter}', [ReportController::class, 'exportPlaneData'])->name('export.plane.data');
Route::view('/export2', 'export');
Route::view('/dashboardh', 'dashboardh');
Route::view('/charts', 'charts');


use App\Http\Controllers\DashboardController;

Route::get('/active-users', [DashboardController::class, 'getActiveUsers']);
Route::get('/average-cycle-usage', [DashboardController::class, 'getAverageCycleUsage']);
Route::get('/cycles-near-limit', [DashboardController::class, 'getCyclesNearLimit']);
Route::get('/total-hours', [DashboardController::class, 'getTotalHours']);
Route::get('/upcoming-events', [DashboardController::class, 'getUpcomingEvents']);


use App\Http\Controllers\ChartController;

Route::get('/charts/pie-data', [ChartController::class, 'getPieChartData']);
Route::get('/charts/bar-data', [ChartController::class, 'getBarChartData']);
Route::get('/analytics-data', [ChartController::class, 'getAnalyticsData']);
Route::get('/plane-analytics-data', [ChartController::class, 'getPlaneAnalyticsData']);








Route::view('/hi', 'hi');
Route::view('/export_final_updated', 'export_final_updated');




//Route::get('/logsheet/store', [LogSheetController::class, 'store'])->name('logsheet.get');
/*Route::post('/logsheet/store', [LogSheetController::class, 'store'])->name('logsheet.store');


Route::post('/hourAA/update', [LogSheetController::class, 'updateHourA'])->name('hourAa.update');
Route::post('/cycleAA/increment', [LogSheetController::class, 'incrementCycleA'])->name('cycleAa.increment');

Route::post('/hourBB/update', [LogSheetController::class, 'updateHourB'])->name('hourBa.update');
Route::post('/cycleBB/increment', [LogSheetController::class, 'incrementCycleB'])->name('cycleBa.increment');

Route::post('/hourCC/update', [LogSheetController::class, 'updateHourC'])->name('hourCa.update');
Route::post('/cycleCC/increment', [LogSheetController::class, 'incrementCycleC'])->name('cycleCa.increment');


Route::post('/logsheet/updateCyclesAndHours', [LogSheetController::class, 'updateCyclesAndHours'])->name('logsheet.updateCyclesAndHours');
*/

