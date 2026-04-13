<?php

class testModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

public function calculate($number1,$number2)
    {
        $value = $number1*$number2;
        return $value;
    }
}