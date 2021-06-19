<?php

namespace Jitesoft\Cli\Arguments;

class Argument implements ArgumentInterface {
    private static int $staticIndex = 0;

    private int $index;
    private bool $required;
    private string $name;
    private string $description;

    public function __construct(string $name,
                                string $description,
                                bool $required = true,
                                int $index = null) {
        $this->name        = $name;
        $this->description = $description;
        $this->index       = $index ?? ++self::$staticIndex;
        $this->required    = $required;
    }

    public function isRequired(): bool {
        return $this->required;
    }

    public function index(): int {
        return $this->index;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

}
