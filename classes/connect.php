<?php

class Database
{

    private $host = 'localhost';    
    private $username = 'root';
    private $password = '';
    private $db = 'manoverse';

    function connect()
    {
        $conn = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        return $conn;
    }


    function read($sql)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $sql);

        if(!$result)
        {
            return false;
        }
        else
        {
            $data = false;
            while($row = mysqli_fetch_assoc($result))

            {
                $data[] = $row;
            }

            return $data;
        }

    }


    function save($sql)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $sql);

        if(!$result)
        {
            return false;
        }
        else
        {
            return true;
        }
        
    }

}