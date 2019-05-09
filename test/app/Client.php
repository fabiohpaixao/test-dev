<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['email', 'name'];

    /**
     * Create a client.
     *
     * @param array
     */
    public static function createClient($request): int
    {
        $client = Client::firstOrCreate(
            ['email' => $request->post('client_email')],
            ['name' => $request->post('client_name')]
        );

        return $client->id;
    }
}