<?php
namespace Jitesoft\Cli\IO;

/** @codeCoverageIgnore  */
/** @codingStandardsIgnoreStart  */

/**
 * Class containing constants for text colors.
 *
 * @package Jitesoft\Cli\IO
 */
final class TextColor {

    private function __construct() {
        /*Can't instantiate class*/}

    // 8bit
    public const Black   = "\033[0;30m";
    public const Red     = "\033[0;31m";
    public const Green   = "\033[0;32m";
    public const Yellow  = "\033[0;33m";
    public const Blue    = "\033[0;34m";
    public const Magenta = "\033[0;35m";
    public const Cyan    = "\033[0;36m";
    public const White   = "\033[0;37m";

    // 16bit.
    public const BrightBlack   = "\033[1;30";
    public const BrightRed     = "\033[1;31";
    public const BrightGreen   = "\033[1;32";
    public const BrightYellow  = "\033[1;33";
    public const BrightBlue    = "\033[1;34";
    public const BrightMagenta = "\033[1;35";
    public const BrightCyan    = "\033[1;36";
    public const BrightWhite   = "\033[1;37";

}

/** @codingStandardsIgnoreEnd  */
