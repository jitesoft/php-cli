<?php
namespace Jitesoft\Cli\Arguments;

interface ArgumentInterface extends InputObjectInterface {

    /**
     * If the argument is required or not.
     *
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * The index/order the argument should be when parsed.
     *
     * @return int
     */
    public function index(): int;

}
