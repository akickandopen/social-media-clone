<?php 
    include("include_php/nav_header.php"); 
    include("include_php/classes/User.php");
    include("include_php/classes/Post.php");

    $user_obj = new User($connect, $userLoggedIn);
    $post = new Post($connect, $userLoggedIn);

    // get post id
    if(isset($_GET['post_id'])){
        $post_id = $_GET['post_id'];
    }

    // get post details
    $user_post_query = mysqli_query($connect, "SELECT user_by_id FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_array($user_post_query);

    $post_by_id = $row['user_by_id']; // id of user who posted

    // get details of the user who posted
    $user_details_query = mysqli_query($connect,"SELECT * FROM users WHERE id='$post_by_id'");
    $row = mysqli_fetch_array($user_details_query);

    $total_user_posts = $row['num_posts']; // number of posts from user who posted

    // remove post from database
    if (isset($_POST['delete-btn'])){

        // remove post from user who posted
        $total_user_posts--; // -1
        $update_num_post = mysqli_query($connect, "UPDATE users SET num_posts='$total_user_posts' WHERE id='$post_by_id'");

        // delete post from database
        $remove_post = mysqli_query($connect, "DELETE FROM posts WHERE user_by_id='$post_by_id' AND id='$post_id'");

        // direct to index.php
        header("Location: index.php");
    }

?>


<div class="container mt-4">
    <div class="card">
        <h3>Delete Post</h3>
        <p>Are you sure you want to delete this post?</p>
        <div class="settings-option">
            <a href="index.php" class="btn back-btn">Go Back</a>
            <form action="delete_option.php?post_id=<?php echo $post_id;?>" method="POST">
                <input type="submit" name="delete-btn" value="Delete" class="btn go-btn">
            </form>
        </div>
    </div>
</div>


</body>
</html>