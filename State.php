<?php

class Context {

	/**
	 * @var State
	 */
	private $state;

	public function __construct(State $state) {

		$this->setState($state);
	}

	public function setState(State $state): void {

		echo "<p>Context: set new state - " . get_class($state) . "</p>";
		$this->state = $state;
		$this->state->setContext($this);
	}

	public function doRequest1(): void {

		$this->state->handle1();
	}

	public function doRequest2(): void {

		$this->state->handle2();
	}

}

abstract class State {

	/**
	 * @var Context
	 */
	protected $context;

	public function setContext(Context $context) {

		$this->context = $context;
	}

	abstract public function handle1(): void;

	abstract public function handle2(): void;
}

class FirstState extends State {

	public function handle1():void {

		echo "<p>Context: do handle1 of FirstState</p>";
		echo "<p>FirstState: change Context state to SecondState</p>";
		$this->context->setState(new SecondState);
	}

	public function handle2(): void {

		echo "<p>Context: do handle2 of FirstState</p>";
	}
}

class SecondState extends State {

	public function handle1(): void {

		echo "<p>Context: do handle1 of SecondState</p>";
	}

	public function handle2(): void {

		echo "<p>Context: do handle2 of SecondState</p>";
		echo "<p>SecondState: change Context state to FirstState</p>";
		$this->context->setState(new FirstState);
	}
}

$context = new Context(new FirstState);
$context->doRequest1();
$context->doRequest2();

?>