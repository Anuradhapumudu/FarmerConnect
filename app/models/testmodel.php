<?php

class testModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

public function calculate($number1,$number2,$operation)
    {
        $value;

        if($operation == '+')
            {
               $value = $number1 + $number2;
            }
        else if($operation == '-')
            {
                $value = $number1 - $number2;
            }
        else if($operation == '*')
            {
                $value = $number1 * $number2;
            }
        else if($operation == '/')
            {
                $value = $number1 / $number2;
            }
      
        return($value);

    }

public function addToDB($farmerID,$note)
{
    //var_dump($farmerID);
    //var_dump($note);
    //exit();


    $this->db->query("
                INSERT INTO test (farmer_id, note)
                VALUES (:f_id,:Note)");

        $this->db->bind(':f_id', $farmerID);
        $this->db->bind(':Note', $note);

        return $this->db->execute();
}

public function listnotes($farmerID)
{
    //var_dump($farmerID);
    //var_dump($note);
    //exit();


    $this->db->query("
        SELECT *
        FROM test
        WHERE farmer_id = :f_id
    ");

    $this->db->bind(':f_id', $farmerID);

    return $this->db->resultSet();
}

}