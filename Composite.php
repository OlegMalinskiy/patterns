<?php

abstract class FormElement
{
    protected string $name;
    protected string $title;
    protected array $data;

    public function __construct(string $name, string $title)
    {
        $this->name = $name;
        $this->title = $title;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    abstract public function render(): string;
}

class Input extends FormElement
{
    private string $type;

    public function __construct(string $name, string $title, string $type)
    {
        parent::__construct($name, $title);

        $this->type = $type;
    }

    public function render(): string
    {
        return "<lable for=\"{$this->name}\">{$this->title}</label>\n" .
            "<input name=\"{$this->name}\" type=\"{$this->type}\" value=\"{$this->data}\">\n";
    }
}

abstract class FieldComposite extends FormElement
{
    protected array $fields = [];

    public function add(FormElement $field): void
    {
        $name = $field->getName();
        $this->fields[$name] = $field;
    }

    public function remove(FormElement $component): void
    {
        $this->fields = array_filter($this->fields, function ($child) use ($component) {
            return $child != $component;
        });
    }

    public function setData(array $data): void
    {
        foreach ($this->fields as $name => $field) {
            if (isset($data[$name])) {
                $field->setData($data[$name]);
            }
        }
    }

    public function getData(): array
    {
        $data = [];

        foreach ($this->fields as $name => $field) {
            $data[$name] = $field->getData();
        }

        return $data;
    }

    public function render(): string
    {
        $output = "";

        foreach ($this->fields as $name => $field) {
            $output .= $field->render();
        }

        return $output;
    }
}

class FieldSet extends FieldComposite
{
    public function render(): string
    {
        $output = parent::render();

        return "<fieldset><legend>{$this->title}</legend>\n$output</fieldset>\n";
    }
}

class Form extends FieldComposite
{
    private string $url;

    public function __construct(string $name, string $title, string $url)
    {
        parent::__construct($name, $title);
        $this->url = $url;
    }

    public function render(): string
    {
        $output = parent::render();

        return "<form action=\"{$this->url}\"><h3>{$this->title}</h3>$output</form>";
    }
}

function getProductForm(): Form {
    $form = new Form('form', 'Add product', '#');
    $form->add(new Input('name', 'Name', 'text'));
    $form->add(new Input('description', 'Description', 'text'));

    $picture = new FieldSet('photo', 'Product photo');
    $picture->add(new Input('caption', 'Caption', 'text'));
    $picture->add(new Input('image', 'Image', 'file'));

    $form->add($picture);
    $form->add(new Input('submit', '', 'submit'));

    return $form;
}

function loadProductData(FormElement $form): void {
    $data = [
        'name'        => 'HP',
        'description' => 'laptop',
        'photo'       => [
            'caption' => 'Front photo',
            'image'   => 'Photo.png',
        ],
        'submit'      => 'Отправить',
    ];

    $form->setData($data);
}

function renderProduct(FormElement $product) {
    echo $product->render();
}

$form = getProductForm();
loadProductData($form);
renderProduct($form);
