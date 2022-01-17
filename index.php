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

<div class="container-fluid mt-4">
    <!--fluid container, margin-top: 1.5rem-->
    <div class="row justify-content-evenly">
        <div class="col-md-3">
            <div class="row">
                <div class="card">
                    <?php
                        echo "Hi, " .$user_obj->getFirstAndLastName() ." ";
                        echo $user_obj->getUserID();
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="card">Trending List</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="newsfeed">
                <form action="index.php" class="post-form card" method="POST">
                    <textarea name="post-text-area" id="post-text-area" placeholder="Write a post..."></textarea>
                    <input type="submit" name="post" id="post-submit-btn" value="Post">
                </form>

                <?php
                    $post->loadPosts();
                ?>
            </div>
        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="card">Add Friends</div>
            </div>
            <div class="row">
                Messages
            </div>
        </div>
    </div>
</div>

<!--for bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

</body>

</html>