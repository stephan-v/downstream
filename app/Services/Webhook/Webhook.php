<?php

namespace App\Services\Webhook;

use Illuminate\Http\Request;

class Webhook
{
    /**
     * This event refers to any Git push to a Repository, including editing tags or branches.
     * Commits via API actions that update references are also counted.
     *
     * @var string PUSH_EVENT
     */
    const PUSH_EVENT = 'push';

    /**
     * Verify that the webhook server request is actually coming from Github.
     *
     * @param Request $request The incoming HTTP server request.
     * @return bool True is the server request is coming from a secure origin, otherwise false.
     */
    public static function isNotSecure(Request $request): bool
    {
        $secret = env('GITHUB_WEBHOOK_SECRET');
        $header = $request->header('X-Hub-Signature');

        // Split the signature into an algorithm and a hash.
        list($algorithm, $hash) = explode('=', $header, 2);

        // Check the hash of our secret against the hash of the Github secret.
        $payloadHash = hash_hmac($algorithm, $request->getContent(), $secret);

        // If the hash from Github matches the hash we made of the payload with our secret, we know that they match.
        return $hash !== $payloadHash;
    }
}
