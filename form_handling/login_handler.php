<?php
    if(isset($_POST['login_btn'])){
        $email = filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL); //verify email is in correct format
        $_SESSION['login_email'] = $email;

        $password = md5($_POST['login_pass']);

        // check if email and password is in the database
        $check_db_query = mysqli_query($connect, "SELECT * FROM users WHERE email='$email' AND password='$password'");

        // return no. of results from checking database
        $check_login_query = mysqli_num_rows($check_db_query);

        if($check_login_query == 1){

            // access results from query into $row
            $row = mysqli_fetch_array($check_db_query);

            $fname = $row['first_name'];
            $_SESSION['first_name'] = $fname;

            // redirect to index.php
            header("Location: index.php");
            
            exit();
        }

    }
?>