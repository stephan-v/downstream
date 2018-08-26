<?php

namespace App\Ssh;

use App\Server;
use Illuminate\Support\Facades\Blade;

trait CompilesCommandsTrait
{
    /**
     * Prepare the commands and replace the brace variables with their respective placeholders.
     *
     * @param Server $server The current server instance.
     * @return string Serialized array of prepared commands.
     */
    private function compileCommands(Server $server): string
    {
        $commands = $this->compileWithBlade($server);

        // Serialize to prepare the data for database insertion.
        return serialize($commands);
    }

    /**
     * Compile the variables inside the string commands with Blade.
     *
     * @param Server $server The server instance.
     * @return array The compiled string array.
     */
    private function compileWithBlade(Server $server): array
    {
        $deployment = $this->deployment;

        // Blade values like {{ symlink }} will get replaced by the their respective key.
        $placeholders = [
            'symlink' => $server->current,
            'release' => $server->releases . $deployment->created_at->timestamp,
            'releases' => $server->releases,
            'repository' => $deployment->project->cloneUrl
        ];

        return $this->compileStrings($placeholders);
    }

    /**
     * Compile the array of string commands which have blade placeholders within them.
     *
     * @param array $placeholders The most used placeholders.
     * @return array The compiled string array.
     */
    private function compileStrings(array $placeholders): array
    {
        return array_map(function($command) use ($placeholders) {
            extract($placeholders);

            $php = Blade::compileString($command);

            ob_start();
            eval('?>' . $php);
            return ob_get_clean();
        }, $this->commands);
    }
}
