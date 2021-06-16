<?php
namespace Jitesoft\Cli\Arguments;


interface OptionInterface extends InputObjectInterface {

    /**
     * Get short name of the option.
     * This will be displayed as a `-[char]` in usage and help.
     *
     * Should be a single character.
     *
     * @return string
     */
    public function getShort(): string;

    /**
     * Get aliases for the option.
     * These will be displayed as `--[alias]` in the usage and help.
     *
     * May be multiple characters.
     *
     * @return array
     */
    public function getAlias(): array;

    /**
     * If the option is required or not.
     *
     * If option is required, it should most likely rather be an argument.
     *
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * If the option requires a value or not. If value is required, an error
     * will be shown if the value is not found.
     *
     * @return bool
     */
    public function mustHaveValue(): bool;

}
