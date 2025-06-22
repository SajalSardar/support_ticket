<?php

// module

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RequesterTypeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketStatusController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', 'verified')->prefix('dashboard')->name('admin.')->group(function () {
    Route::resource('module', ModuleController::class);
    Route::resource('menu', MenuController::class);
    Route::get('menu-list-datatable', [MenuController::class, 'displayListDatatable'])->name('menu.list.datatable');
    Route::resource('category', CategoryController::class)->except(['store', 'update']);
    Route::resource('team', TeamController::class)->except(['store', 'update']);
    Route::resource('source', SourceController::class)->except(['store', 'update']);
    Route::resource('requestertype', RequesterTypeController::class)->except(['store', 'update']);
    Route::resource('department', DepartmentController::class)->except(['store', 'update']);

    Route::controller(TicketStatusController::class)->name('ticketstatus.')->group(function () {
        Route::get('request-status', 'index')->name('index');
        Route::get('request-status-create', 'create')->name('create');
        Route::get('request-show/{ticketstatus}', 'show')->name('show');
        Route::get('request-edit/{ticketstatus}', 'edit')->name('edit');
        Route::delete('delete/{ticketstatus}', 'destroy')->name('delete');
        Route::get('status-list-datatable', 'displayListDatatable')->name('status.list.datatable');
    });

    Route::controller(TicketController::class)->name('ticket.')->group(function () {
        Route::get('requests', 'index')->name('index');
        Route::get('create-request', 'create')->name('create');
        Route::get('show-request/{ticket}', 'show')->name('show');
        Route::get('edit-request/{ticket}', 'edit')->name('edit');
        Route::delete('request-delete/{ticket}', 'destroy')->name('delete');
        Route::delete('file/{file}', 'trashFile')->name('trashFile');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk.delete');
        Route::get('request-list', 'allTicketList')->name('all.list');
        Route::get('status-wise-request-list', 'allTicketList')->name('status.wise.list');
        Route::get('my-request-list', 'allTicketList')->name('list.active.memode');
        Route::get('request-list-datatable', 'allTicketListDataTable')->name('all.list.datatable');
        Route::post('request-log-update/{ticket}', 'logUpdate')->name('logUpdate');
        Route::post('request-internal-note-update/{ticket}', 'interNoteStore')->name('interNoteStore');
        Route::get('request-download/{file}', 'downloadFile')->name('downloadFile');
        Route::post('requester-change/{ticket}', 'ticketRequesterChange')->name('change.requester');
        Route::post('request-partial-update/{ticket}', 'partialUpdate')->name('partialUpdate');
        Route::get('get-category-wise-subcategory', 'categoryWiseSubcategory')->name('category.wise.subcategory');
        Route::get('get-department-wise-team', 'departmentWiseTeam')->name('department.wise.team');
        Route::get('trash-request-list', 'trashRequestList')->name('trash.request.list');
        Route::get('trash-request-datatable', 'trashRequestDatatable')->name('trash.request.list.datatable');
        Route::get('restore-trash-request/{id}', 'restoreTrashRequest')->name('restore.trash.request');
        Route::delete('delete-trash-request/{id}', 'deleteTrashRequest')->name('delete.trash.request');
        Route::post('trash-bluck-request-delete-restore', 'trashBluckRequestDeleteRestore')->name('trash.bluck.delete');
    });

    Route::controller(RoleController::class)->name('role.')->group(function () {
        Route::get('role-list', 'index')->name('index');
        Route::get('/role-list-datatable', 'displayListDatatable')->name('list.datatable');
        Route::get('create-user-role', 'create')->name('create');
        Route::post('create-user-role', 'store')->name('store');
        Route::get('edit-user-role/{id}', 'edit')->name('edit');
        Route::put('update-user-role/{id}', 'update')->name('update');
        Route::post('switch-accont', 'switchAccount')->name('swotch');
        Route::delete('delete', 'delete')->name('delete');
    });

    // modules
    Route::controller(ModuleController::class)->name('module.')->group(function () {
        Route::get('/module-list-datatable', 'displayListDatatable')->name('list.datatable');
    });

    // Category
    Route::controller(CategoryController::class)->name('category.')->group(function () {
        Route::get('/category-list-datatable', 'displayListDatatable')->name('list.datatable');
    });

    // Source
    Route::controller(SourceController::class)->name('source.')->group(function () {
        Route::get('/source-list-datatable', 'displayListDatatable')->name('list.datatable');
    });

    // requesterType
    Route::controller(RequesterTypeController::class)->name('requesterType.')->group(function () {
        Route::get('/requester-type-list-datatable', 'displayListDatatable')->name('list.datatable');
    });

    // requesterType
    Route::controller(DepartmentController::class)->name('department.')->group(function () {
        Route::get('/department-list-datatable', 'displayListDatatable')->name('list.datatable');
    });

    //user
    Route::get('get-user-by-id', [AdminUserController::class, 'getUserById'])->name('get.user.by.id');
    // change role in header option

});
