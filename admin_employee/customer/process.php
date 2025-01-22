<?php
require_once '../../library/config.php';
/*********************************************************
 *                 SHOPPING sendlist FUNCTIONS 
 *********************************************************/
$action = isset($_POST['action']) ? $_POST['action'] : '';

//$det_id = isset($_POST['det_id']) ? $_POST['det_id'] : '';
switch ($action) {

	case 'add':
		add();
		break;
	case 'edit':
		edit();
		break;

	case 'update_active':
		update_active();
		break;
	case 'delimage':
		delimage();
		break;

	case 'delete':
		delete();
		break;

	case 'listcustomer':
		listcustomer();
		break;

	case 'getdata_byid':
		getdata_byid();
		break;
		case 'getservice':
		getservice();
		break;
	case 'getgov':
		getgov();
		break;
		case 'getreg':
		getreg();
		break;
		case 'getwil':
		getwil();
		break;
	default:
		// if action is not defined or unknown
		// move to main Customer page

		//		header('Location: ../index.php');
}



function getdata_byid()
{
	$r_json = array();
	$r_data = array();
	if (isset($_POST['cus_id']) && is_numeric($_POST['cus_id'])) {
	} else {
		echo 'start not correct';
		exit();
	}
	$sql_sel = "select * from customer where cus_id = " . $_POST['cus_id'];
	$result_sel = dbQuery_PDO_no($sql_sel);
	$str = '';
	if ($result_sel->rowCount() > 0) {
		while ($row = $result_sel->fetch(PDO::FETCH_ASSOC)) {

			extract($row);


			$r_json[] = $row;
		}
	}
	$result = array("result" => "success", "message" => $r_json);
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit();
}

function getservice()
{
	$sql_sel = "select * from service ";
	$result_sel = dbQuery_PDO_no($sql_sel);
	$str = '';
	if ($result_sel->rowCount() > 0) {
		while ($row = $result_sel->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
			$r_json[] = $row;
		}
	}
	echo json_encode($r_json);	
}
function getgov()
{
	$sql_sel = "select * from governate order by gov_name";
	$result_sel = dbQuery_PDO_no($sql_sel);
	$str = '';
	if ($result_sel->rowCount() > 0) {
		while ($row = $result_sel->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
			$r_json[] = $row;
		}
	}
	echo json_encode($r_json);	
}

function getwil()
{
	if(isset($_POST["gov_id"]) && is_numeric($_POST["gov_id"]))
	{
		$gov_id =  $_POST["gov_id"];		
	}
	else
	{
		echo "";
	}
	$sql_sel = "select * from wilayat where gov_id = $gov_id order by wil_name";
	$result_sel = dbQuery_PDO_no($sql_sel);
	$str = '';
	if ($result_sel->rowCount() > 0) {
		while ($row = $result_sel->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
			$r_json[] = $row;
		}
	}
	echo json_encode($r_json);	
}

function getreg()
{
	if(isset($_POST["wil_id"]) && is_numeric($_POST["wil_id"]))
	{
		$wil_id =  $_POST["wil_id"];		
	}
	else
	{
		echo "";
	}
	$sql_sel = "select * from region where wil_id = $wil_id order by reg_name";
	$result_sel = dbQuery_PDO_no($sql_sel);
	$str = '';
	if ($result_sel->rowCount() > 0) {
		while ($row = $result_sel->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
			$r_json[] = $row;
		}
	}
	echo json_encode($r_json);	
}


