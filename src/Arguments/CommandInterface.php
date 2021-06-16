<?php

namespace Jitesoft\Cli\Arguments;

interface CommandInterface extends InputObjectInterface {

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

}
