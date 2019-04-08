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

	public function getProduct() {
		return new CostaProduct;
	}
}

class MscCreator extends Creator {

	public function getProduct() {
		return new MscProduct;
	}
}

class CelestyalCreator extends Creator {

	public function getProduct() {
		return new CelestyalProduct;
	}
}

interface Product {
	public function make(): void;
	public function edit(): void;
	public function delete(): void;
}

class CostaProduct implements Product {

	public function make(){
		echo 'make something by CostaProduct class';
		return true;
	}

	public function edit(){
		echo 'edit something by CostaProduct class';
		return true;
	}

	public function delete(){
		echo 'delete something by CostaProduct class';
		return true;
	}
}

class MscProduct implements Product {

	public function make(){
		echo 'make something by MscProduct class';
		return true;
	}

	public function edit(){
		echo 'edit something by MscProduct class';
		return true;
	}

	public function delete(){
		echo 'delete something by MscProduct class';
		return true;
	}
}

class CelestyalProduct implements Product {

	public function make(){
		echo 'make something by CelestyalProduct class';
		return true;
	}

	public function edit(){
		echo 'edit something by CelestyalProduct class';
		return true;
	}
	
	public function delete(){
		echo 'delete something by CelestyalProduct class';
		return true;
	}
}


function clientCode(Creator $creator) {

	$creator->doOperation();
	$creator->doOperation();

}

clientCode(new CostaCreator);
clientCode(new MscCreator);
clientCode(new CelestyalCreator);