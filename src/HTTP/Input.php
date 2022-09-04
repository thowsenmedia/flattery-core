<?php

namespace ThowsenMedia\Flattery\HTTP;

class Input
{

    protected array $input = [];

    public function __construct()
    {
        $this->input = $_REQUEST;
    }

    public function has(...$keys):bool
    {
        foreach($keys as $key) {
            if ( ! isset($this->input[$key])) return false;
        }
        
        return true;
    }

    public function hasFile(string $key):bool
    {
        return isset($_FILES[$key]);
    }

    public function get(...$keys):array
    {
        if (count($keys) == 1 && is_array($keys[0])) {
            $keys = $keys[0];
        }

        $values = [];
        foreach($keys as $key)
        {
            $values[$key] = $this->input[$key] ?? null;
        }

        return $values;
    }

}