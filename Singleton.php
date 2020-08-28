<?php

class Singleton
{
    private static array $instance = [];

    protected function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
        throw new Exception("Cannot use __wakeup method in singleton class");
    }

    public static function getInstance(): self
    {
        $class = static::class;

        if (!isset(self::$instance[$class])) {
            self::$instance[$class] = new static;
        }

        return self::$instance[$class];
    }

}

function clientCode() {
    $std = Singleton::getInstance();
    $std->opt1 = 'opt1';
    $std1 = Singleton::getInstance();
    $std1->opt2 = 'opt2';

    if ($std === $std1) {
        print_r($std);
        print_r($std1);
    } else {
        echo 'ERROR';
    }
}

clientCode();
