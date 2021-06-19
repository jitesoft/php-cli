<?php

namespace Jitesoft\Cli;

use Jitesoft\Cli\Arguments\CommandInterface;
use Jitesoft\Cli\Arguments\Manager;

interface UsageInterface {

    /**
     * Returns a usage string for a specific command.
     *
     * @param Manager               $manager The manager object.
     * @param CommandInterface|null $command Command to generate usage for.
     * @return string
     */
    public function getUsage(Manager $manager,
                            ?CommandInterface $command = null): string;

}
