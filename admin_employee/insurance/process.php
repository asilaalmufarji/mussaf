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

	case 'listinsurance':
		listinsurance();
		break;

	case 'getdata_byid':
		getdata_byid();
		break;
	case 'getTypeCar':
		getTypeCar();
		break;
	case 'getTypeDriver':
		getTypeDriver();
		break;
  case 'getTypeInsurance':
		getTypeInsurance();
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
		// move to main insurance page

		//		header('Location: ../index.php');
}



function getdata_byid()
{
	$r_json = array();
	$r_data = array();
	if (isset($_POST['ins_id']) && is_numeric($_POST['ins_id'])) {
	} else {
		echo 'start not correct';
		exit();
	}
	$sql_sel = "select * from insurance where ins_id = " . $_POST['ins_id'];
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

function getTypeCar()
{
	$sql_sel = "select * from type_car ";
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

function getTypeDriver()
{
	$sql_sel = "select * from type_driver ";
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

function getTypeInsurance()
{
	$sql_sel = "select * from type_insurance ";
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
		isset($_POST['txtins_name']) && $_POST['txtins_name'] != ""
		&& isset($_POST['txtins_name_en']) && $_POST['txtins_name_en'] != ""
	) {

		$ins_name = ares($_POST['txtins_name']);
		$ins_name_en = ares($_POST['txtins_name_en']);

		$ins_mobile2 = ares($_POST['txtins_mobile2']);
		$ins_mobile1 = ares($_POST['txtins_mobile1']);

		$ins_mail = ares($_POST['txtins_mail']);
		$ins_website = ares($_POST['txtins_website']);

		$typ_car_id = ares($_POST['cmbtyp_car_id']);
		$typ_ins_id = ares($_POST['cmbtyp_ins_id']);
		$typ_driver_id = ares($_POST['cmbtyp_driver_id']);
		$gov_id = ares($_POST['cmbgov_id']);

		$wil_id = ares($_POST['cmbwil_id']);
		$reg_id = ares($_POST['cmbreg_id']);
/*
		$dat_id = ares($_POST['cmbdat_id']);*/
		$ins_loc = ares($_POST['txtins_loc']);
		$emp_id = $_SESSION['emp_id'];

		

		$images = uploadCustomerImage("fileadd", '../../images/insurance/', 400, 600);
		$ins_image = $images['image'];
		$ins_thumbnail  = $images['thumbnail'];

				
		$ins_file = uploadFile( "file", '../../file/insurance/');
		$ins_file1 = uploadFile( "file1", '../../file/insurance/');
		$ins_file2 = uploadFile( "file2", '../../file/insurance/');
		
/*
		$imageshover = uploadCustomerImage("fileaddhover", '../../images/insurance/', 400, 600);
		$ins_image_hover = $imageshover['image'];
		$ins_thumbnail_hover  = $imageshover['thumbnail'];*/

		array_push($add_array, $ins_name);
		array_push($add_array, $ins_name_en);
		array_push($add_array, $ins_mobile2);
		array_push($add_array, $ins_mobile1);
		array_push($add_array, $ins_mail);

		array_push($add_array, $ins_website);
		array_push($add_array, $typ_car_id);
		array_push($add_array, $typ_ins_id);
		array_push($add_array, $typ_driver_id);
		array_push($add_array, $gov_id);

		array_push($add_array, $wil_id);
		array_push($add_array, $reg_id);		
		array_push($add_array, $ins_loc);
		array_push($add_array, $emp_id);
		array_push($add_array, $ins_file);
		array_push($add_array, $ins_file1);
		array_push($add_array, $ins_file2);

		array_push($add_array, $ins_image);
		array_push($add_array, $ins_thumbnail);

	} else {
		header('Location: ../index.php');
	}




	$sql_add = " insert into insurance(
	ins_name,ins_name_en,ins_mobile2,ins_mobile1,ins_mail,
	ins_website,typ_car_id,typ_ins_id,typ_driver_id,gov_id
	,wil_id,reg_id,ins_loc,emp_id,ins_file
	,ins_file1,ins_file2
	,ins_thumbnail,ins_image,ins_regdate) ";
	$sql_add .= " value(?,?,?,?,?
	,?,?,?,?,?
	,?,?,?,?,?
	,?,?
	,? ,? , now())";
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
		isset($_POST['hfins_id']) && $_POST['hfins_id'] != ""
	) {

		$ins_id = ares($_POST['hfins_id']);
			$ins_name = ares($_POST['txtins_name']);
		$ins_name_en = ares($_POST['txtins_name_en']);

		$ins_mobile2 = ares($_POST['txtins_mobile2']);
		$ins_mobile1 = ares($_POST['txtins_mobile1']);

		$ins_mail = ares($_POST['txtins_mail']);
		$ins_website = ares($_POST['txtins_website']);

		$ser_id = ares($_POST['cmbser_id']);
		$gov_id = ares($_POST['cmbgov_id']);

		$wil_id = ares($_POST['cmbwil_id']);
		$reg_id = ares($_POST['cmbreg_id']);

		$dat_id = ares($_POST['cmbdat_id']);
		$ins_loc = ares($_POST['cmbins_loc']);


		if (!($_FILES['fileadd']['size'] == 0)) {
			$isfile = true;
			$images = uploadCustomerImage("fileadd", '../../images/insurance/', 400, 600);
			$ins_image = $images['image'];
			$ins_thumbnail  = $images['thumbnail'];
		}
		if (!($_FILES['file']['size'] == 0)) {
			$isfilepdf = true;
			$ins_file = uploadFile( "file", '../../file/insurance/');
		}

		if (!($_FILES['file']['size'] == 0)) {
			$isfilepdf1 = true;
			$ins_file1 = uploadFile( "file1", '../../file/insurance/');
		}

		if (!($_FILES['file']['size'] == 0)) {
			$isfilepdf2 = true;
			$ins_file2 = uploadFile( "file2", '../../file/insurance/');
		}


		

	    array_push($add_array, $ins_name);
		array_push($add_array, $ins_name_en);
		array_push($add_array, $ins_mobile2);
		array_push($add_array, $ins_mobile1);
		array_push($add_array, $ins_mail);
		array_push($add_array, $ins_website);
		array_push($add_array, $ser_id);
		array_push($add_array, $gov_id);
		array_push($add_array, $wil_id);
		array_push($add_array, $reg_id);
		array_push($add_array, $dat_id);
		array_push($add_array, $ins_loc);		

		

		if ($isfile) {
			array_push($add_array, $ins_image);
			array_push($add_array, $ins_thumbnail);
		}
		if ($isfilepdf) {
			array_push($add_array, $ins_file);
			
		}
		if ($isfilepdf1) {
			array_push($add_array, $ins_file1);
			
		}
		if ($isfilepdf2) {
			array_push($add_array, $ins_file2);
			
		}
	
		array_push($add_array, $ins_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update insurance set ins_name = ? , ins_name_en = ? 
	 " . ", ins_mobile2 = ? , ins_mobile1 = ?"
	  . ", ins_mail = ? , ins_website = ?"
	  . ", ser_id = ? , gov_id = ?"
	  . ", wil_id = ? , reg_id = ?"
	  . ", dat_id = ? , ins_loc = ?"
	  . ($isfile == true ? ",  ins_image = ? , ins_thumbnail = ?" : "")
	   . ($isfilepdf == true ? ",  ins_file = ? " : "")
	   . ($isfilepdf1 == true ? ",  ins_file1 = ? " : "")
	   . ($isfilepdf2 == true ? ",  ins_file2 = ? " : "")
		;
	$sql_add .= " where ins_id = ? ";
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
		isset($_POST['ins_id']) && $_POST['ins_id'] != ""
	) {
		$ins_id = ares($_POST['ins_id']);



		array_push($add_array, $ins_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " delete from insurance where ins_id = ? ";
	$result_mod = dbQuery_PDO($sql_add, $add_array);
	echo 'Success deleted';
	exit();
}

//==================================
function update_active()
{

	$add_array = array();

	if (isset($_POST['ins_active']) && isset($_POST['ins_id'])) {

		$ins_id = ares($_POST['ins_id']);
		$ins_active = ares($_POST['ins_active']);



		array_push($add_array, ($ins_active == "on" ? "off" : "on"));
		array_push($add_array, $ins_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update insurance set ins_active = ? ";
	$sql_add .= " where ins_id = ?";
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
		&& isset($_POST['ins_id'])
	) {

		$ins_id = ares($_POST['ins_id']);
		$col1 = ares($_POST['col1']);
		$col2 = ares($_POST['col2']);




		array_push($add_array, $ins_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update insurance set $col1 = NULL , $col2 = NULL ";
	$sql_add .= " where ins_id = ?";
	$result_mod = dbQuery_PDO($sql_add, $add_array);


	echo 'Modified Success';
	exit();
}


function listinsurance()
{
	$sqlQuery = "SELECT *
FROM insurance left join governate on
 	 governate.gov_id = insurance.gov_id
 	 left join wilayat on
 	  wilayat.wil_id = insurance.wil_id
 	  left join region on
 	 region.reg_id = insurance.reg_id
	  
	 where emp_id = " . $_SESSION['emp_id'] . " and 1=1 ";
	if (!empty($_POST["search"]["value"])) {
		$sqlQuery .= ' and (ins_id LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR ins_name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR gov_name LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR wil_name LIKE "%' . $_POST["search"]["value"] . '%" ';
					$sqlQuery .= ' OR reg_name LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR ins_name_en LIKE "%' . $_POST["search"]["value"] . '%" ) ';
	}

	if (!empty($_POST["order"])) {
		$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
	} else {
		$sqlQuery .= 'ORDER BY ins_id DESC ';
	}

	if ($_POST["length"] != -1) {
		$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}
	//	global $conn;

	$result = dbQuery($sqlQuery);




	$allResult = dbQuery("SELECT * FROM insurance  where emp_id= " . $_SESSION['emp_id'] );

	$allRecords = $allResult->rowCount();

	$displayRecords = $result->rowCount();
	$records = array();
	while ($record = $result->fetch(PDO::FETCH_ASSOC)) {
		$rows = array();
		$rows[] = "";
		$rows[] = $record['ins_id'];		
		$rows[] = $record['ins_name'] . '<br> ' . $record['ins_name_en'];
		$rows[] =  $record['gov_name'] . '<br>' . $record['wil_name']. ' - ' . $record['reg_name'];




		//	$rows[] = ''; // '<img  src = "https://cdn-icons-png.flaticon.com/512/744/744465.png" width ="50px">';
		/*$rows[] = '<button type="button" name="update" id="' . $record["ins_id"] . '" onclick ="edit_show(' . $record["ins_id"] . ' )" class="btn btn-warning btn-xs update ">Update</button>';
		$rows[] = '<button type="button" name="delete" id="' . $record["ins_id"] . '" onclick = "del(' . $record["ins_id"] . '  , 1)" class="btn btn-danger btn-xs delete" >Delete</button>';
*/

		$rows[] = '<span class="bi bi-pencil" name="update" id="' . $record["ins_id"] . '" onclick ="edit_show(' . $record["ins_id"] . ' )" ></span>';
		$rows[] = '<span class="bi bi-trash"  name="delete" id="' . $record["ins_id"] . '" onclick = "del(' . $record["ins_id"] . '  , 1)"></span>';

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
  $targetDirectory = path;//'../../file/insurance/'; // Specify the directory where you want to save the uploaded files

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


