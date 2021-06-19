<?php

use Jitesoft\Cli\Kernel;

// Custom kernel which fills the commands array with classes to resolve via dependency container (built in).

class TestKernel extends Kernel {
    protected array $commands = [
        TestCommand::class
    ];
}
