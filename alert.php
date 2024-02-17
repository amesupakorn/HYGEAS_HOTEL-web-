<?php

function alertout(){
    echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>"';
    echo "<script>";
    echo "Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to log out?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Logout'
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?logout=2';";
    echo "}else{
            window.location.href = 'index.php?logout=3';
            }
        })";
    echo "</script>";
  }

  function alertbook(){
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>"';
    echo "<script>";
    echo "Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Booking Complete',
          showConfirmButton: false,
          timer: 1500
          })";
    echo "</script>";

  }

?>