function add()
{

	$add_array = array();

	if (
		isset($_POST['txtcus_name']) && $_POST['txtcus_name'] != ""
		&& isset($_POST['txtcus_name_en']) && $_POST['txtcus_name_en'] != ""
	) {

		$cus_name = ares($_POST['txtcus_name']);
		$cus_name_en = ares($_POST['txtcus_name_en']);

		$cus_mobile2 = ares($_POST['txtcus_mobile2']);
		$cus_mobile1 = ares($_POST['txtcus_mobile1']);

		$cus_mail = ares($_POST['txtcus_mail']);
		$cus_website = ares($_POST['txtcus_website']);

		$ser_id = ares($_POST['cmbser_id']);
		$gov_id = ares($_POST['cmbgov_id']);

		$wil_id = ares($_POST['cmbwil_id']);
		$reg_id = ares($_POST['cmbreg_id']);
/*
		$dat_id = ares($_POST['cmbdat_id']);*/
		$cus_loc = ares($_POST['txtcus_loc']);
		$emp_id = $_SESSION['emp_id'];

		

		$images = uploadCustomerImage("fileadd", '../../images/customer/', 400, 600);
		$cus_image = $images['image'];
		$cus_thumbnail  = $images['thumbnail'];

				
			$cus_file = uploadFile( "file", '../../file/customer/');
		$cus_file1 = uploadFile( "file1", '../../file/customer/');
		$cus_file2 = uploadFile( "file2", '../../file/customer/');
		
/*
		$imageshover = uploadCustomerImage("fileaddhover", '../../images/customer/', 400, 600);
		$cus_image_hover = $imageshover['image'];
		$cus_thumbnail_hover  = $imageshover['thumbnail'];*/

		array_push($add_array, $cus_name);
		array_push($add_array, $cus_name_en);
		array_push($add_array, $cus_mobile2);
		array_push($add_array, $cus_mobile1);
		array_push($add_array, $cus_mail);

		array_push($add_array, $cus_website);
		array_push($add_array, $ser_id);
		array_push($add_array, $gov_id);
		array_push($add_array, $wil_id);
		array_push($add_array, $reg_id);
		
		array_push($add_array, $cus_loc);
		array_push($add_array, $emp_id);
		array_push($add_array, $cus_file);
		array_push($add_array, $cus_file1);
		array_push($add_array, $cus_file2);
		array_push($add_array, $cus_image);
		array_push($add_array, $cus_thumbnail);

	} else {
		header('Location: ../index.php');
	}




	$sql_add = " insert into customer(
	cus_name,cus_name_en,cus_mobile2,cus_mobile1,cus_mail,
	cus_website,ser_id,gov_id,wil_id,reg_id,
	cus_loc,emp_id,cus_file,cus_file1,cus_file2,cus_thumbnail,cus_image
	,cus_regdate) ";
	$sql_add .= " value(?,?,?,?,?
	,?,?,?,?,?
	,?,?,?,?,?
	,?,?
	,now())";
	$result_mod = dbQuery_PDO($sql_add, $add_array);

	echo 'save success';
	exit();
}

