<?php 
    require 'include_php/server.php'; 
    require 'include_php/form_handling/signup_handler.php';
    require 'include_php/form_handling/login_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/register_style.css">
    <title>Registration</title>
</head>

<body>

    <header>
        <h1>Bond</h1>
    </header>

    <section>
        <div class="tabs">
            <input type="radio" name="tab-ex" id="tab-sign-up" class="tab-radio" checked>
            <label for="tab-sign-up" class="tab-label">Log In</label>
            <div class="tab-content">
                <form action="register.php" method="POST">
                    <input type="email" name="login_email" placeholder="Email" value="<?php
                        if(isset($_SESSION['login_email'])){
                            echo $_SESSION['login_email'];
                        }?>" required> <br>
                    <input type="password" name="login_pass" placeholder="Password" required> <br>

                    <input type="submit" name="login_btn" value="Login"> <br>
                    <?php if(in_array("Email or password is incorrect.", $error_list)) echo "Email or password is incorrect.<br>"; ?>
                </form>
            </div>

            <input type="radio" name="tab-ex" id="tab-login" class="tab-radio">
            <label for="tab-login" class="tab-label">Sign Up</label>
            <div class="tab-content">
                <form action="register.php" method="POST">
                    <input type="text" name="sign_up_fname" placeholder="First Name" value="<?php
                        if(isset($_SESSION['sign_up_fname'])){
                            echo $_SESSION['sign_up_fname'];
                        }?>" required> <br>

                    <input type="text" name="sign_up_lname" placeholder="Last Name" value="<?php
                        if(isset($_SESSION['sign_up_lname'])){
                            echo $_SESSION['sign_up_lname'];
                        }?>" required> <br>

                    <input type="email" name="sign_up_email" placeholder="Email" value="<?php
                        if(isset($_SESSION['sign_up_email'])){
                            echo $_SESSION['sign_up_email'];
                        }?>" required> <br>
                    <?php 
                        if(in_array("Email already in use.", $error_list)) echo "Email already in use.<br>";
                        else if (in_array("Invalid email format.", $error_list)) echo "Invalid email format.<br>";
                    ?>

                    <input type="password" name="sign_up_pass" placeholder="Password" required> <br>
                    <input type="password" name="sign_up_pass2" placeholder="Confirm Password" required> <br>
                    <?php if(in_array("Passwords don't match.", $error_list)) echo "Passwords don't match.<br>"; ?>

                    <input type="submit" name="sign_up_btn" value="Create an account">
                </form>
            </div>
        </div>

        <img src="resources/images/website/people.png" alt="People" class="img-people">

    </section>


</body>

</html>