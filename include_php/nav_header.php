<?php require 'include_php/server.php'; 

    // redirect to register.php when user is not logged in
    if (isset($_SESSION['first_name'])){
        $userLoggedIn = $_SESSION['first_name'];
        $user_details_query = mysqli_query($connect, "SELECT * FROM users WHERE first_name='$userLoggedIn'");
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
    <link rel="stylesheet" href="resources/css/nav_header_style.css">
    <link rel="stylesheet" href="resources/css/newsfeed_style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Bond</title>
</head>

<body>

    <nav>
        <div class="nav-left">
            <h1>Bond</h1>
        </div>

        <div class="nav-mid">
            <div class="nav-search">
                <i class="material-icons">search</i>
                <input type="text" placeholder="Search...">
            </div>
        </div>

        <div class="nav-right">
            <div class="buttons">
                <a href="#"><i class="material-icons">notifications</i></a>
                <a href="#"><i class="material-icons">help_outline</i></a>
            </div>
            <div class="user">
                <a href="#" class="user-avatar">
                    <img src="<?php echo $user['profile_pic']; ?>" alt="User profile picture">
                    <?php echo $user['first_name']; ?>
                    <span class="material-icons">expand_more</span>
                </a>
            </div>
        </div>
    </nav>