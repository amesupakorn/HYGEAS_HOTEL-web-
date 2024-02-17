<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>HYGEAS_HOTEL</title>
  <?php
    session_start();
    if(isset($_GET['logout'])){
      if($_GET['logout'] == 2){
        session_unset();
        session_destroy();
      }
      if($_GET['logout'] == 3){
        unset($_SESSION['logout']);
      }
  }
  ?>

  <?php
    include('../connectToDatabase.php');

    $conn = new database();
    $sql = "
            Select firstname, lastname, tel, mail
            From Customer
            Where code_cus = ".$_SESSION['user_code'].";";

    $objResult = mysqli_fetch_array(mysqli_query($conn->getDatabase(), $sql));

    $firstname = $objResult["firstname"];
    $lastname = $objResult["lastname"];
    $tel = $objResult["tel"];
    $email = $objResult["mail"];
  ?>
  <link rel="icon" type="image/x-icon" href="/home/favicon.ico">
  <link rel="stylesheet" href="account.css"><script src="https://kit.fontawesome.com/c1134aa968.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
</head>

<body>

<!-- partial:index.partial.html -->
	<nav class="nav" >
            <div class="logo">
                <a href="#">HYGEAS</a>
            </div>
            <div id="mainListDiv" class="main_list">
                <ul class="navlinks">
                    <li><a href="../">Home</a></li>
                    <li><a href="../room/room.php">Rooms</a>
                    <li><a href="../ballroom/ballroom.php">Ballroom</a>
                    <li><a href="../seminar/seminar.php">Seminar</a>
                    <li><a href="../book/book.php">Booking</a></li>
                    <?php 
                
                      if(isset($_SESSION['user_login']) && !empty($_SESSION['user_login'])){
                          echo "<li>";
                          echo '<a href="#popup2">';
                          echo $_SESSION['user_login'];
                          echo "</a>";
                          echo "</li>";
                      }
                      else{
                          echo "<li><a href='../loginuser/Login.php'>Login</a></li>";
                      
                      }
                  ?>
            </div>
        </div>
 	</nav>

	<div id="popup2" class="overlay light">
		<a class="cancel" href="#"></a>
		<div class="popup">
			<h2>MY ACCOUNT</h2>
			<h2 class="title"></h2>
			<div class="content">
			<a href="account/account.php" class="profile">Profile</a>
			<a href="../historyC/historyC.php" class="profile">MY Bookings</a>
			<a href="logout.php" class="btn2">
			<span class="btn-inner">SIGN OUT</span>
			</a>
			</div>
		</div>
	</div>

	<div class="container">

		<h1>MY ACCOUNT</h1>
		<h2 class="title"></h2>
		<form action="editprofile.php" method="post">
			<div class="grid">
				<div class="form-group a">
					<label for="first-name">Firstname</label>
					<input id="first-name" type="text" name="edit_firstname" placeholder="<?php echo $firstname; ?>" >
				</div>

				<div class="form-group b">
					<label for="last-name">Lastname</label>
					<input id="last-name" type="text" name="edit_lastname" placeholder="<?php echo $lastname; ?>">
				</div>

				<div class="form-group email-group">
					<label for="email">Email</label>
					<input id="email" type="text" name="edit_tel" placeholder="<?php echo $email; ?>">
				</div>

				<div class="form-group phone-group">
					<label for="phone">Telephone (mobile)</label>
					<input id="phone" type="text" name="edit_mail" placeholder="<?php echo $tel; ?>">
				</div>
			</div>
			<div class="button-container">
				<button class="button" type="submit" class="save" value="Save Changes" name="save">Save Changes</button>
			</div>
		</form>
	</div>
<!-- partial -->
  
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js'></script><script  src="./script.js"></script>
    <script src="room.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'></script>
    <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
    <script>
        $(window).scroll(function() {
            if ($(document).scrollTop() > 50) {
                $('.nav').addClass('affix');
                console.log("OK");
            } else {
                $('.nav').removeClass('affix');
            }
        });
    </script>
</body>
</html>