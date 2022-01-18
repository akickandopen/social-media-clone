<?php
    include("server.php"); // database
    include("classes/User.php");
    include("classes/Post.php");

    $post = new Post($connect, $_REQUEST['userLoggedIn']);
    $post->loadPostsAll();
?>