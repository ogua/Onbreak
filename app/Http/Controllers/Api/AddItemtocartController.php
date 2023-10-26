<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ItemResource;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use URL;

class AddItemtocartController extends Controller
{
    
    public function showproduct($barcode)
    {
        $prod = Product::where('Barcode',$barcode)->first();

        if ($prod) {
            return new ItemResource($prod);
        }else{
            return response()->json(['success' => false, 'message' => 'Authourise action'],401);
        }

    }


    public function additem(Request $request)
    {
        $billid = '';
        $appreff = $request->post('barcodeid');
        $prname = $request->post('prname');
        $prpx = $request->post('prpx');
        $qty = $request->post('qty');
        $dscnt = '0'; 

        $total = $prpx * $qty;

        //product
        $prod = Product::where('id',$prname)->first();
        $prqty = $prod->qty;

        if ($qty > $prqty) {

            $res = [
                'error' => false,
                'message' => 'Product Out of Stock'
            ];

            return response()->json($res);
        }

        $newqty = $prqty - $qty;

        $prod->qty = $newqty;
        $prod->save();

        $data = [
            'billid' => $billid,
            'appid' => $appreff,
            'salefrom' => 'app',
            'product_id' => $prod->id,
            'price' => $prod->amnt,
            'qty' => $qty,
            'dscnt' => $dscnt,
            'total' => $total,
            'date' => date('Y-m-d')
        ];

        //check
        $check = Sale::where('appid',$appreff)
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

        $res = [
            'error' => true,
            'message' => 'Product Added successfully!'
        ];

        return response()->json($res);

    }


    public function showcartitems($appreff)
    {
        $sales = Sale::where('appid',$appreff)->latest()->get();
        return CartResource::collection($sales);
    }

    public function carttotal($appreff)
    {
        $sales = Sale::where('appid',$appreff)->sum('total');
        return response()->json(['total' => 'Gh¢'.$sales]);
    }


    public function delfromcart($id)
    {
        $sale = Sale::where('id',$id)->first();
        $qty = $sale->qty;

        $prod = Product::where('id',$sale->product_id)->first();
        $prodqty = $prod->qty + $qty;
        $prod->qty = $prodqty;
        $prod->save();

        $sale->delete();

        $res = [
            'error' => true,
            'message' => 'Product Delected successfully!'
        ];

        return response()->json($res);

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $billid = $request->post('billid');
        $barcodeid = $request->post('barcodeid');
        $prname = $request->post('prname');
        $prpx = $request->post('prpx');
        $qty = $request->post('qty');
        $dscnt = $request->post('dscnt');

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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
