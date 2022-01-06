<?php 
    include("include_php/nav_header.php"); 
    include("include_php/classes/User.php");
    include("include_php/classes/Post.php");

    $user_obj = new User($connect, $userLoggedIn);
    $post = new Post($connect, $userLoggedIn);

    if(isset($_POST['post'])){
        $post->submitPost($_POST['post-text-area']);
        header("Location: index.php");
    }
?>

<div class="wrapper">

    <div class="trending card">
        <!--for trending words-->
    </div>

    <div class="newsfeed card">
        <form action="index.php" class="post-form" method="POST">
            <textarea name="post-text-area" id="post-text-area" placeholder="Write a post..."></textarea>
            <input type="submit" name="post" id="post-submit-btn" value="Post">
        </form>

        <?php
            $post->loadPosts();
        ?>
    </div>

    <div class="card">
        <!--additional card-->
        <?php
            echo $user_obj->getFirstAndLastName();
            echo $user_obj->getUserID();
        ?>
    </div>
</div>

</body>

</html>