<?php

class Post
{   
    private $error = "";

    public function createPost($userID, $data, $files) //a function designed to create a post
    {

        if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['isPFP']) || isset($data['isBanner']))
        {

            $myimage = ""; //initialisation of variables
            $hasImage = 0;
            $isPFP = 0;
            $isBanner = 0;
            
            if(isset($data['isPFP']) || isset($data['isBanner'])) //if banner or pfp data is set run the if loop
            {

                $myimage = $files; //the variable myimage is set to the data contained in the files variable
                $hasImage = 1; //There is an image so value is set to 1

                if(isset($data['isPFP'])) //if isPFP is set then change value to one
                {$isPFP = 1;}

                if(isset($data['isBanner'])) //if isBanner is set then change value to one
                {$isBanner = 1;}

            }else{

                if(!empty($files['file']['name'])) //however if there is no banner or pfp data create a folder to store the post information in.
                {
                    $folder = "uploads/" . $userID . '/';

                    //A folder is created!
                    if(!file_exists($folder))
                    {
                        mkdir($folder, 7777, true);
                    }

                    $imageClass = new Image();

                    $myimage = $folder . $imageClass->generateFilename(16) . ".jpg";
                    move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                    $imageClass->resizeImage($myimage, $myimage, 1500, 1500);
                    
                    $hasImage = 1;  

                }

            }

            $post = "";
            if(isset($data['post']))
            {  
                $post = addslashes($data['post']);
            }
            
            $postID = $this->createPostID();

            $query = "INSERT INTO posts (postID, userID, post, image, hasImage, isPFP, isBanner) VALUES ('$postID', '$userID', '$post', '$myimage', '$hasImage', '$isPFP', '$isBanner')"; 

			$DB = new Database();
			$DB->save($query);

		}else
		{
			$this->error .= "please type something to post. <br>";
		}

		return $this->error;
	}

    public function getPosts($id) //function designed to get all posts from the posts database
    {
        
        $query = "SELECT * FROM posts WHERE userID = '$id' ORDER BY ID DESC limit 10";

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result;
		}else
		{
			return false;
		}

    }

    private function createPostID() //a function designed to generate a random postID
    {
        $length = rand(4, 19); //a random number chosen between 4 and 19
        $number = "";
        for ($i = 0; $i < $length; $i = $i + 1) {
            $newRandom = rand(0, 9);
            $number = $number . $newRandom;

        }
        return $number;
    }

    public function getOnePost($postID) //a function designed to call one single post
    {
        if(!is_numeric($postID)) //this is a quick check to see if the postID is numeric. If not, the function stops to avoid hacking.
        {
            return false;
        }

        $query = "SELECT * FROM posts WHERE postID = '$postID' LIMIT 1";

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result[0];
		}else
		{
			return false;
		}

    }

    public function deletePost($postID) //a function designed for deleting posts
    {
        if(!is_numeric($postID)) //this is a quick check to see if the postID is numeric. If not, the function stops to avoid hacking.
        {
            return false;
        }

        $query = "DELETE FROM posts WHERE postID = '$postID' LIMIT 1";

		$DB = new Database();
		$DB->save($query);

    }

    public function likePost($ID, $type, $manoverseUserID) //a function designed for liking posts
    {   

        $DB = new Database();

        //save the likes details!
        $query = "SELECT likes FROM likes WHERE type='$type' AND contentID = '$ID' LIMIT 1";
        $result = $DB->read($query);
        if(is_array($result))
        {   
            $likes = json_decode($result[0]['likes'], true);
            $userIDs = array_column($likes, "userID");

            if(!in_array($manoverseUserID, $userIDs))
            {
                $array['userID'] = $manoverseUserID;
                $array['date'] = date("Y-m-d H:i:s");
                
                $likes[] = $array;

                $likesString = json_encode($likes);
                $query = "UPDATE likes SET likes = '$likesString' WHERE type='$type' AND contentID = '$ID' LIMIT 1";
                $DB->save($query);

                //increment the right table.
                $query = "UPDATE {$type}s SET likes = likes + 1 WHERE {$type}ID = '$ID' LIMIT 1";
                $DB->save($query);

            }else{

                $search = array_search($manoverseUserID, $userIDs);
                unset($likes[$search]);

                $likesString = json_encode($likes);
                $query = "UPDATE likes SET likes = '$likesString' WHERE type='$type' AND contentID = '$ID' LIMIT 1";
                $DB->save($query);

                //decrement the RIGHT table.
                $query = "UPDATE {$type}s SET likes = likes - 1 WHERE {$type}ID = '$ID' LIMIT 1";
                $DB->save($query);


            }

        }else{

            $array['userID'] = $manoverseUserID;
            $array['date'] = date("Y-m-d H:i:s");
            
            $array2[] = $array;

            $likes = json_encode($array2);
            $query = "INSERT INTO likes (type, contentID, likes) VALUES ('$type', '$ID', '$likes')";
            $DB->save($query);

            //increment the right table.
            $query = "UPDATE {$type}s SET likes = likes + 1 WHERE {$type}ID = '$ID' LIMIT 1";
            $DB->save($query);

        }
    }

    public function getLikes($ID,$type){ //this function will collect details of all likes

		$DB = new Database();
		$type = addslashes($type);

		if(is_numeric($ID)){
 
			//get like details.
			$query = "SELECT likes FROM likes WHERE type='$type' AND contentid = '$ID' LIMIT 1";
			$result = $DB->read($query);
			if(is_array($result)){

				$likes = json_decode($result[0]['likes'],true);
				return $likes;
			}
		}


		return false;
	}
}