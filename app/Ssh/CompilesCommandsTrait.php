<?php

namespace App\Ssh;

use App\Server;
use Illuminate\Support\Facades\Blade;

trait CompilesCommandsTrait
{
    /**
     * Compile the variables inside the string commands with Blade.
     *
     * @param Server $server The server instance.
     * @param array $commands The action commands.
     * @return string Serialized array of prepared commands.
     */
    private function compileWithBlade(Server $server, array $commands): string
    {
        $deployment = $this->deployment;

        // Blade values like {{ symlink }} will get replaced by the their respective key.
        $placeholders = [
            'symlink' => $server->current,
            'release' => $server->releases . $deployment->created_at->timestamp,
            'releases' => $server->releases,
            'repository' => $deployment->project->cloneUrl
        ];

        $commands = $this->compileStrings($placeholders, $commands);

        return serialize($commands);
    }

    /**
     * Compile the array of string commands which have blade placeholders within them.
     *
     * @param array $placeholders The most used placeholders.
     * @param array $commands The action commands.
     * @return array The compiled string array.
     */
    private function compileStrings(array $placeholders, array $commands): array
    {
        return array_map(function($command) use ($placeholders) {
            extract($placeholders);

            $php = Blade::compileString($command);

            ob_start();
            eval('?>' . $php);
            return ob_get_clean();
        }, $commands);
    }
}
