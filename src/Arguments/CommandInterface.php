<?php

namespace Jitesoft\Cli\Arguments;

use Jitesoft\Cli\IO\InputReader;
use Jitesoft\Cli\IO\OutputWriter;

interface CommandInterface extends InputObjectInterface {

    /**
     * Process the command.
     *
     * @param array $arguments Arguments mapped name => value.
     * @param array $options   Options mapped name => value.
     * @return void
     */
    public function process(array $arguments, array $options): void;

    /**
     * Get a list of arguments that the Command makes use of.
     *
     * @return array|ArgumentInterface[] Arguments as an array.
     */
    public function getArguments(): array;

    /**
     * Get a list of options that the Command makes use of.
     *
     * @return array|OptionInterface[]
     */
    public function getOptions(): array;

    /**
     * Add one or multiple options to the Command.
     *
     * @param OptionInterface ...$option
     * @return static
     */
    public function addOption(OptionInterface ...$option): static;

    /**
     * Add one or multiple arguments to the Command.
     *
     * @param ArgumentInterface ...$argument
     * @return static
     */
    public function addArgument(ArgumentInterface ...$argument): static;

    /**
     * Set input reader for the command.
     *
     * @param InputReader $inputReader
     * @return static
     * @internal
     */
    public function setInput(InputReader $inputReader): static;

    /**
     * Set output writer for the command.
     *
     * @param OutputWriter $outputWriter
     * @return static
     * @internal
     */
    public function setOutput(OutputWriter $outputWriter): static;

}
