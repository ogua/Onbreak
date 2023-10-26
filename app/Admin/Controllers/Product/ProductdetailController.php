<?php

namespace App\Admin\Controllers\Product;

use App\Models\Billid;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Sold;
use Encore\Admin\Form;
use Encore\Admin\Http\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Table;
use Illuminate\Http\Request;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a table builder.
     *
     * @return Table
     */
    protected function table()
    {
        $table = new Table(new Product());

        //$table->column('id', __('Id'));
        $table->column('img', __('Product Image'))->image('',200,200);
        $table->column('Barcode', __('Barcode'));
        $table->column('name', __('Product name'))->display(function(){
            return $this->name.' '.$this->ptype;
        });
        $table->column('amnt', __('Amount'))->display(function($amnt){
            return 'Gh¢'.$amnt;
        });
        $table->column('qty', __('Qty'));
        $table->column('dscnt', __('Discnt'));
        $table->column('desc', __('Discription'));
        $table->column('expiredate', __('Expiry Date'));
        $table->column('date', __('Date'));
        
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('img', __('Product Image'));
        $show->field('Barcode', __('Barcode'));
        $show->field('name', __('Product name'));
        $show->field('ptype', __('Product size'));
        $show->field('manufacture', __('Product manufacturer'));
        $show->field('qty', __('Qantity'));
        $show->field('amnt', __('Amount'));
        $show->field('dscnt', __('Discount'));
        $show->field('desc', __('Discription'));
        $show->field('expiredate', __('Expiry Date'));
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
        $form = new Form(new Product());

        $form->image('img', __('Product Image'));
        $form->text('Barcode', __('Barcode'))->required();
        $form->text('name', __('Product name'));
        $form->select('ptype', __('Product size'))
        ->options(['Normal' => 'Normal', 'Small' => 'Small', 'Medium' => 'Medium', 'Large' => 'Large', 'Quarter' => 'Quarter']);
        $form->text('manufacture', __('Product manufacturer'));
        $form->number('qty', __('Qantity'));
        $form->currency('amnt', __('Price'))->symbol('Gh¢');
        $form->number('dscnt', __('Discount'));
        $form->textarea('desc', __('Discription'));
        $form->date('expiredate', __('Expiry Date'));
        $form->date('date', __('Date'));

        return $form;
    }


    public function getpx(Request $request)
    {
        $id = $request->get('id');
        $product = Product::where('id',$id)->first();
        return $product->amnt;
    }

    public function getpxbarcode(Request $request)
    {
        $value = $request->get('value');
        $product = Product::where('Barcode',$value)->first();

        return response()->json(['price' => $product->amnt, 'name' => $product->id]);
    }


    public function recordsales(Content $content)
    {
        $allproducts = Product::all();

        $maxid = Billid::all()->max('billid');

        if ($maxid) {
            $max = (int) substr($maxid, 4);
            $number = $max + 1;
            $billid = "REFF".$number;
        }else{
            $billid = "REFF100";
        }

        $getproduct = Sale::where('billid',$billid)->get();

        return $content->title('Record Sales')
        ->view('sale',compact('billid','allproducts','getproduct'));
    }


    public function addproducttosales(Request $request)
    {
        $billid = $request->get('billid');
        $barcodeid = $request->get('barcodeid');
        $prname = $request->get('prname');
        $prpx = $request->get('prpx');
        $qty = $request->get('qty');
        $dscnt = $request->get('dscnt');



        $total = $prpx * $qty;

        //product
        $prod = Product::where('id',$prname)->first();
        $prqty = $prod->qty;

        if ($qty > $prqty) {
            echo '<div class="alert alert-info">Product Out of Stock </div>';

            exit();
        }

        $newqty = $prqty - $qty;

        $prod->qty = $newqty;
        $prod->save();

        $data = [
            'billid' => $billid,
            'product_id' => $prod->id,
            'price' => $prod->amnt,
            'qty' => $qty,
            'dscnt' => $dscnt,
            'total' => $total,
            'date' => date('Y-m-d')
        ];

        //check
        $check = Sale::where('billid',$billid)
        ->where('product_id',$prod->id)->first();

        if ($check) {
            $cqty = $check->qty + $qty;

            $ctotal = $prod->amnt * $cqty;

            $check->qty = $cqty;
            $check->total = $ctotal;


            $check->save();
        }else{

            $new = new Sale($data);
            $new->save();
        }

        $getproduct = Sale::where('billid',$billid)->get();

        return view('saleproducts',compact('getproduct'));


    }


    public function confirmsales(Request $request)
    {
        $subtotal = $request->get('subtotal');
        $discont = $request->get('discont');
        $total = $request->get('total');
        $billid = $request->get('billid');

        $data = [
            'subtotal' => $subtotal,
            'discount' => $discont,
            'total' => $total,
            'billid' => $billid,
            'date' => date('Y-m-d'),
        ];

        $new = new Sold($data);
        $new->save();

        Billid::create(['billid' => $billid]);

        echo "confirmed Successfully!";

    }


    public function delproductfromsales(Request $request)
    {
        $id = $request->get('id');

        $sale = Sale::where('id',$id)->first();
        $qty = $sale->qty;

        $prod = Product::where('id',$sale->product_id)->first();
        $prodqty = $prod->qty + $qty;
        $prod->qty = $prodqty;
        $prod->save();

        $sale->delete();

        return 'Deleted Successfully!';

    }


    protected function salesperdaytable()
    {
        $table = new Table(new Product());
        $table->model()->whereDate('created_at', \Carbon\Carbon::today());

        $table->column('id', __('Id'));
        $table->column('img', __('Product Image'))->image('',200,200);
        $table->column('Barcode', __('Barcode'));
        $table->column('name', __('Product name'));
        $table->column('qty', __('Qantity'));
        $table->column('amnt', __('Amount'));
        $table->column('dscnt', __('Discount'));
        $table->column('desc', __('Discription'));
        $table->column('expiredate', __('Expiry Date'));
        $table->column('date', __('Date'));
        
        $table->column('created_at', __('Created at'));
        //$table->column('updated_at', __('Updated at'));

        $table->disableFilter();

        $table->footer(function ($query) {

            $data = $query->sum('amnt');

            return "<div style='padding: 10px;background-color: #17a2b8; color: #fff;'> Total Amount ： Gh¢ ".number_format($data ? : 0,2)."</div>";
      });

        return $table;
    }


    public function salesperday(Content $content)
    {
        return $content->title('Sales Per Day')
        ->body($this->salesperdaytable());
    }



    protected function salespermonthtable()
    {
        $table = new Table(new Product());
        $table->model()->whereDate('created_at', \Carbon\Carbon::today());
        
        $table->column('id', __('Id'));
        $table->column('img', __('Product Image'))->image('',200,200);
        $table->column('Barcode', __('Barcode'));
        $table->column('name', __('Product name'));
        $table->column('qty', __('Qantity'));
        $table->column('amnt', __('Amount'));
        $table->column('dscnt', __('Discount'));
        $table->column('desc', __('Discription'));
        $table->column('expiredate', __('Expiry Date'));
        $table->column('date', __('Date'));
        
        $table->column('created_at', __('Created at'));
        //$table->column('updated_at', __('Updated at'));

        $table->filter(function ($filter) {

            $filter->expand();

            $filter->disableIdFilter();

            $filter->between('created_at', __('Sales Per Month'))->datetime();

            $filter->date('date', __('Sales Per Day'));

      });


      $table->footer(function ($query) {

            $data = $query->sum('amnt');

            return "<div style='padding: 10px;background-color: #17a2b8; color: #fff;'> Total Amount ： Gh¢ ".number_format($data ? : 0,2)."</div>";
      });

        return $table;
    }


    public function salespermonth(Content $content)
    {
        return $content->title('Sales Per Month')
        ->body($this->salespermonthtable());
    }



    protected function salesperproducttable()
    {
        $table = new Table(new Product());
        $table->model()->whereDate('created_at', \Carbon\Carbon::today());
        
        $table->column('id', __('Id'));
        $table->column('img', __('Product Image'))->image('',200,200);
        $table->column('Barcode', __('Barcode'));
        $table->column('name', __('Product name'));
        $table->column('qty', __('Qantity'));
        $table->column('amnt', __('Amount'));
        $table->column('dscnt', __('Discount'));
        $table->column('desc', __('Discription'));
        $table->column('expiredate', __('Expiry Date'));
        $table->column('date', __('Date'));
        
        $table->column('created_at', __('Created at'));
        //$table->column('updated_at', __('Updated at'));

        $table->filter(function ($filter) {

            $filter->expand();

            $filter->disableIdFilter();

            $filter->equal('id', __('Sales Per Product'))->select(Product::all()->toArray());

            $filter->between('created_at', __('Sales Per Month'))->datetime();

            $filter->date('date', __('Sales Per Day'));

      });


      $table->footer(function ($query) {

        $data = $query->sum('amnt');

        return "<div style='padding: 10px;background-color: #17a2b8; color: #fff;'> Total Amount ： Gh¢ ".number_format($data ? : 0,2)."</div>";
      });

        return $table;
    }


    public function salesperproduct(Content $content)
    {
        return $content->title('Sales Per Product')
        ->body($this->salesperproducttable());
    }

















}
