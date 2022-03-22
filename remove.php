<?php

    include("classes/autoloader.php");
    
    $login = new Login();
    $userData = $login->checkLogin($_SESSION['manoverseUserID']); //checks to see if a user is logged in or not

    $USER = $userData;

    if(isset($_GET['id']) && is_numeric($_GET['id'])) //If ID in URL is a set value and is numeric run the if loop to display profile data.
    {
        $profile = new Profile();
        $profileData = $profile->getProfile($_GET['id']);

        if(is_array($profileData))
        {$userData = $profileData[0];}
    }

    $post = new Post(); //instantiation of post class
    $error = "";

    if(isset($_GET['id']))
    {
        $ROW = $post->getOnePost($_GET['id']); //uses the function getOnePost from the Post class

        if(!$ROW){ //if there is no row, return an error

            $error = "that post doesn't exist.";
        }else{

            if($ROW['userID'] != $_SESSION['manoverseUserID'])
            {
                $error = "you do not have authorisation to delete this post.";

            }
        }

    }else{ //if the ID doesn't have a value in the url, then return an error
        $error = "that post doesn't exist.";
    }

    //If something was posted:

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $post->deletePost($_POST['postID']);
        header("Location: profile.php");
        die;

    }

    
    


?>



<!DOCTYPE html>
    <html>
        <head>
            <title>manoverse | remove</title>
        </head>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="main.css">
            
        <body id='background'>
 

            <!--top bar-->

            <?php include("header.php") ?>

            <!--cover area-->
            
            <br>
            <div style='width: 800px; margin:auto; min-height:400px;'>
            
                <div style='display: flex;'>

                    <!--posts area-->
                    <div style='min-height: 400px; flex:2.5; padding: 20px; padding-right: 0px;'>

                        <div>

                            <div style='border: solid thin white; padding: 10px; background-color: white;'>

                                <h2> remove a post </h2>

                                <form method="post">
                                        <?php

                                            if($error != "")
                                            {echo $error;
                                            }else
                                            {
                                                echo "you sure you wanna do this?<br>"; ?> <hr> <?php
                                                echo $ROW['post'];

                                                $user = new User();
                                                $ROW_USER = $user->getUser($ROW['userID']);

                                                echo "<input type='hidden' name='postID' value='$ROW[postID]'>";
                                                echo "<a href='profile.php' style='text-decoration: none; color: #0077ff'> ...or redirect back to your profile </a> ";
                                                echo "<input id='postButton' type='submit' value='remove'>";
                                                
                                            }
                                        
                                        ?> 
                                    <hr>


                                    <br>                             
                                </form>

                                <br>
                            </div>

                        </div>

                    </div>


                </div>
             </div>



        </body>

    </html>