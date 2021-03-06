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
    <!--JAVASCRIPT-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/newsfeed_style.css">
</head>
<body class="background">

    <script>
        function toggle(){
            var element = document.getElementbyId("comment_section");
            if(element.style.display == "block")
                element.style.display = "none";
            else
                element.style.display = "block";
        }
    </script>
    
    <!--------------Insert Comments In Database-------------->
    <?php
        // get post id
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
        }

        $user_obj = new User($connect, $userLoggedIn);

        $post_query = mysqli_query($connect, "SELECT user_by_id, user_by FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($post_query);

        $comment_to_id = $row['user_by_id']; // id of other user's post
        $comment_to = $row['user_by']; // name of other user

        $comment_by_id = $userLoggedIn; // id of current user logged in
        $comment_by_username = $user_obj->getUsername(); // username of current user logged in
        $comment_by_full_name = $user_obj->getFirstAndLastName(); // full name of current user logged in

        if(isset($_POST['postComment' . $post_id])){
            $comment_body = $_POST['comment_body'];
            $comment_body = mysqli_escape_string($connect, $comment_body);
            $date_time_now = date("Y-m-d H:i:s");
            $insert_comment = mysqli_query($connect, "INSERT INTO comments VALUES (NULL, '$post_id', '$comment_to_id', '$comment_to', '$comment_by_id', '$comment_by_username', '$comment_by_full_name', '$comment_body', '$date_time_now', 'no')");

            echo '<div class="alert alert-success" role="alert">Comment posted!</div>';

        }
    ?>

    <!--------------Load Comments From Database-------------->
    <?php
        $get_comments = mysqli_query($connect, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
        $count = mysqli_num_rows($get_comments);

        if($count != 0){
            while($comment = mysqli_fetch_array($get_comments)){
                $comment_to = $comment['comment_to'];
                $comment_by_username = $comment['comment_by'];
                $comment_by_full_name = $comment['comment_by_name'];
                $comment_body = $comment['comment_body'];
                $date_added = $comment['date_added'];
                $comment_deleted = $comment['comment_deleted'];

                // get user's profile picture
                $user_pic_query = mysqli_query($connect, "SELECT profile_pic FROM users WHERE username='$comment_by_username'");
                $row = mysqli_fetch_array($user_pic_query);

                $comment_by_pfp = $row['profile_pic']; // id of user who posted

                 //timeframe
                 $date_time_now = date("Y-m-d H:i:s");
                 $start_date = new DateTime($date_added); // date post was added
                 $end_date = new DateTime($date_time_now); // current date and time now
                 $interval = $start_date->diff($end_date); // difference between start and end date

                 $month_interval = $interval->m;
                 $day_interval = $interval->d;
                 $hour_interval = $interval->h;
                 $min_interval = $interval->i;
                 $sec_interval = $interval->s;

                 if($month_interval >= 1){ // if interval is more than or equal to 1 month

                     if($day_interval == 0){ // if interval is exactly one month
                         $days = " ago"; 
                     } 
                     else if($day_interval == 1) { 
                         $days = $interval->d . " day ago"; // add "1 day ago"
                     }
                     else { 
                         $days = $day_interval . " days ago"; // add "1+ days ago"
                     }

                     if($month_interval == 1){ // if interval is one month ago
                         $time_interval_message = $month_interval . " month" . $days;
                     } else { // more than one month
                         $time_interval_message = $month_interval . " months" . " and" . $days;
                     }
                 }
                 else if($day_interval >= 1){ // if interval is more than or equal to 1 day

                     if($day_interval == 1) { 
                         $time_interval_message = "Yesterday"; 
                     }
                     else { 
                         $time_interval_message = $day_interval . " days ago";
                     }
                 }
                 else if($hour_interval >= 1){ // if interval is more than or equal to 1 hour
                     
                     if($hour_interval == 1) { 
                         $time_interval_message = $hour_interval . " hour ago"; 
                     }
                     else { 
                         $time_interval_message = $hour_interval . " hours ago";
                     }
                 }
                 else if($min_interval >= 1){ // if interval is more than or equal to 1 minute
                     
                     if($min_interval == 1) { 
                         $time_interval_message = $min_interval . " minute ago"; 
                     }
                     else { 
                         $time_interval_message = $min_interval . " minutes ago"; 
                     }
                 }
                 else{ 

                     if($sec_interval < 15) { // if interval is less than 15 seconds
                         $time_interval_message = "Just now";
                     }
                     else { 
                         $time_interval_message = $sec_interval . " seconds ago";
                     }
                 }

                 ?>
                 <div id="comment-section">
                    <div class="post-details">
                        <div class="post-details-profile">
                            <a href="<?php echo $comment_by_username; ?>" target="_parent"><img src="<?php echo $comment_by_pfp; ?>" title="<?php echo $comment_by_full_name;?>" width="30"></a>
                            <a href="<?php echo $comment_by_username; ?>" target="_parent"><strong><?php echo $comment_by_full_name; ?></strong></a> 
                        </div>
                        <div class="post-details-time">
                            <?php echo $time_interval_message;?>
                        </div>
                    </div>
                    <div class="comment-body">
                        <?php echo $comment_body;?>
                    </div> <br>
                </div>
                 <?php
            }
        } 
        else {
            echo "<br><p class='d-flex justify-content-center'>No Comments to Show.</p>";
        }
    ?>

    <div class="space"></div>

    <form action="comment_container.php?post_id=<?php echo $post_id; ?>" class="comment-form" id="commentForm" name="postComment<?php echo $post_id;?>" method="POST">
        <textarea name="comment_body"></textarea>
        <button type="submit" name="postComment<?php echo $post_id; ?>" value="Post">
            <i class="material-icons">send</i>
        </button>
    </form>

</body>
</html>