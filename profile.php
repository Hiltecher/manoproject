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
    $mates = $user->getMates($ID);

    $imageClass = new Image();
    

?>

<html>
    <head>
        <title>manoverse | profile</title>
    </head>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600&display=swap" rel="stylesheet">

    <style type='text/css'>

        @font-face {
            font-family: 'Aramco';
            src: url(REZ.ttf);
        }

        #blue_bar{

            height:50px;
            background-color:#0077ff;
            color:white;

        }


        #search_box{

            width: 400px;
            height:30px;
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
            margin-top: -130px;
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

            background-color: white;
            min-height: 400px;
            margin-top: 20px;
            color: #676767;
            padding: 8px;

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
            min-width: 50px;
            cursor: pointer;

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



        <!--cover area-->
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
            <a href="index.php"><div id='menuButtons'>timeline</div></a>
            <a href="profile.php?section=about&id=<?php echo $userData['userID']; ?>"><div id='menuButtons'>about</div></a>
            <a href="index.php?section=following&id=<?php echo $userData['userID']; ?>"><div id='menuButtons'>following</div></a>
            <a href="index.php?section=followers&id=<?php echo $userData['userID']; ?>"><div id='menuButtons'>followers</div></a>
            <a href="index.php?section=settings"><div id='menuButtons'>settings</div></a>
            <br>


            </div>
        
            <div style='display: flex;'>

                <!--mates area-->
                <div style='min-height: 400px; flex:1;'>
                
                    <div id='matesBar'>
                        
                        mates<br>

                        <?php
                                //var_dump($posts);
                                if($mates)
                                {
                                    foreach ($mates as $mateROW){

                                        
                                        include("user.php");
                                    }
                                    

                                }

                            ?>


                    </div>
                </div>

                <!--posts area-->
                <div style='min-height: 400px; flex:2.5; padding: 20px; padding-right: 0px;'>

                    <div>

                        <div style='border: solid thin white; padding: 10px; background-color: white;'>

                            <form method="post" enctype="multipart/form-data">

                                <textarea name='post' placeholder="what's going down on this fine day?"></textarea>
                                <input type='file' name='file'>
                                <input id='postButton' type='submit' value='post'>
                                <br>

                            </form>
                        </div>
                
                        <!--posts-->

                        <!--posts-->
                        <div id='postBar'>

                            <?php
                                //var_dump($posts);
                                if($posts)
                                {
                                    foreach ($posts as $ROW){

                                        $user = new User();
                                        $ROWuser = $user->getUser($ROW['userID']);
                                        
                                        include("post.php");
                                    }
                                    

                                }

                            ?>


                        </div>

                    </div>

                </div>


            </div>
            </div>



    </body>

</html>