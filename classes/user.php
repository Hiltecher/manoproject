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

    public function getMates($ID)
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

    public function getFollowing($ID, $type)
    {
        $DB = new Database();
        $type = addslashes($type);

        if(is_numeric($ID))
        {
            //get details of the likes
            $query = "SELECT following FROM likes WHERE type='$type' AND contentID = '$ID' limit 1";
            $result = $DB->read($query);
            if(is_array($result))
            {
                $following = json_decode($result[0]['following'], true);
                return $following;
            }
        }
        
        return false;
    }

}


?>