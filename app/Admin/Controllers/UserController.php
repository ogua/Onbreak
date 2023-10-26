<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Http\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Table;
use Spatie\Permission\Traits\syncRoles;

class UserController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public function title()
    {
        return trans('admin.administrator');
    }

    /**
     * Make a table builder.
     *
     * @return Table
     */
    protected function table()
    {
        $userModel = config('admin.database.users_model');

        $table = new Table(new User());

        $table->column('id', 'ID')->sortable();
        $table->column('avatar', trans('avatar'))->image('', 100,100);
        $table->column('username', trans('admin.username'));
        $table->column('name', trans('admin.name'));
        $table->column('roles', trans('admin.roles'))->pluck('name')->label();
        $table->column('created_at', trans('admin.created_at'));
        $table->column('updated_at', trans('admin.updated_at'));

        $table->actions(function (Table\Displayers\Actions $actions) {
            if ($actions->getKey() == 1) {
                $actions->disableDelete();
            }
        });

        $table->tools(function (Table\Tools $tools) {
            $tools->batch(function (Table\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        return $table;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $userModel = config('admin.database.users_model');

        $show = new Show(User::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('username', trans('admin.username'));
        $show->field('name', trans('admin.name'));
        $show->field('created_at', trans('admin.created_at'));
        $show->field('updated_at', trans('admin.updated_at'));

        return $show;
    }

    // public function index(Content $content)
    // {
    //     $user = User::where('id', Admin::user()->id)->first();

    //     dd($user->roles);
    // }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $userModel = config('admin.database.users_model');

        $form = new Form(new User());

        $userTable = config('admin.database.users_table');
        $connection = config('admin.database.connection');

        $form->display('id', 'ID');
        $form->text('username', trans('admin.username'))
            ->creationRules(['required', "unique:{$connection}.{$userTable}"])
            ->updateRules(['required', "unique:{$connection}.{$userTable},username,{{id}}"]);

        $form->image('avatar', trans('admin.avatar'));
        $form->text('name', trans('admin.name'))->rules('required');

        $form->multipleSelect('roles', trans('User Role'))
        ->options(\Spatie\Permission\Models\Role::all()->pluck('name','id')->toArray());

        $form->password('password', trans('admin.password'))->rules('required|confirmed');
        $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });

        $form->ignore(['password_confirmation']);

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });

        // $form->saved(function(Form $form){
        //     $userid = $form->model()->id;

        //     $user = User::where('id',$userid)->first();
        //     $user->syncRoles($form->roles['name']);

        // });

        return $form;
    }
}
