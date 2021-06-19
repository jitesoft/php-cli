<?php

namespace Jitesoft\Cli;

use Exception;
use Jitesoft\Cli\Arguments\CommandInterface;
use Jitesoft\Cli\Arguments\Manager;
use Jitesoft\Cli\Arguments\Option;
use Jitesoft\Cli\Arguments\Parser;
use Jitesoft\Container\Container;
use Jitesoft\Container\ContainerInterface;
use ReflectionClass;

class Kernel {
    private ContainerInterface $container;
    private Manager $manager;
    private array $resolvedCommands = [];

    protected array $commands      = [];
    protected array $globalOptions = [];

    public function __construct(string $name,
                                string $description,
                                ContainerInterface $container = null) {
        $this->globalOptions = array_merge(
            $this->globalOptions, [
                new Option(
                    'help',
                    'Print help information.',
                    'h',
                    ['usage']
                )
            ]
        );

        $this->container = $container ?? new Container();
        foreach ($this->commands as $command) {
            $this->addCommand($command);
        }

        $this->manager = new Manager(
            $name,
            $description,
            $this->resolvedCommands,
            $this->globalOptions
        );
    }

    public function addCommand(string $commandClass): void {
        $class = new ReflectionClass($commandClass);
        if (!$class->implementsInterface(CommandInterface::class)) {
            throw new Exception('Commands must implement the CommandInterface');
        }

        // Use the container to auto-resolve any dependencies.
        $this->container->set($commandClass, $commandClass);
        $command = $this->container->get($commandClass);

        $this->resolvedCommands[
            $command::class
        ] = $command;

        $this->container->unset($commandClass);
    }

    public function process(array $argv = null): void {
        $parsed = Parser::parse($argv);

        $command = $this->manager->getCommand();

        if ($command === null) {
            $this->manager->usage();
            return;
        }

        try {
            foreach ($parsed['options'] as $key => $value) {
                if (strtolower($key) === 'help' || strtolower($key) === 'h') {
                    $this->manager->usage($command);
                    return;
                }
            }
        }
        /** @codingStandardsIgnoreStart  */
        catch (Exception) {
            /* Ignore. Will be caught inside invoke. */
        }
        /** @codingStandardsIgnoreEnd  */

        $this->manager->invokeCommand($command);
    }

}
