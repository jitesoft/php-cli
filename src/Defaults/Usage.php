<?php

namespace Jitesoft\Cli\Defaults;

use Jitesoft\Cli\Arguments\ArgumentInterface;
use Jitesoft\Cli\Arguments\CommandInterface;
use Jitesoft\Cli\Arguments\Manager;
use Jitesoft\Cli\Arguments\OptionInterface;
use Jitesoft\Cli\UsageInterface;

class Usage implements UsageInterface {

    public function getUsage(Manager $manager, ?CommandInterface $command = null): string {
        if (!$command) {
            return $this->topLevelCommand($manager);
        }

        return $this->subCommand($command, $manager);
    }

    private function topLevelCommand(Manager $manager): string {
        // Global options
        $options = $this->getOptionsString($manager->getGlobalOptions());
        $commands = $this->getCommandsString($manager->getCommands());

        return "{$manager->getName()} - {$manager->getDescription()}\n\nUsage: {$manager->getName()} [command] [arguments] [options]" .
                ($commands ? "\n\nCommands:\n{$commands}" : '') .
                ($options ? "\n\nOptions:\n{$options}" : '');
    }

    private function subCommand(CommandInterface $command, Manager $manager): string {
        $arguments = $this->getArgumentString($command->getArguments());
        $options = $this->getOptionsString($command->getOptions());
        return "{$command->getName()} - {$command->getDescription()}\nUsage: {$manager->getName()} {$command->getName()} [arguments] [options]" .
                ($arguments ? "\n\nArguments:\n{$arguments}" : '') .
                ($options ? "\n\nOptions:\n{$options}" : '');
    }

    private function getArgumentString(array $arguments): string {
        usort($arguments, static fn(ArgumentInterface $a, ArgumentInterface $b) => $a->index() - $b->index());
        $arguments = array_map(static function(ArgumentInterface $arg) {
            $required = $arg->isRequired() ? '[required]' : '';
            return "  {$arg->getName()} - {$arg->getDescription()} $required";
        }, $arguments);
        return implode("\n", $arguments);
    }

    private function getOptionsString(array $options): string {
        usort($options, static fn(OptionInterface $o, OptionInterface $o2) => $o2->isRequired() - $o->isRequired());
        $options =  array_map(static function(OptionInterface $opt) {
            $short   = $opt->getShort() ? "(-{$opt->getShort()})" : '';
            $required = $opt->isRequired() ? '[required]' : '';
            $value    = $opt->mustHaveValue() ? 'value' : '';
            $alias    = empty($opt->getAlias()) ? '' : "    aliases: " . implode(' ', array_map(static fn($a) => '--'.$a, $opt->getAlias()));

            return "  --{$opt->getName()} {$short} $value - {$opt->getDescription()}{$alias} $required";
        }, $options);

        return implode("\n", $options);
    }

    private function getCommandsString(array $commands): string {
        usort($commands, static fn(CommandInterface $a, CommandInterface $b) => $a->getName() - $b->getName());
        $commands = array_map(static function(CommandInterface $cmd) {
            return "  {$cmd->getName()} - {$cmd->getDescription()}";
        }, $commands);
        return implode("\n", $commands);
    }
}
