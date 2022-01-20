<?php 
    include("include_php/nav_header.php"); 
    include("include_php/classes/User.php");
    include("include_php/classes/Post.php");

    $user_obj = new User($connect, $userLoggedIn);
    $post = new Post($connect, $userLoggedIn);

    $allowUpload = 1;
    $errorMessage = "";
    
    if(isset($_POST['post'])){

        $fileImgName = $_FILES['file-img-upload']['name'];
    
        if($fileImgName != "") { // if fileImgName is not empty

            $targetDir = "resources/images/posts/"; // target directory
            $fileImgName = $targetDir . uniqid() . basename($fileImgName); // image path name
            $fileImgType = pathinfo($fileImgName, PATHINFO_EXTENSION); // file type
    
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

    if(isset($_POST['update-profile'])){
    
        $new_first_name = $_POST['new-first-name'];
        $new_last_name = $_POST['new-last-name'];
        $profileImgName = $_FILES['profile-img-upload']['name'];
    
        if($profileImgName != "") { // if profileImgName is not empty
            $targetDir = "resources/images/profile_pics/"; // target directory
            $profileImgName = $targetDir . uniqid() . basename($profileImgName);
            $profileImgType = pathinfo($profileImgName, PATHINFO_EXTENSION);
    
            if($_FILES['profile-img-upload']['size'] > 10000000) {
                $errorMessage = "The file is too large!";
                $allowUpload = 0;
            }
    
            if(strtolower($profileImgType) != "jpeg" && strtolower($profileImgType) != "png" && strtolower($profileImgType) != "jpg") {
                $errorMessage = "Only jpeg, jpg and png files are allowed";
                $allowUpload = 0;
            }
    
            if($allowUpload) {
                if(move_uploaded_file($_FILES['profile-img-upload']['tmp_name'], $profileImgName)) {
                    //image is uploaded
                }
                else {
                    $allowUpload = 0; //image did not upload
                }
            }
        } else {
            // get post details
            $profile_pic_query = mysqli_query($connect, "SELECT profile_pic FROM users WHERE id='$userLoggedIn'");
            $row = mysqli_fetch_array($profile_pic_query);

            $profileImgName = $row['profile_pic'];
        }
    
        if($allowUpload) {
            // update first and last name and profile pic of the user logged in
            $edit_user_query = mysqli_query($connect, "UPDATE users SET first_name='$new_first_name', last_name='$new_last_name', profile_pic='$profileImgName' WHERE id='$userLoggedIn'");
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
        <div class="col-md-4 greeting-profile">
            <div class="row mx-1 d-none d-md-block">
                <div class="greeting card">
                    <img src="<?php echo $user_obj->getPFP(); ?>">
                    <?php echo "<h4>Hi, " .$user_obj->getFirstName() ."!</h4>"; ?>
                </div>
            </div>
            <div class="row mx-1">
                <div class="card-a">
                    <div class="profile-title mb-1">
                        <h4>Profile</h4>
                        <button onClick="javascript:toggleProfile()"><i class="material-icons">arrow_drop_down_circle</i></button>
                    </div>
                    <div class="profile-info" id="toggleProfile">
                        <div class="row">
                            <div class="col-md-4 col-sm-2">
                                <p>First Name</p>
                            </div>
                            <div class="col">
                                <p><?php echo $user_obj->getFirstName(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-2">
                                <p>Last Name</p>
                            </div>
                            <div class="col">
                                <p><?php echo $user_obj->getLastName(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-2">
                                <p>Email</p>
                            </div>
                            <div class="col">
                                <p><?php echo $user_obj->getEmail(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p>Posts:</p>
                            </div>
                            <div class="col">
                                <p><?php echo $user_obj->getNumPosts(); ?></p>
                            </div>
                            <div class="col">
                                <p>Likes:</p>
                            </div>
                            <div class="col">
                                <p><?php echo $user_obj->getNumLikes(); ?></p>
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
                        <textarea name="post-text-area" id="postTextArea" placeholder="Write a post..."></textarea>
                    </div>
                    <div class="options d-flex justify-content-end align-items-center">
                        <label for="fileImgUpload"><i class="material-icons">image</i></label>
                        <input type="file" name="file-img-upload" id="fileImgUpload">
                        <input type="submit" name="post" id="postSubmitBtn" value="Post">
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
                        <a class="nav-link" data-bs-toggle="tab" href="#trending-posts">Top Tags</a>
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
                        <?php
                            $tab = "tab_trends";
                            $post->loadPosts($tab);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="row mx-1 d-none d-md-block">
                <div class="card">
                    <h5>Top Tags:</h5>
                    <?php
                        // query to select distinct topics in posts that is not null
                        $query = mysqli_query($connect, "SELECT DISTINCT topics FROM `posts` WHERE topics IS NOT NULL AND TRIM(topics) <> ' ' LIMIT 10");

                        while($row = mysqli_fetch_array($query)){
                            $tag = $row['topics'];

                            echo str_replace(",","<br>","$tag"); // replace "," with "<br>" in $tag
                        }
                    ?>
                </div>
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
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <label for="profileImgUpload">Profile Picture</label><br>
                    <img src="<?php echo $user_obj->getPFP(); ?>" width="100">
                    <input type="file" name="profile-img-upload" id="profileImgUpload"><br>

                    <label for="firstName">First Name</label><br>
                    <input type="text" name="new-first-name" id="firstName" value="<?php echo $user_obj->getFirstName(); ?>"><br>

                    <label for="lastName">Last Name</label><br>
                    <input type="text" name="new-last-name" id="lastName" value="<?php echo $user_obj->getLastName(); ?>"><br>
                    
                    <hr>
                    <input type="submit" name="update-profile" class="btn btn-primary" value="Save Changes">
                </form>
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