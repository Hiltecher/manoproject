<?php

class Login

{

    private $error = "";

    public function evaluate($data)
    {

        $email = addslashes($data['email']);
        $password = addslashes($data['password']);

        $query = "SELECT * FROM users WHERE email = '$email' limit 1 ";
         
        //echo $query;
        $db = new Database();
        $result = $db->read($query);

        if($result)
        {

            $row = $result[0];

            if($password == $row['password'])
            {

                //create some session data
                $_SESSION['manoverseUserID'] = $row['userID'];

            }else{

                $this->error .= "wrong password.<br>";
            }


        }else{

            $this->error .= "that email doesn't exist.<br>";
        }
        
        return $this->error;
   
    }

    public function checkLogin($ID)
    {   
        
        if(is_numeric($ID))
        {

            $query = "SELECT * FROM users WHERE userID = '$ID' limit 1";
                
            //echo $query;
            $db = new Database();
            $result = $db->read($query);

            if($result)
            {

                $userData = $result[0];
                return $userData;

            }else{

                header("Location: login.php");
                die;

            }
        
        }else{

            header("Location: login.php");
            die;
        }
        
    }
}