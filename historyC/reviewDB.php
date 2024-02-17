<?php
    session_start();
    include('../connectToDatabase.php');

    $conn = new database();

    $star_location = mysqli_real_escape_string($conn->getDatabase(), $_POST['star-Location']);
    $star_clean = mysqli_real_escape_string($conn->getDatabase(), $_POST['star-Clean']);
    $star_service = mysqli_real_escape_string($conn->getDatabase(), $_POST['star-Service']);
    $star_facilities = mysqli_real_escape_string($conn->getDatabase(), $_POST['star-Facilities']);
    $commend = mysqli_real_escape_string($conn->getDatabase(), $_POST['commend']);
    $num_his = mysqli_real_escape_string($conn->getDatabase(), $_POST['his_num']);


    $codecus = $_SESSION['user_code'];

    date_default_timezone_set('Asia/Bangkok');
    $currentDate = date("Y-m-d H:i:s"); // Format as YYYY-MM-DD HH:MM:SS
   
    $rev_num = mysqli_num_rows($conn->executeQuery("Review"));
    $rev_num +=1;

    $conn->editRow("History", "Review_Status", '1', "History_Num = '$num_his'");

    $conn->addRow("Review", "($rev_num, $codecus, '$commend', '$currentDate', '$star_location',
     '$star_service', '$star_clean', '$star_facilities')");

    $_SESSION['reviewstatus'] = 'pass';
    header("Location: historyC.php");
    
?>