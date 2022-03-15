<div style="min-height: 400px;width:100%;background-color: white;text-align: center;">
	<div style="padding: 20px;">
	<?php
 
		$imageClass = new Image();
		$postClass = new Post();
		$userClass = new User();

		$followers = $postClass->getLikes($userData['userid'],"user");

		if(is_array($followers)){

			foreach ($followers as $follower) {
				# code...
				$FRIEND_ROW = $userClass->getUser($follower['userid']);
				include("user.php");
			}

		}else{

			echo "this user has no followers, how sad.";
		}


	?>

	</div>
</div>