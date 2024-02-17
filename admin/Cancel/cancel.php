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

// สร้างคำสั่ง SQL เพื่อดึงข้อมูล
$sql = "SELECT
    Ca.numC,
    CONCAT(c.firstname, ' ', c.lastname) AS customer_name,
    Ca.sDay AS check_in,
    Ca.OutDay AS check_out,
    Ca.TypeRoom AS room_type,
    Ca.Guests,
    c.Tel,
    Ca.amount AS price
FROM Cancel AS Ca
JOIN Customer AS c ON Ca.Code_Cus = c.Code_Cus";





$result = mysqli_query($conn->getDatabase(), $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hygeas | Cancel</title>
    <link rel="stylesheet" href="cancel.css"> <!-- เชื่อมโยงไฟล์ CSS -->
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
        <h1>CANCEL HISTORY</h1>
    </header>
    <div class="container">
        
        <table>
            <tr>
                <th>Customer name</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Type Room</th>
                <th>Guests</th>
                <th>Price (THB)</th>
                <th>Tel</th>
            </tr>

            <?php
            // แสดงข้อมูลจากฐานข้อมูลในตาราง
            $dataArray = array();

            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row['customer_name'] . "</td>";
              echo "<td>" . $row['check_in'] . "</td>";
              echo "<td>" . $row['check_out'] . "</td>";
              echo "<td>" . $row['room_type'] . "</td>";
              echo "<td>" . $row['Guests'] . "</td>";
              echo "<td>" . $row['price'] . "</td>";
              echo "<td>" . $row['Tel'] . "</td>"; // You need to add the 'Tel' field to your SQL query
              echo "</tr>";
          }
                     
            ?>

        </table>
    </div>

    
</body>
</html>

<?php
$conn->closeConnection();
?>

