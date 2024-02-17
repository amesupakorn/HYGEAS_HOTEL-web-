<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <?php
        session_start();
        if(isset($_SESSION['regis'])){
            if($_SESSION['regis'] == "namefail"){
                $_SESSION['regis'] = "finish";
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>"';
                echo "<script>";
                echo "Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Username is already in use',
                    showConfirmButton: false,
                    timer: 1500
                })";
                echo "</script>";
            }
            if($_SESSION['regis'] == "failpass"){
                $_SESSION['regis'] = "finish";
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>"';
                echo "<script>";
                echo "Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Confirm Password not match with Password',
                    showConfirmButton: false,
                    timer: 1500
                })";
                echo "</script>";
            }
        }

    ?>
    <title>HYGEAS | Register</title>
</head>
<body>
    <nav class="nav">
        <div class="container">
            <div class="logo">
                <a href="../index.php">HYGEAS</a>
            </div>
        </div>
    </nav>
    <div class="box">
        <div class="container">
            <div class="top-header">
                <header>Your Profile</header>
            </div>
            
            <form action="registerDB.php" method="post"> 
                <div class="input-field">
                    <input type="text" class="input" placeholder="First Name" name="first_name" id="contact-firstname" onkeyup="validatefirst()" required>
                    <span id="error-firstname"></span>
                </div>
                <div class="input-field">
                    <input type="text" class="input" placeholder="Last Name" name="last_name"  id="contact-lastname" onkeyup="validatelast()" required>
                    <i class="bx bx-user"></i>
                    <span id="error-lastname"></span>
                </div>
                <div class="input-field">
                    <input type="email" class="input" placeholder="Email" name="email" id="contact-email" onkeyup="validateemail()" required>
                    <i class="bx bx-envelope"></i>
                    <span id="error-email"></span>
                </div>
                <div class="input-field">
                    <input type="tel" class="input" placeholder="Phone Number" name="phone_number" id="contact-phone" onkeyup="validatephone()" required>
                    <i class="bx bx-phone"></i>
                    <span id="error-phone"></span>
                </div>
                <div class="input-field">
                    <input type="text" class="input" placeholder="Username" name="username" id="contact-user" onkeyup="validateuser()" required>
                    <i class="bx bx-user"></i>
                    <span id="error-user"></span>
                </div>
                <div class="input-field">
                    <input type="password" class="input" placeholder="Password" name="password" id="contact-pass" onkeyup="validatepass()" required>
                    <i class="bx bx-lock-alt"></i>
                    <span id="error-pass"></span>
                </div>
                <div class="input-field">
                    <input type="password" class="input" placeholder="Confirm Password" name="confirm_password" id="contact-cpass" onkeyup="validateconpass()"required>
                    <i class="bx bx-lock-alt"></i>
                    <span id="error-conpass"></span>
                </div>

                <fieldset>
                    <legend>Gender :</legend>
                    <div>
                    <input type="radio" id="contactChoice1" name="gender" value="male" checked />
                    <label for="contactChoice1">Male</label>

                    <input type="radio" id="contactChoice2" name="gender" value="Female" />
                    <label for="contactChoice2">Female</label>

                </fieldset>

                <div class="input-field">
                    <input type="submit" class="submit" value="Sign Up" name="sign_up" onclick="return validateForm()">
                        <span id="error-submit"></span> 
                </div>

            </form>
            
            <div class="links">
                Already a member? <a href="Login.php"> Sign In </a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous">
    </script>
</body>
</html>