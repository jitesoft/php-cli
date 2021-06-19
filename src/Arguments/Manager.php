<?php
namespace Jitesoft\Cli\Arguments;

use Exception;
use Jitesoft\Cli\Defaults\Usage;
use Jitesoft\Cli\IO\InputReader;
use Jitesoft\Cli\IO\OutputWriter;
use Jitesoft\Cli\UsageInterface;

class Manager implements InputObjectInterface {


    /** @var array|CommandInterface[] */
    private array          $commands;
    private array          $globalOptions;
    private string         $name;
    private string         $description;
    private UsageInterface $usage;
    private OutputWriter   $output;
    private InputReader    $input;

    /**
     * Creates a new manager to handle commands and parsing of arguments.
     *
     * @param array|CommandInterface[] $commands
     */
    public function __construct(string $name, string $description, array $commands, array $globalOptions = []) {
        $this->globalOptions = $globalOptions;
        $this->commands      = $commands;
        $this->name          = $name;
        $this->description   = $description;
        $this->usage         = new Usage();
        $this->output        = new OutputWriter();
        $this->input         = new InputReader();
    }

    public function invokeCommand(CommandInterface $command, array $argv = null): void {
        $command->setInput($this->input)
                ->setOutput($this->output);

        try {
            $args = $this->getArguments();
            $opts = $this->getOptions();

            $command->process($args, $opts);
        } catch (Exception $ex) {
            $this->output->error($ex->getMessage());
        }
    }

    /**
     * Get options from argument list.
     *
     * @return array Options as an assoc array with [name => value].
     * @throws Exception
     */
    public function getOptions(): array {
        $parsed  = Parser::parse();
        $command = $this->findCommand($parsed['command']);
        $options = $parsed['options'];
        $opts    = [];

        // Match all options in the command.
        foreach ($command?->getOptions() ?? [] as $option) {
            foreach ($options as $name => $value) {
                $lowerCaseName = strtolower($name);
                if ($lowerCaseName === strtolower($option->getName()) ||
                    $lowerCaseName === strtolower($option->getShort())) {

                    $opts[$option->getName()] = $value;
                    break;
                }

                $mappedToLower = array_map(static fn($s) => strtolower($s), $option->getAlias());
                if (in_array($lowerCaseName, $mappedToLower, true)) {
                    $opts[$option->getName()] = $value;
                    break;
                }
            }
        }

        // Check constraints.
        foreach ($command?->getOptions() ?? [] as $option) {
            if ($option->isRequired() && !array_key_exists($option->getName(), $opts)) {
                throw new Exception(sprintf('Option --%s is required.', $option->getName()));
            }

            if ($option->mustHaveValue() && $opts[$option->getName()] === null) {
                throw new Exception(sprintf('Option --%s requires a value.', $option->getName()));
            }
        }

        return $opts;
    }

    public function getArguments(): array {
        $parsed    = Parser::parse();
        $command   = $this->findCommand($parsed['command']);
        $arguments = $parsed['arguments'];
        $args      = [];
        $cmdArgs   = $command->getArguments();
        $cmdLen    = count($cmdArgs);

        // Order arguments and create list.
        usort($cmdArgs, static fn(ArgumentInterface $a, ArgumentInterface $b) => $a->index() - $b->index());

        // Count minimumn args.
        $required = array_filter($cmdArgs, static fn(ArgumentInterface $a) => $a->isRequired());
        if (count($arguments) < count($required)) {
            throw new Exception(
                sprintf(
                    'Command %s requires a minimum of %d arguments, %d passed.',
                    $command->getName(),
                    count($required),
                    count($arguments)
                )
            );
        }

        for ($i = 0; $i < $cmdLen; $i++) {
            $args[$cmdArgs[$i]->getName()] = $arguments[$i];
        }

        return $args;
    }

    private function findCommand(?string $cmd = null) {
        if (!$cmd) {
            return null;
        }

        foreach ($this->commands as $command) {
            if (strtolower($command->getName()) === strtolower($cmd)) {
                return $command;
            }
        }

        return null;
    }

    /**
     * Get command from argument list.
     *
     * @param array|null $argv
     * @return CommandInterface|null
     */
    public function getCommand(): ?CommandInterface {
        return $this->findCommand(Parser::parse()['command']);
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function usage(?CommandInterface $command = null): static {
        $this->output->out($this->usage->getUsage($this, $command));
        return $this;
    }

    public function getGlobalOptions(): array {
        return $this->globalOptions;
    }

    public function getCommands(): array {
        return $this->commands;
    }
}
