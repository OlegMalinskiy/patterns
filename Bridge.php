<?php

abstract class Page {

	protected $render;

	public function __construct(Render $render) {
		$this->render = $render;
	}

	public function changeRender(Render $render) {
		$this->render = $render;
	}

	abstract public function view(): string;

}

class SimplePage extends Page {

	protected $title;
	protected $content;

	public function __construct(Render $render, string $title, string $content) {

		parent::__construct($render);

		$this->title = $title;
		$this->content = $content;
	}

	public function view(): string {

		return $this->render->renderParts([
			$this->render->renderHeader(),
			$this->render->renderTitle($this->title),
			$this->render->renderBody($this->content),
			$this->render->renderFooter(),
		]);

	}
}

class ComplexPage extends Page {

	protected $product;

	public function __construct(Render $render, Product $product) {

		parent::__construct($render);

		$this->product = $product;
	}

	public function view(): string {

		return $this->render->renderParts([
			$this->render->renderHeader(),
			$this->render->renderTitle($this->product->getTitle()),
			$this->render->renderBody($this->product->getDescription()),
			$this->render->renderImage($this->product->getImage()),
			$this->render->renderFooter(),
		]);
	}
}

class Product {
	private $title, $description, $imageUrl;

	public function __construct($title, $description, $imageUrl) {
		$this->title = $title;
		$this->description = $description;
		$this->imageUrl = $imageUrl;
	}

	public function getTitle() { return $this->title; }
	public function getDescription() { return $this->description; }
	public function getImage() { return $this->imageUrl; }
}


interface Render {

	public function renderHeader(): string;
	public function renderTitle(string $title): string;
	public function renderBody(string $content): string;
	public function renderImage(string $url): string;
	public function renderFooter(): string;
	public function renderParts(array $parts): string;
}

class HtmlRender implements Render {

	public function renderHeader(): string {
		return "<html><body>";
	}

	public function renderTitle(string $title): string {
		return "<h1>{$title}</h1>";
	}

	public function renderBody(string $content): string {
		return "<div class=\"content\">{$content}</div>";
	}

	public function renderImage(string $url): string {
		return "<img src=\"{$url}\"><br>";
	}

	public function renderFooter(): string {
		return "</body></html>";
	}

	public function renderParts(array $parts): string {
		return implode("\n", $parts);
	}
}

class JsonRender implements Render {

	public function renderHeader(): string {
		return "";
	}

	public function renderTitle(string $title): string {
		return '"title": "' . $title . '"';
	}

	public function renderBody(string $content): string {
		return '"content": "' . $content . '"';
	}

	public function renderImage(string $url): string {
		return '"img": "' . $url . '"';
	}

	public function renderFooter(): string {
		return "";
	}

	public function renderParts(array $parts): string {
		return "{\n" . implode(",\n", array_filter($parts)) . "\n}";
	}
}


function clientCode(Page $page) {
	echo $page->view();
}

$simplePage = new SimplePage(new HtmlRender, 'Title', 'Big text');

clientCode($simplePage);

$simplePage->changeRender(new JsonRender);

clientCode($simplePage);

$product = new Product('Complex title', 'Complex description', '/var/www/html/123.jpeg');
$complexPage = new ComplexPage(new HtmlRender, $product);

clientCode($complexPage);

$complexPage->changeRender(new JsonRender);

clientCode($complexPage);




?>