<?php
  session_start();
  include('../connectToDatabase.php');
  $errors = array();
  
  $conn = new database();
  $first_name = mysqli_real_escape_string($conn->getDatabase(), $_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn->getDatabase(), $_POST['last_name']);
  $email = mysqli_real_escape_string($conn->getDatabase(), $_POST['email']);
  $phone_number = mysqli_real_escape_string($conn->getDatabase(), $_POST['phone_number']);
  $username = mysqli_real_escape_string($conn->getDatabase(), $_POST['username']);
  $password = mysqli_real_escape_string($conn->getDatabase(), $_POST['password']);
  $confirm_password = mysqli_real_escape_string($conn->getDatabase(), $_POST['confirm_password']);
  $sex = mysqli_real_escape_string($conn->getDatabase(), $_POST['gender']);

  if ($password != $confirm_password){
    array_push($errors, "รหัสผ่านไม่ตรงกัน");
    $_SESSION['regis'] = "failpass";
    header("Location: register.php");
  }

  // echo $username;
  $result = $conn->executeQuery("Account", "*", null, "Username Like '$username'");

  // echo "$result->num_rows he";
  if ($result->num_rows > 0){
      array_push($errors, "มีชื่อผู้ใช้นี้อยู่แล้ว");
      $_SESSION['regis'] = "namefail";
      header("Location: register.php");
  }

  if (count($errors) == 0){
      $password1 = md5($password);

      $num = mysqli_num_rows($conn->executeQuery("Customer"));
      $num = $num+1;
      // echo "$num";
      
      $conn->addRow("Customer", "($num, '$first_name', '$last_name', '$phone_number', '$sex', '$email')");
      $conn->addRow("Account", "($num, '$username' , '$password')");
        

      // $_SESSION['username'] = $username;
      $_SESSION['success'] = "pass";
      header("Location: Login.php");
  }

?>