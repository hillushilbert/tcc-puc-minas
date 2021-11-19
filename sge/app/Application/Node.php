<?php

namespace App\Application;

class Node
{
    public $name;
    public $linked = array();
    public $paths = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function link_to(Node $node, $also = true)
    {
        if (!$this->linked($node)){
            $this->linked[] = $node;
            $this->paths[$node->name] =  New Path($this,$node);
        }

        if ($also) {
            $node->link_to($this, false);
        }
        return $this;
    }

    public function getPath($name)
    {
        return $this->paths[$name] ?? null;
    }

    private function linked(Node $node)
    {
        foreach ($this->linked as $l) { if ($l->name === $node->name) return true; }
        return false;
    }

    public function not_visited_nodes($visited_names)
    {
        $ret = array();
        foreach ($this->linked as $l) {
            if (!in_array($l->name, $visited_names)) $ret[] = $l;
        }
        return $ret;
    }

    public function equals(Node $node){
        return ($node->name == $this->name) ? true : false;
    }
}