<?php
namespace Jitesoft\Cli\IO;

/** @codeCoverageIgnore  */
/** @codingStandardsIgnoreStart  */

/**
 * Class containing constants for background colors.
 *
 * @package Jitesoft\Cli\IO
 */
final class BackgroundColor {

    private function __construct() {
        /*Can't instantiate class*/}

        // 8bit
    public const Black   = "\033[40m";
    public const Red     = "\033[41m";
    public const Green   = "\033[42m";
    public const Yellow  = "\033[43m";
    public const Blue    = "\033[44m";
    public const Magenta = "\033[45m";
    public const Cyan    = "\033[46m";
    public const White   = "\033[47m";

       // 16bit.
    public const BrightBlack   = "\033[40;1m";
    public const BrightRed     = "\033[41;1m";
    public const BrightGreen   = "\033[42;1m";
    public const BrightYellow  = "\033[43;1m";
    public const BrightBlue    = "\033[44;1m";
    public const BrightMagenta = "\033[45;1m";
    public const BrightCyan    = "\033[46;1m";
    public const BrightWhite   = "\033[47;1m";

}

/** @codingStandardsIgnoreEnd  */
