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

    <style>

        #bar{
            height: 100px;
            background-color: #0077ff;
            color: #ffffff;
            padding:4px;
            border-radius: 5px;
        }

    #signup{
        background-color: #3b97ff;
        color: white;
        width: 70px;
        text-align: center;
        padding: 6px;
        border-radius: 4px;
        margin-top: 3px;
        margin-left: 3px;
    }

    #loginbox{
        background-color: #0077ff;
        color: white;
        width:800px;
        height: 300px;
        margin:auto;
        margin-top: 60px;
        padding:10px;
        padding-top: 35px;
        text-align: center;
        border-radius: 6px;
        font-weight: bold;
        font-size: 20px;
    }

    #text{
        margin: 7px;
        height: 40px;
        width: 300px;
        border-radius: 4px;
        border: solid 1px #3b97ff;
        padding: 4px;
        font-size: 14px;
    }

    #button{
        width: 300px;
        height: 40px;
        border-radius: 4px;
        font-weight: bold;
        border: none;
        margin-top: 8px;
        background-color: #3b97ff;
        color: white;


    }

    </style>

    <body style="font-family: 'Titillium Web', sans-serif; background-color: #79b5fa; background-image:url(tris.png);">
        <div id='bar'>

            <div style='font-size: 40px;'>manoverse</div>
            <div id='signup'>sign up</div>

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