<?php
 require_once '../library/config.php';
function importCSVToMySQL($filePath, $tableName) {
    $file = fopen($filePath, 'r');
    if ($file === false) {
        die("Error opening file");
    }
    
    $rowCount = 0;
    $insertStatements = [];
    
    $num = "";
    $name = "";
    while (($data = fgetcsv($file)) !== false) {
        $rowCount++;
        echo $data[0] . " - ";
        // $insertStatements[] = "INSERT INTO $tableName VALUES ($values);";
		$sql = "INSERT INTO $tableName( stu_name , stu_name_en , stu_mobile1  ) 
        VALUES (  '$data[0]', '$data[1]' , '$data[2]' );";
		$result = dbQuery_PDO_no($sql);	
    }
    
    fclose($file);
    
    //echo $insertStatements[2];
}

importCSVToMySQL("g://t//study.csv" , "study_outside" );
?>