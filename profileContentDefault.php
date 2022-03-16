<div style='display: flex;'>

    <!--mates area-->
    <div style='min-height: 400px; flex:1;'>

        <div id='matesBar'>
            
            new users<br>

            <?php
                    //var_dump($posts);
                    if($mates)
                    {
                        foreach ($mates as $mate){

                            $mateROW = $user->getUser($mate['userID']);
                            include("user.php");
                        }
                        

                    }

                ?>


        </div>
    </div>

    <!--posts area-->
    <div style='min-height: 400px; flex:2.5; padding: 20px; padding-right: 0px;'>

        <div>

            <div style='border: solid thin white; padding: 10px; background-color: white;'>

                <form method="post" enctype="multipart/form-data">

                    <textarea name='post' placeholder="what's going down on this fine day?"></textarea>
                    <input type='file' name='file'>
                    <input id='postButton' type='submit' value='post'>
                    <br>

                </form>
            </div>

            <!--posts-->

            <!--posts-->
            <div id='postBar'>

                <?php
                    //var_dump($posts);
                    if($posts)
                    {
                        foreach ($posts as $ROW){

                            $user = new User();
                            $ROWuser = $user->getUser($ROW['userID']);
                            
                            include("post.php");
                        }
                        

                    }

                ?>


            </div>

        </div>

    </div>


</div>