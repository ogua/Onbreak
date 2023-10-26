<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Sold;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Http\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Models\Administrator;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $totuses = Administrator::all()->count();

        $totproduct = Product::all()->count();


        if (Admin::user()->roles[0]->name == 'Administrator') {

            $saleperday = Sold::whereDate('created_at', \Carbon\Carbon::today())->sum('total');

            $salepermonth = Sold::whereMonth('created_at', date('m'))
            ->sum('total');

        }else{

            $saleperday = Sold::whereDate('created_at', \Carbon\Carbon::today())
            ->where('receivedby', Admin::user()->id)
            ->sum('total');

            $salepermonth = Sold::whereMonth('created_at', date('m'))
            ->where('receivedby', Admin::user()->id)
            ->sum('total');
        }

        

        

        return $content
            ->title('Dashboard')
            ->row(Dashboard::title())
            ->view('dashboard.info',compact('totuses','totproduct','saleperday','salepermonth'));
    }
}
