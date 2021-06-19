<?php
namespace Jitesoft\Cli\IO;

/** @codeCoverageIgnore  */
/** @codingStandardsIgnoreStart  */

/**
 * Class containing constants for text decoration.
 *
 * @package Jitesoft\Cli\IO
 */
final class Decoration {

    private function __construct() {
        /*Can't instantiate class*/}

    public const Normal    = "\033[0m";
    public const Bold      = "\033[1m";
    public const Underline = "\033[4m";
    public const Reversed  = "\033[7m";

}

/** @codingStandardsIgnoreEnd  */
