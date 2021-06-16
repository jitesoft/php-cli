<?php
namespace Jitesoft\Cli\IO;

/** @codeCoverageIgnore */
class OutputWriter {
    /** @var false|resource */
    private      $stream;
    private bool $colors;

    public function __construct($stream = null, $noColors = false) {
        $this->stream = $stream ?? fopen('php://stdout', 'rb');
        $this->colors = !$noColors;
    }

    public function setColors(bool $state): static {
        $this->colors = $state;
        return $this;
    }

    public function out(string $text): static {
        fwrite($this->stream, Colors::apply($text));
        return $this;
    }

    public function error(string $text): static {
        if (!$this->colors) {
            return $this->out($text);
        }

        fwrite($this->stream, Colors::apply($text, TextColor::Red));
        return $this;
    }

    public function info(string $text): static {
        if (!$this->colors) {
            return $this->out($text);
        }

        fwrite($this->stream, Colors::apply($text, TextColor::White));
        return $this;
    }

    public function warning(string $text): static {
        if (!$this->colors) {
            return $this->out($text);
        }

        fwrite($this->stream, Colors::apply($text, TextColor::Yellow));
        return $this;
    }

    public function success(string $text): static {
        if (!$this->colors) {
            return $this->out($text);
        }

        fwrite($this->stream, Colors::apply($text, TextColor::Green));
        return $this;
    }

    public function alert(string $text): static {
        if (!$this->colors) {
            return $this->out($text);
        }

        fwrite($this->stream, Colors::apply($text, TextColor::Yellow, BackgroundColor::Red));
        return $this;
    }

    public function eol(): static {
        fwrite($this->stream, PHP_EOL);
        return $this;
    }

    public function decorate(
        string $text,
        string $color = null,
        string $backgroundColor = null,
        string $decoration = null
    ): static {
        if (!$this->colors) {
            return $this->out($text);
        }
        fwrite($this->stream, Colors::apply($text, $color, $backgroundColor, $decoration));
        return $this;
    }

}
