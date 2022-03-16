<?php

    include("classes/autoloader.php");
    
    $login = new Login();
    $userData = $login->checkLogin($_SESSION['manoverseUserID']); //checks to see if a user is logged in or not


    if(isset($_SERVER['HTTP_REFERER']))
    {
        $returnTo = $_SERVER['HTTP_REFERER'];
    }else{
        $returnTo = "profile.php";
    }

    if(isset($_GET['type']) && isset($_GET['id']))
    {
        if(is_numeric($_GET['id']))
        {
            $allowed[] = 'post';
            $allowed[] = 'user';
            $allowed[] = 'users';
            $allowed[] = 'comment';

            if(in_array($_GET['type'], $allowed))
            {
                $post = new Post();
                $userClass = new User();
                $post->likePost($_GET['id'], $_GET['type'], $_SESSION['manoverseUserID']);

            }
        }
    }

    header("Location: " . $returnTo);
    die;


?>