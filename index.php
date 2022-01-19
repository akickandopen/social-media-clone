<?php 
    include("include_php/nav_header.php"); 
    include("include_php/classes/User.php");
    include("include_php/classes/Post.php");

    $user_obj = new User($connect, $userLoggedIn);
    $post = new Post($connect, $userLoggedIn);

    if(isset($_POST['post'])){

        $allowUpload = 1;
        $fileImgName = $_FILES['file-img-upload']['name'];
        $errorMessage = "";
    
        if($fileImgName != "") { // if fileImgName is not empty

            $targetDir = "resources/images/posts/"; // target directory
            $fileImgName = $targetDir . uniqid() . basename($fileImgName);
            $fileImgType = pathinfo($fileImgName, PATHINFO_EXTENSION);
    
            if($_FILES['file-img-upload']['size'] > 10000000) {
                $errorMessage = "The file is too large!";
                $allowUpload = 0;
            }
    
            if(strtolower($fileImgType) != "jpeg" && strtolower($fileImgType) != "png" && strtolower($fileImgType) != "jpg") {
                $errorMessage = "Only jpeg, jpg and png files are allowed";
                $allowUpload = 0;
            }
    
            if($allowUpload) {
                if(move_uploaded_file($_FILES['file-img-upload']['tmp_name'], $fileImgName)) {
                    //image is uploaded
                }
                else {
                    $allowUpload = 0; //image did not upload
                }
            }
    
        }
    
        if($allowUpload) {
            $post->submitPost($_POST['post-text-area'], $fileImgName);
            header("Location: index.php");
        }
        else {
            echo "<div style='text-align:center;' class='alert alert-danger'>
                    $errorMessage
                </div>";
        }
    }
?>

<div class="container-fluid mt-4">
    <!--fluid container, margin-top: 1.5rem-->
    <div class="row justify-content-evenly">
        <div class="col-md-3">
            <div class="row">
                <div class="greeting card">
                    <?php echo "<h3>Hi, " .$user_obj->getFirstName() ."</h3>"; ?>
                </div>
            </div>
            <div class="row">
                <div class="card-a">
                    <div class="profile-title">
                        <h4>Profile</h4>
                        <button onClick="javascript:toggleProfile()"><i class="material-icons">arrow_drop_down_circle</i></button>
                    </div>
                    <div class="profile-info" id="toggleProfile">
                        <div class="row">
                            <div class="col-md-4">
                                <p>First Name</p>
                            </div>
                            <div class="col">
                                <p><?php echo $user_obj->getFirstName(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>Last Name</p>
                            </div>
                            <div class="col">
                                <p><?php echo $user_obj->getLastName(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>Email</p>
                            </div>
                            <div class="col">
                                <p><?php echo $user_obj->getEmail(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <button class="update-profile-btn" data-bs-toggle="modal" data-bs-target="#myModal">Update Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="newsfeed">
                <form action="index.php" class="post-form card" method="POST" enctype="multipart/form-data">
                    <div class="body d-flex align-items-start">
                        <img src="<?php echo $user_obj->getPFP(); ?>">
                        <textarea name="post-text-area" id="post-text-area" placeholder="Write a post..."></textarea>
                    </div>
                    <div class="options d-flex justify-content-end align-items-center">
                        <label for="file-img-upload"><i class="material-icons">image</i></label>
                        <input type="file" name="file-img-upload" id="file-img-upload">
                        <input type="submit" name="post" id="post-submit-btn" value="Post">
                    </div>
                </form>

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#all-posts">All Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#my-posts">My Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#trending-posts">Trending</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="all-posts">
                        <?php
                            $tab = "tab_all";
                            $post->loadPosts($tab);
                        ?>
                        <div class="posts-area"></div>
                        <div class="load-data-message"></div>
                    </div>
                    <div class="tab-pane" id="my-posts">
                        <?php
                            $tab = "tab_user";
                            $post->loadPosts($tab);
                        ?>
                    </div>
                    <div class="tab-pane" id="trending-posts">
                        <div class="card">
                            <br>
                            <p class="d-flex justify-content-center">No posts to show</p>
                            <br>
                        </div>
                        <?php
                            $tab = "tab_trends";
                        ?>
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

<div id="myModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>

</div>

<script>
    function toggleProfile() {
        var x = document.getElementById("toggleProfile");
            if (x.style.display == "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
    }
</script>

</body>

</html>