<?php

interface CarFactory {

	public function createHatchback(): Hatchback;

	public function createSedan(): Sedan;
}

class OpelFactory implements CarFactory {

	public function createHatchback(): Hatchback {
		return new OpelHatchback;
	}

	public function createSedan(): Sedan {
		return new OpelSedan;
	}
}

class MazdaFactory implements CarFactory {

	public function createHatchback(): Hatchback {
		return new MazdaHatchback;
	}

	public function createSedan(): Sedan {
		return new MazdaSedan;
	}
}

class BmwFactory implements CarFactory {

	public function createHatchback(): Hatchback {
		return new BmwHatchback;
	}

	public function createSedan(): Sedan {
		return new BmwSedan;
	}
}


interface Hatchback {

	public function getInfo(): string;
}

class OpelHatchback implements Hatchback {

	public function getInfo(): string {
		return '<p>This is Opel Hatchback</p>';
	}
}

class MazdaHatchback implements Hatchback {

	public function getInfo(): string {
		return '<p>This is Mazda Hatchback</p>';
	}
}

class BmwHatchback implements Hatchback {

	public function getInfo(): string {
		return '<p>This is BMW Hatchback</p>';
	}
}


interface Sedan {

	public function getInfo(): string;
}

class OpelSedan implements Sedan {

	public function getInfo(): string {
		return '<p>This is Opel Sedan</p>';
	}
}

class MazdaSedan implements Sedan {

	public function getInfo(): string {
		return '<p>This is Mazda Sedan</p>';
	}
}

class BmwSedan implements Sedan {

	public function getInfo(): string {
		return '<p>This is BMW Sedan</p>';
	}
}

// Client Code

function clientFunction(CarFactory $factory) {

	$hatchback = $factory->createHatchback();
	echo $hatchback->getInfo();

	$sedan = $factory->createSedan();
	echo $sedan->getInfo();

}

clientFunction(new OpelFactory);
clientFunction(new MazdaFactory);
clientFunction(new BmwFactory);

?>