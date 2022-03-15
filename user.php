<div id='mates'>

    <?php
    
        $image = "images/mvm.png";
        if($mateROW['gender'] == "female")
        {
            $image = "images/mvf.png";
        }

        if(file_exists($mateROW['pfp']))
        {
            $image = $imageClass->getThumbPFP($mateROW['pfp']); 
        }
    
    ?>
    
    <a href="profile.php?id=<?php echo $mateROW['userID']; ?>" style="text-decoration: none; color: #0077ff" >
        <img id='mateImg' src="<?php echo $image ?>"><br>
        <?php echo $mateROW['firstName'] . " " . $mateROW['lastName'] ?>
    </a>

</div>