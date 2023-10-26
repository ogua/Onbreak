<?php

namespace App\Admin\Controllers\Product;

use App\Models\Billid;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Sold;
use App\Models\Suppliers;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Http\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Table;
use Encore\Admin\Widgets\Table as Expandtable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use URL;

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
        $table->column('img', __('Product Image'))
        ->display(function($img){
            if($img){
                return '<img src="'.asset('storage').'/'.$img.'" width="80" height="80">';
            }else{
                return '<img src="'.URL::to('images/logo.png').'" width="80">';
            }
        });
        $table->column('Barcode', __('Barcode'));
        $table->column('name', __('Product name'))->display(function(){
            return $this->name.' '.$this->ptype;
        });
        $table->column('supplier.name', __('Product Supplier'));
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
        $show->field('supplier.name', __('Product Supplier'));
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
        $form->text('name', __('Product name'))->required();
        $form->select('ptype', __('Product size'))
        ->options(['Normal' => 'Normal', 'Small' => 'Small', 'Medium' => 'Medium', 'Large' => 'Large', 'Quarter' => 'Quarter']);
        $form->select('manufacture', __('Product Supplier'))
        ->options(Suppliers::all()->pluck('name','id')->toArray());
        $form->number('qty', __('Qantity'))
        ->default(1)
        ->required();
        $form->currency('amnt', __('Price'))->symbol('Gh¢');
        $form->number('dscnt', __('Discount'))->default(0);
        $form->textarea('desc', __('Discription'));
        $form->date('expiredate', __('Expiry Date'));
        $form->date('date', __('Date'))->value(date('Y-m-d'));

        $form->saving(function(Form $form){
            $discnt = $form->dscnt;
            $px = (int) $form->amnt;

            if ($discnt > 0) {
                $dicpx = ($discnt/100)*$px;
                $form->amnt = (int) $form->amnt - (int) $dicpx;
            }
        });

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
        $code = $request->get('code');
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

        if ($code) {

            $data = [
            'appid' => $code,
            'product_id' => $prod->id,
            'price' => $prod->amnt,
            'qty' => $qty,
            'dscnt' => $dscnt,
            'total' => $total,
            'date' => date('Y-m-d')
        ];

        //check
        $check = Sale::where('appid',$code)
        ->where('product_id',$prod->id)->first();

        }else{

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
            
        }

        //logger($data);

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


        if ($code){
            $getproduct = Sale::where('appid',$code)
          ->latest()->get();
            
        }else{
            $getproduct = Sale::where('billid',$billid)
          ->latest()->get();
        }

        return view('saleproducts',compact('getproduct'));

    }


    public function fetchappproduct(Request $request)
    {
        $id = $request->get('id');

        $getproduct = Sale::where('appid',$id)->latest()->get();

        return view('saleproducts',compact('getproduct'));
    }


    public function confirmsales(Request $request)
    {
        $subtotal = $request->get('subtotal');
        $discont = $request->get('discont');
        $total = $request->get('total');
        $billid = $request->get('billid');
        $code = $request->get('code');

        $data = [
            'subtotal' => $subtotal,
            'discount' => $discont,
            'total' => $total,
            'billid' => $billid,
            'date' => date('Y-m-d'),
            'receivedby' => Admin::user()->id
        ];


        $new = new Sold($data);
        $new->save();

        if (empty($code)) {

            Sale::where('billid',$billid)
            ->update(['status' => 1]);

        }else{

            Sale::where('appid',$code)->update(['status' => 1, 'billid' => $billid]);
        }

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


    public function printbill($billid)
    {
        $pdf = App::make('dompdf.wrapper');

        $getproduct = Sold::where('billid',$billid)->first();

        //return View('print',compact('getproduct'));

        $pdf->loadView('print',compact('getproduct'));

        return $pdf->stream('bill-info-printed-on-'.date('Y-m-d H:i:s').'.pdf');

        
    }


    protected function salesperdaytable()
    {
        $table = new Table(new Sold());

        if (Admin::user()->roles[0]->name == 'Administrator'){

            $table->model()
            ->whereDate('created_at', \Carbon\Carbon::today());

        }else{

            $table->model()
            ->where('receivedby', Admin::user()->id)
            ->whereDate('created_at', \Carbon\Carbon::today());
        }
        

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
        //$table->column('billid', __('Billid'));
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
        

        $table->actions(function($action){
            $action->disableDelete();
            $action->disableEdit();
        });

        $table->disableFilter();

        $table->footer(function ($query) {

            $data = $query->sum('total');

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
        $table = new Table(new Sold());

        if (Admin::user()->roles[0]->name == 'Administrator'){


        }else{

            $table->model()
            ->where('receivedby', Admin::user()->id);
        }

        
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
        

        $table->actions(function($action){
            $action->disableDelete();
            $action->disableEdit();
        });

        $table->filter(function ($filter) {

            $filter->expand();

            $filter->disableIdFilter();

            $filter->between('created_at', __('Sales Per Month'))->datetime();

            $filter->date('date', __('Sales Per Day'));

      });


      $table->footer(function ($query) {

            $data = $query->sum('total');

            return "<div style='padding: 10px;background-color: #17a2b8; color: #fff;'> Total Amount ： Gh¢ ".number_format($data ? : 0,2)."</div>";
      });

        return $table;
    }


    public function salespermonth(Content $content)
    {
        return $content->title('Sales Per Month')
        ->body($this->salespermonthtable());
    }


    protected function salesperproducts()
    {
        $table = new Table(new Sold());

        if (Admin::user()->roles[0]->name == 'Administrator'){


        }else{

            $table->model()
            ->where('receivedby', Admin::user()->id);
        }

        
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


      $table->footer(function ($query) {

            $data = $query->sum('total');

            return "<div style='padding: 10px;background-color: #17a2b8; color: #fff;'> Total Amount ： Gh¢ ".number_format($data ? : 0,2)."</div>";
      });

        return $table;
    }


    protected function salesperproducttable()
    {
        $table = new Table(new Sale());

        $table->model()->where('status','1');
        
        $table->column('id', __('Id'));
        $table->column('product.img', __('Product Image'))
        ->display(function($img){
            if($img){
                return '<img src="'.asset('storage').'/'.$img.'" width="80" height="80">';
            }else{
                return '<img src="'.URL::to('images/logo.png').'" width="80">';
            }
        });
        $table->column('product.Barcode', __('Barcode'));
        $table->column('product.name', __('Product name'));
        $table->column('qty', __('Qantity'));
        $table->column('dscnt', __('Discount'));
        $table->column('total', __('Total'));
        //$table->column('desc', __('Discription'));
        //$table->column('expiredate', __('Expiry Date'));
        //$table->column('user.name', __('Sold By'));
        $table->column('date', __('Date'));
        
        //$table->column('created_at', __('Created at'));
        //$table->column('updated_at', __('Updated at'));

        $table->disableActions();

        $table->filter(function ($filter) {

            $filter->expand();

            $filter->disableIdFilter();

            $filter->equal('product.id', __('Sales Per Product'))
            ->select(Product::all()->pluck('name','id')->toArray());

            $filter->between('created_at', __('Sales Per Month'))->datetime();

            $filter->date('date', __('Sales Per Day'));

      });


      $table->footer(function ($query) {

        $data = $query->sum('total');

        return "<div style='padding: 10px;background-color: #17a2b8; color: #fff;'> Total Amount ： Gh¢ ".number_format($data ? : 0,2)."</div>";
      });

        return $table;
    }


    public function salesperproduct(Content $content)
    {
        return $content->title('Sales Per Product')
        ->body($this->salesperproducts());
    }

















}
