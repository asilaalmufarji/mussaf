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
		$sql = "INSERT INTO $tableName( hea_name , hea_name_en , hea_mobile1 , hea_mobile2 , hea_mail , hea_loc ) 
        VALUES (  '$data[0]', '$data[1]' , '$data[2]', '$data[3]' , '$data[4]', '$data[5]' );";
		$result = dbQuery_PDO_no($sql);	
    }
    
    fclose($file);
    
    //echo $insertStatements[2];
}

importCSVToMySQL("g://t//hea.csv" , "health_care" );
?>