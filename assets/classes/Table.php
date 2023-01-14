<?php 

class Table
{
    public string $name;
    public string $primaryKey;
    public array $columns;
    public array $primaryKeyplus;
    public array $foreignKeys;
    public array $uniqueKeys;

    public function __construct(string $name, string $primaryKey, array $columns,array $primaryKeyplus = [], array $foreignKeys = [], array $uniqueKeys = [])
    {
        $this->name = $name;
        $this->primaryKey = $primaryKey;
        $this->columns = $columns;
        $this->primaryKeyplus = $primaryKeyplus;
        $this->foreignKeys = $foreignKeys;
        $this->uniqueKeys = $uniqueKeys;
    }
}