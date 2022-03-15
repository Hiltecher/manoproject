<?php

class Profile
{

    function getProfile($ID)
    {

        $ID = addslashes($ID); //Adds slashes so any form of SQL injection is countered and not passed to the database.
        $DB = new Database();
        $query = "SELECT * FROM users WHERE userID = '$ID' LIMIT 1";
        //echo $query;
        return $DB->read($query);

    }



}