<?php

abstract class Creator {

	abstract public function getProduct(): Product;

	public function doOperation() {

		$product = $this->getProduct();

		$product->make();
		$product->edit();
		$product->delete();

	} 

}

class CostaCreator extends Creator {

	public function getProduct(): Product {
		return new CostaProduct;
	}
}

class MscCreator extends Creator {

	public function getProduct(): Product {
		return new MscProduct;
	}
}

class CelestyalCreator extends Creator {

	public function getProduct(): Product {
		return new CelestyalProduct;
	}
}

interface Product {
	public function make(): void;
	public function edit(): void;
	public function delete(): void;
}

class CostaProduct implements Product {

	public function make(): void {
		echo '<p>make something by CostaProduct class</p>';
	}

	public function edit(): void {
		echo '<p>edit something by CostaProduct class</p>';
	}

	public function delete(): void {
		echo '<p>delete something by CostaProduct class</p>';
	}
}

class MscProduct implements Product {

	public function make(): void {
		echo '<p>make something by MscProduct class</p>';
	}

	public function edit(): void {
		echo '<p>edit something by MscProduct class</p>';
	}

	public function delete(): void {
		echo '<p>delete something by MscProduct class</p>';
	}
}

class CelestyalProduct implements Product {

	public function make(): void {
		echo '<p>make something by CelestyalProduct class</p>';
	}

	public function edit(): void {
		echo '<p>edit something by CelestyalProduct class</p>';
	}
	
	public function delete(): void {
		echo '<p>delete something by CelestyalProduct class</p>';
	}
}


function clientCode(Creator $creator) {

	$creator->doOperation();

}

clientCode(new CostaCreator);
clientCode(new MscCreator);
clientCode(new CelestyalCreator);