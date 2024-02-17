<?php
session_start();

// กำหนดข้อมูลการเชื่อมต่อฐานข้อมูล
include('../connectToDatabase.php');

// สร้างการเชื่อมต่อ
$conn = new database;

// ตรวจสอบการเชื่อมต่อ
if ($conn->getDatabase()->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->getDatabase()->connect_error);
}

$sql = "SELECT * 
from Event";

$result = mysqli_query($conn->getDatabase(), $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hygeas | Event</title>
    <link rel="stylesheet" href="event.css"> <!-- เชื่อมโยงไฟล์ CSS -->
    <link rel="stylesheet"><script src="https://kit.fontawesome.com/c1134aa968.js" crossorigin="anonymous"></script>
    <style>
    
    
nav {
height: 100%;
position: fixed;
left: 0;
width: 250px;
transform: translateX(-320px);
transition: transform 260ms ease-in-out;
background-color: white;
border-left: 1px solid #eee;
}
nav ul {
  margin-top: 25%;
  padding:0;
  border-top: 1px solid #eee;
}
nav ul>li {
  list-style: none;
  color: #fff;
  text-transform: uppercase;
  font-weight: bold;
  padding: 20px;
  cursor: pointer;
  border-bottom: 1px solid #eee;
  transition: .25s
}
nav ul>li span {
  display: block;
  font-size: 14px;
  color: #353535;
}
nav ul>li a {
  color: #353535;
  text-transform: uppercase;
  font-weight: bold;
  cursor: pointer;
  text-decoration: none;
}
nav ul>li:hover {
  background-color: #dddddd;
}
nav li#nav-signup {
  list-style: none;
  background-color: #00B2D3;
}
nav ul>li#nav-signup span {
  color: #00B2D3;
}
nav ul>li#nav-signup a {
  color: #ffffff;
}
nav ul>li#nav-signup:hover {
  background-color: #006375;
}
input[type="checkbox"]:checked ~ nav {
  transform: translateX(0);
  z-index: 40;
}
input[type=checkbox] {
  box-sizing: border-box;
  display: none;
  transition: all 0.25s;
}
.menuIconToggle {
  box-sizing: border-box;
  cursor: pointer;
  position: fixed;
  z-index: 100;
  height: 100%;
  width: 100%;
  top: 25px;
  left: 30px;
  height: 22px;
  width: 22px;
  transition: all 0.3s;
}
.hamb-line {
  box-sizing: border-box;
  position: absolute;
  height: 3px;
  width: 100%;
  background-color: #444;
  transition: all 0.25s;
}
.hor {
  transition: all 0.3s;
  box-sizing: border-box;
  position: relative;
  float: left;
  margin-top: 3px;
}
.dia.part-1 {
  position: relative;
  box-sizing: border-box;
  float: left;
  transition: all .25s;
}
.dia.part-2 {
  box-sizing: border-box;
  position: relative;
  float: left;
  margin-top: 3px;
  transition: all .25s;
}
input[type=checkbox]:checked ~ .menuIconToggle > .hor {
  box-sizing: border-box;
  opacity: 0;
  transition: all .25s;
}
input[type=checkbox]:checked ~ .menuIconToggle > .dia.part-1 {
  box-sizing: border-box;
  transform: rotate(135deg);
  margin-top: 8px;
  transition: all .25s;
}
input[type=checkbox]:checked ~ .menuIconToggle > .dia.part-2 {
  box-sizing: border-box;
  transform: rotate(-135deg);
  margin-top: -9px;
  transition: all .25s;
}
@media screen and (max-width: 640px) {
nav {
    height: 100%;
    width: 100%;
    transform: translateX(100%);
  } 
}

hr.solid {
  border-top: 3px solid #000000;
} 
</style>

<input type="checkbox" id="openSideMenu" class="openSideMenu">
    <label for="openSideMenu" class="menuIconToggle">
    <div class="hamb-line dia part-1"></div>
    <div class="hamb-line hor"></div>
    <div class="hamb-line dia part-2"></div>
</label>
<nav>
  <ul>
    <li><a href="../homeadmin.php">DashBoard</a></li>
    <li><a href="../eventpage_s/eventUI.php">Create Event</a></li>
    <li><a href="../Event/event.php">Manage Event</a></li>
    <li><a href="../booked.php">Manage Rooms</a></li>
    <li><a href="../booking/booking.php">Manage Booking</a></li>
    <li><a href="../Cancel/cancel.php">History Cancel</a></li>
    <li><a href="../history.php">History Customer</a></li>
  </ul>
</nav>

</head>

<body>
    <header>
        <h1>Manage Event</h1>
    </header>
    <div class="container">
        
    <table>
    <tr>
        <th>Event Code</th>
        <th>Event Name</th>
        <th>Event Start</th>
        <th>Event Stop</th>
        <th>Event Discount</th>
        <th>Event Choice</th>
        <th>Event For</th>
        <th>Event Min</th>
        <th>Event TypeRoom</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php
    // แสดงข้อมูลจากฐานข้อมูลในตาราง
    $dataArray = array();

    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['eCode']) . "</td>";
          echo "<td>" . htmlspecialchars($row['eName']) . "</td>";
          echo "<td>" . htmlspecialchars($row['eStart']) . "</td>";
          echo "<td>" . htmlspecialchars($row['eStop']) . "</td>";
          echo "<td>" . htmlspecialchars($row['eDiscount']) . "</td>";
          echo "<td>" . htmlspecialchars($row['eChoice']) . "</td>";
          echo "<td>" . htmlspecialchars($row['eFor']) . "</td>";
          echo "<td>" . htmlspecialchars($row['eMin']) . "</td>";
          echo "<td>" . htmlspecialchars($row['eTypeRoom']) . "</td>";
          echo "<td style='text-align: center;'><a class='gray-link' href='../eventpage_s/eventUI.php?edit=" . htmlspecialchars($row['eCode']) . "'><i class='fa fa-edit'></i></a></td>";
          echo "<td style='text-align: center;'><a class='gray-link' href='deleteEvent.php?eCode=" . htmlspecialchars($row['eCode']) . "&deleteEvent=1'><i class='fa fa-trash-o'></i></a></td>";
          echo "</tr>";
      }
  } else {
      echo "Error executing SQL query: " . mysqli_error($conn->getDatabase());
  }
   
    ?>

</table>

    </div>

    
</body>
</html>

<?php
$conn->closeConnection();
?>

