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

public function getAllNote()
{
    $this->db->query("
        SELECT *
        FROM test
    ");

    return $this->db->resultSet();
}

public function getfilterNote($filter)
{
    $this->db->query("
        SELECT *
        FROM test
        WHERE priority = :priority
    ");

    $this->db->bind(':priority', $filter);

    return $this->db->resultSet();
}

public function addToDB($farmerID,$note,$priority)
{
    //var_dump($farmerID);
    //var_dump($note);
    //exit();


    $this->db->query("
                INSERT INTO test (farmer_id, note, priority)
                VALUES (:f_id,:Note,:priority)");

        $this->db->bind(':f_id', $farmerID);
        $this->db->bind(':Note', $note);
        $this->db->bind(':priority', $priority);

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

public function getRequestById($id)
{
   
        $this->db->query("
            SELECT *
            FROM test
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);

        return $this->db->single();
}

public function deleteById($id)
{
   
        $this->db->query("
            DELETE
            FROM test
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);

        return $this->db->execute();
}

public function updateDB($farmerID,$note,$id,$priority)
{
    //var_dump($farmerID);
    //var_dump($note);
    //exit();


    $this->db->query("
                UPDATE test
                SET farmer_id = :f_id, note = :Note, priority = :priority
                WHERE id = :id

                ");

        $this->db->bind(':f_id', $farmerID);
        $this->db->bind(':Note', $note);
        $this->db->bind(':id', $id);
        $this->db->bind(':priority', $priority);

        return $this->db->execute();
}

}