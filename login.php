<?php

session_start();

    include("classes/connect.php");
    include("classes/login.php");

    $email = ""; //this code is to clear the boxes
    $password = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $login = new Login();
        //echo "Post data is: " . $_POST['email'];
        //echo "Post data is: " . $_POST['password'];
        $result = $login->evaluate($_POST);

        if($result != ""){

            echo "<div style='text-align:center; font-size: 16px; color: black;'>";
            echo "oh snap! some problems cropped up: <br><br>";
            echo $result;
            echo "<div>";

        }else{

            header("Location: profile.php");
            die;
        }
        
        $email = $_POST['email'];
        $password = $_POST['password']; //this code is to avoid retyping and improve usability
    }
?>

<html>

    <head>

        <title>manoverse | login</title>

    </head>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">

    <body id='background'>
        <div id='bar'>

            <div style='font-size: 40px;'>manoverse</div>
            <a href='signup.php'><div id='signup'>sign up</div></a>

        </div>

        <div id='loginbox'>

            <form method="post">

                <div>log in to the manoverse!</div><br>

                <input name="email" value="<?php echo $email ?>" name="email" id="text" placeholder="Email"><br><br>
                <input name="password" value="<?php echo $password ?>" type='password' id='text' placeholder='Password'><br>
                <input type='submit' id='button' value='log in'>
                <br><br><br>

            </form>
        </div>

    </body>
</html>