<?php

use Jitesoft\Container\Container;

require_once 'vendor/autoload.php';

// A custom kernel is created, naming the 'cli application' to 'cli' and settings its description to
// 'A test cli.'.
// The container passed at the end is not required, but a pre-filled container can be used.
//
// Observe, the container must implement the Jitesoft/Container/ContainerInterface,
// which is a extended version of the Psr\Container\ContainerInterface. This is due to the
// psr interface not forcing a set nor unset method, which is needed inside the kernel to auto-resolve
// dependencies via the container.

$k = new TestKernel('cli', 'A test cli.', new Container([]));

// Process can either be called with an array of arguments or (default) nothing to let it use the global $argv var.
// If passing an array, it should have the command name as first argument, then the argument values and lastly
// any arguments. The following options styles is valid:
//
// [--arg=value]
// [--arg, value]
// [--arg, "value with space and quotations"]
// [--arg]
// [--arg="value with space and quotations"]

// Process will handle any invocation of the commands depending on the passed arguments.
$k->process();
