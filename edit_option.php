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
    $user_post_query = mysqli_query($connect, "SELECT user_by_id, body FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_array($user_post_query);

    $post_by_id = $row['user_by_id']; // id of user who posted
    $previous_body = $row['body'];

    // edit post from database
    if (isset($_POST['save-post'])){

        $new_body = $_POST['post-text-area'];

        // update body of post
        $edit_post_query = mysqli_query($connect, "UPDATE posts SET body='$new_body', post_edited='yes' WHERE id='$post_id'");

        // direct to index.php
        header("Location: index.php");
    }

?>


<div class="container mt-4">
    <div class="card">
        <h3>Edit Post</h3>
        <form action="edit_option.php?post_id=<?php echo $post_id;?>" method="POST">
            <div class="edit-body d-flex align-items-start">
                <textarea name="post-text-area" id="postTextArea" placeholder="<?php echo $previous_body;?>"></textarea>
            </div>
            <div class="settings-option">
                <a href="index.php" class="btn back-btn">Go Back</a>
                <input type="submit" name="save-post" class="btn go-btn" value="Save Changes">
            </div>
        </form>
    </div>
</div>


</body>
</html>