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
	
	if(isset($_GET['find'])){

		$find = addslashes($_GET['find']);

		$query = "SELECT * FROM users WHERE firstName LIKE '%$find%' OR lastName LIKE '%$find%' ";
		$DB = new Database();
		$results = $DB->read($query);


	}
 
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>manoverse | search</title>
	</head>

	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600&display=swap" rel="stylesheet">

	<style type="text/css">
		
        #blue_bar{

            height:50px;
            background-color:#0077ff;
            color:white;

        }


        #search_box{

            width: 400px;
            height:22px;
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

		<?php include("header.php"); ?>

		<!--cover area-->
		<div style="width: 800px;margin:auto;min-height: 400px;">
		 
			<!--below cover area-->
			<div style="display: flex;">	

				<!--posts area-->
 				<div style="min-height: 400px;flex:2.5;padding: 20px;padding-right: 0px;">
 					
 					<div style="border:solid thin #aaa; padding: 10px;background-color: white;">

  					 <?php 

  					 		$User = new User();
  					 		$imageClass = new Image();

  					 		if(is_array($results)){

  					 			foreach ($results as $row) {
  					 				# code...
  					 				$mateROW = $User->getUser($row['userID']);
 									include("user.php");
 					 			}
  					 		}else{

  					 			echo "looks like we couldn't grab anything. maybe try a broader search?";
  					 		}

  					 ?>

  					 <br style="clear: both;">
 					</div>
  

 				</div>
			</div>

		</div>

	</body>
</html>