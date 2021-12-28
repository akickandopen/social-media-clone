<?php require 'server.php'; 

session_start();

// Variables
$fname = ""; //first name
$lname = ""; //last name
$email = ""; //email address
$pass = ""; //password
$pass2 = ""; //confirm password
$date = ""; //date signed up
$error = ""; //error messages

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
            echo "Email already in use.";
        }

    }
    else {
        echo "Invalid email format";
    }

    // Check if passwords match
    if($pass != $pass2){
        echo "Passwords don't match.";
    } 

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>

<body>

    <form action="register.php" method="POST">
        <input type="text" name="sign_up_fname" placeholder="First Name" 
        value="<?php
            if(isset($_SESSION['sign_up_fname'])){
                echo $_SESSION['sign_up_fname'];
            }?>" 
            required> <br>

        <input type="text" name="sign_up_lname" placeholder="Last Name" 
        value="<?php
            if(isset($_SESSION['sign_up_lname'])){
                echo $_SESSION['sign_up_lname'];
            }?>"
            required> <br>

        <input type="email" name="sign_up_email" placeholder="Email" 
        value="<?php
            if(isset($_SESSION['sign_up_email'])){
                echo $_SESSION['sign_up_email'];
            }?>"
            required> <br>

        <input type="password" name="sign_up_pass" placeholder="Password" required> <br>
        <input type="password" name="sign_up_pass2" placeholder="Confirm Password" required> <br>
        
        <input type="submit" name="sign_up_btn" value="Create an account"> 
    </form>

</body>

</html>