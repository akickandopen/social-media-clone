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
                        echo $userLoggedIn;
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

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#all-posts">All Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#friends-posts">Friends</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#trending-posts">Trending</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="all-posts">
                        <!-- <?php
                            $post->loadPostsAll();
                        ?> -->
                        <div class="posts-area"></div>
                        <div class="load-data"></div>
                        <div class="load-data-message"></div>

                    </div>
                    <div class="tab-pane" id="friends-posts">
                        <?php
                            $post->loadPostsFriends();
                        ?>
                    </div>
                    <div class="tab-pane" id="trending-posts">
                        Trending
                    </div>
                </div>
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

<script>
var userLoggedIn = <?php echo $userLoggedIn; ?>;
var limit = 7;
var start = 0;
var action = 'inactive';

function loadPosts(limit, start) {
    $.ajax({
        url: "include_php/ajax_loading_posts.php",
        method: "POST",
        data: {limit:limit, start:start, userLoggedIn:userLoggedIn},
        cache: false,

        success: function(data) {
            $('.posts-area').append(data);
            if (data == '') {
                $('.load-data-message').html("<p>No More Posts</p>");
                action = 'active';
            } else {
                $('.load-data-message').html("<img src='resources/images/website/loading_icon.gif'>");
                action = 'inactive';
            }
        }
    });
}

if (action == 'inactive') {
    action = 'active';
    loadPosts(limit, start);
}

$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() > $(".posts-area").height() && action == 'inactive') {
        action = 'active';
        start = start + limit;
        setTimeout(function() {
            loadPosts(limit, start);
        }, 1000);
    }
});
</script>

</body>

</html>