<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Exception;
use App\Ticket;

class TicketController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::orderBy('tickets.created_at', 'desc')
            ->join('clients', 'tickets.client_id', '=', 'clients.id')
            ->join('orders', 'tickets.order_id', '=', 'orders.id')
            ->paginate(5);

        return view('tickets.index', compact('tickets'))
            ->with('i', (request()->input(
                'page',
                1
            ) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required',
            'client_email' => 'required',
            'order_code' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        if (!Ticket::createTicket($request))
            return redirect()->route('tickets.create')
                ->with('error', 'Código do pedido já cadatrado para outro cliente');


        return redirect()->route('tickets.create')
            ->with('success', 'Ticket criado com sucesso.');
    }

    /**
     * Show Ticket
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticket = Ticket::find($ticket->id)
            ->join('clients', 'tickets.client_id', '=', 'clients.id')
            ->join('orders', 'tickets.order_id', '=', 'orders.id')->first();

        return view('tickets.show', compact('ticket'));
    }
}