<?php
    class Post {
        private $user_obj;
        private $connect;

        public function __construct($connect, $user){
            $this->connect = $connect;
            $this->user_obj = new User($connect, $user);
        }

        public function submitPost($body, $fileImgName) {
            $body = strip_tags($body); //remove html tags
            $body = mysqli_real_escape_string($this->connect, $body);

            $check_empty = preg_replace('/\s+/', '', $body); //deletes all spaces
            if($check_empty != ""){
                //current date and time
                $date_added = date("Y-m-d H:i:s");

                //get username and user ID
                $user_by = $this->user_obj->getUsername();
                $user_by_id = $this->user_obj->getUserID();

                //insert post in database
                $query = mysqli_query($this->connect, "INSERT INTO posts (body, image, user_by_id, user_by, date_added, user_by_closed, post_deleted, likes) VALUES('$body', '$fileImgName', '$user_by_id', '$user_by', '$date_added', 'no', 'no', '0')");
                $returned_id = mysqli_insert_id($this->connect);

                //update number of posts
                $num_posts = $this->user_obj->getNumPosts();
                $num_posts++;
                $update_query = mysqli_query($this->connect, "UPDATE users SET num_posts='$num_posts' WHERE username='$user_by'");
            
            }

        }

        public function loadPosts($tab){
            $post_str = "";
            $userLoggedIn = $this->user_obj->getUserID();

            //select posts that haven't been deleted in descending order
            $posts_data_query = mysqli_query($this->connect, "SELECT * FROM posts WHERE post_deleted='no' ORDER BY id DESC");

            if(mysqli_num_rows($posts_data_query) > 0) {

                while($row = mysqli_fetch_array($posts_data_query)){
                    $id = $row['id'];
                    $body = $row['body'];
                    $user_by_id = $row['user_by_id'];
                    $user_by = $row['user_by'];
                    $date_time = $row['date_added'];
                    $fileImgPath = $row['image'];

                    //Check if user who added the post is closed
                    $user_by_obj = new User($this->connect, $user_by_id);
                    if($user_by_obj->isClosed()){
                        continue;
                    }

                    $user_logged_obj = new User($this->connect, $userLoggedIn);
                    if($tab == "tab_user" && $user_logged_obj->isUser($user_by)){
                        continue;
                    }

                    // if the user logged in is the one who posted, include settings button
                    if($userLoggedIn == $user_by_id){
                        $settings_btn = "<button class='settings-btn dropdown-toggle align-self-end' id='settingsBtn' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                            <i class='material-icons'>settings</i>
                                        </button>";
                    } else {
                        $settings_btn = "";
                    }

                    //select user's first name, last name, and profile pic
                    $user_details_query = mysqli_query($this->connect, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$user_by'");
                    $user_row = mysqli_fetch_array($user_details_query);

                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>

                    <script>
                        function toggleFunction<?php echo $id; ?>() {

                            var x = document.getElementById("toggleComment<?php echo $id; ?>");
                                if (x.style.display == "none") {
                                    x.style.display = "block";
                                } else {
                                    x.style.display = "none";
                                }
                        }
                    </script>

                    <?php
                        //query to check number of comments in the post
                        $num_comments_check = mysqli_query($this->connect, "SELECT * FROM comments WHERE post_id='$id'");
                        $num_comments = mysqli_num_rows($num_comments_check);

                        //timeframe
                        $date_time_now = date("Y-m-d H:i:s");
                        $start_date = new DateTime($date_time); // date post was added
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

                        if($fileImgPath != ""){
                            $file_img = "<div class='post-body-image'>
                                            <img src='$fileImgPath'>
                                        </div>";
                        } else {
                            $file_img = "";
                        }

                        $post_str .= "<div class='status-post card'>
                                        <div class='post-details'>
                                            <div class='post-details-profile'>
                                                <img src='$profile_pic' width='36' alt='Profile Picture'>
                                                <a href='$user_by'> $first_name $last_name </a>
                                            </div>
                                            <div class='post-details-time'>
                                                $time_interval_message
                                            </div>
                                        </div>
                                        <div id='post-body'>
                                            $body <br>
                                            $file_img
                                            <div class='post-options d-flex justify-content-between'>
                                                <div class='d-flex align-items-end'>
                                                    <button onClick='javascript:toggleFunction$id()' class='comment-icon'>
                                                        <i class='material-icons'>question_answer</i>
                                                    </button>
                                                        <p>$num_comments</p>
                                                    <iframe src='like_option.php?post_id=$id' scrolling='no'></iframe>
                                                </div>
                                                <div class='dropdown d-flex align-items-end'>
                                                    $settings_btn
                                                    <ul class='dropdown-menu' aria-labelledby='settingsBtn'>
                                                        <li><a class='dropdown-item' href='#'>Edit</a></li>
                                                        <li><a class='dropdown-item' href='delete_option.php?post_id=$id'>Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='post-comment' id='toggleComment$id' style='display:none;'>
                                            <iframe src='comment_container.php?post_id=$id' id='comment_iframe' frameborder='0' width='100%'></iframe>
                                        </div>
                                    </div>
                                    ";
                    }
                }
            echo $post_str;
        }

    }

?>