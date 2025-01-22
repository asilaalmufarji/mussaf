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
		$sql = "INSERT INTO $tableName( med_name , med_name_en , med_mobile1, med_mobile2 , med_mail, med_website ) 
        VALUES (  '$data[0]', '$data[1]' , '$data[2]', '$data[3]' , '$data[4]' , '$data[5]' );";
		$result = dbQuery_PDO_no($sql);	
    }
    
    fclose($file);
    
    //echo $insertStatements[2];
}

importCSVToMySQL("g://t//med.csv" , "medical" );
?>