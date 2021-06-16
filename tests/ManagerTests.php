<?php
namespace Jitesoft\Cli\Arguments\Tests;

use Exception;
use Jitesoft\Cli\Arguments\Argument;
use Jitesoft\Cli\Arguments\Command;
use Jitesoft\Cli\Arguments\Manager;
use Jitesoft\Cli\Arguments\Option;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[CoversClass(Manager::class)]
#[Group('arguments')]
class ManagerTests extends TestCase {

    public function testGetCommand(): void {
        $commands = [
            new Command('test-command1', ''),
            new Command('test-command2', ''),
        ];

        $manager = new Manager('', '', $commands);

        self::assertEquals($commands[1], $manager->getCommand([
            'test-command2',
        ]));

        self::assertEquals($commands[0], $manager->getCommand([
            'test-command1',
            'argument1',
            '--option',
            'with value!',
        ]));
    }

    public function testGetCommandNoCommand(): void {
        $manager = new Manager('', '', []);
        self::assertNull($manager->getCommand(['a', 'b']));
    }

    public function testGetOptions(): void {
        $command = new Command('test', '', [], [new Option('test', ''), new Option('test2', '')]);

        $manager = new Manager('', '', [$command]);
        self::assertEquals(['test' => 'abc'], $manager->getOptions([
            'test',
            '--test',
            'abc',
        ]));

        self::assertEquals(['test2' => 'aaaaaaaa', 'test' => 'abc'], $manager->getOptions([
            'test',
            '--test2=aaaaaaaa',
            '--test',
            'abc',
        ]));
    }

    public function testGetOptionsConstraintRequired(): void {
        $command = new Command('test', '', [], [new Option('test', ''), new Option('test2', '', isRequired: true)]);

        $manager = new Manager('', '', [$command]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Option --test2 is required.');
        $manager->getOptions([
            'test',
            '--test',
            'abc',
        ]);
    }

    public function testGetOptionsConstraintValue(): void {
        $command = new Command('test', '', [], [new Option('test', ''), new Option('test2', '', mustHaveValue: true)]);

        $manager = new Manager('', '', [$command]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Option --test2 requires a value.');
        $manager->getOptions([
            'test',
            '--test2',
        ]);
    }

    public function testGetArguments(): void {
        $command = new Command('test', '', [new Argument('test', '')]);

        $manager = new Manager('', '', [$command]);

        self::assertEquals(['test' => 'abc'], $manager->getArguments([
            'test',
            'abc',
            'hej hej',
            '--opt=5',
        ]));
    }

    public function testGetArgumentsOrder(): void {
        $command = new Command('test', '', [
            new Argument('test', '', index: 9999),
            new Argument('test2', '', index: 1),
            new Argument('test3', '', index: 500),
        ]);

        $manager = new Manager('', '', [$command]);

        self::assertEquals([
            'test2' => 'hejpådej',
            'test3' => 'dinkråka',
            'test'  => 'en sträng med spaces',
        ], $manager->getArguments([
            'test',
            'hejpådej',
            'dinkråka',
            '"en sträng med spaces"',
            'hej hej',
            '--opt=5',
        ]));
    }

    public function testGetArgumentsConstraintRequired(): void {
        $command = new Command('test', '', [
            new Argument('test', '', required: true),
            new Argument('test2', '', required: true),
            new Argument('test3', '', required: true),
        ]);

        $manager = new Manager('', '', [$command]);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Command test requires a minimum of 3 arguments, 2 passed.');
        $manager->getArguments([
            'test',
            'hejpådej',
            'dinkråka',
        ]);
    }

}
