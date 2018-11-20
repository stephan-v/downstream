<?php

namespace App\Http\Middleware\GithubClient;

use App\Services\HttpClients\GithubClient;
use App\Services\HttpClients\VersionControlInterface;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;

/**
 * Bind a Guzzle HTTP client instance configured for Github in the service container.
 */
class BindGithubClient
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request The incoming HTTP server request.
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($user = $request->user()) {
            $stack = HandlerStack::create();
            $stack->push(new GuzzleExceptionMiddleware);

            $client = new Client([
                'base_uri' => "https://api.github.com/repos/",
                'headers' => [
                    'Authorization' => 'token ' . decrypt($user->access_token)
                ],
                'handler' => $stack,
            ]);

            app()->instance(VersionControlInterface::class, new GithubClient($client));
        }

        return $next($request);
    }
}
