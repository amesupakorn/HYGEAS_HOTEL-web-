<?php

session_start();
include('../connectToDatabase.php');
$conn = new database();

$order= mysqli_real_escape_string($conn->getDatabase(), $_POST['cancel_booking']);

$sql = "
                Select CAST(sDay AS DATE) AS SDay, CAST(OutDay AS DATE) AS OutDay, book.TypeRoom, book.Guests, book.Pay, CAST(OutDay AS DATE)-CAST(sDay AS DATE) AS duration
                From Booking book
                Where `Order` = $order;";

$ObjResult = mysqli_fetch_array(mysqli_query($conn->getDatabase(), $sql));

$sday = $ObjResult['SDay'];
$OutDay = $ObjResult['OutDay'];
$guest = $ObjResult['Guests'];
$pay = $ObjResult['Pay'];
$roomtype = $ObjResult['TypeRoom'];
$amount = $ObjResult['Pay'];
                
$numcancel = mysqli_num_rows($conn->executeQuery("Cancel"));
$numcancel += 1;

$conn->addRow("Cancel", "('$numcancel', '$sday', ".$_SESSION['user_code'].", '$guest', '$OutDay', '$amount', '$roomtype')");

// ลบการจองออกจากตาราง RoomBooking
$deleteBookingQuery = "DELETE FROM Booking WHERE Code_Cus = ".$_SESSION['user_code']." AND `Order` = $order";
$deleteResult = $conn->getDatabase()->query($deleteBookingQuery);

mysqli_close($conn->getDatabase());

$_SESSION['cancelday'] = 'pass';
header("Location: historyC.php");
?>
