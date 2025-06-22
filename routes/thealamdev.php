<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\Entity;
use App\Http\Controllers\Admin\EntityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'locale', 'verified'])->prefix('dashboard')->name('admin.')->group(function () {
    Route::controller(AdminUserController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/user-list-datatable', 'displayListDatatable')->name('list.datatable');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{user}', 'edit')->name('edit');
        Route::delete('delete/{user}', 'destroy')->name('delete');
    });

    Route::controller(ConversationController::class)->prefix('conversations')->name('conversation.')->group(function () {
        Route::post('replay/{conversation}', 'replay')->name('replay');
        Route::post('conversations/{ticket}', 'conversation')->name('ticket.conversation');
    });

    Route::controller(EntityController::class)->prefix('entities')->name('entity.')->group(function () {
        Route::get('/{entity}', 'index')->name('index');
        Route::get('/{entity}/list-datatable', 'displayListDatatable')->name('list.datatable');
    });
});
