<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['client_id', 'title', 'content', 'order_id'];

    public static function createTicket($request)
    {
        $client_id = Client::createClient($request);
        $order_id = Order::createOrder($request, $client_id);

        if ($order_id == -1)
            return false;

        Ticket::updateOrCreate(
            ['client_id' => $client_id, 'order_id' => $order_id],
            ['title' => $request->post('title'), 'content' => $request->post('content')]
        );

        return true;
    }
}