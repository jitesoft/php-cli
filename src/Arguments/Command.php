<?php

namespace Jitesoft\Cli\Arguments;

use Jitesoft\Cli\IO\InputReader;
use Jitesoft\Cli\IO\OutputWriter;

abstract class Command implements CommandInterface {
    protected array $arguments    = [];
    protected array $options      = [];
    protected string $name        = '';
    protected string $description = '';
    protected InputReader $input;
    protected OutputWriter $output;

    public function getArguments(): array {
        return $this->arguments;
    }

    public function getOptions(): array {
        return $this->options;
    }

    public function addOption(OptionInterface ...$option): static {
        $this->options = array_merge($this->options, $option);
        return $this;
    }

    public function addArgument(ArgumentInterface ...$argument): static {
        $this->arguments = array_merge($this->arguments, $argument);
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    // @codingStandardsIgnoreLine
    public function process(array $arguments, array $options): void {
        $this->output->warning('This command is not implemented.');
    }

    public function setOutput(OutputWriter $outputWriter): static {
        $this->output = $outputWriter;
        return $this;
    }

    public function setInput(InputReader $inputReader): static {
        $this->input = $inputReader;
        return $this;
    }

}
