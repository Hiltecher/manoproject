<div style="min-height: 400px;width:100%;background-color: white;">
	<div style="padding: 20px;">
	<?php
 
		$imageClass = new Image();
		$postClass = new Post();
		$userClass = new User();

		$followers = $postClass->getLikes($userData['userID'],"user");

		if(is_array($followers)){

			foreach ($followers as $follower)
            {
				$mateROW = $userClass->getUser($follower['userID']);
				include("user.php");
			}

		}else{

			echo "this user doesn't have any followers.";
		}


	?>

	</div>
</div>