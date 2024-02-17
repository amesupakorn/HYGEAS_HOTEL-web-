<!DOCTYPE html>
<html>
<head>

    <title>HYGEAS_HOTEL</title>
    <meta charset="utf-8" />
    <?php
      session_start();
    ?>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Inknut+Antiqua:600|Roboto|Roboto+Condensed:700'><link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="room.css">
    <link rel="icon" type="image/x-icon" href="/home/favicon.ico">
    <link rel="stylesheet"><script src="https://kit.fontawesome.com/c1134aa968.js" crossorigin="anonymous"></script>
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
    <nav class="nav" >
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
        <main class="main-content">
            <section class="slideshow">
              <div class="slideshow-inner">
                <div class="slides">
                  <div class="slide is-active ">
                    <div class="slide-content">
                      <div class="caption">
                        <div class="title">The Rooms</div>
                          <div class="text">
                            <p>The Very Best of 5 Star Space and Service.</p>
                          </div> 
                          <a href="../book/book.php" class="btn">
                            <span class="btn-inner">BOOK NOW</span>
                          </a>
                      </div>
                    </div>
                    <div class="image-container"> 
                      <img src="../home/kit.jpg" alt="" class="image" />
                    </div>
                  </div>
                  <div class="slide">
                    <div class="slide-content">
                      <div class="caption">
                        <div class="title">The Rooms</div>
                          <div class="text">
                            <p>The Very Best of 5 Star Space and Service.</p>
                          </div> 
                          <a href="../book/book.php" class="btn">
                            <span class="btn-inner">BOOK NOW</span>
                          </a>
                      </div>
                    </div>
                    <div class="image-container">
                      <img src="image/DeluxeTwin/bed2.5.webp" alt="" class="image" />
                    </div>
                  </div>
                  <div class="slide">
                    <div class="slide-content">
                      <div class="caption">
                        <div class="title">The Rooms</div>
                          <div class="text">
                            <p>The Very Best of 5 Star Space and Service.</p>
                          </div> 
                          <a href="/book/book.php" class="btn">
                            <span class="btn-inner">BOOK NOW</span>
                          </a>
                      </div>
                    </div>
                    <div class="image-container">
                      <img src="image/DeluxeTwin/bed2.3.webp" alt="" class="image" />
                    </div>
                  </div>
                  <div class="slide">
                    <div class="slide-content">
                      <div class="caption">
                        <div class="title">The Rooms</div>
                          <div class="text">
                            <p>The Very Best of 5 Star Space and Service.</p>
                          </div> 
                          <a href="../book/book.php" class="btn">
                            <span class="btn-inner">BOOK NOW</span>
                          </a>
                      </div>
                    </div>
                    <div class="image-container"> 
                      <img src="image/poolvilla/bed3.1.webp" alt="" class="image" />
                    </div>
                  </div>
                </div>
              </div> 
            </section>
          </main>
    </section>
    </div>
    <div style="height: 230px"></div>

    <div class="texthead" style="height: 160px" >
        <h1 >Enjoy Your Stay</h1>
        <p>A hotel is an establishment that provides paid lodging on a short-term basis.</p>
        <p>Facilities provided may range from a modest-quality mattress</p>
    </div>

     <!-- Main Button -->
     <div style="height: 100px"></div>
     <section class="block">
      <div class="item-parallax-content flex-container img-grid">
        <figure class="img-gridItem type-right">
          <img src="../room/image/Deluxedouble/bed1.1.webp" alt="" />
          <figcaption class="img-caption">
            <h2 class="head-small">Deluxe Double Room</h2>
            <p class="copy copy-white">
              •&nbsp;&nbsp;&nbsp;Deluxe room with double bed
              <br>A room size of  42m², Mountain view, Non-smoking, Desk, Room Service, Air conditioned, Mini Fridge, Shower - separate, Balcony, Room Safe, Telephone, Cable/Satellite TV, Television, Clock Radio, Tea/Coffee Maker, Hairdryer, Wireless Internet, Linen and Towels Provided.
              <br><br>•&nbsp;&nbsp;&nbsp;AMENITIES<br>
                <i class="fa-solid fa-person"></i>&nbsp;&nbsp;&nbsp;Sleeps 2<br> <i class="fa-solid fa-bed"></i>1 Double bed<br><i class="fa-solid fa-bath"></i>&nbsp;1 Bathroom<br>
            </p>
            <h5>THB 5,000.00</h5>
            <h6>/night</h6>
          </figcaption>
        </figure>
        <div style="height: 70px"></div>
        <figure class="img-gridItem type-left">
          <img src="../room/image/Deluxetwin/bed2.1.png" alt="" />
          <figcaption class="img-caption">
            <h2 class="head-small">Deluxe Twin Room</h2>
            <p class="copy copy-white">
              •&nbsp;&nbsp;&nbsp;Deluxe room with 2-single bed
              <br>A room size of  42m², Mountain view, Non-smoking, Desk, Room Service, Air conditioned, Mini Fridge, Shower - separate, Balcony, Room Safe, Telephone, Cable/Satellite TV, Television, Clock Radio, Tea/Coffee Maker, Hairdryer, Wireless Internet, Linen and Towels Provided.
              <br><br>•&nbsp;&nbsp;&nbsp;AMENITIES<br>
                <i class="fa-solid fa-person"></i>&nbsp;&nbsp;&nbsp;Sleeps 2<br> <i class="fa-solid fa-bed"></i>2 Twin<br><i class="fa-solid fa-bath"></i>&nbsp;1 Bathroom<br>
            </p>
            <h5>THB 5,000.00</h5>
            <h6>/night</h6>
          </figcaption>
        </figure>
        <div style="height: 70px"></div>
        <figure class="img-gridItem type-right">
          <img src="../room/image/poolvilla/bed3.3.webp" alt="" />
          <figcaption class="img-caption">
            <h2 class="head-small">Pool Villa</h2>
            <p class="copy copy-white">
              •&nbsp;&nbsp;&nbsp;Pool villa with double bed, private pool and<br> &nbsp;&nbsp;&nbsp;&nbsp;outdoor bath tub
              <br>A room size of  60m², Mountain view, Non-smoking, Desk, Room Service, Air conditioned, Mini Fridge, Shower - separate, Balcony, Room Safe, Telephone, Cable/Satellite TV, Television, Clock Radio, Tea/Coffee Maker, Hairdryer, Wireless Internet, Linen and Towels Provided.
              <br><br>•&nbsp;&nbsp;&nbsp;AMENITIES<br>
                <i class="fa-solid fa-person"></i>&nbsp;&nbsp;&nbsp;Sleeps 2<br> <i class="fa-solid fa-bed"></i>1 Double bed<br><i class="fa-solid fa-bath"></i>&nbsp;1 Bathroom<br>
            </p>
            <h5>THB 10,000.00</h5>
            <h6>/night</h6>
          </figcaption>
        </figure>
      </div>
    </section>

    <!-- <section class="inner">
      <div class="row">
        <div class="cardview">
            <img style="background-image:url(image/Deluxedouble/bed1.1.webp)"/>
            <section class="content">
            <h1>Deluxe Double Room</h1>
            <p> mauris proin sed nibh magna ipsum sollicitudin urna lobortis eros in ac malesuada bibendum...</p>
            <a href="#">BOOK NOW</a>
            </section>
        </div>

        <div class="cardview">
            <img style="background-image:url(image/DeluxeTwin/bed2.1.webp)"/>
            <section class="content">
            <h1>Deluxe Twin Room</h1>
            <p>nulla neque ligula laoreet turpis blandit imperdiet quam nulla tortor leo cras egestas </p>
            <a href="#">BOOK NOW</a>
            </section>
        </div>
        
        <div class="cardview">
            <img style="background-image:url(image/poolvilla/bed3.4.webp)"/>
            <section class="content">
            <h1>Pool Villa</h1>
            <p>donec mattis dui lorem vestibulum nec sodales tortor tortor ipsum erat viverra </p>
            <a href="#">BOOK NOW</a>
            </section>
        
        </section> -->
    <div style="height: 200px"></div>

    
    <section class="custom-properties-ftw">
        <h3 class="head-small head-centered">HYGEAS HOTEL</h3>
    </section>


    
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