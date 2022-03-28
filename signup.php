<?php

    include("classes/connect.php");
    include("classes/signup.php");

    $firstName = ""; //this code is to clear the boxes
    $lastName = "";
    $gender = "";
    $email = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $signup = new Signup();
        //echo "Post data is: " . $_POST['firstName'];
        //echo "Post data is: " . $_POST['lastName'];
        //echo "Post data is: " . $_POST['gender'];
        //echo "Post data is: " . $_POST['email'];
        //echo "Post data is: " . $_POST['password'];
        //echo "Post data is: " . $_POST['urlAddress'];
        $result = $signup->evaluate($_POST);


        if($result != ""){

            echo "<div style='text-align:center; font-size: 16px; color: black;'>";
            echo "oh snap! some problems cropped up: <br><br>";
            echo $result;
            echo "<div>";

        }else{

            header("Location: login.php");
            die;
        }
        
        $firstName = $_POST['firstName']; //this code is to avoid retyping and improve usability
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];


    }

?>

<!DOCTYPE html>

<html>

    <head>

        <title>manoverse | signup</title>

    </head>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="main.css">

    <body id='background'>
        <div id='bar'>

            <div style='font-size: 40px;'>manoverse</div>
            <a href='login.php'><div id='signup'>log in</div></a>
        </div>

        <div id='signupbox'>
            
            <div>join the manoverse!</div><br>

            <form method="post" action="">

                <input value='<?php echo $firstName ?>' name='firstName' type='text' id='text' placeholder='first name'><br>
                <input value='<?php echo $lastName ?>' name='lastName' type='text' id='text' placeholder='last name'><br>
                <span style='font-weight: normal; font-size: smaller;'>gender:</span><br>
                <select id='text' name='gender'>
                    <option><?php echo $gender ?></option>
                    <option>male</option>
                    <option>female</option>
                </select><br>
                <input value='<?php echo $email ?>' name='email' type='text' id='text' placeholder='email address'><br>
                <input name='password' type='password' id='text' placeholder='password'><br>
                <input name='password2' type='password' id='text' placeholder='retype password'><br>
                <input type='submit' id='button' value='sign up'>

            </form>

        </div>

    </body>
</html>