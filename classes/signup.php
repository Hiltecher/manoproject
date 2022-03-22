<?php

class Signup
{

    private $error = "";

    public function evaluate($data)
    {

        foreach ($data as $key => $value) {
            if(empty($value))
            {
                $this->error = $this->error . $key . " is empty.<br>";
            }

            if($key == "email")
            {   
                $query = "SELECT ID FROM users WHERE email = '$data[email]' LIMIT 1";
                $DB = new Database();
                $check = $DB->read($query);

                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) { //checks email validity

                    $this->error = $this->error . " invalid email address.<br>";
                }elseif(is_array($check)){

                    $this->error = $this->error . "another user is already using this email.<br>";

                }
            }

            if($key == "firstName")
            {
                if (is_numeric($value)) {

                    $this->error = $this->error . " first name cannot be a number.<br>";
                }

                if (strstr($value, " ")) {

                    $this->error = $this->error . " first name contains spaces.<br>";
                }
            }

            if($key == "lastName")
            {
                if (is_numeric($value)) {

                    $this->error = $this->error . " last name cannot be a number.<br>";
                }

                if (strstr($value, " ")) {

                    $this->error = $this->error . " last name contains spaces.<br>";
                }
            }

            if($key == "password")
            {
                if ($data['password'] != $data['password2'])
                {
                    $this->error = $this->error . " passwords don't match.<br>";
                }
            }

        }

        if($this->error == "")
        {
            //No errors.
            $this->createUser($data);

        }else
        {
            return $this->error;
        }
    }

    public function createUser($data)
    {

        $firstName = ucfirst($data['firstName']);
        $lastName = ucfirst($data['lastName']);
        $gender = $data['gender'];
        $password = $data['password'];
        $email = $data['email'];

        //these must be created!
		$urlAddress = strtolower($firstName) . "." . strtolower($lastName);
        $userID = $this->createUserID();

        $query = "INSERT INTO users
        (userID, firstName, lastName, gender, email, password, urlAddress)
        VALUES
        ('$userID', '$firstName', '$lastName', '$gender', '$email', '$password', '$urlAddress')";

        //echo $query;
        $db = new Database();
        $db->save($query);
    }

    private function createURL()
    {

    }

    private function createUserID()
    {
        $length = rand(4, 19); //a random number chosen between 4 and 19
        $number = "";
        for ($i = 0; $i < $length; $i = $i + 1) {
            $newRandom = rand(0, 9);
            $number = $number . $newRandom;

        }
        return $number;
    }


}