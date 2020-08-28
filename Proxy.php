<?php

interface Receiver
{
    public function getInfo(int $id): string;
}

class SimpleReceiver implements Receiver
{
    public function getInfo(int $id): string
    {
        return "<p>Some information from SimpleReceiver with id = {$id}</p>";
    }
}

class CacheReceiver implements Receiver
{
    private SimpleReceiver $simple;
    private array $cache = [];

    public function __construct(SimpleReceiver $simple)
    {
        $this->simple = $simple;
    }

    public function getInfo(int $id): string
    {
        if (!isset($this->cache[$id])) {
            $info = $this->simple->getInfo($id);
            $this->cache[$id] = $info;
            return $info;
        } else {
            $info = sprintf("<hr>From cache! %s<hr>", $this->cache[$id]);
            return $info;
        }
    }
}

function clientCode(Receiver $receiver) {
    echo $receiver->getInfo(2);
    echo $receiver->getInfo(3);
    echo $receiver->getInfo(2);
    echo $receiver->getInfo(3);
    echo $receiver->getInfo(2);
    echo $receiver->getInfo(1);
}

$simple = new SimpleReceiver;

clientCode($simple);
clientCode(new CacheReceiver($simple));
