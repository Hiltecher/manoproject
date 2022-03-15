<?php

class Image
{

	public function generateFilename($length) //function that generates a random filename
	{

		$array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$text = "";

		for($x = 0; $x < $length; $x++)
		{

			$random = rand(0,61);
			$text .= $array[$random];
		}

		return $text;
	}

	public function cropImage($originalFileName, $croppedFileName, $maxWidth, $maxHeight) //function that crops an image
	{

		if(file_exists($originalFileName))
		{
 
			$originalImage = imagecreatefromjpeg($originalFileName);

			$originalWidth = imagesx($originalImage);
			$originalHeight = imagesy($originalImage);

			if($originalHeight > $originalWidth)
			{
				//make width equal to max width;
				$ratio = $maxWidth / $originalWidth;

				$newWidth = $maxWidth;
				$newHeight = $originalHeight * $ratio;

			}else
			{

				//make width equal to max width;
				$ratio = $maxHeight / $originalHeight;

				$newHeight = $maxHeight;
				$newWidth = $originalWidth * $ratio;
			}
		}

		//adjust incase max width and height are different
		if($maxWidth != $maxHeight)
		{

			if($maxHeight > $maxWidth)
			{

				if($maxHeight > $newHeight)
				{
					$adjustment = ($maxHeight / $newHeight);
				}else
				{
					$adjustment = ($newHeight / $maxHeight);
				}

				$newWidth = $newWidth * $adjustment;
				$newHeight = $newHeight * $adjustment;
			}else
			{

				if($maxWidth > $newWidth)
				{
					$adjustment = ($maxWidth / $newWidth);
				}else
				{
					$adjustment = ($newWidth / $maxWidth);
				}

				$newWidth = $newWidth * $adjustment;
				$newHeight = $newHeight * $adjustment;
			}
		}

		$newImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

		imagedestroy($originalImage);

		if($maxWidth != $maxHeight)
		{

			if($maxWidth > $maxHeight)
			{

				$diff = ($newHeight - $maxHeight);
				if($diff < 0){
					$diff = $diff * -1;
				}
				$y = round($diff / 2);
				$x = 0;
			}else
			{

				$diff = ($newWidth - $maxHeight);
				if($diff < 0){
					$diff = $diff * -1;
				}
				$x = round($diff / 2);
				$y = 0;
			}
		}else
		{
			if($newHeight > $newWidth)
			{

				$diff = ($newHeight - $newWidth);
				$y = round($diff / 2);
				$x = 0;
			}else
			{

				$diff = ($newWidth - $newHeight);
				$x = round($diff / 2);
				$y = 0;
			}
		}

		$newCroppedImage = imagecreatetruecolor($maxWidth, $maxHeight);
		imagecopyresampled($newCroppedImage, $newImage, 0, 0, $x, $y, $maxWidth, $maxHeight, $maxWidth, $maxHeight);
		
		imagedestroy($newImage);

		imagejpeg($newCroppedImage,$croppedFileName,90);
		imagedestroy($newCroppedImage);
	}

	public function resizeImage($originalFileName,$resizedFileName,$maxWidth,$maxHeight) //function that resizes an image
	{

		if(file_exists($originalFileName))
		{

			$originalImage = imagecreatefromjpeg($originalFileName);

			$originalWidth = imagesx($originalImage);
			$originalHeight = imagesy($originalImage);

			if($originalHeight > $originalWidth)
			{
				//make width equal to max width;
				$ratio = $maxWidth / $originalWidth;

				$newWidth = $maxWidth;
				$newHeight = $originalHeight * $ratio;

			}else
			{

				//make width equal to max width;
				$ratio = $maxHeight / $originalHeight;

				$newHeight = $maxHeight;
				$newWidth = $originalWidth * $ratio;
			}
		}

		//adjust incase max width and height are different
		if($maxWidth != $maxHeight)
		{

			if($maxHeight > $maxWidth)
			{

				if($maxHeight > $newHeight)
				{
					$adjustment = ($maxHeight / $newHeight);
				}else
				{
					$adjustment = ($newHeight / $maxHeight);
				}

				$newWidth = $newWidth * $adjustment;
				$newHeight = $newHeight * $adjustment;
			}else
			{

				if($maxWidth > $newWidth)
				{
					$adjustment = ($maxWidth / $newWidth);
				}else
				{
					$adjustment = ($newWidth / $maxWidth);
				}

				$newWidth = $newWidth * $adjustment;
				$newHeight = $newHeight * $adjustment;
			}
		}

		$newImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

		imagedestroy($originalImage);

		imagejpeg($newImage,$resizedFileName, 100);
		imagedestroy($newImage);
	}

	public function getThumbPost($filename) //function that makes a thumbnail of a post
	{

		$thumbnail = $filename . "_post_thumb.jpg";
		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}

		$this->cropImage($filename, $thumbnail, 600, 600);

		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}else
		{
			return $filename;
		}
	}

	//create thumbnail for pfp
	public function getThumbPFP($filename)
	{

		$thumbnail = $filename . "_pfp_thumb.jpg";
		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}

		$this->cropImage($filename,$thumbnail,600,600);

		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}else
		{
			return $filename;
		}
	}

}


?>