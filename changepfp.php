<?php

    include("classes/autoloader.php"); //includes the classes from the autoloader
    
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

    if($_SERVER['REQUEST_METHOD'] == "POST") //run this if statement if the server's request method is POST
    {

        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") //run this if statement if filename is set and isn't empty
        {   

            if($_FILES['file']['type'] == "image/jpeg") //run this if statement if the image type is JPEG
            {
                $maxSize = (1024 * 1024) * 5; //5mb is the max size

                if($_FILES['file']['size'] < $maxSize) //run this if statement if the filesize is under the max size of 5mb
                {   
                    $folder = "uploads/" . $userData['userID'] . '/';

                    //A folder is created!
                    if(!file_exists($folder)) //if a folder doesn't exist with the above name, then create it
                    {
                        mkdir($folder, 7777, true);
                    }

                    $image = new Image(); //initialise image class

                    $filename = $folder . $image->generateFilename(16) . ".jpg"; //create the filename
                    move_uploaded_file($_FILES['file']['tmp_name'], $filename); //move the file into the new location
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

                        $image->cropImage($filename, $filename, 1366, 488); //set the banner resolution to 1366 x 488
                    }else{

                        if(file_exists($userData['pfp']))
                        {unlink($userData['pfp']);}

                        $image->cropImage($filename, $filename, 800, 800); //set the profile picture resolution to 800 x 800
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
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600&display=swap" rel="stylesheet"> <!--these links are for external fonts and css. -->
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