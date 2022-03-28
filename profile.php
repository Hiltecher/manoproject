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

    //for posting

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {

        $post = new Post();
        $ID = $_SESSION['manoverseUserID'];
        $result = $post->createPost($ID, $_POST, $_FILES);
        //print_r($_POST);

        if($result == "")
        {
            header("Location: profile.php");
            die;

        }else{

            echo "<div style='text-align:center; font-size: 16px; color: black;'>";
            echo "oh hell naw! some problems cropped up: <br><br>";
            echo $result;
            echo "</div>";

        }
        
    }

    //collect posts
    $post = new Post();
    $ID = $userData['userID'];

    $posts = $post->getPosts($ID);

    //collect friends
    $user = new User();
    $mates = $user->getNewUsers($ID);

    $imageClass = new Image();
    

?>

<html>
    <head>
        <title>manoverse | profile</title>
    </head>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
        
    <body id='background'>

        <!--navigation area-->
        <?php include("header.php") ?>
        
        <br>

        <div style='width: 800px; margin:auto; min-height:400px;'>



            <div style='background-color: white; text-align: center; color: #405d9b'>

                    <?php

                    $image = "images/placeholderbanner.jpg";
                    if($userData['gender'] == 'female')
                    {$image = "images/placeholderbanner2.jpg";}

                    if(file_exists($userData['banner']))
                    {

                        $image = $userData['banner'];

                    }

                    ?>
                <img src="<?php echo $image ?>" style='width: 100%;'>

                <span style="font-size: 12px;">

                    <?php

                        $image = "images/mvm.png";
                        if($userData['gender'] == 'female')
                        {$image = "images/mvf.png";}

                        if(file_exists($userData['pfp']))
                        {

                            $image = $userData['pfp'];

                        }

                    ?>
                    
                    <img id='pfp' src="<?php echo $image ?>"><br>
                    <a href="changepfp.php?change=pfp" style="text-decoration: none; color: #405d9b">change pfp</a> | 
                    <a href="changepfp.php?change=banner" style="text-decoration: none; color: #405d9b">change banner</a>

                </span>
                <br>

                <a href="profile.php?id=<?php $userData['userID']; ?>" style="text-decoration: none; color: #405d9b;">
                    <div style='font-size: 20px;'><?php echo $userData['firstName'] . ' ' . $userData['lastName']?>
                </a>

                    <br>
                    <?php
                        $myFollowers = "";
                        if($userData['likes'] > 0)
                        {
                            $myFollowers = "(" . $userData['likes'] . ")";
                        }
                    ?>

                    <a href='like.php?type=user&id=<?php echo $userData['userID']; ?>' >
                        <input id='postButton' style='margin-right: 10px; width: auto;' type='button' value='follow <?php echo $myFollowers ?>'>
                    </a>
            
                </div>

                <br>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="profile.php?section=media&id=<?php echo $userData['userID']; ?>"><div id='menuButtons'>media</div></a>
                <a href="profile.php?section=followers&id=<?php echo $userData['userID']; ?>"><div id='menuButtons'>followers</div></a>
                <br>

            </div>

            <!--under the navigation area-->
            
            <?php

                $section = "default";
                if(isset($_GET['section']))
                {
                    $section = $_GET['section'];
                }

                if($section == "default")
                {
                    include("profileContentDefault.php");

                }elseif($section == "media")
                {
                    include("profileContentMedia.php");

                }elseif($section == "followers")
                {
                    include("profileContentFollowers.php");

                }
                
            ?>

        </div>
    </body>
</html>