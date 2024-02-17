<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>HYGEAS | Login</title>
    <?php
        session_start();
        if(isset($_SESSION['login'])){
            if($_SESSION['login'] == "fail"){
                $_SESSION['login'] = "finish";
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>"';
                echo "<script>";
                echo "Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Login Failed',
                    showConfirmButton: false,
                    timer: 1500
                })";
                echo "</script>";
            }
        }
    ?>
</head>
<body>
    <nav class="nav">
            <div class="container">
                <div class="logo">
                    <a href="../admin/homeadmin.php">HYGEAS</a>
                </div>
            </div>
    </nav>
    <div class="box">
        <div class="container">
            <div class="top-header">
                <header>Admin</header>
            </div>

            <form action = "../CheckUser.php" method="post"> 
                <div class="input-field">
                    <input type="text" class="input" placeholder="Username" name="username" required>
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-field">
                    <input type="password" class="input" placeholder="Password" name="password" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <input type="hidden" name="user" value="1">
                <div class="input-field">
                    <input type="submit" class="submit" value="Sign In">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
