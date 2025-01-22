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
		$sql = "INSERT INTO $tableName( ins_name , ins_name_en , ins_mobile1, ins_mobile2 , ins_mail, ins_loc ) 
        VALUES (  '$data[0]', '$data[1]' , '$data[2]', '$data[3]' , '$data[4]' , '$data[5]' );";
		$result = dbQuery_PDO_no($sql);	
    }
    
    fclose($file);
    
    //echo $insertStatements[2];
}

importCSVToMySQL("g://t//insur.csv" , "insurance" );
?>