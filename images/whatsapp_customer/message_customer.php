<?php 
require_once '../../library/config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
<title>message customer</title>
</head>

<body>
<?php
if(isset($_GET["cus_id"]))
{
$sql_sel = "select * from mes_cus_whats where cus_id = " . $_GET["cus_id"];
	$result_sel = dbQuery_PDO_no($sql_sel);
	$str = '';
	if($result_sel->rowCount() >0)
	{	
		
		while($row = $result_sel->fetch(PDO::FETCH_ASSOC)) 
		{
			extract($row);
			$str .= $mes_regdate. " &nbsp; " . " WhatsApp";
            $str .= "<br>";
            $str .= $mes_content;
            $str .= "<br>";
            $str .= "------------------------------------------------------------------------";
            $str .= "<br>";
		}
	}
	echo  $str;
}
    ?>
</body>
</html>
