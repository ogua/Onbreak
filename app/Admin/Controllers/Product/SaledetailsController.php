<?php

namespace App\Admin\Controllers\Product;

use App\Models\Sale;
use App\Models\Sold;
use Encore\Admin\Form;
use Encore\Admin\Http\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Table;

class SaledetailsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Sale';

    /**
     * Make a table builder.
     *
     * @return Table
     */
    protected function table()
    {
        $table = new Table(new Sold());

        $table->column('id', __('Id'));
        $table->column('billid', __('Billid'));
        $table->column('product_id', __('Product id'));
        $table->column('qty', __('Qty'));
        $table->column('dscnt', __('Dscnt'));
        $table->column('total', __('Total'));
        $table->column('date', __('Date'));
        $table->column('created_at', __('Created at'));
        $table->column('updated_at', __('Updated at'));

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
        $show = new Show(Sold::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('billid', __('Billid'));
        $show->field('product_id', __('Product id'));
        $show->field('qty', __('Qty'));
        $show->field('dscnt', __('Dscnt'));
        $show->field('total', __('Total'));
        $show->field('date', __('Date'));
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
        $form = new Form(new Sold());

        $form->text('billid', __('Billid'));
        $form->text('product_id', __('Product id'));
        $form->text('qty', __('Qty'));
        $form->text('dscnt', __('Dscnt'));
        $form->text('total', __('Total'));
        $form->text('date', __('Date'));

        return $form;
    }
}
