<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['code', 'client_id'];
    /**
     * Create a ticket.
     *
     * @param array
     */
    public static function createOrder($request, $client_id): int
    {
        if (!Order::verifyOrder($client_id, $request->post('order_code')))
            return -1;

        $order = Order::firstOrCreate(['client_id' => $client_id, 'code' => $request->post('order_code')]);

        return $order->id;
    }

    public static function verifyOrder($client_id, $code)
    {
        $count = Order::where('code',  $code)->where('client_id', '<>', $client_id)->count();

        if ($count != 0)
            return false;

        return true;
    }
}