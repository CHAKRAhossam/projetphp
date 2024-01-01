<?php 
class categorie {
    public $category_id;
    public $category_name;
 
        public static function selectAllCategories ($tableName, $conn){
        $sql = "SELECT  category_id, category_name FROM $tableName";
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