<?php

namespace App\Http\Middleware\GithubClient;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * This is responsible for transforming Guzzle error response to Laravel error responses.
 */
class GuzzleExceptionMiddleware
{
    /**
     * The callable which is invoked when this class is being called as a method.
     *
     * @param callable $handler The next handler to invoke in the middleware chain.
     * @return \Closure The closure.
     */
    function __invoke(callable $handler): \Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            return $handler($request, $options)->then(
                function (ResponseInterface $response) use ($request, $handler) {
                    $code = $response->getStatusCode();

                    if ($code < 400) {
                        return $response;
                    }

                    $this->abortWithStatusCode($code, $request);
                }
            );
        };
    }

    /**
     * Throw an HTTP exception with the provided HTTP code and message.
     *
     * @param int $code The HTTP response code.
     * @param RequestInterface $request The incoming server request.
     */
    private function abortWithStatusCode(int $code, RequestInterface $request)
    {
        abort($code, $request->getBody());
    }
}