function edit()
{

	$add_array = array();
	$isfile = false;
	$isfilepdf = false;
	$isfilepdf1 = false;
	$isfilepdf2 = false;
	$str = $isfile1 . $isfile;
	if (
		isset($_POST['hfcus_id']) && $_POST['hfcus_id'] != ""
	) {

		$cus_id = ares($_POST['hfcus_id']);
			$cus_name = ares($_POST['txtcus_name']);
		$cus_name_en = ares($_POST['txtcus_name_en']);

		$cus_mobile2 = ares($_POST['txtcus_mobile2']);
		$cus_mobile1 = ares($_POST['txtcus_mobile1']);

		$cus_mail = ares($_POST['txtcus_mail']);
		$cus_website = ares($_POST['txtcus_website']);

		$ser_id = ares($_POST['cmbser_id']);
		$gov_id = ares($_POST['cmbgov_id']);

		$wil_id = ares($_POST['cmbwil_id']);
		$reg_id = ares($_POST['cmbreg_id']);

		$dat_id = ares($_POST['cmbdat_id']);
		$cus_loc = ares($_POST['cmbcus_loc']);


		if (!($_FILES['fileadd']['size'] == 0)) {
			$isfile = true;
			$images = uploadCustomerImage("fileadd", '../../images/customer/', 400, 600);
			$cus_image = $images['image'];
			$cus_thumbnail  = $images['thumbnail'];
		}
		if (!($_FILES['file']['size'] == 0)) {
			$isfilepdf = true;
			$cus_file = uploadFile( "file", '../../file/customer/');
		}
		if (!($_FILES['file1']['size'] == 0)) {
			$isfilepdf1 = true;
			$cus_file1 = uploadFile( "file1", '../../file/customer/');
		}
		if (!($_FILES['file2']['size'] == 0)) {
			$isfilepdf2 = true;
			$cus_file2 = uploadFile( "file2", '../../file/customer/');
		}


		

	  array_push($add_array, $cus_name);
		array_push($add_array, $cus_name_en);
		array_push($add_array, $cus_mobile2);
		array_push($add_array, $cus_mobile1);
		array_push($add_array, $cus_mail);
		array_push($add_array, $cus_website);
		array_push($add_array, $ser_id);
		array_push($add_array, $gov_id);
		array_push($add_array, $wil_id);
		array_push($add_array, $reg_id);
		array_push($add_array, $dat_id);
		array_push($add_array, $cus_loc);		

		

		if ($isfile) {
			array_push($add_array, $cus_image);
			array_push($add_array, $cus_thumbnail);
		}
		if ($isfilepdf) {
			array_push($add_array, $cus_file);
			
		}
		if ($isfilepdf1) {
			array_push($add_array, $cus_file1);
			
		}
		if ($isfilepdf2) {
			array_push($add_array, $cus_file2);
			
		}
	
		array_push($add_array, $cus_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update customer set cus_name = ? , cus_name_en = ? 
	 " . ", cus_mobile2 = ? , cus_mobile1 = ?"
	  . ", cus_mail = ? , cus_website = ?"
	  . ", ser_id = ? , gov_id = ?"
	  . ", wil_id = ? , reg_id = ?"
	  . ", dat_id = ? , cus_loc = ?"
	  . ($isfile == true ? ",  cus_image = ? , cus_thumbnail = ?" : "")
	   . ($isfilepdf == true ? ",  cus_file = ? " : "")
	   . ($isfilepdf1 == true ? ",  cus_file1 = ? " : "")
	   . ($isfilepdf2 == true ? ",  cus_file2 = ? " : "")
		;
	$sql_add .= " where cus_id = ?";
	//echo $isfile . $isfile1.  $_FILES['fileaddhover']['size'] ."before:".$str . "----" . $sql_add ;
	$result_mod = dbQuery_PDO($sql_add, $add_array);


	//			update_trans($cat_name , "" , "2" ,$cat_id );
	echo 'Modified Success';
	exit();
}

function delete()
{

	$add_array = array();

	if (
		isset($_POST['cus_id']) && $_POST['cus_id'] != ""
	) {
		$cus_id = ares($_POST['cus_id']);



		array_push($add_array, $cus_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " delete from customer where cus_id = ? ";
	$result_mod = dbQuery_PDO($sql_add, $add_array);
	echo 'Success deleted';
	exit();
}

//==================================
function update_active()
{

	$add_array = array();

	if (isset($_POST['cus_active']) && isset($_POST['cus_id'])) {

		$cus_id = ares($_POST['cus_id']);
		$cus_active = ares($_POST['cus_active']);



		array_push($add_array, ($cus_active == "on" ? "off" : "on"));
		array_push($add_array, $cus_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update customer set cus_active = ? ";
	$sql_add .= " where cus_id = ?";
	$result_mod = dbQuery_PDO($sql_add, $add_array);


	echo 'Modified Success';
	exit();
}

function delimage()
{

	$add_array = array();

	if (
		isset($_POST['col1'])
		&& isset($_POST['col2'])
		&& isset($_POST['cus_id'])
	) {

		$cus_id = ares($_POST['cus_id']);
		$col1 = ares($_POST['col1']);
		$col2 = ares($_POST['col2']);




		array_push($add_array, $cus_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update customer set $col1 = NULL , $col2 = NULL ";
	$sql_add .= " where cus_id = ?";
	$result_mod = dbQuery_PDO($sql_add, $add_array);


	echo 'Modified Success';
	exit();
}


function listcustomer()
{
	/*
	 , (select gov_name from governate where gov_id = customer.gov_id)  as gov_name 
	 , (select wil_name from wilayat where wil_id = customer.wil_id)  as wil_name 
	 , (select reg_name from region where reg_id = customer.reg_id)  as reg_name 
   
	*/
	$sqlQuery = "SELECT *
  
	 FROM customer left join governate on
 	 governate.gov_id = customer.gov_id
 	 left join wilayat on
 	  wilayat.wil_id = customer.wil_id
 	  left join region on
 	 region.reg_id = customer.reg_id
	  where emp_id = " . $_SESSION['emp_id'] . " and 1=1 ";
	if (!empty($_POST["search"]["value"])) {
		$sqlQuery .= ' and (cus_id LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR cus_name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR gov_name LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR wil_name LIKE "%' . $_POST["search"]["value"] . '%" ';
					$sqlQuery .= ' OR reg_name LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR cus_name_en LIKE "%' . $_POST["search"]["value"] . '%" ) ';
	}

	if (!empty($_POST["order"])) {
		$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
	} else {
		$sqlQuery .= 'ORDER BY cus_id DESC ';
	}

	if ($_POST["length"] != -1) {
		$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}
	//	global $conn;

	$result = dbQuery($sqlQuery);




	$allResult = dbQuery("SELECT * FROM customer where emp_id= " . $_SESSION['emp_id'] );

	$allRecords = $allResult->rowCount();

	$displayRecords = $result->rowCount();
	$records = array();
	while ($record = $result->fetch(PDO::FETCH_ASSOC)) {
		$rows = array();
		$rows[] = "";
		$rows[] = $record['cus_id'];
		$rows[] = $record['cus_name'] . '<br> ' . $record['cus_name_en'];
		$rows[] =  $record['gov_name'] . '<br>' . $record['wil_name']. ' - ' . $record['reg_name'];




		//	$rows[] = ''; // '<img  src = "https://cdn-icons-png.flaticon.com/512/744/744465.png" width ="50px">';
		/*$rows[] = '<button type="button" name="update" id="' . $record["cus_id"] . '" onclick ="edit_show(' . $record["cus_id"] . ' )" class="btn btn-warning btn-xs update ">Update</button>';
		$rows[] = '<button type="button" name="delete" id="' . $record["cus_id"] . '" onclick = "del(' . $record["cus_id"] . '  , 1)" class="btn btn-danger btn-xs delete" >Delete</button>';
*/

		$rows[] = '<span class="bi bi-pencil" name="update" id="' . $record["cus_id"] . '" onclick ="edit_show(' . $record["cus_id"] . ' )" ></span>';
		$rows[] = '<span class="bi bi-trash"  name="delete" id="' . $record["cus_id"] . '" onclick = "del(' . $record["cus_id"] . '  , 1)"></span>';

		$records[] = $rows;
	}

	$output = array(
		"draw"	=> 	intval($_POST["draw"]),
		"iTotalRecords"	=> 	$displayRecords,
		"iTotalDisplayRecords"	=>  $allRecords,
		"data"	=> 	$records
	);

	echo json_encode($output);
}

function uploadFile($myFill , $path){
  $targetDirectory = $path;//'../../file/insurance/'; // Specify the directory where you want to save the uploaded files

  // Check if the file was uploaded without any errors
  if (isset($_FILES[$myFill]) && $_FILES[$myFill]['error'] === UPLOAD_ERR_OK) {
    $originalFileName = $_FILES[$myFill]['name'];
    $temporaryFilePath = $_FILES[$myFill]['tmp_name'];

    // Get the MIME type of the uploaded file
    $fileType = mime_content_type($temporaryFilePath);

    // Check if the uploaded file is a PDF or Word document
    if ($fileType === 'application/pdf' || $fileType === 'application/msword' || $fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
      // Generate a unique filename to avoid conflicts
      $newFileName = uniqid() . '_' . $originalFileName;

      // Specify the destination path where the file will be saved
      $destinationPath = $targetDirectory . $newFileName;

      // Move the uploaded file to the destination directory
      if (move_uploaded_file($temporaryFilePath, $destinationPath)) {
        // File was successfully uploaded and saved
        return  $newFileName;
      } else {
        // Error occurred while moving the file
        return '';
      }
    } else {
      // Invalid file type
      return '';
    }
  } else {
    // Error occurred during file upload
    return '';
  }
}



