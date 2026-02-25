<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    public function index()
    {
       return view('backend.coupon.index');
       
    }

    public function view()
    {

       return view('backend.coupon.add');
    }

    // public function delivery()
    // {

    //    return delivery('backend.orders.view_delivery');
    // }
    
}
