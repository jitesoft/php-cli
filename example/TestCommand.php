<?php

use Jitesoft\Cli\Arguments\Argument;
use Jitesoft\Cli\Arguments\Command;
use Jitesoft\Cli\Arguments\Option;

// To create a new command, a new class is required.
// The command requires a name to be able to be called, while the rest of the properties are less important to override.
// The properties below are all overriden and will be invoked by the kernel depending on parsed in arguments.

class TestCommand extends Command {
    public function __construct() {
        $this->name = 'something';
        $this->description = 'A description of the command.';

        $this->arguments = [
            new Argument('test-arg', 'a test arg.')
        ];
        $this->options = [
            new Option('test-opt1', 'a test option.', 'o'),
            new Option('test-opt2', 'another test option.', 't', alias: ['aaaa', 'hkja'], isRequired: true)
        ];
    }

    public function process(array $arguments, array $options): void {
        // The arguments inside this function is a list of key-values where the key is the name of the argument
        // and the key is the passed value.
        // The same is true for the options.
        // Be sure to always check if the key exists in the array before invoking it, as only required arguments
        // and options are forced and the others might not even be in the array.


        // The input/output objects are injected into the command on creation and passes output to stdout while it reads
        // input from stdin.
        $this->output->out('Do you want to do this, really? [Y/N]');
        $input = $this->input->readChar();

        if (strtolower($input) === 'y') {
            $this->output->success('Green color which means that you did the right thing!');
        } else {
            $this->output->error('This is a red text and very very bad!');
        }
    }

}
