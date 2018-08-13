<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'user' => 'required|string',
            'path' => 'required|string',
            'ip_address' => 'required|ipv4',
            'project_id' => 'required|integer'
        ]);

        Server::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $server = Server::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'user' => 'required|string',
            'path' => 'required|string',
            'ip_address' => 'required|ipv4',
            'project_id' => 'required|integer'
        ]);

        $input = $request->all();

        // After an edit to the server properties we set it to untested again.
        $server->status = Server::UNTESTED;

        // Populate the server with the request input and update it.
        $server->fill($input)->save();
    }
}
