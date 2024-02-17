<?php
require('../connectToDatabase.php');
$data = new database();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Refresh at Midnight</title>
</head>

<body>

    <?php
    date_default_timezone_set('Asia/Bangkok');


    $todayDate = date('Y-m-d');
    // $yesterdayDate = date('Y-m-d', strtotime($todayDate . ' -2 day'));

    $sqlRoomBooking = "SELECT * FROM Booking WHERE sDay <= '$todayDate'";
    $Result = $data->getDatabase()->query($sqlRoomBooking);

    if ($Result) {
        // Check if there are rows in the result set
        if ($Result->num_rows > 0) {
            // Loop through each row in the result set
            while ($ObjResult = mysqli_fetch_assoc($Result)) {
                $Order = $ObjResult['Order'];
                $sDay = $ObjResult['sDay'];
                $OutDay = $ObjResult['OutDay'];
                $Guests = $ObjResult['Guests'];
                $Pay = $ObjResult['Pay'];
                $TypeRoom = $ObjResult['TypeRoom'];
                $Code_Cus = $ObjResult['Code_Cus'];

                // Output the data for each row
                echo "$Order <br>";
                echo "$sDay <br>";
                echo "$OutDay <br>";
                echo "$Guests <br>";
                echo "$Pay <br>";
                echo "$TypeRoom <br>";
                echo "$Code_Cus <br>";
                echo "$todayDate <br>";


                //เพิ่มใน cancel
                $maxNumcQuery = "SELECT MAX(numc) as maxNumc FROM Cancel";
                $maxNumcResult = $data->getDatabase()->query($maxNumcQuery);

                if ($maxNumcResult) {
                    $maxNumcObjResult = mysqli_fetch_assoc($maxNumcResult);
                    $maxNumc = $maxNumcObjResult['maxNumc'];

                    // Increment numc by 1
                    $numc = $maxNumc + 1;



                    $insertQuery = "INSERT INTO Cancel (numc, sDay, Code_Cus, Guests, OutDay, amount, TypeRoom) 
        VALUES ('$numc','$sDay', '$Code_Cus', '$Guests', '$OutDay', '$Pay', '$TypeRoom')";
                    $result = $data->getDatabase()->query($insertQuery);
                }
            }
        }
    }
    $deleteBooking = "DELETE FROM Booking WHERE sDay <= '$todayDate'";
    $deleteBooking = $data->getDatabase()->query($deleteBooking);
    header("Location: booking.php"); // แทนด้วย URL หน้าสำเร็จจริง
    exit();
    ?>




</body>

</html>