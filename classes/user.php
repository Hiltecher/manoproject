<?php

//This is the user class representing manoverse users

class User
{

    public function getData($ID)
    {

        $query = "SELECT * FROM users WHERE userID = '$ID' limit 1";
        $db = new Database();
        $result = $db->read($query);

        if($result)
        {   
            $row = $result[0];
            return $row;

        }else{

            return false;
        }

    }

    public function getUser($ID)
    {
        
        $query = "SELECT * FROM users WHERE userID = '$ID' limit 1"; //create a query
        $DB = new Database(); //instantiate the Database class
        $result = $DB->read($query);      //get a result from the query

        if($result)
        {
            return $result[0];
        }else{
            return false;
        }


    }

    public function getNewUsers($ID)
    {
        
        $query = "SELECT * FROM users WHERE userID != '$ID' ORDER BY ID DESC LIMIT 5";
        $DB = new Database(); //instantiate the Database class
        $result = $DB->read($query);      //get a result from the query

        if($result)
        {
            return $result;
        }else{
            return false;
        }


    }

}


?>