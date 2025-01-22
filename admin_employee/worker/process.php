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

	case 'listworker':
		listworker();
		break;

	case 'getdata_byid':
		getdata_byid();
		break;
		case 'gettype':
		gettype_ser();
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
		// move to main worker page

		//		header('Location: ../index.php');
}



function getdata_byid()
{
	$r_json = array();
	$r_data = array();
	if (isset($_POST['wor_id']) && is_numeric($_POST['wor_id'])) {
	} else {
		echo 'start not correct';
		exit();
	}
	$sql_sel = "select * from worker where wor_id = " . $_POST['wor_id'];
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

function gettype_ser()
{
	$sql_sel = "select * from type_worker ";
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
		isset($_POST['txtwor_name']) && $_POST['txtwor_name'] != ""
		&& isset($_POST['txtwor_name_en']) && $_POST['txtwor_name_en'] != ""
	) {

		$wor_name = ares($_POST['txtwor_name']);
		$wor_name_en = ares($_POST['txtwor_name_en']);

		$wor_mobile2 = ares($_POST['txtwor_mobile2']);
		$wor_mobile1 = ares($_POST['txtwor_mobile1']);

		$wor_mail = ares($_POST['txtwor_mail']);
		$wor_website = ares($_POST['txtwor_website']);

		$typ_id = ares($_POST['cmbtyp_id']);
		$gov_id = ares($_POST['cmbgov_id']);

		$wil_id = ares($_POST['cmbwil_id']);
		$reg_id = ares($_POST['cmbreg_id']);
/*
		$dat_id = ares($_POST['cmbdat_id']);*/
		$wor_loc = ares($_POST['txtwor_loc']);
		$wor_info = ares($_POST['txtwor_info']);
		$wor_country = ares($_POST['txtwor_country']);
		$emp_id = $_SESSION['emp_id'];

		

		$images = uploadCustomerImage("fileadd", '../../images/worker/', 400, 600);
		$wor_image = $images['image'];
		$wor_thumbnail  = $images['thumbnail'];

				
			$wor_file = uploadFile( "file", '../../file/worker/');
		$wor_file1 = uploadFile( "file1", '../../file/worker/');
		$wor_file2 = uploadFile( "file2", '../../file/worker/');
		
/*
		$imageshover = uploadCustomerImage("fileaddhover", '../../images/customer/', 400, 600);
		$wor_image_hover = $imageshover['image'];
		$wor_thumbnail_hover  = $imageshover['thumbnail'];*/

		array_push($add_array, $wor_name);
		array_push($add_array, $wor_name_en);
		array_push($add_array, $wor_mobile2);
		array_push($add_array, $wor_mobile1);
		array_push($add_array, $wor_mail);

		array_push($add_array, $wor_website);
		
		array_push($add_array, $gov_id);
		array_push($add_array, $wil_id);
		array_push($add_array, $reg_id);
		
		array_push($add_array, $wor_loc);
		array_push($add_array, $wor_country);
		array_push($add_array, $wor_info);
		array_push($add_array, $emp_id);
		array_push($add_array, $wor_file);
		array_push($add_array, $wor_file1);
		array_push($add_array, $wor_file2);
		array_push($add_array, $wor_image);
		array_push($add_array, $wor_thumbnail);

	} else {
		header('Location: ../index.php');
	}




	$sql_add = " insert into worker(
	wor_name,wor_name_en,wor_mobile2,wor_mobile1,wor_mail,
	wor_website,gov_id,wil_id,reg_id,
	wor_loc,wor_country,wor_info,emp_id,wor_file,
	wor_file1,wor_file2,wor_thumbnail,wor_image
	,wor_regdate) ";
	$sql_add .= " value(?,?,?,?,?
	,?,?,?,?,?
	,?,?,?,?,?
	,?,?,?
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
		isset($_POST['hfwor_id']) && $_POST['hfwor_id'] != ""
	) {

		$wor_id = ares($_POST['hfwor_id']);
			$wor_name = ares($_POST['txtwor_name']);
		$wor_name_en = ares($_POST['txtwor_name_en']);

		$wor_mobile2 = ares($_POST['txtwor_mobile2']);
		$wor_mobile1 = ares($_POST['txtwor_mobile1']);

		$wor_mail = ares($_POST['txtwor_mail']);
		$wor_website = ares($_POST['txtwor_website']);

		$gov_id = ares($_POST['cmbgov_id']);

		$wil_id = ares($_POST['cmbwil_id']);
		$reg_id = ares($_POST['cmbreg_id']);

		$dat_id = ares($_POST['cmbdat_id']);
		$wor_loc = ares($_POST['txtwor_loc']);
		$wor_country = ares($_POST['txtwor_country']);
		$wor_info = ares($_POST['txtwor_info']);


		if (!($_FILES['fileadd']['size'] == 0)) {
			$isfile = true;
			$images = uploadCustomerImage("fileadd", '../../images/worker/', 400, 600);
			$wor_image = $images['image'];
			$wor_thumbnail  = $images['thumbnail'];
		}
		if (!($_FILES['file']['size'] == 0)) {
			$isfilepdf = true;
			$wor_file = uploadFile( "file", '../../file/worker/');
		}
		if (!($_FILES['file1']['size'] == 0)) {
			$isfilepdf1 = true;
			$wor_file1 = uploadFile( "file1", '../../file/worker/');
		}
		if (!($_FILES['file2']['size'] == 0)) {
			$isfilepdf2 = true;
			$wor_file2 = uploadFile( "file2", '../../file/worker/');
		}


		

	  array_push($add_array, $wor_name);
		array_push($add_array, $wor_name_en);
		array_push($add_array, $wor_mobile2);
		array_push($add_array, $wor_mobile1);
		array_push($add_array, $wor_mail);
		array_push($add_array, $wor_website);
		
		array_push($add_array, $gov_id);
		array_push($add_array, $wil_id);
		array_push($add_array, $reg_id);
		//array_push($add_array, $dat_id);
		array_push($add_array, $wor_loc);		
		array_push($add_array, $wor_info);		
		array_push($add_array, $wor_country);		

		

		if ($isfile) {
			array_push($add_array, $wor_image);
			array_push($add_array, $wor_thumbnail);
		}
		if ($isfilepdf) {
			array_push($add_array, $wor_file);
			
		}
		if ($isfilepdf1) {
			array_push($add_array, $wor_file1);
			
		}
		if ($isfilepdf2) {
			array_push($add_array, $wor_file2);
			
		}
	
		array_push($add_array, $wor_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update worker set wor_name = ? , wor_name_en = ? 
	 " . ", wor_mobile2 = ? , wor_mobile1 = ?"
	  . ", wor_mail = ? , wor_website = ?"
	  . ",  gov_id = ?"
	  . ", wil_id = ? , reg_id = ?"
	  . ", wor_loc = ?"
	  . ", wor_info = ? , wor_country = ?"
	  . ($isfile == true ? ",  wor_image = ? , wor_thumbnail = ?" : "")
	   . ($isfilepdf == true ? ",  wor_file = ? " : "")
	   . ($isfilepdf1 == true ? ",  wor_file1 = ? " : "")
	   . ($isfilepdf2 == true ? ",  wor_file2 = ? " : "")
		;
	$sql_add .= " where wor_id = ?";
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
		isset($_POST['wor_id']) && $_POST['wor_id'] != ""
	) {
		$wor_id = ares($_POST['wor_id']);



		array_push($add_array, $wor_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " delete from worker where wor_id = ? ";
	$result_mod = dbQuery_PDO($sql_add, $add_array);
	echo 'Success deleted';
	exit();
}

//==================================
function update_active()
{

	$add_array = array();

	if (isset($_POST['wor_active']) && isset($_POST['wor_id'])) {

		$wor_id = ares($_POST['wor_id']);
		$wor_active = ares($_POST['wor_active']);



		array_push($add_array, ($wor_active == "on" ? "off" : "on"));
		array_push($add_array, $wor_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update worker set wor_active = ? ";
	$sql_add .= " where wor_id = ?";
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
		&& isset($_POST['wor_id'])
	) {

		$wor_id = ares($_POST['wor_id']);
		$col1 = ares($_POST['col1']);
		$col2 = ares($_POST['col2']);




		array_push($add_array, $wor_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update worker set $col1 = NULL , $col2 = NULL ";
	$sql_add .= " where wor_id = ?";
	$result_mod = dbQuery_PDO($sql_add, $add_array);


	echo 'Modified Success';
	exit();
}


function listworker()
{
	$sqlQuery = "SELECT *
	FROM worker left join governate on
 	 governate.gov_id = worker.gov_id
 	 left join wilayat on
 	  wilayat.wil_id = worker.wil_id
 	  left join region on
 	 region.reg_id = worker.reg_id
	  
	 where emp_id = " . $_SESSION['emp_id'] . " and 1=1 ";
	if (!empty($_POST["search"]["value"])) {
		$sqlQuery .= ' and (wor_id LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR wor_name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR gov_name LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR wil_name LIKE "%' . $_POST["search"]["value"] . '%" ';
					$sqlQuery .= ' OR reg_name LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR wor_name_en LIKE "%' . $_POST["search"]["value"] . '%" ) ';
	}

	if (!empty($_POST["order"])) {
		$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
	} else {
		$sqlQuery .= 'ORDER BY wor_id DESC ';
	}

	if ($_POST["length"] != -1) {
		$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}
	//	global $conn;

	$result = dbQuery($sqlQuery);




	$allResult = dbQuery("SELECT * FROM worker  where emp_id= " . $_SESSION['emp_id'] );

	$allRecords = $allResult->rowCount();

	$displayRecords = $result->rowCount();
	$records = array();
	while ($record = $result->fetch(PDO::FETCH_ASSOC)) {
		$rows = array();
		$rows[] = "";
		$rows[] = $record['wor_id'];
		
		$rows[] = $record['wor_name'] . '<br> ' . $record['wor_name_en'];
		$rows[] =  $record['gov_name'] . '<br>' . $record['wil_name']. ' - ' . $record['reg_name'];




		//	$rows[] = ''; // '<img  src = "https://cdn-icons-png.flaticon.com/512/744/744465.png" width ="50px">';
		/*$rows[] = '<button type="button" name="update" id="' . $record["wor_id"] . '" onclick ="edit_show(' . $record["wor_id"] . ' )" class="btn btn-warning btn-xs update ">Update</button>';
		$rows[] = '<button type="button" name="delete" id="' . $record["wor_id"] . '" onclick = "del(' . $record["wor_id"] . '  , 1)" class="btn btn-danger btn-xs delete" >Delete</button>';
*/

		$rows[] = '<span class="bi bi-pencil" name="update" id="' . $record["wor_id"] . '" onclick ="edit_show(' . $record["wor_id"] . ' )" ></span>';
		$rows[] = '<span class="bi bi-trash"  name="delete" id="' . $record["wor_id"] . '" onclick = "del(' . $record["wor_id"] . '  , 1)"></span>';

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



