<?php
require_once '../library/config.php';
$action = isset($_POST['action']) ? $_POST['action'] : '';

//$det_id = isset($_POST['det_id']) ? $_POST['det_id'] : '';
 switch ($action) {
	
	case 'checklogin':
			checklogin();
		break;		
		

	default :
	    // if action is not defined or unknown
		// move to main Customer page
		header('Location: ../index.php');
}



function checklogin()
{
$add_array = array();
	if (isset($_POST['emp_name']) && isset($_POST['emp_pwd'])  ) {		
		$emp_name = ares($_POST['emp_name']);
		$emp_pwd = ares($_POST['emp_pwd']);
	
		//===================mobile
		array_push($add_array , utf8_decode($emp_name));
		//=======================
		array_push($add_array , utf8_decode($emp_pwd));
	} else {
		//header('Location: ../index.php');
	}
	

	
	// check if the product is already
	// in sendlist table for this session
	$sql = "SELECT *
	        FROM employee
			WHERE emp_name = ?  and emp_pwd = ? ";
	$result = dbQuery_PDO($sql , $add_array);
	
	//$result = dbQuery_PDO_no("select * from admin_inplass limit 0,1");
	
		if($result->rowCount() == 0)
	{	
	
				$result = array("result"=>"failure","message"=>"Password incorrect");
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
				exit;

				} else {
										
						
							while($row = $result->fetch(PDO::FETCH_ASSOC)) 
							{

								extract($row);
								$r_json[] = $row;
								 $_SESSION['emp_id'] = $emp_id;
								 $_SESSION['emp_name'] = $emp_name;		
								//setcookie("adm_id", $adm_id , time() + (86400 * 30 *  86400), "/");
								
							}	

							
						}
						

 $result = array("result"=>"success","message"=>$r_json); 
	 echo json_encode($result , JSON_UNESCAPED_UNICODE);

}
?>
