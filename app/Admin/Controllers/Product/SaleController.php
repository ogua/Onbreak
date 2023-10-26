<?php

namespace App\Admin\Controllers\Product;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Sold;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Http\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Table;
use Encore\Admin\Widgets\Table as Expandtable;
use URL;

class SaleController extends AdminController
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

        if (Admin::user()->roles[0]->name == 'Administrator'){


        }else{

            $table->model()
            ->where('receivedby', Admin::user()->id);
        }
        

        //$table->column('id', __('Id'));
        $table->column('billid',__('Bill id'))->expand(function ($model) {
            $guardian = $model->sales()->get()->map(function ($comment) {

                $data = [
                    'img' => $comment->product->img ? '<img src="'.asset('storage').'/'.$comment->product->img.'" width="50" height="50">' : '<img src="'.URL::to('images/logo.png').'" width="50">',
                    'product' => $comment->product->name,
                    'price' =>  'Gh¢'.$comment->price,
                    'qty' =>  $comment->qty,
                    'total' =>  'Gh¢'.$comment->total
                ];

                return $data;
            });
            return new Expandtable(['img','Product Name','Price','Qty','Total'], $guardian->toArray());
        });
        $table->column('subtotal', __('Sub Total'))->display(function(){
            return 'Gh¢'.$this->subtotal;
        });
        $table->column('discount', __('Discount'))->display(function(){
            return $this->discount.'%';
        });
        $table->column('total', __('Total'))->display(function(){
            return 'Gh¢'.$this->total;
        });
        $table->column('user.name', __('Sold By'));
        $table->column('date', __('Date'));
        // $table->column('created_at', __('Created at'))->display(function($created_at){
        //     return date('m-d-Y',strtotime($created_at));
        // });
        //$table->column('updated_at', __('Updated at'));

        $table->actions(function($action){
            $action->disableDelete();
            $action->disableEdit();
        });

        $table->filter(function ($filter) {

            $filter->expand();

            $filter->disableIdFilter();

            $filter->between('created_at', __('Sales Per Month'))->datetime();

            $filter->date('date', __('Sales Per Day'));

            $filter->equal('sales.product_id', __('Sales Per Product'))
            ->select(Product::all()->pluck('name','id')->toArray());

      });

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
        $show->field('subtotal', __('Sub total'));
        $show->field('discount', __('Discount'));
        $show->field('total', __('Total'));
        $show->field('date', __('Date'));
        $show->field('created_at', __('Created at'));
        //$show->field('updated_at', __('Updated at'));

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
