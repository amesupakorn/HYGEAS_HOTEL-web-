<?php
require('connectToDatabase.php');
$data = new database();

$action = $_POST['action']; // 'checkin' หรือ 'checkout'
$roomNumber = $_POST['roomnumber'];
$thisday = $_POST['Checkin'];
$checkoutdate = $_POST['CheckOut'];
$extension = $_POST['Extension'];
$extensionex = $_POST['Extensionex'];
$amount = $_POST['Amount'];

if (isset($_POST['selectedCode'])) {
    $code = $_POST['selectedCode'];

    $sqlGuests = "SELECT * FROM Booking WHERE Code_Cus = '$code'";
    $resualt = $data->getDatabase()->query($sqlGuests);
    $row = mysqli_fetch_assoc($resualt);
    $numCard = $row['NumCard'];
    $guest = $row['Guests'];
}

if($action == 'checkin') {
                $todayDate = date('Y-m-d');
                $deleteBooking = "DELETE FROM Booking WHERE Code_Cus = '$code' AND sDay = '$todayDate' LIMIT 1";
                $deleteBooking = $data->getDatabase()->query($deleteBooking);


                $insertQuery = "INSERT INTO RoomBooking (Code_Cus, Code_Room, CheckIn, CheckOut, additional, Guests,NumCard) 
                    VALUES ('$code', '$roomNumber', '$thisday', '$checkoutdate', '$extension', '$guest',$numCard)";
                $result = $data->getDatabase()->query($insertQuery);

                if ($result) {
                    // Redirect to another page upon success
                    header("Location: booked.php"); // Replace "another_page.php" with the actual URL
                    exit(); // Terminate script execution after the redirection
                }


} elseif ($action == 'checkout') {

    $sqlextension = "SELECT additional FROM RoomBooking WHERE Code_Room = '$roomNumber'";
    $extensionResult = $data->getDatabase()->query($sqlextension);

    $something = $_POST['checkupdate'];

    if($something == "no"){

                                $getOldExtensionQuery = "SELECT additional FROM RoomBooking WHERE Code_Room = '$roomNumber'";
                                $oldExtensionResult = $data->getDatabase()->query($getOldExtensionQuery);
                            
                                if ($oldExtensionResult->num_rows > 0) {
                                    $row = $oldExtensionResult->fetch_assoc();
                                    $oldExtension = $row['additional'];
                            
                                    // นำค่าเดิมมาบวกกับค่าใหม่ที่ต้องการเพิ่ม
                                    $newExtension = $oldExtension . $extension;
                                }
                                // ทำการอัปเดต extension ในฐานข้อมูล
                                $updateBillExtensionQuery = "UPDATE RoomBooking SET additional = '$newExtension' WHERE Code_Room = '$roomNumber'";
                                $updateBillExtensionResult = $data->getDatabase()->query($updateBillExtensionQuery);
                        

        echo "update";
        
    }
    
    
    elseif($something == "yes"){
        echo "ลบ";
        
        $sqlRoomBooking = "SELECT * FROM RoomBooking WHERE Code_Room = $roomNumber";
        $Result = $data->getDatabase()->query($sqlRoomBooking);
        $ObjResult = mysqli_fetch_assoc($Result);
        $oldDay = $ObjResult['CheckIn']; 
        $NumCard = $ObjResult['NumCard'];
        $guest = $ObjResult['Guests'];
        $code = $ObjResult['Code_Cus'];
        
        $sqlname = "SELECT * FROM Customer WHERE Code_Cus = $code";
        $resultName = $data->getDatabase()->query($sqlname); 
        $ObjnameResult = mysqli_fetch_assoc($resultName); 
        $customerFirstName = $ObjnameResult['firstname'];
        $customerLastName = $ObjnameResult['lastname'];


                        $currentHistoryNum = mysqli_num_rows($data->executeQuery("History"));

                        $newHistoryNum = $currentHistoryNum + 1;
                        
                        // ย้ายข้อมูลไปยังตาราง History
                        $moveToHistoryQuery = "INSERT INTO History (History_Num, Code_Room, Code_Cus, CheckIn, CheckOut, Guests, firstname, lastname) 
                                            VALUES ($newHistoryNum, '$roomNumber', '$code', '$oldDay', '$checkoutdate', '$guest ', '$customerFirstName', '$customerLastName')";
                        $moveResult = $data->getDatabase()->query($moveToHistoryQuery);

                        // สร้างรายการใบเสร็จในตาราง Bill
                        $amount = (int)$amount; // แปลงเป็นจำนวนเต็ม

                        $moveToBillQuery = "INSERT INTO Bill (History_Num, additional, amount, NumCard)
                                            VALUES ('$newHistoryNum', '$extensionex', $amount, $NumCard)";
                        $moveBillResult = $data->getDatabase()->query($moveToBillQuery);

                        // ลบการจองออกจากตาราง RoomBooking
                        $deleteBookingQuery = "DELETE FROM RoomBooking WHERE Code_Room = '$roomNumber'";
                        $deleteResult = $data->getDatabase()->query($deleteBookingQuery);

    }
    
}
header("Location: booked.php"); // แทนด้วย URL หน้าสำเร็จจริง
exit(); // สิ้นสุดการดำเนินการหลังจากการเปลี่ยนเส้นทาง
?>