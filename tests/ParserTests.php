<?php
namespace Jitesoft\Cli\Arguments\Tests;

use Jitesoft\Cli\Arguments\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[Group('arguments')]
class ParserTests extends TestCase {

    public function testParseValidArguments(): void {
        $out = Parser::parse([
            'command',
            'arg-1',
            'arg-2',
            'arg-3'
        ]);

        self::assertEquals([
            'arg-1',
            'arg-2',
            'arg-3'
        ], $out['arguments']);
    }

    public function testParseCommand(): void {
        $out = Parser::parse(['command']);
        self::assertEquals('command', $out['command']);
    }

    public function testParseOptions(): void {
        $out = Parser::parse([
            '--test',
            '--test2=abc',
            '--test3',
            'efg',
            '--test4',
            '   abc123     ',
            '--test5',
            'a text with many parts',
            '--test6',
            '" another text!11!!""""    '
        ]);

        self::assertEquals([
            'test'  => 1,
            'test2' => 'abc',
            'test3' => 'efg',
            'test4' => 'abc123',
            'test5' => 'a text with many parts',
            'test6' => 'another text!11!!'
        ], $out['options']);
    }

    public function testParseOptionsAndArgsCorrect(): void {
        $out = Parser::parse([
            'command',
            'arg1',
            'arg2',
            '--opt1', 'value for opt1',
            '--opt2=something',
            '--opt3', '" opt threeee  '
        ]);

        self::assertEquals(['arg1', 'arg2'], $out['arguments']);
        self::assertEquals([
            'opt1' => 'value for opt1',
            'opt2' => 'something',
            'opt3' => 'opt threeee'
            ],
            $out['options']
        );

    }

    public function testParseOptionsAndArgsBad(): void {
        $out = Parser::parse([
            'command',
            'arg1',
            'arg2',
            '--opt1', 'value for opt1',
            'arg3',
            '--opt2=something',
            '--opt3', '" opt threeee  '
        ]);

        self::assertEquals(['arg1', 'arg2'], $out['arguments']);
        self::assertEquals([
            'opt1' => 'value for opt1 arg3', // This is wrong, but expected to happen. User be smart!
            'opt2' => 'something',
            'opt3' => 'opt threeee'
        ],
            $out['options']
        );
    }

}
