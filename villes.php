<?php 
class villes {
    public $ville_id;
    public $ville_name;
        public static function selectAllcities ($tableName, $conn){
        $sql = "SELECT  ville_id, ville_name FROM $tableName";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $data = []; 
        while ($row = mysqli_fetch_assoc($result)) {
        $data [ ] = $row;
        }
        return $data;
    } 
}
}

?>