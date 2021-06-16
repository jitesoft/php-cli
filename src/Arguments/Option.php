<?php

namespace Jitesoft\Cli\Arguments;

class Option implements OptionInterface {

    protected string  $name;
    protected string  $description;
    protected ?string $short;
    protected ?array  $alias;
    protected bool    $isRequired;
    protected bool    $mustHaveValue;

    public function __construct(
        string $name,
        string $description,
        ?string $short      = null,
        ?array $alias       = null,
        bool $isRequired    = false,
        bool $mustHaveValue = false
    ) {
        $this->name          = $name;
        $this->description   = $description;
        $this->short         = $short;
        $this->alias         = $alias;
        $this->isRequired    = $isRequired;
        $this->mustHaveValue = $mustHaveValue;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getShort(): string {
        return $this->short ?? '';
    }

    public function getAlias(): array {
        return $this->alias ?? [];
    }

    public function isRequired(): bool {
        return $this->isRequired;
    }

    public function mustHaveValue(): bool {
        return $this->mustHaveValue;
    }
}
