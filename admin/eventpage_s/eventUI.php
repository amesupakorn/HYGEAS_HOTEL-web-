
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'><link rel="stylesheet" href="./style.css">
    <input type="checkbox" id="openSideMenu" class="openSideMenu">
    <label for="openSideMenu" class="menuIconToggle">
    <div class="hamb-line dia part-1"></div>
    <div class="hamb-line hor"></div>
    <div class="hamb-line dia part-2"></div>
</label>
<nav>
  <ul>
    <li><a href="../homeadmin.php">DashBoard</a></li>
    <li><a href="../eventpage_s/eventUI.php">Create Event</a></li>
    <li><a href="../Event/event.php">Manage Event</a></li>
    <li><a href="../booked.php">Manage Rooms</a></li>
    <li><a href="../booking/booking.php">Manage Booking</a></li>
    <li><a href="../Cancel/cancel.php">History Cancel</a></li>
    <li><a href="../history.php">History Customer</a></li>
  </ul>
</nav>
</head>
<body>
<?php
        session_start();
        include('../connectToDatabase.php');
        $conn = new database();

        if(isset($_POST["save"])){
            $eCode = $_POST['ecode'];
            $eName = $_POST['ename'];
            $eStart = date('Y-m-d', strtotime($_POST['estart']));
            $eStop = date('Y-m-d', strtotime($_POST['estop']));
            $eDis = $_POST['edis'];
            $eGuests = $_POST['eguests'];
            $eMin = $_POST['emin'];
            $eFor = $_POST['estatus'];
            $eChoice = $_POST['echoice'];
            $eDes = $_POST['edes'];
            $eTypeRoom = $_POST['etyperoom'];


            $file = $_FILES['file'];
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];
        
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
        
            $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        
            if(in_array($fileActualExt, $allowed)){
                if($fileError === 0){
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'uploads/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                }else{
                    echo "error upload";
                }
            } else{
                echo "You cannot upload files.";


                
            }


            $conn->addRow("Event", "('$eCode', '$eName', '$eStart', '$eStop', '$eDis', '$eChoice', '$eGuests', '$eFor', '$eDes', '$fileNameNew', '$eMin', '$eTypeRoom')");

                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>"';
                echo "<script>";
                echo "Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Create Success',
                    showConfirmButton: false,
                    timer: 1500
                  })";
                echo "</script>";
                
              }
          
    ?>
    
<div id="div_form" class="tab_content">
  <form method="post" enctype="multipart/form-data">
    <div class="container">
      <div class="well clearfix">
        <fieldset class="well well-form">
          <legend class="well-legend">Event Times</legend>
          <div class="row">
            <div class="col-xs-2">
              <label class="control-label" for="ecode">Promotion Code</label>
              <input class="form-control" type="text" name="ecode" placeholder="Promotion code" required/>
            </div>

            <div class="col-xs-4">
              <label class="control-label" for="estart">Start Date</label>
              <div class="form-group input-group">
                <span class="input-group-addon "><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="date" name="estart" min="<?php echo date('Y-m-d');?>"required>
              </div>
            </div>

            <div class="col-xs-4">
              <label class="control-label" for="estop">End date</label>
              <div class="form-group input-group">
                <span class="input-group-addon "><i class="fa fa-calendar-check-o"></i></span>
                <input class="form-control" type="date" name="estop" min="<?php echo date('Y-m-d');?>"required>
              </div>
            </div>

		  </select>
          </div>
          <!-- end Row -->
        </fieldset>


        <fieldset class="well well-form">
          <legend class="well-legend">Event Details</legend>
          <div class="row">
            <div class="col-xs-5">

              <label class="control-label" for="edis">Discount&nbsp;(</label>
              <input type="radio" id="percent" name="echoice" value="percent" required>
              <label for="%">%</label>
              <input type="radio" id="thb" name="echoice" value="thb" required>
              <label for="฿">฿)</label>
                <input type="number" class="form-control" name="edis" placeholder="Discount" required>

              <label class="control-label" for="emin">Minimum Price</label>
                <input type="number" class="form-control" name="emin" placeholder="Price" required>

                <label class="control-label" for="eguests">Guests</label>
                <input type="number" class="form-control" name="eguests" placeholder="Number of guests" required>

              <label class="control-label" for="etyperoom">Rooms Type</label>
              <select class="form-control" name="etyperoom">
                <option value="" >Please Select</option>dsf
                <option value="Deluxe Double Room, Deluxe Twin Room, Pool villa" required>Deluxe Double Room, Deluxe Twin Room, Pool villa</option>
                <option value="Ballroom, Seminar" required>Ballroom, Seminar</option>
                <option value="ALL" required>ALL</option>
              </select>

              <div class="usertype" ><br>User Type</div>
                <input type="radio" id="new" name="estatus" value="new" required>
                <label for="new">New User&nbsp;&nbsp;&nbsp;&nbsp;</label>
          
                <input type="radio" id="old" name="estatus" value="old" required>
                <label for="old">Old User&nbsp;&nbsp;&nbsp;&nbsp;</label>
          
                <input type="radio" id="all" name="estatus" value="all" required>
                <label for="all">All User&nbsp;&nbsp;&nbsp;&nbsp;</label>

              
            </div>
            
            <div class="col-xs-7">
                <label class="control-label" for="ename">Event Name</label>
                <input class="form-control" type="text" name="ename" placeholder="Name" required/>

              <label class="control-label">Description</label>
              <textarea class="input-xlarge form-control" id="message" name="edes" rows="10" required></textarea>

            <label class="control-label" for="eimage"><b>Image</b></label>
                <input type="file" name="file" accept=".jpg, .jpeg, .png" required>

            
            </div> 

          </div>

        </fieldset>


        <div class="row">
          <div class="col-xs-12">
            <br/>
            <button class="btn btn-success " type="submit" value="Save" name="save"><i class="fa fa-pencil"></i> Save</button>
            <button class="btn btn-danger " type="submit" value="Discard" name="discard"><i class="fa fa-send"></i> Discard</button>
            <button class="btn btn-info pull-right" type="submit"><i class="fa fa-refresh"></i> Reload calendars</button>
          </div>
        </div>


      </div>

    </div>

  </form>
    <link rel="stylesheet" href="style.css">
    <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js'></script>
</body>
</html>
