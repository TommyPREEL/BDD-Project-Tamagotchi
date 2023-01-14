<?php

class Column
{
    public string $name;
    public string $type;
    public string $extras;

    public function __construct(string $name, string $type, string $extras = "")
    {
        $this->name = $name;
        $this->type = $type;
        $this->extras = $extras;
    }
}