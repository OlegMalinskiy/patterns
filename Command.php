<?php

interface Command
{
    public function execute(): void;
}

class SimpleCommand implements Command
{
    protected string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function execute(): void
    {
        echo "This class can do very simple command. Like show you this text: {$this->text}. <br>";
    }
}

class ComplexCommand implements Command
{
    protected Receiver $receiver;
    protected string $actionOne;
    protected string $actionTwo;

    public function __construct(Receiver $receiver, string $actionOne, string $actionTwo)
    {
        $this->receiver = $receiver;
        $this->actionOne = $actionOne;
        $this->actionTwo = $actionTwo;
    }

    public function execute(): void
    {
        echo "This class can do difficult command and send them to class Receiver <br>";
        $this->receiver->makeFirstAction($this->actionOne);
        $this->receiver->makeSecondAction($this->actionTwo);
    }
}

class Receiver
{
    public function makeFirstAction(string $a): void
    {
        echo "Do first action with text: {$a}. <br>";
    }

    public function makeSecondAction(string $b): void
    {
        echo "Do second action with text: {$b}. <br>";
    }
}


class Invoker
{
    protected array $commands = [];

    public function addCommand(Command $command): void
    {
        $this->commands[] = $command;
    }

    public function callCommands(): void
    {
        if (!empty($this->commands)) {

            foreach ($this->commands as $command) {
                $command->execute();
            }
        } else {

            echo "Array of Commands is empty.<br>";
        }
    }
}

/**
 * Client code
 */

$invoker = new Invoker;

$invoker->addCommand(new SimpleCommand('Text for SimpleCommand'));
$receiver = new Receiver;
$invoker->addCommand(new ComplexCommand($receiver, 'Text for firstAction', 'Text for Second Action'));
$invoker->addCommand(new SimpleCommand('Another text for SimpleCommand'));

$invoker->callCommands();
