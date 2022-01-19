<?php 
    require 'include_php/server.php'; 
    include("include_php/classes/User.php");
    include("include_php/classes/Post.php");

    // redirect to register.php when user is not logged in
    if (isset($_SESSION['id'])){
        $userLoggedIn = $_SESSION['id'];
        $user_details_query = mysqli_query($connect, "SELECT * FROM users WHERE id='$userLoggedIn'");
        $user = mysqli_fetch_array($user_details_query);
    } 
    else {
        header("Location: register.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="resources/css/newsfeed_style.css">
</head>
<body>
    
</body>
</html>