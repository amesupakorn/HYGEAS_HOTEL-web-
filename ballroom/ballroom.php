<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>HYGEAS_HOTEL</title>
  <?php 
        session_start();
        
  ?>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css'><link rel="stylesheet" href="ballroom.css">
  <link rel="icon" type="image/x-icon" href="/home/favicon.ico">
  <link href="http://fonts.googleapis.com/css?family=Playfair+Display:900" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Alice:400,700" rel="stylesheet" type="text/css" />
  <?php
      if(isset($_SESSION['logout'])){
          if($_SESSION['logout'] == 1){
            include ('alert.php');
            alertout();
          }
      }
    ?>
</head>
<body>
<!-- partial:index.partial.html -->
    <nav class="nav">
      <div class="container">
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
                          echo '<a href="#popup2"">';
                          echo $_SESSION['user_login'];
                          echo "</a>";
                          echo "</li>";
                      }
                      else{
                          echo "<li><a href='../loginuser/Login.php'>Login</a></li>";
                      
                      }

                ?>             
            </ul>
          </div>
      </div>
    </nav>
    <div id="popup2" class="overlay light">
      <a class="cancel" href="#"></a>
      <div class="popup">
        <h2>MY ACCOUNT</h2>
        <h2 class="title2"></h2>
        <div class="content">
            <a href="../account/account.php" class="profile">Profile</a>
            <a href="../historyC/historyC.php" class="profile">MY Bookings</a>
            <a href="logout.php" class="btn2">
              <span class="btn-inner">SIGN OUT</span>
            </a>
        </div>
      </div>
    </div>
    <section class="head">
      <div class="caption">
          <div class="title">The Ballroom</div>
              <div class="text">
                  <p>The Very Best of 5 Star Space and Service.</p>
              </div> 
              <a href="../book/book.php" class="btn">
                <span class="btn-inner">BOOK NOW</span>
              </a>
              </div>
            </div>
          <div class="image-container"> 
            <img src="image/ballroom1.webp" alt="" class="image" />
          </div>
      </div>
    </section>
    <main>
      <div>
        <h1>BALLROOM</h1>
        <hr>
        <p>Hotel Hygeas’s signature ballroom is the<br>epitome of grandeur. There is access to<br>an outdoor terrace with views of mountain<br> and beautiful floor to ceiling windows.<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FUNCTION TYPES<br>- Gala dinners&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Cocktail receptions<br>- Weddings&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Private celebrations</p>
        <h5>THB 250,000.00</h5>
        <h6>/days</h6>
      </div>
      <div class="swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide swiper-slide--one"></div>
          <div class="swiper-slide swiper-slide--two"></div>
          <div class="swiper-slide swiper-slide--three"></div>
          <div class="swiper-slide swiper-slide--four"></div>
          <div class="swiper-slide swiper-slide--five"></div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
      </div>
    </msin>

    <div style="height: 230px"></div>
<!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js'></script><script  src="ballroom.js"></script>
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
