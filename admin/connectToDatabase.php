<?php
class database{
    private $server_name = '161.246.127.24';
    private $user = 'rootHotel';
    private $password = 'Aa1234Jam';
    private $port = '9022';
    private $database_name = 'Hotel';

    private $database = "";

    public function __construct()//constructor
    {
        $this->database = new mysqli($this->server_name, $this->user, $this->password, $this->database_name, $this->port);

        if ($this->database->connect_error) {
            die("Connection failed: " . $this->database->connect_error);
        }
    }

    public function executeQuery($table, $select = "*", $join = null, $where = null, $order = null, $limit = null) {
        

        if ($this->tableExist($table)) {
            $sql = "SELECT $select FROM $table";
            if ($join != null) {
                $sql .= " JOIN $join";
            }
            if ($where != null) {
                $sql .= " WHERE $where";
            }
            if ($order != null) {
                $sql .= " ORDER BY $order";
            }
            if ($limit != null) {
                $sql .= " LIMIT $limit";
            }
            $query = mysqli_query($this->database, $sql);
            if ($query) {
                return $query;//ส่งผลลัพธ์กลับไปแบบใช้ชื่อคอลัมเป็นkey ใช้ foreach ในการแสดงผลลัพธ์ทีละrow *(หมายถึงผู้รับ)
                //ดีกว่าใช้while แสดงออกมาทันที
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function tableExist($table)
    {
        $sql = "SHOW TABLES FROM $this->database_name LIKE '{$table}'";
        $tableInDb = $this->database->query($sql);
        if ($tableInDb) {
            if ($tableInDb->num_rows  == 1) {
                return true;
            } else {
                array_push($this->database, $table . " Does not Exist");
            }
        } else {
            return false;
        }
    }

    public function addColumn($tableName, $columnName, $columnType) {
        $sql = "ALTER TABLE $tableName ADD COLUMN $columnName $columnType";

        if ($this->database->query($sql) === TRUE) {
            return "เพิ่มคอลัมน์ $columnName สำเร็จ";
        } else {
            return "เกิดข้อผิดพลาดในการเพิ่มคอลัมน์: " . $this->database->error;
        }
    }

    public function removeColumn($tableName, $columnName) {
        $sql = "ALTER TABLE $tableName DROP COLUMN $columnName";

        if ($this->database->query($sql) === TRUE) {
            return "ลบคอลัมน์ $columnName สำเร็จ";
        } else {
            return "เกิดข้อผิดพลาดในการลบคอลัมน์: " . $this->database->error;
        }
    }

    public function closeConnection() {
        if ($this->database) {
            $this->database->close();
        }
    }
    
    public function addRow($table, $value){
        $sql = "INSERT INTO ".$table." VALUES ".$value;
    }

    public function getDatabase(){
        return $this->database;
        
    }
}

?>
