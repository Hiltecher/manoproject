
<div id='post'>
    <div>
        <?php

            $image = "images/mvm.png";
            if($mateROW['gender'] == "female")
            {
                $image = "images/mvf.png";
            }

            if(file_exists($ROWuser['pfp']))
            {
                $image = $imageClass->getThumbPFP($ROWuser['pfp']); 
            }

            

        ?>

        <img src='<?php echo $image ?>' style='width: 75px; height: 75px; margin-right: 10px; border-radius: 50%;'>
    </div>
    <div style='width: 100%;'>
        <div style='font-weight: bold; color: #0077ff;'><?php echo htmlspecialchars($ROWuser['firstName'] . ' ' . $ROWuser['lastName'])  ?></div>
        
        <?php echo htmlspecialchars($ROW['post']) ?> 
        <!--Special chars is used to make sure users don't type in raw code in the post box and break the website. -->
        <br><br>

        <?php
        
        if(file_exists($ROW['image']))
        {
            $postImage = $imageClass->getThumbPost($ROW['image']);

            echo "<img src='$postImage' style='width: 80%; border-radius: 10px;'/>";
        }
        
        
        ?>

        <br><br>
        <?php
            $likes = "";

            if($ROW['likes'] > 0)
            {

                $likes = $ROW['likes'];
            }else{

                $likes = "";
            }
        ?>

        <a href='like.php?type=post&id=<?php echo $ROW['postID'] ?>'>like (<?php echo $likes ?>) </a> | <a href=''>comment</a> .
        
        <span style='color: #999'>
        
        <?php echo $ROW['date'] ?> </span>
        
        <span style='color: #999; float: right;'>
            <a href="remove.php?id=<?php echo $ROW['postID'] ?>" style="color: #999; text-decoration: none;" >remove post</a>
        </span> 
        
        <?php

            $iLiked = false;       

            if(isset($_SESSION['manoverseUserID']))
            {   
                $DB = new Database();

                $query = "SELECT likes FROM likes WHERE type='post' AND contentID = '$ROW[postID]' LIMIT 1";
                $result = $DB->read($query);
                if(is_array($result))
                {   
                    $likes = json_decode($result[0]['likes'], true);
                    $userIDs = array_column($likes, "userID");

                    if(in_array($_SESSION['manoverseUserID'], $userIDs))
                    {
                        $iLiked = true;
                    }
                }
            }

            if($ROW['likes'] > 0)
            {   
                echo "<br>";

                if($ROW['likes'] == 1)
                {   
                    if($iLiked)
                    {
                        echo "<div style='text-align:left;'>you have liked this post </div> ";

                    }else{

                        echo "<div style='text-align:left;'>1 user has liked this post </div> ";
                    }

                }else{
                    if($iLiked)
                    {   
                        $text = "other users";
                        if($ROW['likes'] - 1 == 1){$text = "other user";}

                        echo "<div style='text-align:left;'>you and " . ($ROW['likes'] - 1) . " $text have liked this post </div> ";
                    
                    }else{

                        echo "<div style='text-align:left;'>" . $ROW['likes'] . " users have liked this post </div> ";
                    }
                }


            }
        ?>

    </div>

</div>