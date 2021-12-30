<?php
    // Variables
    $fname = ""; //first name
    $lname = ""; //last name
    $email = ""; //email address
    $pass = ""; //password
    $pass2 = ""; //confirm password
    $date = ""; //date signed up
    $error_list = array(); //error messages

    if(isset($_POST['sign_up_btn'])){

        // Remove html tags from form values
        $fname = strip_tags($_POST['sign_up_fname']);
        $lname = strip_tags($_POST['sign_up_lname']); 
        $email = strip_tags($_POST['sign_up_email']); 
        $pass = strip_tags($_POST['sign_up_pass']);
        $pass2 = strip_tags($_POST['sign_up_pass2']); 

        // Store values into session variable
        $_SESSION['sign_up_fname'] = $fname; 
        $_SESSION['sign_up_lname'] = $lname; 
        $_SESSION['sign_up_email'] = $email; 

        $date = date("Y-m-d"); //current date
        
        // Check if email is in valid format
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

            // If email already exists
            $email_check = mysqli_query($connect, "SELECT email FROM users WHERE email='$email'");
            $num_rows = mysqli_num_rows($email_check); // count no. of rows from $email_check

            if($num_rows > 0){
                array_push($error_list, "Email already in use."); // store error message into array
            }

        }
        else {
            array_push($error_list, "Invalid email format.");
        }

        // Check if passwords match
        if($pass != $pass2){
            array_push($error_list, "Passwords don't match.");
        } 

        // If there are no errors
        if(empty($error_list)){
            // encrypt password before adding into database
            $pass = md5($pass);

            // assign profile pic to the user
            $profile_pic = "resources/images/profile_pics/default/blank-profile-picture.png";

            // send values into the databse
            $query = "INSERT INTO users (first_name, last_name, email, password, date_registered, profile_pic, num_posts, num_likes, user_closed, friend_array) VALUES ('$fname', '$lname', '$email', '$pass', '$date', '$profile_pic', '0', '0', 'no', ',')";
            if (mysqli_query($connect, $query)) {
                echo "New record created successfully !";
            } else {
                echo "Error: " . $query . " " . mysqli_error($connect);
            }

            // clear session variables
            $_SESSION['sign_up_fname'] = "";
            $_SESSION['sign_up_lname'] = "";
            $_SESSION['sign_up_email'] = "";
        }
    }
    
?>