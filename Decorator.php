<?php

interface Input
{
    public function getInfo(): string;
}

class TextComponent implements Input
{
    protected string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getInfo(): string
    {
        return $this->text;
    }
}

class MainDecorator implements Input
{
    protected Input $wrap;

    public function __construct(Input $wrap)
    {
        $this->wrap = $wrap;
    }

    public function getInfo(): string
    {
        return $this->wrap->getInfo();
    }
}

class SaveTextDecorator extends MainDecorator
{
    public function getInfo(): string
    {
        $text = parent::getInfo();

        return strip_tags(trim($text));
    }
}

class FormatTextDecorator extends MainDecorator
{
    public function getInfo(): string
    {
        $text = parent::getInfo();

        return ucfirst(strtolower($text));
    }
}


function clientCode(Input $input): void {
    echo $input->getInfo();
}

$input = new TextComponent('Very simple text');

clientCode($input);

$input = new SaveTextDecorator(new TextComponent('  <h1>Text with tags<h1>  '));

clientCode($input);

$input = new SaveTextDecorator(new TextComponent('   <h3>TexT WitH Different italIcs AND TagS</h3>  '));
$input = new FormatTextDecorator($input);

clientCode($input);
