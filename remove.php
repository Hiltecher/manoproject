<?php

    include("classes/autoloader.php");


    $login = new Login();
    $userData = $login->checkLogin($_SESSION['manoverseUserID']); //checks to see if a user is logged in or not
    $post = new Post();
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

        <style type='text/css'>

            #blue_bar{

                height:50px;
                background-color:#0077ff;
                color:white;

            }


            #search_box{

                width: 400px;
                height:22px;
                border-radius: 5px;
                border:none;
                padding: 4px;
                font-size: 14px;
                background-image: url(search.png);
                background-repeat: no-repeat;
                background-position: right;
                
            }


            #pfp{

                width: 150px;
                border-radius: 50%;
                border:solid 2px white;

            }

            #menuButtons{

                width: 100px;
                display: inline-block;
                margin: 2px;
            }

            #mateImg{

                width: 75px;
                height: 75px;
                float: left;
                margin: 8px;
            }

            #matesBar{

                min-height: 400px;
                margin-top: 20px;
                padding: 8px;
                text-align: center;
                font-size: 20px;
                color: white;

            }

            #mates{

                clear:both;
                font-size: 12px;
                font-weight: bold;
                color: #405d9b;

            }

            textarea{

                width: 100%;
                border: none;
                font-family: 'Titillium Web', sans-serif;
                border-radius: 3px;
                height: 60px;

            }

            #postButton{

                float: right;
                background-color: #0077ff;
                color: white;
                border: none;
                padding: 4px;
                font-family: 'Titillium Web', sans-serif;
                width: 50px;
            }
            
            #postBar{

                margin-top: 20px;
                background-color: white;
                padding: 10px;

            }            

            #post{

                padding: 4px;
                font-size: 13px;
                display: flex;

            }

        </style>
            
        <body id='background' style="font-family: 'Titillium Web', sans-serif; background-color: #79b5fa; background-image:url(tris.png);">
 

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