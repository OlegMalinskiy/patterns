<?php

class Context
{
    private Strategy $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(Strategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function doSomeImportant(string $some_string): void
    {
        echo "<p>Do something important using - " . get_class($this->strategy) . "</p>";
        echo $this->strategy->execute($some_string);
    }
}

interface Strategy
{
    public function execute(string $some_string): string;
}

class FirstStrategy implements Strategy
{
    public function execute(string $some_string): string
    {
        return strrev($some_string);
    }
}

class SecondStrategy implements Strategy
{
    public function execute(string $some_string): string
    {
        return str_shuffle($some_string);
    }
}

$context = new Context(new FirstStrategy);
$context->doSomeImportant('Some random string');
$context->setStrategy(new SecondStrategy);
$context->doSomeImportant('New random string');
