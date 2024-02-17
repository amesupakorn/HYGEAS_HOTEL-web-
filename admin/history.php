<?php
session_start();

// กำหนดข้อมูลการเชื่อมต่อฐานข้อมูล
include('connectToDatabase.php');

// สร้างการเชื่อมต่อ
$conn = new database;

// ตรวจสอบการเชื่อมต่อ
if ($conn->getDatabase()->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->getDatabase()->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูล
$sql = "SELECT H.Code_Room, H.CheckIn, H.CheckOut, H.firstname, H.lastname, B.amount AS Price, H.History_Num, B.additional
FROM History H
LEFT JOIN Bill B ON H.History_Num = B.History_Num
";




$result = mysqli_query($conn->getDatabase(), $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hygeas | Check-In/Check-Out</title>
    <link rel="stylesheet" href="history.css"> <!-- เชื่อมโยงไฟล์ CSS -->
    <style>
    /* CSS สำหรับ pop-up */
    .popup {  
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.7);
      display: none;
      justify-content: center;
      align-items: center;
    }

    .popup-content {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    }

    .popup:target {
      display: flex;
    }

    .close-button {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
    }
    /* CSS สำหรับลบที่ขีดเส้นใต้ไอคอนของปุ่ม */
    table a {
      text-decoration: none; /* ลบที่ขีดเส้นใต้ */
    }
    /* CSS สำหรับลบเส้นใต้ตรงที่อักขระ "❌" ในปุ่มปิด pop-up */
    .close-button a {
      text-decoration: none; /* ลบเส้นใต้ */
    }
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
    <header>
        <h1>CUSTOMER HISTORY</h1>
    </header>
    <div class="container">
        
        <table>
            <tr>
                <th>Customer name</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Room number</th>
                <th>Price (THB)</th>
                <th>Additional</th>
            </tr>

            <?php
            // แสดงข้อมูลจากฐานข้อมูลในตาราง
            $dataArray = array();
            
            // ...
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["firstname"] . " " . $row["lastname"] . "</td>";
                    echo "<td>" . $row["CheckIn"] . "</td>";
                    echo "<td>" . $row["CheckOut"] . "</td>";
                    echo "<td>" . $row["Code_Room"] . "</td>";
                    echo "<td>" . $row["Price"] . "</td>"; // แสดงราคาจากตาราง Bill
                    // รวมค่า History_Num ใน href ของลิงก์ pop-up
                    $additionalContent = $row["additional"] ? "➕" : '<span class="tag need">needless</span';
                    echo "<td><a href='#popup" . $row["additional"] . "'>" . $additionalContent . "</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>ไม่มีข้อมูล</td></tr>";
            }

            ?>

        </table>
    </div>

    <?php
    // รีเซ็ตผลลัพธ์เพื่อเริ่มต้นจากต้นของผลลัพธ์
    mysqli_data_seek($result, 0);

    // แสดง pop-up สำหรับค่า History_Num แต่ละค่า
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div id='popup" . $row["additional"] . "' class='popup'>";
            echo "<div class='popup-content'>";
            echo '<a class="close" href="#">&times;</a>';
            echo "<h3>More details</h3>";
            echo "<p>" . $row["additional"] . "</p>"; // แสดงราคาจากตาราง Bill
            echo "</div>";
            echo "</div>";
        }
    }
    ?>
</body>
</html>

<?php
$conn->closeConnection();
?>

