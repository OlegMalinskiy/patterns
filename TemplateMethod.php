<?php

abstract class Base
{
    public function execute(): void
    {
        $this->firstMethod();
        $this->baseMethod();
        $this->secondMethod();
    }

    public function baseMethod(): void
    {
        echo '<p>' . get_class($this) . ': call baseMethod</p>';
    }

    abstract function firstMethod(): void;

    abstract function secondMethod(): void;
}

class FirstClass extends Base
{
    public function firstMethod(): void
    {
        echo '<p>Call FirstClass::firstMethod<p>';
    }

    public function secondMethod(): void
    {
        echo '<p>Call FirstClass::secondMethod</p>';
    }
}

class SecondClass extends Base
{
    public function firstMethod(): void
    {
        echo '<p>Call SecondClass::firstMethod</p>';
    }

    public function secondMethod(): void
    {
        echo '<p>Call SecondClass::secondMethod</p>';
    }
}

function client(Base $base) {
    $base->execute();
}

client(new FirstClass);

echo '<hr>';

client(new SecondClass);
