<?php

namespace Jitesoft\Cli\Arguments;

class Command implements CommandInterface {
    protected array  $arguments;
    protected array  $options;
    protected string $name;
    protected string $description;

    public function __construct(string $name, string $description, array $arguments = [], array $options = []) {
        $this->arguments = $arguments;
        $this->options   = $options;
        $this->name = $name;
        $this->description = $description;
    }

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
}
