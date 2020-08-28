<?php

class ItemsIterator implements Iterator
{
    private ItemsCollection $collection;
    private int $position = 0;
    private bool $reverse = false;

    public function __construct(ItemsCollection $collection, bool $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }

    public function current()
    {
        return $this->collection->getItems()[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position += $this->reverse ? -1 : 1;
    }

    public function rewind(): void
    {
        $this->position = $this->reverse ? count($this->collection->getItems()) - 1 : 0;
    }

    public function valid(): bool
    {
        return isset($this->collection->getItems()[$this->position]);
    }
}

class ItemsCollection implements IteratorAggregate
{
    private array $items = [];

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem($item): void
    {
        $this->items[] = $item;
    }

    public function getIterator(): Iterator
    {
        return new ItemsIterator($this);
    }

    public function getReverseIterator(): Iterator
    {
        return new ItemsIterator($this, true);
    }
}

$items_collection = new ItemsCollection;
$items_collection->addItem('First Item');
$items_collection->addItem('Second Item');
$items_collection->addItem('Third Item');

foreach ($items_collection->getIterator() as $key => $value) {
    echo sprintf('<p>%s) %s</p>', ++$key, $value);
}

foreach ($items_collection->getReverseIterator() as $key => $value) {
    echo sprintf('<p>%s) %s</p>', ++$key, $value);
}
