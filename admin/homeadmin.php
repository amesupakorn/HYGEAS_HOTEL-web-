<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  
  <title>HYGEAS_HOTEL</title>
  
  <link rel="icon" type="image/x-icon" href="/home/favicon.ico">
  <link rel="stylesheet" href="style.css"><script src="https://kit.fontawesome.com/c1134aa968.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="./style.css">


<input type="checkbox" id="openSideMenu" class="openSideMenu">
<label for="openSideMenu" class="menuIconToggle">
  <div class="hamb-line dia part-1"></div>
  <div class="hamb-line hor"></div>
  <div class="hamb-line dia part-2"></div>
</label>
<nav>
  <ul>
  <li><a href="homeadmin.php">DashBoard</a></li>
    <li><a href="eventpage_s/eventUI.php">Create Event</a></li>
    <li><a href="Event/event.php">Manage Event</a></li>
    <li><a href="booked.php">Manage Rooms</a></li>
    <li><a href="booking/booking.php">Manage Booking</a></li>
    <li><a href="Cancel/cancel.php">History Cancel</a></li>
    <li><a href="history.php">History Customer</a></li>
  </ul>
</nav>

</head>
<body>

  <div class="app-main">
    <div class="main-header-line">
      <h1>Hotel Dashboard</h1>
      <div class="action-buttons">
        <button class="open-right-area">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </button>
      <button class="menu-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      </div>
    </div>

<?php
  require("connectToDatabase.php");
  $conn = new Database();
  $sql="
    SELECT (SUM(rate_location) + SUM(rate_service) + SUM(rate_cleanliness) + SUM(rate_facilities)) AS review
    FROM Review
  ";

  $query = mysqli_query($conn->getDatabase(), $sql);
  $result = mysqli_query($conn->getDatabase(), $sql);
  $ObjResult = mysqli_fetch_array(mysqli_query($conn->getDatabase(), $sql));

  $history_num = mysqli_num_rows($conn->executeQuery("History"));
  $customer_num = mysqli_num_rows($conn->executeQuery("Account"));
  $review_num = mysqli_num_rows($conn->executeQuery("Review"));
  $review = $ObjResult['review'];
  $review = $review / 4;
?>
    <div class="chart-row three">
      <div class="chart-container-wrapper">
        <div class="chart-container">
          <div class="chart-info-wrapper">
            <h2>Number of Booking</h2>
            <span><?php echo $history_num;?> Booking</span>
            <p>Booking/100</p>
          </div>
          <div class="chart-svg">
            <svg viewBox="0 0 36 36" class="circular-chart pink">
      <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
      <path class="circle" stroke-dasharray="<?php echo $history_num;?>, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
      <text x="18" y="20.35" class="percentage"><?php echo $history_num;?> %</text>
    </svg>
          </div>
        </div>
      </div>
      <div class="chart-container-wrapper">
        <div class="chart-container">
          <div class="chart-info-wrapper">
            <h2>Number of Customers</h2>
            <span><?php echo $customer_num;?> Guests</span>
            <p>Guest/100</p>
          </div>
           <div class="chart-svg">
            <svg viewBox="0 0 36 36" class="circular-chart orange">
      <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
      <path class="circle" stroke-dasharray="<?php echo $customer_num;?>, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
      <text x="18" y="20.35" class="percentage"><?php echo $customer_num;?> %</text>
    </svg>
          </div>
        </div>
      </div>
      <div class="chart-container-wrapper">
        <div class="chart-container">
          <div class="chart-info-wrapper">
            <h2>Popularity</h2>
            <span><?php echo $review_num;?> Review</span>
            <p>Review/5 star</p>
          </div>
          <div class="chart-svg">
            <svg viewBox="0 0 36 36" class="circular-chart blue">
      <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
      <path class="circle" stroke-dasharray="<?php echo $review*20?>, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
      <text x="18" y="20.35" class="percentage"><?php echo $review*20?> %</text>
    </svg>
          </div>
        </div>
      </div>
    </div>



    <div class="chart-row two">
      <div class="chart-container-wrapper big">
        <div class="chart-container">
          <div class="chart-container-header">
            <h2>Top Booking</h2>
            <span>Last 30 days</span>
          </div>
          <div class="line-chart">
            <canvas id="chart"></canvas>
          </div>
          <div class="chart-data-details">
            <div class="chart-details-header"></div>
          </div>
        </div>
      </div>



  <div class="app-right">
    <button class="close-right">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>

    <div class="app-right-section">
      <div class="app-right-section-header">
        <h2>Activity this month</h2>
        <span class="notification-active">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </span>
      </div>

      <?php 
          $sql3 ="
          SELECT eName, CAST(eStart As DATE) As eStart, CAST(eStop As DATE) As eStop
          FROM Event;
          ";
      
        $result3 = mysqli_query($conn->getDatabase(), $sql3);
        $ObjResult3 = mysqli_fetch_array(mysqli_query($conn->getDatabase(), $sql3));


        while($row3 = mysqli_fetch_array($result3)){
          echo ' 
            <div class="activity-line">
            <span class="activity-icon applicant">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
            </span>
            <div class="activity-text-wrapper">
              <p class="activity-text">'.$row3['eName'].'</p>
              <p class="activity-text">'.$row3['eStart'].' - '.$row3['eStop'].'</p>
              
            </div>
            </div>
          ';
        }
      ?>
  </div>
