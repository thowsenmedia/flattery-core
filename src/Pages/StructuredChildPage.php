<?php

namespace ThowsenMedia\Flattery\Pages;

use ThowsenMedia\Flattery\HTML\Element;

class StructuredChildPage extends Page
{

    protected array $siblings = [];

    public function __construct(string $name, string $file, array $data, string $source)
    {
        parent::__construct($name, $file, $data, $source);
    }

    public function getRoutePath():string
    {
        $name = explode('/', $this->name);
        foreach($name as $k => $n) {
            if ($n == 'children') {
                array_unset($k, $name);
            }
        }

        return implode('/', $name);
    }

    public function getParentRoutePath():string
    {
        $name = explode('/', $this->name);
        return implode('/', array_slice($name, 0, count($name) - 2));
    }

    public function getParentPage():StructuredPage
    {
        $parentPath = $this->getParentRoutePath();
        return pages()->get($this->getParentRoutePath());
    }

    public function renderMenu(array $classes = [], string $activeClass = 'active')
    {
        return $this->getParentPage()->renderMenu($classes, $activeClass);
    }

}