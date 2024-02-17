<?php
// Start the session
session_start();

include('connectToDatabase.php');
$conn = new database;

// ตรวจสอบการเชื่อมต่อ
if ($conn->getDatabase()->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->getDatabase()->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลจากตาราง RoomBooking
$sql = "SELECT rb.Code_Cus, rb.CheckIn, rb.Code_Room, c.firstname, c.lastname 
        FROM RoomBooking rb
        LEFT JOIN Customer c ON rb.Code_Cus = c.Code_Cus";

$result = mysqli_query($conn->getDatabase(), $sql);

// เริ่มต้น session และกำหนดค่า Room Number เริ่มต้นเป็นค่าว่าง
if (!isset($_SESSION['selectedRoomNumber'])) {
    $_SESSION['selectedRoomNumber'] = "";
}





// เริ่มต้น session และกำหนดค่า Room Number เริ่มต้นเป็นค่าว่าง
if (!isset($_SESSION['selectedRoomNumber'])) {
    $_SESSION['selectedRoomNumber'] = "";
}

// ตรวจสอบว่ามีการคลิกปุ่มและมีค่า Room Number ส่งมาหรือไม่
if (isset($_POST['openCheckRoomButton']) && isset($_POST['selectedRoomNumber'])) {
    // รับค่า Room Number จากฟอร์ม
    $selectedRoomNumber = $_POST['selectedRoomNumber'];
    
    // บันทึกค่า Room Number ลงใน session
    $_SESSION['selectedRoomNumber'] = $selectedRoomNumber;

    // Redirect ไปยังหน้า checkroom.php
    header('Location: checkroom.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Hygeas | booked</title>
    <link rel="stylesheet"><script src="https://kit.fontawesome.com/c1134aa968.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="booked.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

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

<body>

<div class="container py-5">
    <h1 class="text-center">Manange Rooms</h1>
    <div class="row row-cols-1 row-md-4 g-4 py-5">
        <!-- เส้นคั่น separator -->
        <hr class="solid">
        <section>
            <h2>Deluxe Double Room</h2>
        </section>
        <!-- Deluxe Double Room Card -->

        <?php
        // สร้างลูปเพื่อแสดงข้อมูลห้อง 101-110 และ 201-210
        for ($roomNumber = 101; $roomNumber <= 210; $roomNumber++) {
            // ตรวจสอบว่าห้องอยู่ในช่วงที่ต้องการหรือไม่
            if (($roomNumber >= 101 && $roomNumber <= 110) || ($roomNumber >= 201 && $roomNumber <= 210)) {
                // คำสั่ง SQL เพื่อตรวจสอบว่าห้องมีการจองหรือไม่
                $checkRoomSQL = "SELECT * FROM RoomBooking WHERE Code_Room = '$roomNumber'";
                $resultRoom = mysqli_query($conn->getDatabase(), $checkRoomSQL);
                $roomAvailable = (mysqli_num_rows($resultRoom) == 0);

                // ดึงข้อมูลลูกค้าและวันเช็คอิน
                $customerName = "-";
                $checkInDate = "-";

                if (!$roomAvailable) {
                    $roomData = mysqli_fetch_assoc($resultRoom);
                    $customerCode = $roomData['Code_Cus'];

                    $customerQuery = "SELECT * FROM Customer WHERE Code_Cus = '$customerCode'";
                    $customerResult = mysqli_query($conn->getDatabase(), $customerQuery);
                    if ($customerRow = mysqli_fetch_assoc($customerResult)) {
                        $customerName = $customerRow['firstname'] . " " . $customerRow['lastname'];
                    }

                    if (!empty($roomData['CheckIn'])) {
                        $checkInDate = date("Y-m-d H:i:s", strtotime($roomData['CheckIn']));
                    }
                }
        ?>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center">
                    <p class="availability">Status: <?php echo $roomAvailable ? '<i class="fa-solid fa-square-check" style="color: #00d500; font-size: 23px;"></i>' : '<i class="fa-solid fa-square-xmark" style="color: #ff2600; font-size: 23px;"></i>' ; ?></p>
                    <p class="bookedBy">Booked by: <?php echo $customerName; ?></p>
                    <p class="bookingDate">CheckIn Date: <?php echo $checkInDate; ?></p>
                    <p class="roomNumber">Room Number: <?php echo $roomNumber; ?></p>
                    <!-- เพิ่มฟอร์มสำหรับการคลิกปุ่ม -->
                    <form method="post" action="checkroom.php">
                        <input type="hidden" name="room" value="<?php echo $roomNumber; ?>">
                        <input type="hidden" name="roomname" value="Deluxe Double Room">
                        <button type="submit" class="btn btn-primary align-self-center">CheckIn/CheckOut</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
            }
        }
        ?>

        <!-- เส้นคั่น separator -->
<hr class="solid">
<section>
    <h2>Deluxe Twin Room</h2>
</section>

<div class="row">
    <?php
    // สร้างลูปเพื่อแสดงข้อมูลห้อง 301-310
    for ($roomNumber = 301; $roomNumber <= 310; $roomNumber++) {
        // คำสั่ง SQL เพื่อตรวจสอบว่าห้องมีการจองหรือไม่
        $checkRoomSQL = "SELECT * FROM RoomBooking WHERE Code_Room = '$roomNumber'";
        $resultRoom = mysqli_query($conn->getDatabase(), $checkRoomSQL);
        $roomAvailable = (mysqli_num_rows($resultRoom) == 0);

        // ดึงข้อมูลลูกค้าและวันเช็คอิน
        $customerName = "-";
        $checkInDate = "-";

        if (!$roomAvailable) {
            $roomData = mysqli_fetch_assoc($resultRoom);
            $customerCode = $roomData['Code_Cus'];

            $customerQuery = "SELECT * FROM Customer WHERE Code_Cus = '$customerCode'";
            $customerResult = mysqli_query($conn->getDatabase(), $customerQuery);
            if ($customerRow = mysqli_fetch_assoc($customerResult)) {
                $customerName = $customerRow['firstname'] . " " . $customerRow['lastname'];
            }

            if (!empty($roomData['CheckIn'])) {
                $checkInDate = date("Y-m-d H:i:s", strtotime($roomData['CheckIn']));
            }
        }
    ?>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex flex-column justify-content-center">
                <p class="availability">Status: <?php echo $roomAvailable ? '<i class="fa-solid fa-square-check" style="color: #00d500; font-size: 23px;"></i>' : '<i class="fa-solid fa-square-xmark" style="color: #ff2600; font-size: 23px;"></i>' ; ?></p>
                <p class="bookedBy">Booked by: <?php echo $customerName; ?></p>
                <p class="bookingDate">CheckIn Date: <?php echo $checkInDate; ?></p>
                <p class="roomNumber">Room Number: <?php echo $roomNumber; ?></p>
                <!-- เพิ่มฟอร์มสำหรับการคลิกปุ่ม -->
                <form method="post" action="checkroom.php">
                    <input type="hidden" name="room" value="<?php echo $roomNumber; ?>">
                    <input type="hidden" name="roomname" value="Deluxe Twin Room">
                    <button type="submit" class="btn btn-primary align-self-center">CheckIn/CheckOut</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    // ตรวจสอบห้องสุดท้ายและไม่ให้เพิ่มเส้นคั่นหากเป็นห้อง Room Number: 310
    if ($roomNumber % 4 == 0 || ($roomNumber == 310 && $roomNumber % 4 != 0)) {
        echo '</div><div class="row">';
    }
    }
    ?>
</div>


<hr class="solid">
<section>
    <h2>Pool Villa</h2>
</section>

<div class="row">
    <?php
    // สร้างลูปเพื่อแสดงข้อมูล Villa 1-5
    for ($roomNumber = 401; $roomNumber <= 405; $roomNumber++) {
        // คำสั่ง SQL เพื่อตรวจสอบว่าห้องมีการจองหรือไม่
        $villaRoomNumber = $roomNumber;
        $checkRoomSQL = "SELECT * FROM RoomBooking WHERE Code_Room = '$villaRoomNumber'";
        $resultRoom = mysqli_query($conn->getDatabase(), $checkRoomSQL);
        $roomAvailable = (mysqli_num_rows($resultRoom) == 0);

        // ดึงข้อมูลลูกค้าและวันเช็คอิน
        $customerName = "-";
        $checkInDate = "-";

        if (!$roomAvailable) {
            $roomData = mysqli_fetch_assoc($resultRoom);
            $customerCode = $roomData['Code_Cus'];

            $customerQuery = "SELECT * FROM Customer WHERE Code_Cus = '$customerCode'";
            $customerResult = mysqli_query($conn->getDatabase(), $customerQuery);
            if ($customerRow = mysqli_fetch_assoc($customerResult)) {
                $customerName = $customerRow['firstname'] . " " . $customerRow['lastname'];
            }

            if (!empty($roomData['CheckIn'])) {
                $checkInDate = date("Y-m-d H:i:s", strtotime($roomData['CheckIn']));
            }
        }
    ?>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex flex-column justify-content-center">
                <p class="availability">Status: <?php echo $roomAvailable ? '<i class="fa-solid fa-square-check" style="color: #00d500; font-size: 23px;"></i>' : '<i class="fa-solid fa-square-xmark" style="color: #ff2600; font-size: 23px;"></i>' ; ?></p>
                <p class="bookedBy">Booked by: <?php echo $customerName; ?></p>
                <p class="bookingDate">CheckIn Date: <?php echo $checkInDate; ?></p>
                <p class="roomNumber">Room Number: <?php echo $villaRoomNumber; ?></p>
                <!-- เพิ่มฟอร์มสำหรับการคลิกปุ่ม -->
                <form method="post" action="checkroom.php">
                    <input type="hidden" name="room" value="<?php echo $villaRoomNumber; ?>">
                    <input type="hidden" name="roomname" value="Pool villa">
                    <button type="submit" class="btn btn-primary align-self-center">CheckIn/CheckOut</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    }
    ?>


</div>
<hr class="solid">

<!-- Seminar and Ballroom Cards -->
<section>
    <h2>Seminar / Ballroom</h2>
</section>

<div class="row">
    <?php
    // สร้างลูปเพื่อแสดงข้อมูล Seminar 1-2 และ Ballroom 1
    $seminarBallroomRooms = ["001", "002", "003"];
    foreach ($seminarBallroomRooms as $roomName) {
        $namesfull = ["Seminar", "Ballroom"];
        foreach ($namesfull as $roomnamefull) 
        // คำสั่ง SQL เพื่อตรวจสอบว่าห้องมีการจองหรือไม่
        $checkRoomSQL = "SELECT * FROM RoomBooking WHERE Code_Room = '$roomName'";
        $resultRoom = mysqli_query($conn->getDatabase(), $checkRoomSQL);
        $roomAvailable = (mysqli_num_rows($resultRoom) == 0);

        // ดึงข้อมูลลูกค้าและวันเช็คอิน
        $customerName = "-";
        $checkInDate = "-";

        if (!$roomAvailable) {
            $roomData = mysqli_fetch_assoc($resultRoom);
            $customerCode = $roomData['Code_Cus'];

            $customerQuery = "SELECT * FROM Customer WHERE Code_Cus = '$customerCode'";
            $customerResult = mysqli_query($conn->getDatabase(), $customerQuery);
            if ($customerRow = mysqli_fetch_assoc($customerResult)) {
                $customerName = $customerRow['firstname'] . " " . $customerRow['lastname'];
            }

            if (!empty($roomData['CheckIn'])) {
                $checkInDate = date("Y-m-d H:i:s", strtotime($roomData['CheckIn']));
            }
        }
    ?>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex flex-column justify-content-center">
                <p class="availability">Status: <?php echo $roomAvailable ? '<i class="fa-solid fa-square-check" style="color: #00d500; font-size: 23px;"></i>' : '<i class="fa-solid fa-square-xmark" style="color: #ff2600; font-size: 23px;"></i>' ; ?></p>
                <p class="bookedBy">Booked by: <?php echo $customerName; ?></p>
                <p class="bookingDate">CheckIn Date: <?php echo $checkInDate; ?></p>
                <p class="roomNumber">Room Number: <?php echo $roomName; ?></p>
                <!-- เพิ่มฟอร์มสำหรับการคลิกปุ่ม -->
                <form method="post" action="checkroom.php">
                    <input type="hidden" name="room" value="<?php echo $roomName; ?>">
                    <input type="hidden" name="roomname" value="<?php echo $roomnamefull; ?>">
                    <button type="submit" class="btn btn-primary align-self-center">CheckIn/CheckOut</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    }
    ?>
</div>
    </div>
</div>
</body>
</html>
<?php
$conn->closeConnection();
?>