<?php

namespace App\Http\Middleware;

use App\Domain\HttpClients\GithubClient;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * Bind a Guzzle HTTP client instance configured for Github in the service container.
 */
class BindGithubClient
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($user = $request->user()) {
            $client = new Client([
                'base_uri' => 'https://api.github.com',
                'headers' => [
                    'Authorization' => 'token ' . decrypt($user->access_token)
                ]
            ]);

            app()->instance(GithubClient::class, new GithubClient($client));
        }

        return $next($request);
    }
}
