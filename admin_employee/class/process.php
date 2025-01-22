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

	case 'listClass':
		listClass();
		break;

	case 'getdata_byid':
		getdata_byid();
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
	if (isset($_POST['cla_id']) && is_numeric($_POST['cla_id'])) {
	} else {
		echo 'start not correct';
		exit();
	}
	$sql_sel = "select * from class where cla_id = " . $_POST['cla_id'];
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


function add()
{

	$add_array = array();

	if (
		isset($_POST['txtcla_name']) && $_POST['txtcla_name'] != ""
		&& isset($_POST['txtcla_name_en']) && $_POST['txtcla_name_en'] != ""
	) {

		$cla_name = ares($_POST['txtcla_name']);
		$cla_name_en = ares($_POST['txtcla_name_en']);

		$cla_domain = ares($_POST['txtcla_domain']);
		$cla_domain_en = ares($_POST['txtcla_domain_en']);


		$images = uploadCustomerImage("fileadd", '../../images/class/', 400, 600);
		$cla_image = $images['image'];
		$cla_thumbnail  = $images['thumbnail'];


		$imageshover = uploadCustomerImage("fileaddhover", '../../images/class/', 400, 600);
		$cla_image_hover = $imageshover['image'];
		$cla_thumbnail_hover  = $imageshover['thumbnail'];

		array_push($add_array, $cla_name);
		array_push($add_array, $cla_name_en);
		array_push($add_array, $cla_domain);
		array_push($add_array, $cla_domain_en);

		array_push($add_array, $cla_image);
		array_push($add_array, $cla_thumbnail);
		array_push($add_array, $cla_image_hover);
		array_push($add_array, $cla_thumbnail_hover);
	} else {
		header('Location: ../index.php');
	}




	$sql_add = " insert into class(cla_name,cla_name_en,cla_domain,cla_domain_en,cla_image,cla_thumbnail,cla_image1,cla_thumbnail1,cla_regdate) ";
	$sql_add .= " value(?,?,?,?,?,?,?,?,now())";
	$result_mod = dbQuery_PDO($sql_add, $add_array);

	echo 'save success';
	exit();
}

function edit()
{

	$add_array = array();
	$isfile = false;
	$isfile1 = false;
	$str = $isfile1 . $isfile;
	if (
		isset($_POST['hfcla_id']) && $_POST['hfcla_id'] != ""
	) {

		$cla_id = ares($_POST['hfcla_id']);
		$cla_name = ares($_POST['txtcla_name']);
		$cla_name_en = ares($_POST['txtcla_name_en']);

		$cla_domain = ares($_POST['txtcla_domain']);
		$cla_domain_en = ares($_POST['txtcla_domain_en']);


		if (!($_FILES['fileadd']['size'] == 0)) {
			$isfile = true;
			$images = uploadCustomerImage("fileadd", '../../images/class/', 400, 600);
			$cla_image = $images['image'];
			$cla_thumbnail  = $images['thumbnail'];
		}


		if (!($_FILES['fileaddhover']['size'] == 0 && $_FILES['fileaddhover']['error'] == 0)) {
			$isfile1 = true;
			$images1 = uploadCustomerImage("fileaddhover", '../../images/class/', 400, 600);
			$cla_image1 = $images1['image'];
			$cla_thumbnail1  = $images1['thumbnail'];
		}



		array_push($add_array, $cla_name);
		array_push($add_array, $cla_name_en);
		array_push($add_array, $cla_domain);
		array_push($add_array, $cla_domain_en);

		if ($isfile) {
			array_push($add_array, $cla_image);
			array_push($add_array, $cla_thumbnail);
		}
		if ($isfile1) {
			array_push($add_array, $cla_image1);
			array_push($add_array, $cla_thumbnail1);
		}
		array_push($add_array, $cla_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update class set cla_name = ? , cla_name_en = ? 
	 " . ", cla_domain = ? , cla_domain_en = ?"
		. ($isfile == true ? ",  cla_image = ? , cla_thumbnail = ?" : "")
		. ($isfile1 == true ? ",  cla_image1 = ? , cla_thumbnail1 = ?" : "");
	$sql_add .= " where cla_id = ?";
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
		isset($_POST['cla_id']) && $_POST['cla_id'] != ""
	) {
		$cla_id = ares($_POST['cla_id']);



		array_push($add_array, $cla_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " delete from class where cla_id = ? ";
	$result_mod = dbQuery_PDO($sql_add, $add_array);
	echo 'Success deleted';
	exit();
}

//==================================
function update_active()
{

	$add_array = array();

	if (isset($_POST['cla_active']) && isset($_POST['cla_id'])) {

		$cla_id = ares($_POST['cla_id']);
		$cla_active = ares($_POST['cla_active']);



		array_push($add_array, ($cla_active == "on" ? "off" : "on"));
		array_push($add_array, $cla_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update class set cla_active = ? ";
	$sql_add .= " where cla_id = ?";
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
		&& isset($_POST['cla_id'])
	) {

		$cla_id = ares($_POST['cla_id']);
		$col1 = ares($_POST['col1']);
		$col2 = ares($_POST['col2']);




		array_push($add_array, $cla_id);
	} else {
		header('Location: ../index.php');
	}


	$sql_add = " update class set $col1 = NULL , $col2 = NULL ";
	$sql_add .= " where cla_id = ?";
	$result_mod = dbQuery_PDO($sql_add, $add_array);


	echo 'Modified Success';
	exit();
}
function listClass()
{
	$sqlQuery = "SELECT * FROM class ";
	if (!empty($_POST["search"]["value"])) {
		$sqlQuery .= 'where(cla_id LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR cla_name LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR cla_name_en LIKE "%' . $_POST["search"]["value"] . '%" ) ';
	}

	if (!empty($_POST["order"])) {
		$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
	} else {
		$sqlQuery .= 'ORDER BY cla_id DESC ';
	}

	if ($_POST["length"] != -1) {
		$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}
	//	global $conn;

	$result = dbQuery($sqlQuery);




	$allResult = dbQuery("SELECT * FROM class");

	$allRecords = $allResult->rowCount();

	$displayRecords = $result->rowCount();
	$records = array();
	while ($record = $result->fetch(PDO::FETCH_ASSOC)) {
		$rows = array();
		$rows[] = "";
		$rows[] = $record['cla_id'];
		$rows[] = $record['cla_name'];
		$rows[] = $record['cla_name_en'];




		//	$rows[] = ''; // '<img  src = "https://cdn-icons-png.flaticon.com/512/744/744465.png" width ="50px">';
		/*$rows[] = '<button type="button" name="update" id="' . $record["cla_id"] . '" onclick ="edit_show(' . $record["cla_id"] . ' )" class="btn btn-warning btn-xs update ">Update</button>';
		$rows[] = '<button type="button" name="delete" id="' . $record["cla_id"] . '" onclick = "del(' . $record["cla_id"] . '  , 1)" class="btn btn-danger btn-xs delete" >Delete</button>';
*/

		$rows[] = '<span class="bi bi-pencil" name="update" id="' . $record["cla_id"] . '" onclick ="edit_show(' . $record["cla_id"] . ' )" ></span>';
		$rows[] = '<span class="bi bi-trash"  name="delete" id="' . $record["cla_id"] . '" onclick = "del(' . $record["cla_id"] . '  , 1)"></span>';

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
