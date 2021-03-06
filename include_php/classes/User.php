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

        public function getFirstName() {
            return $this->user['first_name'];
        }

        public function getLastName() {
            return $this->user['last_name'];
        }

        public function getEmail() {
            return $this->user['email'];
        }

        public function getNumPosts(){
            $user_id = $this->user['id'];
            $query = mysqli_query($this->connect, "SELECT num_posts FROM users WHERE id='$user_id'");
            $row = mysqli_fetch_array($query);
            return $row['num_posts'];
        }

        public function getNumLikes(){
            $user_id = $this->user['id'];
            $query = mysqli_query($this->connect, "SELECT num_likes FROM users WHERE id='$user_id'");
            $row = mysqli_fetch_array($query);
            return $row['num_likes'];
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

        public function isUser($username_check){
            if((strstr($this->user['username'], $username_check))){ // if the user who posted is the current user logged in
                return false;
            } else {
                return true;
            }
        }
    }

?>