<?php
    class User {
        private $user;
        private $connect;

        public function __construct($connect, $user){
            $this->connect = $connect;
            $user_details_query = mysqli_query($connect, "SELECT * FROM users WHERE user_id='$user'");
            $this->user = mysqli_fetch_array($user_details_query);
        }

        public function getUsername() {
            return $this->user['username'];
        }

        public function getNumPosts(){
            $user_id = $this->user['user_id'];
            $query = mysqli_query($this->connect, "SELECT num_posts FROM users WHERE user_id='$user_id'");
            $row = mysqli_fetch_array($query);
            return $row['num_posts'];
        }

        public function getFirstAndLastName() {
            $user_id = $this->user['user_id'];
            $query = mysqli_query($this->connect, "SELECT first_name, last_name FROM users WHERE user_id='$user_id'");
            $row = mysqli_fetch_array($query);
            return $row['first_name'] . " " . $row['last_name'];
        }
    }

?>