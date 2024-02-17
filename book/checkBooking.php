<?php
    class CheckBooking{
        private $conn;
        private $checkin;
        private $checkout;
        private $people;
        private $type;
        private $pay;
        private $codeCus;
        private $night;
        
        public function __construct($conn,$checkin, $checkout, $people, $type, $codeCus){
            $this->conn = $conn;
            $this->checkin = $checkin;
            $this->checkout = $checkout;
            $this->people = $people;
            $this->type = $type;
            $this->codeCus = $codeCus;
            $this->pay = 0;
            $this->night = floor((strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24));
        }

        public function checkTable(){
            $today = date("Y-m-d 23:59:59", strtotime($this->checkin.'-1 day'));
            $today2 = date("Y-m-d 00:00:01", strtotime($this->checkin));
            $newCheckout = date("Y-m-d 23:59:59", strtotime($this->checkout));
            $newCheckout2 = date("Y-m-d 23:59:59", strtotime($this->checkout.'-1 day'));
            $sql = "SELECT *
                    FROM Booking
                    WHERE ((sDay BETWEEN '$today' AND '$newCheckout2') OR (OutDay BETWEEN '$today2' AND '$newCheckout') OR (sDay <= '$today' AND OutDay >= '$newCheckout2')) AND (TypeRoom Like '$this->type');";
            $result = mysqli_query($this->conn->getDatabase(), $sql);
            $arrayCount = array();

            while($bookRow = $result->fetch_assoc()){
                $order = 0;
                $chin = $bookRow["sDay"];
                $chout = $bookRow["OutDay"];
                for($i = strtotime($this->checkin); $i < strtotime($this->checkout);$i+=(60 * 60 * 24)){
                    if (!isset($arrayCount[$order])) {
                        $arrayCount[$order] = 0;
                    }
                    if($i >= strtotime($chin) && $i < strtotime($chout)){
                        $arrayCount[$order] = $arrayCount[$order]+1;
                    }
                    $order++;
                }
            }
            if(count($arrayCount)){
                $maxNumber = max($arrayCount);
            }else{
                $maxNumber = 0;
            }
            switch($this->type){
                case "Deluxe Double Room":
                    if($maxNumber  >= 20){
                        return 1;//ไม่ให้จอง
                    }else{
                        $this->pay = 5000*$this->night;
                    }break;
                case "Deluxe Twin Room":
                    if($maxNumber >= 10){
                        return 1;//ไม่ให้จอง
                    }else{
                        $this->pay = 5000*$this->night;
                    }break;
                case "Pool Villa":
                    if($maxNumber >= 5){
                        return 1;//ไม่ให้จอง
                    }else{
                        $this->pay = 10000*$this->night;
                    }break;
                case "Seminar":
                    if($maxNumber >= 2){
                        return 1;//ไม่ให้จอง
                    }else{
                        $this->pay = 50000*($this->night);
                    }break;
                case "Ballroom":
                    if($maxNumber >= 1){
                        return 1;//ไม่ให้จอง
                    }else{
                        $this->pay = 250000*($this->night);
                    }break;
            }
        }
        public function createCommand(){
            
            $sql1 = "SELECT Code_Cus FROM Account WHERE Username LIKE '".$this->codeCus."';";
            $code1 = mysqli_query($this->conn->getDatabase(), $sql1);
            $sql2 = "SELECT max(`Order`) FROM Booking;";
            $code2 = mysqli_query($this->conn->getDatabase(), $sql2);
            $order = $code2->fetch_assoc();
            $sql3 = "INSERT INTO Booking(`Order`, Code_Cus, sDay, OutDay, Guests, Pay, TypeRoom, NumCard) 
            VALUES (".($order['max(`Order`)']+1).", ".(mysqli_fetch_assoc($code1)['Code_Cus']).", 
            '$this->checkin', '$this->checkout', $this->people, %d, '$this->type', '%s');";

            return $sql3;
        }

        public function getConn(){
            return $this->conn;
        }
        public function getCheckin(){
            return $this->checkin;
        }
        public function getCheckout(){
            return $this->checkout;
        }
        public function getPeople(){
            return $this->people;
        }
        public function getPay(){
            return $this->pay;
        }
        public function getCodeCus(){
            return $this->codeCus;
        }
        public function getType(){
            return $this->type;
        }
        public function getNight(){
            return $this->night;
        }
    }
?>