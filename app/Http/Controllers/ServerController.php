<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

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

        /** @var Model $server */
        $server = Server::create($request->all());

        return response($server->jsonSerialize(), Response::HTTP_CREATED);
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
        /** @var Model $server */
        $server = Server::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'user' => 'required|string',
            'path' => 'required|string',
            'ip_address' => 'required|ipv4',
            'project_id' => 'required|integer'
        ]);

        $input = $request->all();
        $server->fill($input);
        $server->save();

        return response($server->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $server = Server::findOrFail($id);
        $server->delete();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Check the SSH connection status.
     *
     * @param int $id The server id we want retrieve a model for.
     */
    public function connection(int $id)
    {
        $server = Server::findOrFail($id);

        $process = new Process("ssh -q $server->target exit");
        $process->setTimeout(10);

        try {
            $process->run();
        } catch (RuntimeException $exception) {
            $server->status = Server::FAILED;
            $server->save();
        }

        if (!$process->isSuccessful()) {
            $server->status = Server::FAILED;
            $server->save();

            throw new ProcessFailedException($process);
        }

        $server->status = Server::SUCCESSFUL;
        $server->save();
    }
}
