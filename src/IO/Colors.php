<?php
namespace Jitesoft\Cli\IO;
/** @codeCoverageIgnore  */

/**
 * Used to colorize a piece of text.
 *
 * Simple class which uses CLI ANSI escape codes to colorize and decorate texts via the
 * constants in the TextColor, BackgroundColor and Decoration classes.
 *
 * @package Jitesoft\Cli\IO
 */
final class Colors {

    /**
     * Apply colors and decoration to a specific text.
     *
     * @param string      $text            Text to colorize.
     * @param string|null $textColor       Text color to apply.
     * @param string|null $backgroundColor Background color to apply.
     * @param string|null $decoration      Decoration to apply.
     *
     * @return string Colorized string.
     *
     * @see TextColor
     * @see BackgroundColor
     * @see Decoration
     */
    public static function apply(
        string $text,
        string $textColor = null,
        string $backgroundColor = null,
        string $decoration = null
    ): string {
        $text = trim($text);

        $colorize = $textColor        ?? '';
        $colorize .= $backgroundColor ?? '';
        $colorize .= $decoration      ?? '';

        return "$colorize$text\033[0m";
    }

}
