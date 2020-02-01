<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders="";

        if(sizeof($request) > 0)
        {
            // Getting data
            $order_id  = $request->get('order_id');
            $from_date = $request->get('from_date');
            $to_date   = $request->get('to_date');

            // Handling data-null situations
            $order_id  = (is_null($order_id) ? ""         : $order_id);
            $from_date = (is_null($from_date)? "1-1-1"    : $from_date.' 00:00:00');
            $to_date   = (is_null($to_date)  ? "4040-1-1" : $to_date.' 00:00:00');

            // Query
            $orders = Order::where('order_id', 'like', "%".$order_id."%")
                            ->where('created_at', '>=', $from_date)
                            ->where('created_at', '<=', $to_date)
                            ->orderBy('id', 'DESC')
                            ->paginate(10);

            // Set path
            $path = "order?order_id=".$order_id."&from_date=".$from_date."&to_date=".$to_date;
            $orders->SetPath($path);
        }

        else
            $orders = Order::orderBy('id', 'DESC')->paginate(10);

        return view('admin/order/index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
