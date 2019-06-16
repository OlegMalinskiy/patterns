<?php

class ItemsIterator implements \Iterator {

	/**
	 * @var ItemsCollection
	 */
	private $collection;

	/**
	 * @var int
	 */
	private $position = 0;

	/**
	 * @var bool
	 */
	private $reverse = false;

	public function __construct($collection, $reverse = false) {

		$this->collection = $collection;
		$this->reverse = $reverse;
	}

	public function current() {

		return $this->collection->getItems()[$this->position];
	}

 	public function key() {

 		return $this->position;
 	}

	public function next() {

		$this->position += $this->reverse ? -1 : 1;
	}

	public function rewind() {

		$this->position = $this->reverse ? count($this->collection->getItems()) - 1 : 0;
	}

	public function valid() {

		return isset($this->collection->getItems()[$this->position]);
	}
}

class ItemsCollection implements \IteratorAggregate {

	/**
	 * @var array
	 */
	private $items = [];

	public function getItems() {

		return $this->items;
	}

	public function addItem($item) {

		$this->items[] = $item;
	}

	public function getIterator(): \Iterator {

		return new ItemsIterator($this);
	}

	public function getReverseIterator(): \Iterator {

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


?>