<?php
namespace Jitesoft\Cli\Arguments\Tests;

use Exception;
use Jitesoft\Cli\Arguments\Argument;
use Jitesoft\Cli\Arguments\Command;
use Jitesoft\Cli\Arguments\Manager;
use Jitesoft\Cli\Arguments\Option;
use Jitesoft\Cli\Arguments\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[CoversClass(Manager::class)]
#[Group('arguments')]
class ManagerTests extends TestCase {

    public function testGetCommand(): void {
        $commands = [
            new TestCommand1(),
            new TestCommand2()
        ];

        $manager = new Manager('', '', $commands, []);
        Parser::parse([
            'test-command2'
        ]);

        self::assertEquals($commands[1], $manager->getCommand());

        Parser::clean();
        Parser::parse([
            'test-command1',
            'argument1',
            '--option',
            'with value!'
        ]);
        self::assertEquals($commands[0], $manager->getCommand());
    }

    public function testGetCommandNoCommand(): void {
        $manager = new Manager('', '', [
            new TestCommand1()
        ]);

        Parser::parse([]);
        self::assertNull($manager->getCommand());
    }

    public function testGetOptions(): void {
        $command = new TestCommand1('test', [], [new Option('test', ''), new Option('test2', '')]);

        Parser::parse([
            'test',
            '--test',
            'abc',
        ]);

        $manager = new Manager('', '', [$command]);
        self::assertEquals(['test' => 'abc'], $manager->getOptions());

        Parser::clean();
        Parser::parse([
            'test',
            '--test2=aaaaaaaa',
            '--test',
            'abc',
        ]);

        self::assertEquals(['test2' => 'aaaaaaaa', 'test' => 'abc'], $manager->getOptions());
    }

    public function testGetOptionsConstraintRequired(): void {
        $command = new TestCommand1('test', [], [new Option('test', ''), new Option('test2', '', isRequired: true)]);

        $manager = new Manager('', '', [$command]);

        Parser::parse([
            'test',
            '--test',
            'abc',
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Option --test2 is required.');
        $manager->getOptions();
    }

    public function testGetOptionsConstraintValue(): void {
        $command = new TestCommand1('test', [], [new Option('test', ''), new Option('test2', '', mustHaveValue: true)]);

        $manager = new Manager('', '', [$command]);

        Parser::parse([
            'test',
            '--test2',
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Option --test2 requires a value.');
        $manager->getOptions();
    }

    public function testGetArguments(): void {
        $command = new TestCommand1('test', [new Argument('test', '')]);

        $manager = new Manager('', '', [$command]);

        Parser::parse([
            'test',
            'abc',
            'hej hej',
            '--opt=5',
        ]);

        self::assertEquals(['test' => 'abc'], $manager->getArguments());
    }

    public function testGetArgumentsOrder(): void {
        $command = new TestCommand1('test', [
            new Argument('test', '', index: 9999),
            new Argument('test2', '', index: 1),
            new Argument('test3', '', index: 500),
        ]);


        Parser::parse([
            'test',
            'hejpådej',
            'dinkråka',
            '"en sträng med spaces"',
            'hej hej',
            '--opt=5',
        ]);

        $manager = new Manager('', '', [$command]);

        self::assertEquals([
            'test2' => 'hejpådej',
            'test3' => 'dinkråka',
            'test'  => 'en sträng med spaces',

        ], $manager->getArguments());
    }

    public function testGetArgumentsConstraintRequired(): void {
        $command = new TestCommand1('test', [
            new Argument('test', '', required: true),
            new Argument('test2', '', required: true),
            new Argument('test3', '', required: true),
        ]);

        Parser::parse([
            'test',
            'hejpådej',
            'dinkråka',
        ]);

        $manager = new Manager('', '', [$command]);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Command test requires a minimum of 3 arguments, 2 passed.');
        $manager->getArguments();
    }

}

class TestCommand1 extends Command {
    public function __construct(string $name = 'test-command1', array $arguments = [], array $options = []) {
        $this->name = $name;
        $this->arguments = $arguments;
        $this->options = $options;
    }
}
class TestCommand2 extends Command {
    protected string $name = 'test-command2';
}
