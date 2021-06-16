<?php
namespace Jitesoft\Cli\Arguments;

interface InputObjectInterface {

    /**
     * Get the name of the specific input object.
     * In cases of options, this is used as the 'long' version of the option.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get short description of the specific input object.
     *
     * @return string
     */
    public function getDescription(): string;

}
