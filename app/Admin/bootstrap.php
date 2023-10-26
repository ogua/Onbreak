<?php

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Table;

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Admin::favicon('/images/favicon.ico');

//Admin::disablePjax();

Form::init(function (Form $form) {

    $form->disableEditingCheck();

    //$form->disableCreatingCheck();

    $form->disableViewCheck();

    $form->tools(function (Form\Tools $tools) {
        //$tools->disableDelete();
        //$tools->disableView();
        //$tools->disableList();
    });
});


Table::init(function (Table $table) {

    $table->model()->orderByDesc('id');
    
    $table->batchActions(function ($batchActions){
        $batchActions->disableDelete();
    });


    //$table->disableActions();

    //$table->disablePagination();

    //$table->disableCreateButton();

    //$table->disableFilter();

    $table->disableRowSelector();

    $table->disableColumnSelector();

    //$table->disableTools();

    //$table->disableExport();

    $table->actions(function (Table\Displayers\Actions $actions) {
        //$actions->disableView();
        //$actions->disableEdit();
        //$actions->disableDelete();
    });
});




app('view')->prependNamespace('admin', resource_path('views/encore-admin/views'));

Admin::js('/bower_components/loading_overlay/loading_overlay.js');
Admin::js('/sweetalert/sweertalert.js');

Form::extend('image',App\Admin\Extension\Form\Image::class);
Form::extend('file',App\Admin\Extension\Form\File::class);