<!--top bar-->
<?php

    $bannerPFP = "images/mvm.png"; //placeholder profile picture

    if(isset($USER))
    {
        if(file_exists($USER['pfp'])) //if a profile picture file exists in the database
        {
            $imageClass = new Image(); //create a new image class
            $bannerPFP = $imageClass->getThumbPFP($USER['pfp']);
        }else{

            if($USER['gender'] = 'female'){

                $bannerPFP = "images/mvf.png";

            }

        }
    }


?>


<div id='blue_bar'>

    <div style='width: 800px; margin:auto; font-size: 30px;'>

        <form method='get' action='search.php'>

            <a href="profile.php" style="color: white; text-decoration: none"> manoverse </a>

            &nbsp &nbsp <input type='text' id='search_box' name='find' placeholder='explore the manoverse'>

        <a href="profile.php">
            <img src='<?php echo $bannerPFP ?>' style='width:50px; float:right;'>
        </a>

        <a href="logout.php">
            <span style="font-size: 12px; float: right; margin: 10px; color: white;">log out</span>
        </a>

    </div>
    </form>

    
</div>