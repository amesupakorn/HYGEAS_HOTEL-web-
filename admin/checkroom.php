<?php
    session_start();
if (isset($_POST['room'])) {
    $roomNumber = $_POST['room'];
}

require("connectToDatabase.php");

$datacus = new database;

$sqlextension = "SELECT additional FROM RoomBooking WHERE Code_Room = '$roomNumber'";

$extension = $datacus->getDatabase()->query($sqlextension)->fetch_assoc();
if (empty($_POST['selectedCode'])) {
    $sqldatacus_code = "SELECT Code_Cus FROM Booking WHERE sday = CURDATE()";
    $datacus_code = $datacus->getDatabase()->query($sqldatacus_code);
} else {
    
    $sqldatacus_code = "SELECT Code_Cus FROM RoomBooking WHERE Code_Room = '$roomNumber'";
    $datacus_code = $datacus->getDatabase()->query($sqldatacus_code);
}

$query = "SELECT * FROM RoomBooking WHERE Code_Room = '$roomNumber'";
$result = $datacus->getDatabase()->query($query);



// Check if a matching record exists
if ($result->num_rows > 0) {
    // Show elements for when a matching record is found (e.g., id="allcheckout")
    $showCheckout = true;
} else {
    // Show elements for when no matching record is found (e.g., id="allcheckin")
    $showCheckout = false;
}


?>

<!DOCTYPE html> 
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มห้องว่าง</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="checkroom.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <form method="post" action="data.php" id="checkRoomForm">
        <div id="codenamehide" style="display: none;">
            <p><label class="codename">User_Code</label></p>
            <select class="inputcodename" name="selectedCode" >
            <optgroup label="code">
            <?php
            if ($datacus_code->num_rows > 0) {
                
                while ($row = $datacus_code->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        echo '<option value="' . $value . '">' . $value . '</option>';
                    }
                }
            } else {
                echo '<option value="" disabled selected>ไม่มีลูกค้า</option>'; // เพิ่มตัวเลือก placeholder และทำให้เลือกไม่ได้
            }
            ?>
            </optgroup>
            </select>
        </div>
            </p>
            <p><label class="Typeroom">Code Room</label></p>
            <input type="text" name="roomnumber" value="<?php echo $roomNumber; ?>" readonly>
            <div id="allcheckin" style="display: none;">
                <p class="DataCheckIn"><label>Check In</label></p>
            <p><?php date_default_timezone_set('Asia/Bangkok');
                    $currentDate = date("Y-m-d H:i:s"); // Format as YYYY-MM-DD HH:MM:SS
                    echo "Current Date: " . $currentDate;
                ?>
                <input type="hidden" name="Checkin" value="<?php date_default_timezone_set('Asia/Bangkok');
                    $currentDate = date("Y-m-d H:i:s");
                    echo $currentDate;
                ?>">
            </p>
            </div>
        <div id="allcheckout" style="display: none;">
            <input type="hidden" name="CheckOut" value="<?php date_default_timezone_set('Asia/Bangkok');
            $currentDatenow = date("Y-m-d"); echo $currentDatenow. " ". "12:00:00" ?>">
            <p class="DataCheckout"><label>Check Out Now</label></p>
            <input class="checkbox" id="check" type="checkbox" name="CheckOut" value="<?php
            $currentDate = date("Y-m-d"); // Format as YYYY-MM-DD
            $currentTime = date("H:i:s"); // Format as HH:MM:SS
            echo $currentDate. " ".$currentTime;?>">
            <div id="AllAmount" style="display: none;">
                <p><label class="textAmount">Amount</label></p>
                <p><input type="text" id="AmountField" class="inputAmount" name="Amount" placeholder="Money"></p>
            </div>
            <div id="extensionadd" style="display: none;">
            <p><label class="textExtension">Extension</label></p>
            <p><textarea class="inputextension" name="Extension" rows="4" cols="35" placeholder="extension"></textarea>
            </p>
            </div>
            <div id="extensionshow" style="display: none;">
            <p><label class="textExtension">Extension</label></p>
            <p><textarea class="inputextension" name="Extensionex"  rows="4" cols="35" readonly><?php echo $extension['additional'] ?></textarea>
            </p>
            </div>
            <input type="hidden" name="checkupdate" value="no">
            <?php

            if ($showCheckout) {
                echo '<input type="hidden" name="action" value="checkout">';
                
            } else {
                echo '<input type="hidden" name="action" value="checkin">';
                
            }
            ?>

            
        </div>

    <button type="submit" class="btn btn-dark">Submit</button>
    
</form>
</div>
        
<script>
    document.getElementById("extensionadd").style.display = "block";
    document.getElementById("extensionshow").style.display = "none";

    document.addEventListener("DOMContentLoaded", function() {
    // เมื่อค่าของ checkbox เปลี่ยนแปลง
    document.getElementById("check").addEventListener("change", function() {
        // หาก checkbox ถูกเลือก (checked)
        if (this.checked) {
            // แสดง div ที่มี id="AllAmount" เพื่อแสดงฟิลด์ "Amount"
            document.getElementById("AllAmount").style.display = "block";
            document.getElementById("extensionshow").style.display = "block";
            document.getElementById("extensionadd").style.display = "none";
            
            // Checkbox ถูกเลือก
        // สร้าง XMLHttpRequest object
        var inputElement = document.createElement("input");

        // Set attributes for the input element
        inputElement.setAttribute("type", "hidden"); // Set the input type to text
        inputElement.setAttribute("name", "checkupdate"); // Set the name attribute
        inputElement.setAttribute("value", "yes"); // Set the default value

        // Get a reference to the form by its ID (change "myForm" to your form's ID)
        var form = document.getElementById("checkRoomForm");

        // Append the input element to the form
        form.appendChild(inputElement);    

        } else {
            // ถ้า checkbox ไม่ถูกเลือก (unchecked) ซ่อน div ที่มี id="AllAmount" เพื่อซ่อนฟิลด์ "Amount"
            document.getElementById("AllAmount").style.display = "none";
            document.getElementById("extensionshow").style.display = "none";
            document.getElementById("extensionadd").style.display = "block";
            var inputElement = document.createElement("input");

            // Set attributes for the input element
            inputElement.setAttribute("type", "hidden"); // Set the input type to text
            inputElement.setAttribute("name", "checkupdate"); // Set the name attribute
            inputElement.setAttribute("value", "no"); // Set the default value

            // Get a reference to the form by its ID (change "myForm" to your form's ID)
            var form = document.getElementById("checkRoomForm");

            // Append the input element to the form
            form.appendChild(inputElement);  
        }
    });

    // Initially hide both sections
    document.getElementById("allcheckin").style.display = "none";
    document.getElementById("allcheckout").style.display = "none";
    document.getElementById("codenamehide").style.display = "none";
    
    // Show the appropriate section based on the PHP condition
    <?php
if ($showCheckout) {
    echo 'document.getElementById("allcheckout").style.display = "block";';
}else {
        echo 'document.getElementById("allcheckin").style.display = "block";';
        echo 'document.getElementById("codenamehide").style.display = "block";';
    }
    ?>
});
</script>



</body>
</html>