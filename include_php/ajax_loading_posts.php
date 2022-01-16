<?php
    include("../server.php"); // database
    include("classes/User.php");
    include("classes/Post.php")

    $limit = 5; //number limit of posts to be loaded

    $posts = new Post($connect, $_REQUEST['userLoggedIn']);
    $posts->loadPosts();
?>