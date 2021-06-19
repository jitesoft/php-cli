# jitesoft/cli

Simple multi-command CLI helper/kernel with parsing capabilities and automatically created help/usage output.  

Creating new commands is easily done by creating a new class inheriting the abstract Command class and implement
the `process` method.  
Commands are auto-resolved via dependency injection allowing the kernel to automatically resolve dependencies
for the Command via constructor injection.

For a simple example, take a look in the `example` folder. Further documentation will be added later on.
