<?php

namespace App\Admin\Controllers\Supplier;

use App\Models\Suppliers;
use Encore\Admin\Form;
use Encore\Admin\Http\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Table;
use Encore\Admin\Widgets\Table as Expandtable;
use URL;

class SupplierController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Suppliers';

    /**
     * Make a table builder.
     *
     * @return Table
     */
    protected function table()
    {
        $table = new Table(new Suppliers());

        //$table->column('id', __('Id'));
        $table->column('logo', __('Logo'))
        ->display(function($logo){
            if($logo){
                return '<img src="'.asset('storage').'/'.$logo.'" width="80" height="80">';
            }else{
                return '<img src="'.URL::to('images/logo.png').'" width="80">';
            }
        });
        $table->column('name',__('Name'))->expand(function ($model) {
            $supplier = $model->supplyproducts()->get()->map(function ($supplierproduct) {

                $data = [
                    'product' => $supplierproduct->name,
                ];

                return $data;
            });
            return new Expandtable(['Products Supply'], $supplier->toArray());
        });
        $table->column('ref', __('Ref'));
        $table->column('email', __('Email'));
        $table->column('contact', __('Contact Info'))->display(function(){
            return $this->zipcode.''.$this->phone;
        });
        //$table->column('zipcode', __('Zipcode'));
        //$table->column('phone', __('Phone'));
        //$table->column('website', __('Website'));
        //$table->column('tax', __('Tax'));
        $table->column('location', 'Location Info')->display(function(){
            return $this->address.'<br>'.$this->country.','.$this->towncity.'-'.$this->stateprovince;
        });
        //$table->column('address', __('Address'));
        //$table->column('country', __('Country'));
        //$table->column('towncity', __('Towncity'));
        //$table->column('stateprovince', __('Stateprovince'));
        //$table->column('created_at', __('Created at'));
        //$table->column('updated_at', __('Updated at'));

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
        $show = new Show(Suppliers::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('logo', __('Logo'))->image();
        $show->field('name', __('Name'));
        $show->field('ref', __('Ref'));
        $show->field('email', __('Email'));
        $show->field('zipcode', __('Zipcode'));
        $show->field('phone', __('Phone'));
        $show->field('website', __('Website'));
        $show->field('tax', __('Tax'));
        $show->field('address', __('Address'));
        $show->field('country', __('Country'));
        $show->field('towncity', __('Towncity'));
        $show->field('stateprovince', __('Stateprovince'));
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
        $form = new Form(new Suppliers());

        $form->image('logo', __('Logo'))->removable();
        $form->text('name', __('Name'));
        $form->text('ref', __('Ref'))->default('REF-');
        $form->email('email', __('Email'));
        $form->text('zipcode', __('Zipcode'));
        $form->text('phone', __('Phone'))->rules('required|min:10|max:10');
        $form->url('website', __('Website'));
        //$form->text('tax', __('Tax'));
        $form->textarea('address', __('Address'));
        $form->text('country', __('Country'))->default('Ghana');
        $form->text('towncity', __('Towncity'));
        $form->text('stateprovince', __('State/province'));

        $form->hasMany('supplyproducts',__('Products Supply'), function ($form) {
               $form->text('name', __('Product name'));
        });

        return $form;
    }
}
