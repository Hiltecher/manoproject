<!--top bar-->
<?php

    $bannerPFP = "images/mvm.png"; //placeholder profile picture for males

    if(isset($USER))
    {
        if(file_exists($USER['pfp'])) //if a profile picture file exists in the database
        {
            $imageClass = new Image(); //initialise the image class
            $bannerPFP = $imageClass->getThumbPFP($USER['pfp']); //use the getThumbPFP to call the user's profile picture
        }else{

            if($USER['gender'] = 'female'){ //but if the user is female, the placeholder pfp is pink

                $bannerPFP = "images/mvf.png";

            }

        }
    }


?>


<div id='blue_bar'>

    <div style='width: 800px; margin:auto; font-size: 30px;'>

        <form method='get' action='search.php'>

            <a href="profile.php" style="color: white; text-decoration: none"> manoverse </a> <!--title for the main bar-->

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