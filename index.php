<?php

    include("classes/autoloader.php");


    $login = new Login();
    $userData = $login->checkLogin($_SESSION['manoverseUserID']); //checks to see if a user is logged in or not


?>



<!DOCTYPE html>
    <html>
        <head>
            <title>manoverse | timeline</title>
        </head>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600&display=swap" rel="stylesheet">

        <style type='text/css'>

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

                min-height: 400px;
                margin-top: 20px;
                padding: 8px;
                text-align: center;
                font-size: 20px;
                color: white;

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
 

            <!--top bar-->

            <?php include("header.php") ?>

            <!--cover area-->
            
            <br>

            <div style='width: 800px; margin:auto; min-height:400px;'>

            
                <div style='display: flex;'>

                    <!--mates area-->
                    <div style='min-height: 400px; flex:1;'>
                    
                        <div id='matesBar'>
                            
                            <img src='shaq.png' id='pfp'><br>
                            <a href='profile.php' style="color: white; text-decoration: none"> <?php echo $userData['firstName'] . " <br> " . $userData['lastName'] ?></a>

                        </div>
                    </div>

                    <!--posts area-->
                    <div style='min-height: 400px; flex:2.5; padding: 20px; padding-right: 0px;'>

                        <div>

                            <div style='border: solid thin white; padding: 10px; background-color: white;'>

                                <textarea placeholder="what's going down on this fine day?"></textarea>
                                <input id='postButton' type='submit' value='post'>
                                <br>
                            </div>
                    
                            <!--posts-->
                            <div id='postBar'>
                                <div id='post'>
                                    <div>
                                        <img src='user2.jpg' style='width: 75px; height: 75px; margin-right: 10px; '>
                                    </div>
                                    <div>
                                        <div style='font-weight: bold; color: #0077ff; '>@keshyclub</div>
                                        I'm tired of people screenshotting my NFTs so listen closely: There can be multiple copies of my art but only one original piece. That is what makes the original painting valuable and irreplaceable. Other factors that make NFTs such valuable investments are utility, ownership history, underlying value, perception of the buyer, liquidity premium and future value.
                                        <br><br>
                                        <a href=''>like</a> . <a href=''>comment</a> . <span style='color: #999'>Feb 9th 22</span>    
                                    </div>

                                </div>

                            </div>

                            <!--posts-->
                            <div id='postBar'>
                                <div id='post'>
                                    <div>
                                        <img src='user1.png' style='width: 75px; height: 75px; margin-right: 10px; '>
                                    </div>
                                    <div>
                                        <div style='font-weight: bold; color: #0077ff; '>@manoceo</div>
                                        Akash Natarajan has officially launched his first NFT collection in collaboration with League of Legends. While I'm still not entirely keen on the whole 'selling picture for billions' idea I can't ignore his commitment to the process. Check it out
                                        <br><br>
                                        <a href=''>like</a> . <a href=''>comment</a> . <span style='color: #999'>Feb 9th 22</span>    
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>
             </div>



        </body>

    </html>