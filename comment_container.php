<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>

    <?php 
        require 'include_php/server.php'; 
        include("include_php/classes/User.php");
        include("include_php/classes/Post.php");

        // redirect to register.php when user is not logged in
        if (isset($_SESSION['id'])){
            $userLoggedIn = $_SESSION['id'];
            $user_details_query = mysqli_query($connect, "SELECT * FROM users WHERE id='$userLoggedIn'");
            $user = mysqli_fetch_array($user_details_query);
        } 
        else {
            header("Location: register.php");
        }
    ?>

    <script>
        function toggle(){
            var element = document.getElementbyId("comment_section");
            if(element.style.display == "block")
                element.style.display = "none";
            else
                element.style.display = "block";
        }
    </script>
    
    <?php
        // get post id
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
        }

        $user_obj = new User($connect, $userLoggedIn);
        $post_query = mysqli_query($connect, "SELECT user_by_id, user_by FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($post_query);

        $comment_to_id = $row['user_by_id'];
        $comment_to = $row['user_by'];
        $comment_by_id = $userLoggedIn;
        $comment_by = $user_obj->getFirstAndLastName();

        if(isset($_POST['postComment' . $post_id])){
            $comment_body = $_POST['comment_body'];
            $comment_body = mysqli_escape_string($connect, $comment_body);
            $date_time_now = date("Y-m-d H:i:s");
            $insert_comment = mysqli_query($connect, "INSERT INTO comments VALUES (NULL, '$post_id', '$comment_to_id', '$comment_by_id', '$comment_body', '$comment_by', '$comment_to', '$date_time_now', 'no')");
            
            echo "<p>Comment Posted! </p>";
        }
    ?>

    <form action="comment_container.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id;?>" method="POST">
        <textarea name="comment_body"></textarea>
        <input type="submit" name="postComment<?php echo $post_id; ?>" value="Post">
    </form>

    <!--Load Comments-->
    <!-- <div id="comment_section">
    </div> -->

</body>
</html>