</div>

<?php
  $sql2 ="
    SELECT MONTH(CAST(CheckIn AS DATE)) AS CheckIn
    FROM History;
  ";

  $result2 = mysqli_query($conn->getDatabase(), $sql2);
  $ObjResult2 = mysqli_fetch_array(mysqli_query($conn->getDatabase(), $sql2));
  mysqli_close($conn->getDatabase());
  $m1 = 0; $m2 = 0; $m3 = 0; $m4 = 0; $m5 = 0; $m6 = 0; $m7 = 0; 
  $m8 = 0; $m9 = 0; $m10 = 0; $m11 = 0; $m12 = 0;

  while($row = mysqli_fetch_array($result2)){
    if($row['CheckIn'] == 1){
      $m1 = $m1 + 1;
    }
    else if($row['CheckIn'] == 2){
      $m2 = $m2 + 1;
    }
    else if($row['CheckIn'] == 3){
      $m3 = $m3 + 1;
    }
    else if($row['CheckIn']== 4){
      $m4 = $m4 + 1;
    }
    else if($row['CheckIn'] == 5){
      $m5 = $m5 + 1;
    }
    else if($row['CheckIn'] == 6){
      $m6 = $m6 + 1;
    }
    else if($row['CheckIn'] == 7){
      $m7 = $m7 + 1;
    }
    else if($row['CheckIn'] == 8){
      $m8 = $m8 + 1;
    }
    else if($row['CheckIn'] == 9){
      $m9 = $m9 + 1;
    }
    else if($row['CheckIn'] == 10){
      $m10 = $m10 + 1;
    }
    else if($row['CheckIn']== 11){
      $m11 = $m11 + 1;
    }
    else if($row['CheckIn'] == 12){
      $m12 = $m12 + 1;
    }

  }

?>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js'></script><script  src="./script.js"></script>
  <script>
    var chart    = document.getElementById('chart').getContext('2d'),
    gradient = chart.createLinearGradient(0, 0, 0, 450);

    gradient.addColorStop(0, 'rgba(0, 199, 214, 0.32)');
    gradient.addColorStop(0.3, 'rgba(0, 199, 214, 0.1)');
    gradient.addColorStop(1, 'rgba(0, 199, 214, 0)');


    var data  = {
        labels: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October', 'November','December' ],
        datasets: [{
          label: 'Booking',
          backgroundColor: gradient,
          pointBackgroundColor: '#00c7d6',
          borderWidth: 1,
          borderColor: '#0e1a2f',
          data: [<?=$m1;?>, <?=$m2;?>, <?=$m3;?>, <?=$m4;?>, <?=$m5;?>, <?=$m6;?>, <?=$m7;?>, <?=$m8;?>, <?=$m9;?>, <?=$m10;?>, <?=$m11;?>, <?=$m12;?>]
        }]
    };

    var options = {
      responsive: true,
      maintainAspectRatio: true,
      animation: {
        easing: 'easeInOutQuad',
        duration: 520
      },
      scales: {
        yAxes: [{
          ticks: {
            fontColor: '#5e6a81'
          },
          gridLines: {
            color: 'rgba(200, 200, 200, 0.08)',
            lineWidth: 1
          }
        }],
        xAxes:[{
          ticks: {
            fontColor: '#5e6a81'
          }
        }]
      },
      elements: {
        line: {
          tension: 0.4
        }
      },
      legend: {
        display: false
      },
      point: {
        backgroundColor: '#00c7d6'
      },
      tooltips: {
        titleFontFamily: 'Poppins',
        backgroundColor: 'rgba(0,0,0,0.4)',
        titleFontColor: 'white',
        caretSize: 5,
        cornerRadius: 2,
        xPadding: 10,
        yPadding: 10
      }
    };

    var chartInstance = new Chart(chart, {
        type: 'line',
        data: data,
        options: options
    });

    document.querySelector('.open-right-area').addEventListener('click', function () {
        document.querySelector('.app-right').classList.add('show');
    });

    document.querySelector('.close-right').addEventListener('click', function () {
        document.querySelector('.app-right').classList.remove('show');
    });

    document.querySelector('.menu-button').addEventListener('click', function () {
        document.querySelector('.app-left').classList.add('show');
    });

    document.querySelector('.close-menu').addEventListener('click', function () {
        document.querySelector('.app-left').classList.remove('show');
    });
  </script>
</body>
</html>