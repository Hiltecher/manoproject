<div style="min-height: 400px; width: 100%; background-color: white; text-align: center;">
    <br>
    <?php

        $DB = new Database();
        $query = "SELECT image, postID FROM posts WHERE hasImage = 1 AND userID = $userData[userID] ORDER BY ID DESC";
        $images = $DB->read($query);
        $imageClass = new Image();

        if(is_array($images))
        {

            foreach ($images as $imageRow)
            {
                echo "<img src = '" . $imageClass->getThumbPost($imageRow['image']) . "' style='width:170px; border-radius: 10px'>";

            }


        }else{

            echo "this user doesn't have any media.";
        }


    ?>

</div>