<?php
    session_start();
    include('../connectToDatabase.php');

    $conn = new database();

    $edit_firstname = mysqli_real_escape_string($conn->getDatabase(), $_POST['edit_firstname']);
    $edit_lastname = mysqli_real_escape_string($conn->getDatabase(), $_POST['edit_lastname']);
    $edit_tel = mysqli_real_escape_string($conn->getDatabase(), $_POST['edit_tel']);
    $edit_mail = mysqli_real_escape_string($conn->getDatabase(), $_POST['edit_mail']);

    if(strlen($edit_firstname) > 0){
        $conn->editRow("Customer", "firstname", "$edit_firstname", "code_cus =".$_SESSION['user_code'].";");
        header("Location: account.php");
    }
    if(strlen($edit_lastname) > 0){
        $conn->editRow("Customer", "lastname", "$edit_lastname", "code_cus =".$_SESSION['user_code'].";");
        header("Location: account.php");
    }
    if(strlen($edit_mail) > 0){
        $conn->editRow("Customer", "tel", "$edit_mail", "code_cus =".$_SESSION['user_code'].";");
        header("Location: account.php");
    }
    if(strlen($edit_tel) > 0){
        $conn->editRow("Customer", "mail", "$edit_tel", "code_cus =".$_SESSION['user_code'].";");
        header("Location: account.php");
    }
    else{
        header("Location: account.php");
    }
?>
