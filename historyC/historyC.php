<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>HYGEAS_HOTEL</title>  <link rel="stylesheet" href="historyC.css">
  <link rel="icon" type="image/x-icon" href="../home/favicon.ico">

  <link href="https://fonts.googleapis.com/css?family=DM+Sans:400,500,700&display=swap" rel="stylesheet">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css'></link>
  <link rel="stylesheet"><script src="https://kit.fontawesome.com/c1134aa968.js" crossorigin="anonymous"></script>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'><link rel="stylesheet" href="./style.css">
  <link rel="stylesheet"><script src="https://kit.fontawesome.com/c1134aa968.js" crossorigin="anonymous"></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css'></link>
  <?php
    session_start();
    require('../connectToDatabase.php');
    $conn = new database();
    if(isset($_SESSION['reviewstatus'])){
        if($_SESSION['reviewstatus'] == 'pass'){
          $_SESSION['reviewstatus'] = "finish";
          echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>"';
          echo "<script>";
          echo "Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Thanks for Your Review',
              showConfirmButton: false,
              timer: 2000
            })";
          echo "</script>";
          
        }
    }

    if(isset($_SESSION['cancelday'])){
        if($_SESSION['cancelday'] == 'pass'){
            $_SESSION['reviewstatus'] = "finish";
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>"';
            echo "<script>";
            echo "Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Booking has been canceled.',
                showConfirmButton: false,
                timer: 3000
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
            </ul>
        </div>
    </div>
</nav>

<!-- partial:index.partial.html -->

<div id="popup2" class="overlay light">
	<a class="cancel" href="#"></a>
	<div class="popup">
		<h2>MY ACCOUNT</h2>
    <h5 class="title2"></h5>
		<div class="content">
        <a href="../account/account.php" class="profile">Profile</a>
        <a href="#" class="profile">MY Bookings</a>
        <a href="../logout.php" class="btn2">
          <span class="btn-inner">SIGN OUT</span>
        </a>
		</div>
	</div>
</div>



<div class="task-manager">
  <div class="page-content">
    <div class="header"><i class="fa-solid fa-calendar-check"></i>&nbsp;&nbsp;My Booking</div>
    <form>
        <div class="content-categories">
            <div class="label-wrapper">
                <input class="nav-item" name="nav" type="radio" id="opt-1" value="coming" onclick="hidedisplay(this.value)" >
                <label class="category" for="opt-1">UPCOMING</label>
            </div>
            <div class="label-wrapper">
                <input class="nav-item" name="nav" type="radio" id="opt-2" value="complie" onclick="hidedisplay(this.value)" checked>
                <label class="category" for="opt-2">COMPLETED</label>
            </div>
            <div class="label-wrapper">
                <input class="nav-item" name="nav" type="radio" id="opt-3" value="cancel" onclick="hidedisplay(this.value)">
                <label class="category" for="opt-3">CANCELLED</label>
            </div>
        </div>
    </form>




  <div id="coming" class="section">
    <?php
        $sql = "
                Select CAST(sDay AS DATE) AS SDay, CAST(OutDay AS DATE) AS OutDay, book.TypeRoom, book.Guests, book.Order, book.Pay, c.firstname, c.lastname, c.Sex, CAST(OutDay AS DATE)-CAST(sDay AS DATE) AS duration, NumCard
                From Booking book
                Join Customer c
                Using (Code_Cus)
                Where Code_Cus = ".$_SESSION['user_code']."
                ORDER BY book.Order;";

        $query = mysqli_query($conn->getDatabase(), $sql);
        $result = mysqli_query($conn->getDatabase(), $sql);
        $ObjResult = mysqli_fetch_array(mysqli_query($conn->getDatabase(), $sql));
        mysqli_close($conn->getDatabase());

        if(!empty($ObjResult)){
            
            $sday = $ObjResult['SDay'];
            $OutDay = $ObjResult['OutDay'];
            $guest = $ObjResult['Guests'];
            $pay = $ObjResult['Pay'];
            $roomtype = $ObjResult['TypeRoom'];
            $order = $ObjResult["Order"];

            while($row = mysqli_fetch_array($result)){
                if($row['TypeRoom'] == 'Deluxe Double Room'){         
                    echo '<div class="room-box">';
                    echo '<div class="card">
                            <div><img src="img/double.webp" alt="" class="review-logo"></div>
                            <span class="tag coming">Coming</span>
                            <section class="content">
                            <h4>HYGEAS&nbsp;HOTEL</h4>
                            <p>Deluxe&nbsp;Double&nbsp;Room</p>
                            <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row['Guests'].'&nbspGuests</p>                        
                            <p class="upcoming"></p>
                            
                            <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                            <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                            <div class="date-in">'.$row['SDay'].'</div>
                            <div class="date-out">'.$row['OutDay'].'</div>
                            <form action="#receipt'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                </div>
                            </form>
                            <form action="#cancelp'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="cancelbtn" value="Cancel Booking" name="" onclick="">
                                </div>
                            </form>
                            </section>
                        </div>
                    </div>';
                }
                
                else if($row['TypeRoom'] == 'Deluxe Twin Room'){
                    echo '<div class="room-box">
                            <div class="card">
                                <div><img src="img/twin.webp" alt="" class="review-logo"></div>
                                <span class="tag coming">Coming</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>Deluxe&nbsp;Twin&nbsp;Room</p>
                                <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row['Guests'].'&nbspGuests</p>                        
                                <p class="upcoming"></p>
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row['SDay'].'</div>
                                <div class="date-out">'.$row['OutDay'].'</div>
                                <form action="#receipt'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                </div>
                                </form>
                                <form action="#cancelp'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="cancelbtn" value="Cancel Booking" name="" onclick="">
                                </div>
                                </form>
                                </section>
                            </div>
                        </div>';
                }
                else if($row['TypeRoom'] == 'Pool villa'){
                    echo '<div class="room-box">
                            <div class="card">
                                <div><img src="img/villa.webp" alt="" class="review-logo"></div>
                                <span class="tag coming">Coming</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>Pool Villa</p>
                                <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row['Guests'].'&nbspGuests</p>                        
                                <p class="upcoming"></p>
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row['SDay'].'</div>
                                <div class="date-out">'.$row['OutDay'].'</div>
                                <form action="#receipt'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                </div>
                                </form>
                                <form action="#cancelp'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="cancelbtn" value="Cancel Booking" name="" onclick="">
                                </div>
                                </form>
                                </section>
                            </div>
                        </div>';
                }
                else if($row['TypeRoom'] == 'Seminar'){
                    echo '<div class="room-box">
                            <div class="card">
                                <div><img src="img/seminar.jpg" alt="" class="review-logo"></div>
                                <span class="tag coming">Coming</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>Seminar&nbsp;Room</p>
                                <p><i class="fa-solid fa-hotel" style="color: #000000;"></i></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row['Guests'].'&nbspGuests</p>                        
                                <p class="upcoming"></p>         
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row['SDay'].'</div>
                                <div class="date-out">'.$row['OutDay'].'</div>
                                <form action="#receipt'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                </div>
                                </form>
                                <form action="#cancelp'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="cancelbtn" value="Cancel Booking" name="" onclick="">
                                </div>
                                </form>
                                </section>
                            </div>
                        </div>';
                }
                else if($row['TypeRoom'] == 'Ballroom'){
                    echo '<div class="room-box">
                            <div class="card">
                                <div><img src="img/ballroom.png" alt="" class="review-logo"></div>
                                <span class="tag coming">Coming</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>BallRoom</p>
                                <p><i class="fa-solid fa-hotel" style="color: #000000;"></i></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row['Guests'].'&nbspGuests</p>                        
                                <p class="upcoming"></p>         
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row['SDay'].'</div>
                                <div class="date-out">'.$row['OutDay'].'</div>
                                <form action="#receipt'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                </div>
                                </form>
            
                                <form action="#cancelp'.$row['Order'].'">
                                <div class="input-field">
                                    <input type="submit" class="cancelbtn" value="Cancel Booking" name="" onclick="">
                                </div>
                                </form>
                                </section>
                            </div>
                        </div>';
                }

            echo '<div class="receipt">
                    <div id="receipt'.$row['Order'].'" class="overlay3">
                        <div class="receiptpopup">
                            <a class="close" href="#">&times;</a>
                            <div class="row content">
                                <div>
                                    <a class="check"><i class="fa-solid fa-circle-check"></i></a>
                                    <h3>The booking has been confirmed.</h3>
                                <div>
                                    <img src="img/logo.png" alt="" class="receipt-logo">
                                </div>
                            <div class="dear">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HYGEAS HOTEL</div>';
                    if($row['SEX'] = "male"){
                        echo '<p>Dear Mr. '.$row["firstname"].' '.$row["lastname"].', the booking number is '.$row["Order"].'. If you have any questions. Regarding accommodation, please contact the accommodation directly. Tel.025623711</p>';
                        }
                    else{
                        echo '<p>Dear Ms. '.$row["firstname"].' '.$row["lastname"].', the booking number is '.$row["Order"].'. If you have any questions. Regarding accommodation, please contact the accommodation directly. Tel.025623711</p>';
                        }
                        echo '<h4>Booking details</h4>';
                        echo '<div class="receipt-header">';
                        echo '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<thead>';
                        echo      '<tr>';
                        echo        '<th class="rec-text-h">check-in</th>';
                        echo        '<th class="rec-text-h">check-out</th>';
                        echo      '</tr>';
                        echo    '</thead>';
                        echo  '</table>';
                        echo'</div>';
                        echo'<div class="receipt-content">';
                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<tbody>';
                        echo      '<tr>';
                        echo        '<td class="rec-text-c">'.$row["SDay"].' (After 14.00 pm.)</td>';
                        echo        '<td class="rec-text-c">'.$row["OutDay"].' (Before 12.00 pm.)</td>';
                        echo      '</tr>';
                        echo    '</tbody>';
                        echo  '</table>';
                        echo'</div>';

                        echo'<div class="receipt-header">';
                        echo  '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<thead>';
                        echo      '<tr>';
                        echo        '<th class="rec-text-h">Duration</th>';
                        echo        '<th class="rec-text-h">Room type</th>';
                        echo        '<th class="rec-text-h">Guest name</th>';
                        echo        '<th class="rec-text-h">guests</th>';
                        echo        '<th class="rec-text-h">Extension</th>';
                        echo      '</tr>';
                        echo    '</thead>';
                        echo  '</table>';
                        echo'</div>';
                        echo'<div class="receipt-content">';
                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<tbody>';
                        echo      '<tr>';
                        echo        '<td class="rec-text-c">1 room, '.$row["duration"].' night</td>';
                        echo        '<td class="rec-text-c">'.$row["TypeRoom"].'</td>';
                        echo        '<td class="rec-text-c">'.$row["firstname"].' '.$row["lastname"].'</td>';
                        echo        '<td class="rec-text-c">'.$row["Guests"].'</td>';
                        echo        '<td class="rec-text-c">-</td>';
                        echo      '</tr>';
                        echo    '</tbody>';
                        echo  '</table>';
                        echo'</div>';

                        echo'<h4>Confirmed payment</h4>';
                        echo'<div class="receipt-header">';
                        echo  '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<thead>';
                        echo      '<tr>';
                        echo        '<th class="rec-text-h">Duration of stay</th>';
                        echo        '<th class="rec-text-h">PRICE (THB)</th>';
                        echo      '</tr>';
                        echo    '</thead>';
                        echo  '</table>';
                        echo'</div>';
                        echo'<div class="receipt-content">';
                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<tbody>';
                        echo      '<tr>';
                        echo        '<td class="rec-text-c">1 room, '.$row["duration"].' night</td>';
                        echo        '<td class="rec-text-c">'.$row["Pay"].'</td>';
                        echo      '</tr>';
                        echo    '</tbody>';
                        echo  '</table>';
                        echo'</div>';
                        echo'<div><br><i class="fa-solid fa-credit-card"></i>&nbsp;Pay by CREDIT/DEBIT CARD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;xxx-xxx-xxxx-'.$row['NumCard'].'</div>';
                    echo     '</div>
                        </div>
                        </div>
                    </div>
                    </div>';


                    echo '<div class="cancelpage">
                            <div id="cancelp'.$row['Order'].'" class="overlay4">
                                <div class="cancelpop">
                                <a class="close" href="#">&times;</a>
                                <div class="row content">
                                    <!-- description -->
                                    <div>
                                    <a class="xmark"><i class="fa-solid fa-circle-xmark"></i></a>
                                    <h3 class="h3">Cancel reservation</h3>
                                    <div>
                                        <img src="img/logo.png" alt="" class="cancel-logo">
                                    </div>
                                    <div class="dear">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HYGEAS HOTEL</div>';
                                        if($row['SEX'] = "male"){
                                        echo '<p>For Mr. '.$row["firstname"].' '.$row["lastname"].' who wants to cancel your room reservation at Hyeas Hotel, the booking number is '.$row["Order"].'. Please read the terms and conditions before confirming. If you have any questions. Regarding accommodation, please contact the accommodation directly. Tel.025623711</p>';
                                        }
                                        else{
                                        echo '<p>For Ms. '.$row["firstname"].' '.$row["lastname"].' who wants to cancel your room reservation at Hyeas Hotel, the booking number is '.$row["Order"].'. Please read the terms and conditions before confirming. If you have any questions. Regarding accommodation, please contact the accommodation directly. Tel.025623711</p>';
                                        }
                                        echo '<a class="warn"><i class="fa-solid fa-circle-exclamation"></i>&nbsp;Cancellation of this booking will not be refunded.</a>';
                        
                                        echo '<h4>Booking details</h4>';
                                        echo '<div class="receipt-header">';
                                        echo '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                                        echo    '<thead>';
                                        echo      '<tr>';
                                        echo        '<th class="rec-text-h">check-in</th>';
                                        echo        '<th class="rec-text-h">check-out</th>';
                                        echo      '</tr>';
                                        echo    '</thead>';
                                        echo  '</table>';
                                        echo'</div>';
                                        echo'<div class="receipt-content">';
                                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                                        echo    '<tbody>';
                                        echo      '<tr>';
                                        echo        '<td class="rec-text-c">'.$row["SDay"].' (After 14.00 pm.)</td>';
                                        echo        '<td class="rec-text-c">'.$row["OutDay"].' (Before 12.00 pm.)</td>';
                                        echo      '</tr>';
                                        echo    '</tbody>';
                                        echo  '</table>';
                                        echo'</div>';
                        
                                        echo'<div class="receipt-header">';
                                        echo  '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                                        echo    '<thead>';
                                        echo      '<tr>';
                                        echo        '<th class="rec-text-h">Duration</th>';
                                        echo        '<th class="rec-text-h">Room type</th>';
                                        echo        '<th class="rec-text-h">Guest name</th>';
                                        echo        '<th class="rec-text-h">guests</th>';
                                        echo        '<th class="rec-text-h">Extension</th>';
                                        echo      '</tr>';
                                        echo    '</thead>';
                                        echo  '</table>';
                                        echo'</div>';
                                        echo'<div class="receipt-content">';
                                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                                        echo    '<tbody>';
                                        echo      '<tr>';
                                        echo        '<td class="rec-text-c">1 room, '.$row["duration"].' night</td>';
                                        echo        '<td class="rec-text-c">'.$row["TypeRoom"].'</td>';
                                        echo        '<td class="rec-text-c">'.$row["firstname"].' '.$row["lastname"].'</td>';
                                        echo        '<td class="rec-text-c">'.$row["Guests"].'</td>';
                                      
                                        echo        '<td class="rec-text-c">-</td>';
                                        echo      '</tr>';
                                        echo    '</tbody>';
                                        echo  '</table>';
                                        echo'</div>';
                        
                                        echo'<h4>Payment details</h4>';
                                        echo'<div class="receipt-header">';
                                        echo  '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                                        echo    '<thead>';
                                        echo      '<tr>';
                                        echo        '<th class="rec-text-h">Duration of stay</th>';
                                        echo        '<th class="rec-text-h">PRICE (THB)</th>';
                                        echo        '<th class="rec-text-h">REFUND (THB)</th>';
                                        echo      '</tr>';
                                        echo    '</thead>';
                                        echo  '</table>';
                                        echo'</div>';
                                        echo'<div class="receipt-content">';
                                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                                        echo    '<tbody>';
                                        echo      '<tr>';
                                        echo        '<td class="rec-text-c">1 room, '.$row["duration"].' night</td>';
                                        echo        '<td class="rec-text-c">'.$row["Pay"].'</td>';
                                        echo        '<td class="rec-text-c">0.00</td>';
                                        echo      '</tr>';
                                        echo    '</tbody>';
                                        echo  '</table>';
                                        echo'</div>';
                                        echo'<div><br><i class="fa-solid fa-credit-card"></i>&nbsp;Pay by CREDIT/DEBIT CARD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;xxx-xxx-xxxx-'.$row["NumCard"].'</div>';
                                        echo'<form action="cancel.php" method="post">
                                            <div class="input-field">
                                                <button value="'.$row['Order'].'"  name="cancel_booking" type="submit" class="submitcancel">Confirm cancellation</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';


                }
        }

    ?>
</div>


<div id="complie" class="section">
    <?php
        $conn2 = new database();
        $sql2 = "
                SELECT CAST(h.CheckIn AS DATE) AS CheckIn , CAST(h.CheckOut AS DATE) AS CheckOut , h.Guests, r.TypeRoom, c.firstname, c.lastname, c.sex, b.amount, b.additional, h.History_Num
                       , CAST(h.CheckOut AS DATE)-CAST(h.CheckIn AS DATE) AS duration, Review_Status, b.NumCard
                FROM History h
                JOIN RoomOwn r
                USING (Code_Room)

                JOIN Bill b
                USING (History_Num)

                JOIN Customer c
                USING (Code_Cus)

                WHERE Code_Cus = '".$_SESSION['user_code']."';
            ";

        
        $ObjResult2 = mysqli_fetch_array(mysqli_query($conn2->getDatabase(), $sql2));
        $result2 = mysqli_query($conn2->getDatabase(), $sql2);

        mysqli_close($conn2->getDatabase());

        if(!empty($ObjResult2)){
            while($row2 = mysqli_fetch_array($result2)){
                if($row2['TypeRoom'] == 'Deluxe Double Room'){
                    
                    echo '<div class="room-box">';
                    echo '<div class="card">
                            <div><img src="img/double.webp" alt="" class="review-logo"></div>
                            <span class="tag comple">Completed</span>
                            <section class="content">
                            <h4>HYGEAS&nbsp;HOTEL</h4>
                            <p>Deluxe&nbsp;Double&nbsp;Room</p>
                            <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row2['Guests'].'&nbspGuests</p>                                     
                            <p class="upcoming"></p>         
                            <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                            <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                            <div class="date-in">'.$row2['CheckIn'].'</div>
                            <div class="date-out">'.$row2['CheckOut'].'</div>
                            <form action="#receiptc'.$row2['History_Num'].'">
                                <div class="input-field">
                                    <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                </div>
                            </form>';
                            if($row2['Review_Status'] == 0){
                                echo   '<form action="#reviewpup'.$row2['History_Num'].'">
                                            <div class="input-field">
                                                <input type="submit" class="review" value="REVIEW" name="" onclick="">
                                            </div>
                                        </form>';
                                }
                            echo '</section>
                                </div>
                            </div>';
                }
                
                else if($row2['TypeRoom'] == 'Deluxe Twin Room'){
                    echo '<div class="room-box">
                            <div class="card">
                                <div><img src="img/twin.webp" alt="" class="review-logo"></div>
                                <span class="tag comple">Completed</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>Deluxe&nbsp;Twin&nbsp;Room</p>
                                <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row2['Guests'].'&nbspGuests</p>                                            
                                <p class="upcoming"></p>
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row2['CheckIn'].'</div>
                                <div class="date-out">'.$row2['CheckOut'].'</div>
                                <div class="input-field">
                                <form action="#receiptc'.$row2['History_Num'].'">
                                    <div class="input-field">
                                        <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                    </div>
                                </form>';
                            if($row2['Review_Status'] == 0){
                                echo   '<form action="#reviewpup'.$row2['History_Num'].'">
                                            <div class="input-field">
                                                <input type="submit" class="review" value="REVIEW" name="" onclick="">
                                            </div>
                                        </form>';
                                }
                            echo '</section>
                                </div>
                            </div>';
                }
                else if($row2['TypeRoom'] == 'Pool villa'){
                    echo '<div class="room-box">
                            <div class="card">
                                <div><img src="img/villa.webp" alt="" class="review-logo"></div>
                                <span class="tag comple">Completed</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>Pool Villa</p>
                                <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row2['Guests'].'&nbspGuests</p>                                             
                                <p class="upcoming"></p>
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row2['CheckIn'].'</div>
                                <div class="date-out">'.$row2['CheckOut'].'</div>
                                <form action="#receiptc'.$row2['History_Num'].'">
                                    <div class="input-field">
                                        <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                    </div>
                                </form>';
                            if($row2['Review_Status'] == 0){
                                echo   '<form action="#reviewpup'.$row2['History_Num'].'">
                                            <div class="input-field">
                                                <input type="submit" class="review" value="REVIEW" name="" onclick="">
                                            </div>
                                        </form>';
                                }
                            echo '</section>
                                </div>
                            </div>';
                }
                else if($row2['TypeRoom'] == 'Seminar'){
                    echo '<div class="room-box">
                            <div class="card">
                                <div><img src="img/seminar.jpg" alt="" class="review-logo"></div>
                                <span class="tag comple">Completed</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>Seminar&nbsp;Room</p>
                                <p><i class="fa-solid fa-hotel" style="color: #000000;"></i></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row2['Guests'].'&nbspGuests</p>                        
                                <p class="upcoming"></p>
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row2['CheckIn'].'</div>
                                <div class="date-out">'.$row2['CheckOut'].'</div>
                                <form action="#receiptc'.$row2['History_Num'].'">
                                <div class="input-field">
                                    <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                </div>
                                </form>';
                                if($row2['Review_Status'] == 0){
                                    echo   '<form action="#reviewpup'.$row2['History_Num'].'">
                                                <div class="input-field">
                                                    <input type="submit" class="review" value="REVIEW" name="" onclick="">
                                                </div>
                                            </form>';
                                    }
                                echo '</section>
                                    </div>
                                </div>';
                }
                else if($row2['TypeRoom'] == 'Ballroom'){
                    echo '<div class="room-box">
                            <div class="card">
                                <div><img src="img/ballroom.png" alt="" class="review-logo"></div>
                                <span class="tag comple">Completed</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>BallRoom</p>
                                <p><i class="fa-solid fa-hotel" style="color: #000000;"></i></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row2['Guests'].'&nbspGuests</p>                        
                                <p class="upcoming"></p>
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row2['CheckIn'].'</div>
                                <div class="date-out">'.$row2['CheckOut'].'</div>
                                <form action="#receiptc'.$row2['History_Num'].'">
                                <div class="input-field">
                                    <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                </div>
                                </form>';
                                if($row2['Review_Status'] == 0){
                                    echo   '<form action="#reviewpup'.$row2['History_Num'].'">
                                                <div class="input-field">
                                                    <input type="submit" class="review" value="REVIEW" name="" onclick="">
                                                </div>
                                            </form>';
                                    }
                                echo '</section>
                                    </div>
                                </div>';
                }


                echo '<div class="receipt">
                    <div id="receiptc'.$row2['History_Num'].'" class="overlay3">
                        <div class="receiptpopup">
                            <a class="close" href="#">&times;</a>
                            <div class="row content">
                                <div>
                                    <a class="check"><i class="fa-solid fa-circle-check"></i></a>
                                    <h3>The booking has been confirmed.</h3>
                                <div>
                                    <img src="img/logo.png" alt="" class="receipt-logo">
                                </div>
                            <div class="dear">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HYGEAS HOTEL</div>';
                    if($row2['sex'] = "male"){
                        echo '<p>Dear Mr. '.$row2["firstname"].' '.$row2["lastname"].', the booking number is '.$row2["History_Num"].'. If you have any questions. Regarding accommodation, please contact the accommodation directly. Tel.025623711</p>';
                        }
                    else{
                        echo '<p>Dear Ms. '.$row2["firstname"].' '.$row2["lastname"].', the booking number is '.$row2["History_Num"].'. If you have any questions. Regarding accommodation, please contact the accommodation directly. Tel.025623711</p>';
                        }
                        echo '<h4>Booking details</h4>';
                        echo '<div class="receipt-header">';
                        echo '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<thead>';
                        echo      '<tr>';
                        echo        '<th class="rec-text-h">check-in</th>';
                        echo        '<th class="rec-text-h">check-out</th>';
                        echo      '</tr>';
                        echo    '</thead>';
                        echo  '</table>';
                        echo'</div>';
                        echo'<div class="receipt-content">';
                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<tbody>';
                        echo      '<tr>';
                        // $date_in = date_format($row["sDay"], "Y-m-d");
                        echo        '<td class="rec-text-c">'.$row2["CheckIn"].' (After 14.00 pm.)</td>';
                        echo        '<td class="rec-text-c">'.$row2["CheckOut"].' (Before 12.00 pm.)</td>';
                        echo      '</tr>';
                        echo    '</tbody>';
                        echo  '</table>';
                        echo'</div>';

                        echo'<div class="receipt-header">';
                        echo  '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<thead>';
                        echo      '<tr>';
                        echo        '<th class="rec-text-h">Duration</th>';
                        echo        '<th class="rec-text-h">Room type</th>';
                        echo        '<th class="rec-text-h">Guest name</th>';
                        echo        '<th class="rec-text-h">guests</th>';
                        echo        '<th class="rec-text-h">Extension</th>';
                        echo      '</tr>';
                        echo    '</thead>';
                        echo  '</table>';
                        echo'</div>';
                        echo'<div class="receipt-content">';
                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<tbody>';
                        echo      '<tr>';
                        echo        '<td class="rec-text-c">1 room, '.$row2["duration"].' night</td>';
                        echo        '<td class="rec-text-c">'.$row2["TypeRoom"].'</td>';
                        echo        '<td class="rec-text-c">'.$row2["firstname"].' '.$row2["lastname"].'</td>';
                        echo        '<td class="rec-text-c">'.$row2["Guests"].'</td>';
                        echo        '<td class="rec-text-c">'.$row2["additional"].'</td>';
                        echo      '</tr>';
                        echo    '</tbody>';
                        echo  '</table>';
                        echo'</div>';

                        echo'<h4>Confirmed payment</h4>';
                        echo'<div class="receipt-header">';
                        echo  '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<thead>';
                        echo      '<tr>';
                        echo        '<th class="rec-text-h">Duration of stay</th>';
                        echo        '<th class="rec-text-h">PRICE (THB)</th>';
                        echo      '</tr>';
                        echo    '</thead>';
                        echo  '</table>';
                        echo'</div>';
                        echo'<div class="receipt-content">';
                        echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                        echo    '<tbody>';
                        echo      '<tr>';
                        echo        '<td class="rec-text-c">1 room, '.$row2["duration"].' night</td>';
                        echo        '<td class="rec-text-c">'.$row2["amount"].'</td>';
                        echo      '</tr>';
                        echo    '</tbody>';
                        echo  '</table>';
                        echo'</div>';
                        echo'<div><br><i class="fa-solid fa-credit-card"></i>&nbsp;Pay by CREDIT/DEBIT CARD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;xxx-xxx-xxxx-'.$row2['NumCard'].'</div>';
                    echo     '</div>
                        </div>
                        </div>
                    </div>
                </div>';



                // review
            echo '<div class="reviewpage">
                    <form action="reviewDB.php" method="post">
                        <div id="reviewpup'.$row2['History_Num'].'" class="overlay2">

                            <div class="popupreview">
                                <a class="close" href="#">&times;</a>
                                <div class="row content">
                                <!-- description -->
                                <div>
                                    <div><img src="img/logo.png" alt="" class="review-logor"></div>
                                    <div><h3>HYGEAS HOTEL</h3></div>
                        
                                    <!-- รายละเอียด  -->
                                    <h4>Thank you for the review</h4>                                <div class="review-i1"><i class="fa-solid fa-map-location-dot"></i></div>
                                    <div class="star-t1"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location</div>
                                    <div class="cont1">
                                    <div class="stars">
                    
                                        <input class="star star-5" id="star-5-1'.$row2['History_Num'].'" type="radio" name="star-Location" value="5"/>
                                        <label class="star star-5" for="star-5-1'.$row2['History_Num'].'"></label>
                                        <input class="star star-4" id="star-4-1'.$row2['History_Num'].'" type="radio" name="star-Location" value="4"/>
                                        <label class="star star-4" for="star-4-1'.$row2['History_Num'].'"></label>
                                        <input class="star star-3" id="star-3-1'.$row2['History_Num'].'" type="radio" name="star-Location" value="3"/>
                                        <label class="star star-3" for="star-3-1'.$row2['History_Num'].'"></label>
                                        <input class="star star-2" id="star-2-1'.$row2['History_Num'].'" type="radio" name="star-Location" value="2"/>
                                        <label class="star star-2" for="star-2-1'.$row2['History_Num'].'"></label>
                                        <input class="star star-1" id="star-1-1'.$row2['History_Num'].'" type="radio" name="star-Location" value="1"/>
                                        <label class="star star-1" for="star-1-1'.$row2['History_Num'].'"></label>
                                    </div>
                                    </div>
                        
                                    <div class="review-i2"><i class="fa-solid fa-broom"></i></div>
                                    <div class="star-t2"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cleanliness</div>
                                    <div class="cont2">
                                    <div class="stars">
                                        <input class="star star-5" id="star-5-2'.$row2['History_Num'].'" type="radio" name="star-Clean" value="5"/>
                                        <label class="star star-5" for="star-5-2'.$row2['History_Num'].'"></label>
                                        <input class="star star-4" id="star-4-2'.$row2['History_Num'].'" type="radio" name="star-Clean" value="4"/>
                                        <label class="star star-4" for="star-4-2'.$row2['History_Num'].'"></label>
                                        <input class="star star-3" id="star-3-2'.$row2['History_Num'].'" type="radio" name="star-Clean" value="3"/>
                                        <label class="star star-3" for="star-3-2'.$row2['History_Num'].'"></label>
                                        <input class="star star-2" id="star-2-2'.$row2['History_Num'].'" type="radio" name="star-Clean" value="2"/>
                                        <label class="star star-2" for="star-2-2'.$row2['History_Num'].'"></label>
                                        <input class="star star-1" id="star-1-2'.$row2['History_Num'].'" type="radio" name="star-Clean" value="1"/>
                                        <label class="star star-1" for="star-1-2'.$row2['History_Num'].'"></label>
                                    </div>
                                    </div>
                        
                                    <div class="review-i3"><i class="fa-solid fa-bell-concierge"></i></div>
                                    <div class="star-t3"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service</div>
                                    <div class="cont2">
                                    <div class="stars3">
                                        <input class="star star-5" id="star-5-3'.$row2['History_Num'].'" type="radio" name="star-Service" value="5"/>
                                        <label class="star star-5" for="star-5-3'.$row2['History_Num'].'"></label>
                                        <input class="star star-4" id="star-4-3'.$row2['History_Num'].'" type="radio" name="star-Service" value="4"/>
                                        <label class="star star-4" for="star-4-3'.$row2['History_Num'].'"></label>
                                        <input class="star star-3" id="star-3-3'.$row2['History_Num'].'" type="radio" name="star-Service" value="3"/>
                                        <label class="star star-3" for="star-3-3'.$row2['History_Num'].'"></label>
                                        <input class="star star-2" id="star-2-3'.$row2['History_Num'].'" type="radio" name="star-Service" value="2"/>
                                        <label class="star star-2" for="star-2-3'.$row2['History_Num'].'"></label>
                                        <input class="star star-1" id="star-1-3'.$row2['History_Num'].'" type="radio" name="star-Service" value="1"/>
                                        <label class="star star-1" for="star-1-3'.$row2['History_Num'].'"></label>
                                    </div>
                                    </div>
                        
                                    <div class="review-i4"><i class="fa-solid fa-tv"></i></div>
                                    <div class="star-t4"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Facilities</div>
                                    <div class="cont2">
                                    <div class="stars4">
                                        <input class="star star-5" id="star-5-4'.$row2['History_Num'].'" type="radio" name="star-Facilities" value="5"/>
                                        <label class="star star-5" for="star-5-4'.$row2['History_Num'].'"></label>
                                        <input class="star star-4" id="star-4-4'.$row2['History_Num'].'" type="radio" name="star-Facilities" value="4"/>
                                        <label class="star star-4" for="star-4-4'.$row2['History_Num'].'"></label>
                                        <input class="star star-3" id="star-3-4'.$row2['History_Num'].'" type="radio" name="star-Facilities" value="3"/>
                                        <label class="star star-3" for="star-3-4'.$row2['History_Num'].'"></label>
                                        <input class="star star-2" id="star-2-4'.$row2['History_Num'].'" type="radio" name="star-Facilities" value="2"/>
                                        <label class="star star-2" for="star-2-4'.$row2['History_Num'].'"></label>
                                        <input class="star star-1" id="star-1-4'.$row2['History_Num'].'" type="radio" name="star-Facilities" value="1"/>
                                        <label class="star star-1" for="star-1-4'.$row2['History_Num'].'"></label>
                                    </div>
                                    </div>
                        
                                    <h4>Commend</h4>
                                    <div>
                                        <textarea type="text" class="commend" col="10" name="commend" value="commend"></textarea>
                                    <div class="input-field">
                                        <button value="'.$row2['History_Num'].'"  name="his_num" type="submit" class="submitreview">Review</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>';




            }
        }
    ?>
</div>


<div id="cancel" class="section">
    <?php
            $conn3 = new database();
            $sql3 = "
                    Select CAST(sDay AS DATE) AS SDay, CAST(OutDay AS DATE) AS OutDay, TypeRoom, Guests, amount, c.firstname, c.lastname, c.Sex, CAST(OutDay AS DATE)-CAST(sDay AS DATE) AS duration, numC
                    From Cancel 
                    Join Customer c
                    Using (Code_Cus)
                    Where Code_Cus = ".$_SESSION['user_code']."
                    ORDER BY numC;";

            $result3 = mysqli_query($conn3->getDatabase(), $sql3);
            $ObjResult3 = mysqli_fetch_array(mysqli_query($conn3->getDatabase(), $sql3));
            mysqli_close($conn3->getDatabase());

            if(!empty($ObjResult3)){
                while($row3 = mysqli_fetch_array($result3)){
                    if($row3['TypeRoom'] == 'Deluxe Double Room'){         
                        echo '<div class="room-box">';
                        echo '<div class="card">
                                <div><img src="img/double.webp" alt="" class="review-logo"></div>
                                <span class="tag cancel">Cancelled</span>
                                <section class="content">
                                <h4>HYGEAS&nbsp;HOTEL</h4>
                                <p>Deluxe&nbsp;Double&nbsp;Room</p>
                                <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row3['Guests'].'&nbspGuests</p>                        
                                <p class="upcoming"></p>
                                
                                <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                <div class="date-in">'.$row3['SDay'].'</div>
                                <div class="date-out">'.$row3['OutDay'].'</div>
                                <form action="#receipt'.$row3['numC'].'">
                                    <div class="input-field">
                                        <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                    </div>
                                </form>
                                </section>
                            </div>
                         </div>';
                    }
                    
                    else if($row3['TypeRoom'] == 'Deluxe Twin Room'){
                        echo '<div class="room-box">
                                <div class="card">
                                    <div><img src="img/twin.webp" alt="" class="review-logo"></div>
                                    <span class="tag cancel">Cancelled</span>
                                    <section class="content">
                                    <h4>HYGEAS&nbsp;HOTEL</h4>
                                    <p>Deluxe&nbsp;Twin&nbsp;Room</p>
                                    <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row3['Guests'].'&nbspGuests</p>                        
                                    <p class="upcoming"></p>
                                    <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                    <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                    <div class="date-in">'.$row3['SDay'].'</div>
                                    <div class="date-out">'.$row3['OutDay'].'</div>
                                    <form action="#receipt'.$row3['numC'].'">
                                    <div class="input-field">
                                        <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                    </div>
                                    </form>
                                    </section>
                                </div>
                            </div>';
                    }
                    else if($row3['TypeRoom'] == 'Pool villa'){
                        echo '<div class="room-box">
                                <div class="card">
                                    <div><img src="img/villa.webp" alt="" class="review-logo"></div>
                                    <span class="tag cancel">Cancelled</span>
                                    <section class="content">
                                    <h4>HYGEAS&nbsp;HOTEL</h4>
                                    <p>Pool Villa</p>
                                    <p><i class="fa-solid fa-bed" style="color: #000000;"></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row3['Guests'].'&nbspGuests</p>                        
                                    <p class="upcoming"></p>
                                    <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                    <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                    <div class="date-in">'.$row3['SDay'].'</div>
                                    <div class="date-out">'.$row3['OutDay'].'</div>

                                    <form action="#receipt'.$row3['numC'].'">
                                    <div class="input-field">
                                        <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                    </div>
                                    </form>
                                    </section>
                                </div>
                            </div>';
                    }
                    else if($row3['TypeRoom'] == 'Seminar'){
                        echo '<div class="room-box">
                                <div class="card">
                                    <div><img src="img/seminar.jpg" alt="" class="review-logo"></div>
                                    <span class="tag cancel">Cancelled</span>
                                    <section class="content">
                                    <h4>HYGEAS&nbsp;HOTEL</h4>
                                    <p>Seminar&nbsp;Room</p>
                                    <p><i class="fa-solid fa-hotel" style="color: #000000;"></i></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row3['Guests'].'&nbspGuests</p>                        
                                    <p class="upcoming"></p>
                                    <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                    <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                    <div class="date-in">'.$row3['SDay'].'</div>
                                    <div class="date-out">'.$row3['OutDay'].'</div>
                                    <form action="#receipt'.$row3['numC'].'">
                                    <div class="input-field">
                                        <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                    </div>
                                    </form>
                                    </section>
                                </div>
                            </div>';
                    }
                    else if($row3['TypeRoom'] == 'Ballroom'){
                        echo '<div class="room-box">
                                <div class="card">
                                    <div><img src="img/ballroom.png" alt="" class="review-logo"></div>
                                    <span class="tag cancel">Cancelled</span>
                                    <section class="content">
                                    <h4>HYGEAS&nbsp;HOTEL</h4>
                                    <p>BallRoom</p>
                                    <p><i class="fa-solid fa-hotel" style="color: #000000;"></i></i>&nbsp;1&nbsp;Room&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-solid fa-person" style="color: #000000;"></i><i class="fa-solid fa-person-dress" style="color: #000000;"></i>&nbsp&nbsp'.$row3['Guests'].'&nbspGuests</p>                        
                                    <div class="checkin"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-in</div>
                                    <div class="checkout"><i class="fa-solid fa-calendar-week"></i>&nbsp;Check-out</div>
                                    <div class="date-in">'.$row3['SDay'].'</div>
                                    <div class="date-out">'.$row3['OutDay'].'</div>

                                    <form action="#receipt'.$row3['numC'].'">
                                    <div class="input-field">
                                        <input type="submit" class="receiptbtn" value="RECEIPT" name="" onclick="">
                                    </div>
                                    </form>
                                    </section>
                                </div>
                            </div>';
                    }

                    echo '<div class="receipt">
                            <div id="receipt'.$row3['numC'].'" class="overlay3">
                                <div class="cancelpopup">
                                    <a class="close" href="#">&times;</a>
                                    <div class="row content">
                                    <div>
                                        <a class="xmark"><i class="fa-solid fa-circle-xmark"></i></a>                    
                                        <h3>The booking has been Canceled.</h3>
                                    <div>
                                        <img src="img/logo.png" alt="" class="receipt-logo">
                                    </div>
                                <div class="dear">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HYGEAS HOTEL</div>';
                        if($row3['SEX'] = "male"){
                            echo '<p>Dear Mr. '.$row3["firstname"].' '.$row3["lastname"].', the booking number is '.$row3["numC"].'. If you have any questions. Regarding accommodation, please contact the accommodation directly. Tel.025623711</p>';
                            }
                        else{
                            echo '<p>Dear Ms. '.$row3["firstname"].' '.$row3["lastname"].', the booking number is '.$row3["numC"].'. If you have any questions. Regarding accommodation, please contact the accommodation directly. Tel.025623711</p>';
                            }
                            echo '<h4>Booking details</h4>';
                            echo '<div class="receipt-header">';
                            echo '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                            echo    '<thead>';
                            echo      '<tr>';
                            echo        '<th class="rec-text-h">check-in</th>';
                            echo        '<th class="rec-text-h">check-out</th>';
                            echo      '</tr>';
                            echo    '</thead>';
                            echo  '</table>';
                            echo'</div>';
                            echo'<div class="receipt-content">';
                            echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                            echo    '<tbody>';
                            echo      '<tr>';
                            // $date_in = date_format($row["sDay"], "Y-m-d");
                            echo        '<td class="rec-text-c">'.$row3["SDay"].' (After 14.00 pm.)</td>';
                            echo        '<td class="rec-text-c">'.$row3["OutDay"].' (Before 12.00 pm.)</td>';
                            echo      '</tr>';
                            echo    '</tbody>';
                            echo  '</table>';
                            echo'</div>';

                            echo'<div class="receipt-header">';
                            echo  '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                            echo    '<thead>';
                            echo      '<tr>';
                            echo        '<th class="rec-text-h">Duration</th>';
                            echo        '<th class="rec-text-h">Room type</th>';
                            echo        '<th class="rec-text-h">Guest name</th>';
                            echo        '<th class="rec-text-h">guests</th>';
                            echo        '<th class="rec-text-h">Extension</th>';
                            echo      '</tr>';
                            echo    '</thead>';
                            echo  '</table>';
                            echo'</div>';
                            echo'<div class="receipt-content">';
                            echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                            echo    '<tbody>';
                            echo      '<tr>';
                            echo        '<td class="rec-text-c">1 room, '.$row3["duration"].' night</td>';
                            echo        '<td class="rec-text-c">'.$row3["TypeRoom"].'</td>';
                            echo        '<td class="rec-text-c">'.$row3["firstname"].' '.$row3["lastname"].'</td>';
                            echo        '<td class="rec-text-c">'.$row3["Guests"].'</td>';
                            echo        '<td class="rec-text-c">-</td>';
                            echo      '</tr>';
                            echo    '</tbody>';
                            echo  '</table>';
                            echo'</div>';

                            echo'<h4>Confirmed payment</h4>';
                            echo'<div class="receipt-header">';
                            echo  '<table class="tb-head" cellpadding="0" cellspacing="0" border="0">';
                            echo    '<thead>';
                            echo      '<tr>';
                            echo        '<th class="rec-text-h">Duration of stay</th>';
                            echo        '<th class="rec-text-h">PRICE (THB)</th>';
                            echo      '</tr>';
                            echo    '</thead>';
                            echo  '</table>';
                            echo'</div>';
                            echo'<div class="receipt-content">';
                            echo  '<table class="tb-content" cellpadding="0" cellspacing="0" border="0">';
                            echo    '<tbody>';
                            echo      '<tr>';
                            echo        '<td class="rec-text-c">1 room, '.$row3["duration"].' night</td>';
                            echo        '<td class="rec-text-c">'.$row3["amount"].'</td>';
                            echo      '</tr>';
                            echo    '</tbody>';
                            echo  '</table>';
                            echo'</div>';
                            echo '</div>
                                </div>
                                </div>
                            </div>
                            </div>';
                }
            }

        ?>
</div>







    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'></script>
    <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
            function hidedisplay(id) {
                    // $('#').hide();
                    if(id == 'coming'){
                        $('#cancel').hide();
                        $('#complie').hide();
                        $('#coming').show();
                    }
                    else if(id == 'complie'){
                        $('#cancel').hide();
                        $('#coming').hide();
                        $('#complie').show();
                    }
                    else if(id == 'cancel'){
                        $('#coming').hide();
                        $('#complie').hide();
                        $('#cancel').show();
                    }
                };
    </script>
    <script>




    </script>

  
</body>
</html>

