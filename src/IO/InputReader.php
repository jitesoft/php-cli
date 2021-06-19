<?php
namespace Jitesoft\Cli\IO;

/** @codeCoverageIgnore  */

class InputReader {
    /** @var false|resource */
    protected $stream;

    public function __construct($stream = null) {
        $this->stream = $stream ?? fopen('php://stdin', 'rb');
    }

    public function readLine(): string {
        return fgets($this->stream);
    }

    public function readChar(): string {
        return fgetc($this->stream);
    }

}
