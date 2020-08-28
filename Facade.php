<?php

class Facade
{
    protected FirstLibraryClass $firstLibrary;
    protected SecondLibraryClass $secondLibrary;

    public function __construct()
    {
        $this->firstLibrary = new FirstLibraryClass;
        $this->secondLibrary = new SecondLibraryClass;
    }

    public function operation(): string
    {
        $result = '';

        $result .= $this->firstLibrary->doSomeOperation();
        $result .= $this->secondLibrary->doMoreOperation();
        $result .= '<p>Add another functionality</p>';
        $result .= $this->firstLibrary->doAnotherOperation();
        $result .= $this->secondLibrary->doOperation();

        return $result;
    }
}


class FirstLibraryClass
{
    public function doSomeOperation(): string
    {
        return '<p>Do some operation from FirstLibraryClass</p>';
    }

    public function doAnotherOperation(): string
    {
        return '<p>Do another operation from FirstLibraryClass</p>';
    }
}

class SecondLibraryClass
{
    public function doOperation(): string
    {
        return '<p>Do operation from SecondLibraryClass</p>';
    }

    public function doMoreOperation(): string
    {
        return '<p>Do more operation from SecondLibraryClass</p>';
    }
}

function clientCode(Facade $facade) {
    echo $facade->operation();
}

clientCode(new Facade);
