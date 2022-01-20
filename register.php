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
    <title>Registration</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/register_style.css">
</head>

<body>

    <div class="container">
      <div class="forms-container">
        <div class="login-signup">
            <form action="register.php" method="POST" class="log-in-form">
                <h2 class="title">Log in</h2>

                <div class="input-field">
                    <i class="material-icons">email</i>
                    <input type="email" name="login_email" placeholder="Email" value="<?php
                        if(isset($_SESSION['login_email'])){
                            echo $_SESSION['login_email'];
                        }?>" required>
                </div>

                <div class="input-field">
                    <i class="material-icons">lock</i>
                    <input type="password" name="login_pass" placeholder="Password" required>
                </div>

                <input type="submit" name="login_btn" value="Login" class="btn solid">
                <?php if(in_array("Email or password is incorrect.", $error_list)) echo '<script>alert("Email or password is incorrect.")</script>'; ?>
            </form>
            <form action="register.php" method="POST" class="sign-up-form">
                <h2 class="title">Sign up</h2>

                <div class="input-field">
                    <i class="material-icons">person</i>
                    <input type="text" name="sign_up_fname" placeholder="First Name" value="<?php
                        if(isset($_SESSION['sign_up_fname'])){
                            echo $_SESSION['sign_up_fname'];
                        }?>" required>
                </div>

                <div class="input-field">
                    <i class="material-icons">person</i>
                    <input type="text" name="sign_up_lname" placeholder="Last Name" value="<?php
                        if(isset($_SESSION['sign_up_lname'])){
                            echo $_SESSION['sign_up_lname'];
                        }?>" required>
                </div>

                <div class="input-field">
                    <i class="material-icons">email</i>
                    <input type="email" name="sign_up_email" placeholder="Email" value="<?php
                        if(isset($_SESSION['sign_up_email'])){
                            echo $_SESSION['sign_up_email'];
                        }?>" required>

                    <?php 
                        if(in_array("Email already in use.", $error_list)) echo '<script>alert("Email already in use.")</script>';
                        else if (in_array("Invalid email format.", $error_list)) echo '<script>alert("Invalid email format.")</script>';
                    ?>
                </div>

                <div class="input-field">
                    <i class="material-icons">lock</i>
                     <input type="password" name="sign_up_pass" placeholder="Password" required>
                </div>

                <div class="input-field">
                    <i class="material-icons">lock</i>
                    <input type="password" name="sign_up_pass2" placeholder="Confirm Password" required>
                    <?php if(in_array("Passwords don't match.", $error_list)) echo '<script>alert("Passwords do not match.")</script>'; ?>
                </div>

                    <input type="submit" name="sign_up_btn" value="Create an account" class="btn">
                </div>
            </form>
        </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here?</h3>
            <p>
              Share your ideas and thoughts. Share your life through posts. Join now 
              and connect with others through Bond!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="resources/images/website/register.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Already have an account?</h3>
            <p>Log in and have fun with Bond!</p>
            <button class="btn transparent" id="log-in-btn">
              Log in
            </button>
          </div>
          <img src="resources/images/website/login.svg" class="image" alt="" />
        </div>
      </div>
    </div>
    

    <script>
        var log_in_btn = document.querySelector("#log-in-btn");
        var sign_up_btn = document.querySelector("#sign-up-btn");
        var container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        log_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>


</body>

</html>