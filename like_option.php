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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="resources/css/newsfeed_style.css">
</head>
<body>
    <?php
        // get post id
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
        }

        // get post details
        $like_post_query = mysqli_query($connect, "SELECT user_by_id, user_by, likes FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($like_post_query);

        $post_by_id = $row['user_by_id']; // id of user who posted
        $post_by = $row['user_by']; // username of user who posted
        $total_likes = $row['likes']; // number of likes in post

        // get details of the user who posted
        $user_details_query = mysqli_query($connect,"SELECT * FROM users WHERE id='$post_by_id'");
        $row = mysqli_fetch_array($user_details_query);
        $total_user_likes = $row['num_likes'];

        // get details of user who liked
        $user_obj = new User($connect, $userLoggedIn);
        $liked_by_id = $user_obj->getUserID();
        $liked_by = $user_obj->getUsername();

        // Like
        if (isset($_POST['like-btn'])){
            // add like to the post
            $total_likes++; // +1
            $query = mysqli_query($connect, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
            
            // add number of posts liked from user who posted
            $total_user_likes++; // +1
            $post_by_likes = mysqli_query($connect, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$post_by'");

            $insert_user = mysqli_query($connect, "INSERT INTO likes (post_id, post_by_id, post_by, liked_by_id, liked_by) VALUES ('$post_id', '$post_by_id', '$post_by', '$liked_by_id', '$liked_by')");

        }

        // Unlike
        if (isset($_POST['unlike-btn'])){
            // remove like from post
            $total_likes--; // -1
            $query = mysqli_query($connect, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");

            // remove like in num_likes from user who posted
            $total_user_likes--; // -1
            $post_by_likes = mysqli_query($connect, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$post_by'");

            $remove_user = mysqli_query($connect, "DELETE FROM likes WHERE post_by='$post_by' AND post_id='$post_id'");
        }

        //check for previous likes from the user who liked
        $check_query = mysqli_query($connect, "SELECT * FROM likes WHERE liked_by='$liked_by' AND post_id='$post_id'");
        $num_rows = mysqli_num_rows($check_query);

        if($num_rows > 0){ // if there is 1 like, set button to Unlike
            echo '<form action="like_option.php?post_id=' . $post_id . '" method="POST">
                    <input type="submit" class="comment-like" name="unlike-btn" value="Unlike">
                    <div class="like-value">
                        ' . $total_likes . ' Likes
                    </div>
                </form>';
        } else { // no likes, set button to Like
            echo '<form action="like_option.php?post_id=' . $post_id . '" method="POST">
                    <input type="submit" class="comment-like" name="like-btn" value="Like">
                    <div class="like-value">
                        ' . $total_likes . ' Likes
                    </div>
                </form>';
        }
    ?>
</body>
</html>