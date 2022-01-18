<?php require 'include_php/server.php'; 

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
    <title>Bond</title>

    <!--JAVASCRIPT-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/nav_header_style.css">
    <link rel="stylesheet" href="resources/css/newsfeed_style.css">
    
</head>

<body>

    <nav>
        <div class="nav-left">
            <h1>Bond</h1>
            <div class="nav-search">
                <i class="material-icons">search</i>
                <input type="text" placeholder="Search...">
            </div>
        </div>

        <!-- <div class="nav-mid">
            <div class="nav-search">
                <i class="material-icons">search</i>
                <input type="text" placeholder="Search...">
            </div>
        </div> -->

        <div class="nav-right">
            <div class="buttons">
                <a href="#"><i class="material-icons">notifications</i></a>
                <a href="#"><i class="material-icons">help_outline</i></a>
                <a href="include_php/logout.php">
                    <i class="material-icons">logout</i>
                </a>
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