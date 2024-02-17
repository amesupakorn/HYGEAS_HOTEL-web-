<?php
session_start();

    $public_key = 'pkey_test_5x48zalcuue0w88bymn';
    $secret_key = 'skey_test_5x48st0dfumefhbbcog';

    require_once dirname(__FILE__).'/omise-php/lib/Omise.php';

    define('OMISE_API_VERSION', '2015-11-17');
    define('OMISE_PUBLIC_KEY', $public_key);
    define('OMISE_SECRET_KEY', $secret_key);


    $arrayCharge = array();
    $arrayAmount = array();
    $amount = $_POST['amount'];
    // ราคา
    $eChoice = 'thb';
    $eDiscount = 0;
    // เงื่อนไข
    $eGuests = 0;//คน $_POST['people']
    $eFor = 'all';//เก่าใหม่
    $eMin = 0;//ราคาขั้นต่ำ
    $eTypeRoom = 'ALL';//ประเภท $_POST['type']
    $CondiToDis = 0;
    require('../connectToDatabase.php');
    $conn = new database;
    $sqlhistory = "SELECT * FROM History WHERE Code_Cus = (SELECT Code_Cus FROM Account WHERE Username LIKE '".$_SESSION['user_login']."');";

    $sqlevent = "SELECT eCode, eChoice, eDiscount, eGuests, eFor, eMin, eTypeRoom
					FROM `Event` WHERE eCode LIKE '".$_POST['event_code']."';";
	$resultCheckEvent = mysqli_query($conn->getDatabase(), $sqlevent);
    $resultCheckHistory = mysqli_query($conn->getDatabase(), $sqlhistory);

    if($resultCheckEvent->num_rows > 0 || $_POST['event_code'] == ' '){
        echo "<br>III";
        while($row = mysqli_fetch_assoc($resultCheckEvent)){
            $eChoice = $row['eChoice'];

            $eDiscount = $row['eDiscount'];

            $eGuests = $row['eGuests'];

            $eFor = $row['eFor'];

            $eMin = $row['eMin'];

            $eTypeRoom = $row['eTypeRoom'];

        }

        if($eTypeRoom == 'ALL' || $_POST['type'] == $eTypeRoom ){
            echo "type<br>";
            if($_POST['people']>= $eGuests){
                echo "people<br>";
                if($amount >= $eMin){
                    echo "eMin<br>";
                    if(($eFor == 'all') || ($eFor == 'new' && $resultCheckHistory->num_rows == 0) || ($eFor == 'old' && $resultCheckHistory->num_rows > 0)){
                        $CondiToDis = 1;
                    }
                }
            }
        }
    }else{
        echo $_POST['event_code'];
        $_SESSION['code'] = 'fail';
        header("Location: ../book/book.php");
    }

    if($CondiToDis==1){
        if($eChoice == 'percent'){
            $amount = floor($amount*((100-$eDiscount)/100));
        }else{
            $amount = ($amount-$eDiscount);
        }
    }
    $disamount = $amount;

    $amount = $amount*100;

    $index = 0;
    echo $_POST['command']."<br/>";
    while($amount > 0){
        echo "$amount<br/>";
        echo $_POST['card_name']."<br/>";
        echo $_POST['card_number']."<br/>";
        echo $_POST['expiration_month']."<br/>";
        echo $_POST['expiration_year']."<br/>";
        echo $_POST['security_code']."<br/>";
        $useAmount = min($amount, 15000000);

        $newToken = OmiseToken::create(array(
            'card' => array(
                'name' => $_POST['card_name'],  // ชื่อบนบัตร
                'number' => $_POST['card_number'],  // เลขที่บัตร
                'expiration_month' => (int)$_POST['expiration_month'],  // เดือนหมดอายุ
                'expiration_year' => (int)("20".$_POST['expiration_year']),  // ปีหมดอายุ
                'security_code' => $_POST['security_code'],  // CVV/CVC
            ),
        ));
        $arrayAmount[$index] = $useAmount;
        $arrayCharge[$index] = OmiseCharge::create(array(
            'amount' => $useAmount,
            'currency' => 'thb',
            'card' => $newToken['id']
        ));
        if($arrayCharge[$index]['status'] != 'successful'){

        }
        $amount-=$useAmount;
        $index ++;
    }
    
    echo "WWW ".$amount."<br>";
    $lastDigit = substr($arrayCharge[0]['card']['last_digits'], -4);

    // ต้องเช็คก่อนจ่ายด้วยอีกทีก่อนจ่าย ใช้ transaction begin
    $success = 0;
    $countCharge = count($arrayCharge);
    foreach($arrayCharge as $charge){
        if($charge['status'] == 'successful'){
            $success++;
        }
    }
    echo $success."<br>";
    echo $countCharge."<br>";
    if($success == $countCharge){
        try {
            $addDigit = sprintf($_POST['command'], $disamount, $lastDigit);
            echo $addDigit."<br/>";
            mysqli_query($conn->getDatabase(), $addDigit);
        } catch (Exception $e) {
            echo "Refund<br/>";
            try {
                    
                    for($i = 0;$i<$success;$i++){
                        $charge = OmiseCharge::retrieve($arrayCharge[$i]['id']);
                        $refund = $charge->refunds()->create(['amount' => $arrayAmount[$i]]);
                    }

                //alert refund success
                $_SESSION['refund'] = "complete";
                header("Location: ../book/book.php");
                echo "Refund processed successfully. Refund ID: " . $refund['id'];
            } catch (Exception $e) {
                //alert refund fail contact servier
                $_SESSION['refund'] = "fail";
                header("Location: ../book/book.php");
                echo "Error: " . $e->getMessage();
            }
        }
    }else{
        for($i = 0;$i<$success;$i++){
            $charge = OmiseCharge::retrieve($arrayCharge[$i]['id']);
            $refund = $charge->refunds()->create(['amount' => $arrayAmount[$i]]);
        }
        $_SESSION['pass'] = "failpay";
        header("Location: ../book/book.php");
        echo "Payment Fail";
    }

    $_SESSION['pass'] = "success";
    header("Location: ../book/book.php");
    exit();

?>