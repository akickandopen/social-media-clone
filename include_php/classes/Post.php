<?php
    class Post {
        private $user_obj;
        private $connect;

        public function __construct($connect, $user){
            $this->connect = $connect;
            $this->user_obj = new User($connect, $user);
        }

        public function submitPost($body) {
            $body = strip_tags($body); //remove html tags
            $body = mysqli_real_escape_string($this->connect, $body);

            //allow line breaks in posts
            $body = str_replace('\r\n', '\n', $body);
            $body = nl2br($body);

            $check_empty = preg_replace('/\s+/', '', $body); //deletes all spaces
            if($check_empty != ""){
                //current date and time
                $date_added = date("Y-m-d H:i:s");

                //get username
                $added_by = $this->user_obj->getUsername();

                //insert post in database
                $query = mysqli_query($this->connect, "INSERT INTO posts (body, added_by, date_added, user_closed, post_deleted, likes) VALUES('$body', '$added_by', '$date_added', 'no', 'no', '0')");
                $returned_id = mysqli_insert_id($this->connect);

                //update number of posts
                $num_posts = $this->user_obj->getNumPosts();
                $num_posts++;
                $update_query = mysqli_query($this->connect, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
            
            }

        }
    }

?>