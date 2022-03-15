<?php

    include("classes/autoloader.php");

    $login = new Login();
    $userData = $login->checkLogin($_SESSION['manoverseUserID']); //checks to see if a user is logged in or not

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {

        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {   

            if($_FILES['file']['type'] == "image/jpeg")
            {
                $maxSize = (1024 * 1024) * 5;

                if($_FILES['file']['size'] < $maxSize)
                {   
                    $folder = "uploads/" . $userData['userID'] . '/';

                    //A folder is created!
                    if(!file_exists($folder))
                    {
                        mkdir($folder, 7777, true);
                    }

                    $image = new Image();

                    $filename = $folder . $image->generateFilename(16) . ".jpg";
                    move_uploaded_file($_FILES['file']['tmp_name'], $filename);

                    $change = "pfp";

                    //This checks the mode for change.
                    if(isset($_GET['change']))
                    {
                        $change = $_GET['change'];
                    }

                    if($change == 'banner')
                    {   
                        if(file_exists($userData['banner']))
                        {unlink($userData['banner']);}

                        $image->cropImage($filename, $filename, 1366, 488);
                    }else{

                        if(file_exists($userData['pfp']))
                        {unlink($userData['pfp']);}

                        $image->cropImage($filename, $filename, 800, 800);
                    }
                    
                    


                    if(file_exists($filename))
                    {
        
                        $userID = $userData['userID'];
                    

                        if($change == 'banner')
                        {
                            $query = "UPDATE users SET banner = '$filename' WHERE userID = '$userID' limit 1"; 
                            $isBanner = 1;
                        }else{
                            $query = "UPDATE users SET pfp = '$filename' WHERE userID = '$userID' limit 1";
                            $isPFP = 1;
                        }

                        $DB = new Database();
                        $DB->save($query);

                        //create a post to show the new profile picture or banner
                        $post = new Post();
                        $post->createPost($userID, $_POST, $filename);


                        header(("Location: profile.php"));
                        die;

                    }

                }else{

                    echo "<div style='text-align:center; font-size: 16px; color: black;'>";
                    echo "oh man! some problems cropped up: <br><br>";
                    echo "your image size is above the 5mb limit.";
                    echo "</div>";

                }
            }else
            {

                echo "<div style='text-align:center; font-size: 16px; color: black;'>";
                echo "oh man! some problems cropped up: <br><br>";
                echo "only images of JPEG formats are supported.";
                echo "</div>";

            }

        }else{

            echo "<div style='text-align:center; font-size: 16px; color: black;'>";
            echo "oh man! some problems cropped up: <br><br>";
            echo "looks like you forgot to add an image Remember: only JPEG is supported.";
            echo "</div>";

        }
        

    }


?>



<!DOCTYPE html>
    <html>
        <head>
            <title>manoverse | Change PFP</title>
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

                    <form method='post' enctype='multipart/form-data'>  <!--enc makes sure all file types are supported-->

                        <div>

                            <div style='border: solid thin white; padding: 10px; background-color: white;'>

                                <input type='file' name='file'>
                                <input id='postButton' type='submit' value='post'>
                                <br>
                            </div>

                        </div>

                    </div>


                </div>
             </div>



        </body>

    </html>