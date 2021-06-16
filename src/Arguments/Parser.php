<?php

namespace Jitesoft\Cli\Arguments;

class Parser {

    /**
     * Parses incoming argument list (argv by default) and produces an
     * assoc array with the command, arguments and options parsed into
     * different structures.
     *
     * <pre>
     * [
     *   'command'   => 'command-name',
     *   'options'   => [ 'key' => 'value' ],
     *   'arguments' => [ 'arg1', 'arg2' ]
     * ]
     * </pre>
     *
     * @param array|null $argv Argument list. Defaults to global $argv.
     * @return array
     */
    public static function parse(array $argv = null): array {
        if (!$argv) {
            global $argv;
            // Remove the initial value, as that is the script name.
            array_shift($argv);
        }

        $len = count($argv);

        $command = null;
        if ($len > 0 && !str_starts_with($argv[0], '-')) {
            $command = array_shift($argv);
            $len--;
        }

        $args = [];
        $opts = [];

        $opt = false;

        /** @noinspection ForeachInvariantsInspection */
        for ($i = 0; $i < $len; $i++) {
            $entry = $argv[$i];

            if (str_starts_with($entry, '-')) {
                // If options have started coming, we dont want to bother with args more.
                // Options are last, else we can't guess the value of the opt.
                $opt = true;
            }

            if ($opt) {
                if (str_contains($entry, '=')) {
                    $split = explode('=', $entry);
                    $opts[trim($split[0], " \t\n\r\0\x0B-")] = trim($split[1]);
                } else if ($len > ($i + 1) && !str_starts_with($argv[$i + 1], '-')) {
                    $val = '';

                    while ($len > ($i + 1) && !str_starts_with($argv[$i + 1], '-')) {
                        $val .= $argv[$i + 1] . ' ';
                        $i++;
                    }

                    $opts[trim($entry, " \t\n\r\0\x0B-")] = trim($val, " \t\n\r\0\x0B\"");
                } else {
                    $opts[trim($entry, " \t\n\r\0\x0B-")] = null;
                }
                continue;
            }

            $args[] = trim($entry, " \t\n\r\0\x0B\"");
        }

        return ['command' => $command, 'arguments' => $args, 'options' => $opts];
    }
}
