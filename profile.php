<?php 
    include("include_php/nav_header.php"); 
    include("include_php/classes/User.php");
    include("include_php/classes/Post.php");

    $user_obj = new User($connect, $userLoggedIn);
    $post = new Post($connect, $userLoggedIn);
?>

<div class="wrapper">

    <div class="card">
        <p>This is the profile page</p>
    </div>
</div>

</body>

</html>