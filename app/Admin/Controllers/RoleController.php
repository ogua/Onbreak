<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Admin\role\Addpermission;
use Encore\Admin\Form;
use Encore\Admin\Http\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Table;
use Spatie\Permission\Models\Role as Spartierole;

class RoleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Role';

    /**
     * Make a table builder.
     *
     * @return Table
     */
    protected function table()
    {
        $table = new Table(new Spartierole());

        $table->column('id', __('Id'));
        $table->column('name',__('Name'));
        $table->column('guard_name', __('Guardname'));
        $table->column('created_at', __('Created at'))->display(function($created_at){
            return date('m-d-Y',strtotime($created_at));
        });
        
        $table->column('updated_at', __('Updated at'))->display(function($updated_at){
            return date('m-d-Y',strtotime($updated_at));
        });

        $table->disableFilter();
        
        $table->modalForm();

        return $table;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Spartierole::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('guard_name', __('Guardname'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Spartierole());

        $form->text('name', __('Name'))->required();

        return $form;
    }


    










}
