<?php
    class User {
        private $user;
        private $connect;

        public function __construct($connect, $user){
            $this->connect = $connect;
            $user_details_query = mysqli_query($connect, "SELECT * FROM users WHERE id='$user'");
            $this->user = mysqli_fetch_array($user_details_query);
        }

        public function getUserID() {
            return $this->user['id'];
        }

        public function getUsername() {
            return $this->user['username'];
        }

        public function getNumPosts(){
            $user_id = $this->user['id'];
            $query = mysqli_query($this->connect, "SELECT num_posts FROM users WHERE id='$user_id'");
            $row = mysqli_fetch_array($query);
            return $row['num_posts'];
        }

        public function getFirstAndLastName() {
            $user_id = $this->user['id'];
            $query = mysqli_query($this->connect, "SELECT first_name, last_name FROM users WHERE id='$user_id'");
            $row = mysqli_fetch_array($query);
            return $row['first_name'] . " " . $row['last_name'];
        }

        public function getPFP() {
            $user_id = $this->user['id'];
            $query = mysqli_query($this->connect, "SELECT profile_pic FROM users WHERE id='$user_id'");
            $row = mysqli_fetch_array($query);
            return $row['profile_pic'];
        }

        public function isClosed(){
            $username = $this->user['username'];
            $query = mysqli_query($this->connect, "SELECT user_closed FROM users WHERE username='$username'");
            $row = mysqli_fetch_array($query);

            if($row['user_closed'] == 'no')
                return false;
            else
                return true;
        }

        public function isFriend($username_friend_check){
            $username_friend = "," . $username_friend_check . ",";

            if((strstr($this->user['friend_array'], $username_friend) || $username_friend_check == $this->user['username'])){
                return false;
            } else {
                return true;
            }
        }
    }

?>