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
}
