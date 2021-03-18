<?php

use Alexusmai\LaravelFileManager\Controllers\FileManagerController;
use Rvsitebuilder\Filemanager\Http\Controllers\Admin\DashboardController;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'web',
], function () {
    Route::group([
        'prefix' => 'filemanager',
        'as' => 'filemanager.',
        'middleware' => 'admin',
    ], function () {
        // 'admin.filemanager.dashboard.'
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

        // 'admin.filemanager.'
        Route::get('initialize', [FileManagerController::class, 'initialize'])->name('initialize');
        Route::get('content', [FileManagerController::class, 'content'])->name('content');
        Route::get('tree', [FileManagerController::class, 'tree'])->name('tree');
        Route::get('select-disk', [FileManagerController::class, 'selectDisk'])->name('select-disk');
        Route::post('upload', [FileManagerController::class, 'upload'])->name('upload');
        Route::post('delete', [FileManagerController::class, 'delete'])->name('delete');
        Route::post('paste', [FileManagerController::class, 'paste'])->name('paste');
        Route::post('rename', [FileManagerController::class, 'rename'])->name('rename');
        Route::get('download', [FileManagerController::class, 'download'])->name('download');
        Route::get('thumbnails', [FileManagerController::class, 'thumbnails'])->name('thumbnails');
        Route::get('preview', [FileManagerController::class, 'preview'])->name('preview');
        Route::get('url', [FileManagerController::class, 'url'])->name('url');
        Route::get('create-directory', [FileManagerController::class, 'createDirectory'])->name('create-directory');
        Route::post('create-file', [FileManagerController::class, 'createFile'])->name('create-file');
        Route::post('update-file', [FileManagerController::class, 'updateFile'])->name('update-file');
        Route::get('stream-file', [FileManagerController::class, 'streamFile'])->name('stream-file');
        Route::post('zip', [FileManagerController::class, 'zip'])->name('zip');
        Route::post('unzip', [FileManagerController::class, 'unzip'])->name('unzip');

        // Integration with editors
        Route::get('ckeditor', [FileManagerController::class, 'ckeditor'])->name('ckeditor');
        Route::get('tinymce', [FileManagerController::class, 'tinymce'])->name('tinymce');
        Route::get('summernote', [FileManagerController::class, 'summernote'])->name('summernote');
        Route::get('fm-button', [FileManagerController::class, 'fmButton'])->name('fm-button');
    });
});
