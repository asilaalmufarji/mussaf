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
		case 'order_class':
			order_class();
		break;	
		case 'update_active':
			update_active();
		break;	
		case 'getlink_parent':
			getlink_parent();
		break;		 	
		case 'delete':
			delete();
		break;		 
		case 'getdata':
			getdata();
		break;		
		case 'countdata':
			countdata();
		break;	
		case 'getdata_byid':
			getdata_byid();
		break;		 

	default :
	    // if action is not defined or unknown
		// move to main Customer page

//		header('Location: ../index.php');
}



function getdata_byid()
{
$r_json = array();
$r_data = array();
if(isset($_POST['cla_id']) && is_numeric($_POST['cla_id']))
	{
		
	}
	else
	{
		echo 'start not correct';
		exit();
	}
	$sql_sel = "select * from class where cla_id = " .$_POST['cla_id'];
					$result_sel = dbQuery_PDO_no($sql_sel);
					$str = '';
					if($result_sel->rowCount() >0)
					{	
						while($row = $result_sel->fetch(PDO::FETCH_ASSOC)) 
						{

							extract($row);
							$r_data['cla_id'] = $row['cla_id'];

							$r_data['cla_name'] = utf8_decode($row['cla_name']);
							$r_data['cla_name_en'] = utf8_decode($row['cla_name_en']);
							
							$r_data['cla_domain'] = utf8_decode($row['cla_domain']);
							$r_data['cla_domain_en'] = utf8_decode($row['cla_domain_en']);

							
							$r_data['cla_thumbnail'] = $row['cla_thumbnail'];							
							$r_data['cla_image'] = $row['cla_image'];
							$r_data['cla_image1'] = $row['cla_image1'];
							$r_data['cla_thumbnail1'] = $row['cla_thumbnail1'];

							$r_json[] = $r_data;
						}
					}
					$result = array("result"=>"success","message"=>$r_json); 
	 				echo json_encode($result , JSON_UNESCAPED_UNICODE);
					exit();
}
function countdata()
{
	
	
	$search  ="";
	$parent  ="0";
	if(isset($_POST['parent_id']) && $_POST['parent_id'] != "")
	{
		$parent = $_POST['parent_id'];
	}
	if(isset($_POST['txtsearch']) && $_POST['txtsearch'] != "")
	{
		$search = " and ( cla_name like '%" . utf8_encode($_POST['txtsearch']). "%' 
		or cla_name_en like '%" .utf8_encode($_POST['txtsearch']). "%') ";
	}
	
	
	/*if(isset($_POST['parent_id']) && is_numeric($_POST['parent_id'])
	&& $_POST['parent_id']!= "0")
	{
		$parent = " where parent_id = " .$_POST['parent_id'];
	}
	else
	{
		$parent = " where parent_id = 0 " ;
	}*/
	//$sql_sel = "select * from class " . $parent . " order by cla_order limit $start,$end";
	$sql_sel = "select count(*) as cou from class where parent_id = " . $parent .
	$search . " order by cla_order ";
	
					$result_sel = dbQuery_PDO_no($sql_sel);
					$str = '';
					if($result_sel->rowCount() >0)
					{	
						while($row = $result_sel->fetch(PDO::FETCH_ASSOC)) 
						{
							extract($row);
							$str = $cou;
						}
					}
						echo $str;
					exit();
}
function getdata()
{
	$end = "10";
	$start = "0";
	$parent = "";
	if(isset($_POST['start']) && is_numeric($_POST['start']))
	{
		$start = $_POST['start'];
		if(isset($_POST['parent_id']) && is_numeric($_POST['parent_id'])
		&& $_POST['parent_id']!= "0")
		{
			$parent = " where parent_id = " .$_POST['parent_id'];
		}
		else
		{
			$parent = " where parent_id = 0 " ;
		}
	}
	else
	{
		echo 'start not correct';
		exit();
	}
	$search ="";
		if(isset($_POST['txtsearch']) && $_POST['txtsearch'] != "")
	{
		$search = " and ( cla_name like '%" .utf8_encode($_POST['txtsearch']). "%' 
		or cla_name_en like '%" .utf8_encode($_POST['txtsearch']). "%') ";
	}
	$sql_sel = "select * from class " . $parent . $search . " order by cla_order limit $start,$end";
					$result_sel = dbQuery_PDO_no($sql_sel);
					$str = '';
					if($result_sel->rowCount() >0)
					{	
						$i_color = 0;
						$_color = "#F2F2F2";
						$i = 0;
						while($row = $result_sel->fetch(PDO::FETCH_ASSOC)) 
						{
							extract($row);
							$i += 1;
							$str .= '';
					/*	$str .= '<table width="100%" border="0" class="table_data" align="center" style="	margin-top:5px;height:45px;background-color:' .$_color. '" id = "tbl_'. $cla_id .'" > ';*/
							$str .= ' <tr align="center" style="height:45px;background-color:' 
							.$_color. '" id = "tbl_'. $cla_id .'"> ';
							$str .= ' <td align="center" style="cursor:pointer" 
							onclick = "show_order('.$cla_id.' , '.$cla_order.');" width="40px"> ';
							$str .= $cla_order ;
							$str .= ' </td> ';

							$str .= '<td  width="40px">';
							$str .= '<input type ="checkbox" id = "chk_'.$cla_id.'" check_value = "'.
							$cla_id .'" />' ;
							$str .= '</td>';
							$str .= ' <td align="center" style="cursor:pointer" 
							onclick ="getchild('.$cla_id.')"  width="100px"> ';
							 $str .= ' <span align="center" style="cursor:pointer" 
							 id ="tdcla_name'.$cla_id.'"
							 > ';
							$str .=  $cla_id . " - " .  utf8_decode($cla_name) ;
							$str .=  "</span><br>" ;
$str .= ' <spane align="center" style="cursor:pointer" 
							 id ="tdcla_name_en'.$cla_id.'"
							 > ';
							$str .= utf8_decode($cla_name_en) ;
							$str .= ' </span> ';
							$str .= ' </td> ';
							$str .= ' <td align="center" style="cursor:pointer"  width="100px" > ';
							if($cla_active == "on")
							{
								$str .= "<span class ='per_active1' style =''  
								id = 'active_".$cla_id."'
								data_id = '".$cla_id."' 
								data_active = '".$cla_active."'
								onclick ='class_active(".$cla_id.");'><img src = '../icon/true.gif'></span>";
							}
							else
							{
								$str .= "<span style ='' 
								class ='per_active1'
								id = 'active_".$cla_id."'
								data_id = '".$cla_id."' 
								data_active = '".$cla_active."' 
								onclick ='class_active(".$cla_id.");'>
								<img src = '../icon/false.gif'></span>";
							}
							
							$str .= ' </td> ';

							$str .= ' </tr> ';
                            //$str .= ' </table> ';
							$str .= '  ';
							if($i_color == 0)
							{
								$i_color = 1;

								$_color = "white";								
							}
							else
							{
								$i_color = 0;
								$_color = "#F2F2F2";								
							}
						}
					}
					echo $str;
					exit();
}

function getlink_parent()
{
	$end = "20";
	$start = "0";
	$parent = "";
	
		if(isset($_POST['parent_id']) && is_numeric($_POST['parent_id'])
		&& $_POST['parent_id']!= "0")
		{
			$parent = $_POST['parent_id'];
		}
		else
		{
			$parent = "0" ;
		}
	
						$sql_sel = "select * from class 
						where cla_id = " . $parent ;
						$result_sel = dbQuery_PDO_no($sql_sel);
						//echo $sql_sel ;
						$str = '';
					$sort_array = array();					
					if($result_sel->rowCount() >0)
					{	
						$row = $result_sel->fetch();
						$par_id = $row["parent_id"];
						
						
						$str = " > ";
						$str .= "<span 
						style ='cursor:pointer' onclick = 'getchild(" .$row["cla_id"]. ");'>" 
						. utf8_decode($row["cla_name_en"]). "</span>";
						array_push($sort_array , $str);
						while($par_id != "0") 
						{							
							$sql_sel = "select * from class 
							where cla_id = " . $par_id;
							$result_sel = dbQuery_PDO_no($sql_sel);
							$row_p = $result_sel->fetch();
							
							$str = " > ";
							$str .= "<span style ='cursor:pointer' 
							onclick = 'getchild(" .$row_p["cla_id"]. ");'>" 
							. $row_p["cla_name_en"]. "</span>";
							array_push($sort_array , $str);
							$par_id = $row_p["parent_id"];
						}
					}
					$str = "";
					for ($x = count($sort_array) - 1 ; $x >= 0 ; $x--)
					{
						$str .= $sort_array[$x];
					}
					echo $str;
					exit();
}
function add()
{
	
	$add_array = array();

	if ( isset($_POST['txtcla_name']) && $_POST['txtcla_name'] != ""
		&& isset($_POST['txtcla_name_en']) && $_POST['txtcla_name_en'] != ""
		) {		
		
		$cla_name = utf8_encode(ares($_POST['txtcla_name']));
		$cla_name_en = utf8_encode(ares($_POST['txtcla_name_en']));
		
		$cla_domain = utf8_encode(ares($_POST['txtcla_domain']));
		$cla_domain_en = utf8_encode(ares($_POST['txtcla_domain_en']));
		$parent_id = $_POST['hf_par_add'];		

	
		$images = uploadCustomerImage("fileadd", '../../images/class/' , 400 , 600 );
		$cla_image = $images['image'];
		$cla_thumbnail  = $images['thumbnail'];
		
		
		$imageshover = uploadCustomerImage("fileaddhover", '../../images/class/' , 400 , 600 );
		$cla_image_hover = $imageshover['image'];
		$cla_thumbnail_hover  = $imageshover['thumbnail'];
		
		array_push($add_array , $cla_name);
		array_push($add_array , $cla_name_en);
		array_push($add_array , $cla_domain);
		array_push($add_array , $cla_domain_en);
		array_push($add_array , $parent_id);
		array_push($add_array , $cla_image);	
		array_push($add_array , $cla_thumbnail);		
		array_push($add_array , $cla_image_hover);	
		array_push($add_array , $cla_thumbnail_hover);		
		
		
		
		
	} else {
		header('Location: ../index.php');
	}
	

	
	$sql_order = " update class set cla_order = cla_order + 1 where parent_id = $parent_id ";
//	$sql_add .= " where cla_order <= $cla_order and cla_order > $cla_order_old ";
	$result_order = dbQuery_PDO_no($sql_order); 
			echo $sql_order;
	$sql_add = " insert into class(cla_name,cla_name_en,cla_domain,cla_domain_en,parent_id,cla_image,cla_thumbnail,cla_image1,cla_thumbnail1,cla_regdate,cla_order) ";
	$sql_add .= " value(?,?,?,?,?,?,?,?,?,now(),1)";
	$result_mod = dbQuery_PDO($sql_add , $add_array);
		
			 echo 'save success';
			exit();
	
	
}
function order_class()
{
	
	$add_array = array();

	if ( isset($_POST['cla_id']) && $_POST['cla_order'] != ""
		) {		
		
			$cla_id = $_POST['cla_id'];
			$cla_order = ares($_POST['cla_order']);
			$cla_order_old = ares($_POST['cla_order_old']);
			$parent_id = $_POST['parent_id'];
			
			array_push($add_array , $cla_id);
			array_push($add_array , $cla_order);
						
			if($cla_order > $cla_order_old)
			{
				//===========================check if number found			
			
			$order_array = array();
			array_push($order_array , $parent_id);
			array_push($order_array , $cla_order);
			$sql_order = "SELECT *
	        FROM class
			WHERE parent_id = ?  and cla_order = ? ";

			$result_order = dbQuery_PDO($sql_order , $order_array);
	
			if($result_order->rowCount() == 0)
			{	
				echo "0";
				exit;
			}
			//===========================End check if number found
				$sql_add = " update class set cla_order = cla_order -1  ";
				$sql_add .= " where parent_id = $parent_id 
				and cla_order <= $cla_order and cla_order > $cla_order_old ";
			}
			else
			{
				$sql_add = " update class set cla_order = cla_order +1  ";
				$sql_add .= " where  parent_id = $parent_id and 
				cla_order >= $cla_order and cla_order <= $cla_order_old ";
			}
			$result_mod = dbQuery_PDO_no($sql_add); 
			
			$sql_ord = " update class set cla_order = $cla_order  ";
			$sql_ord .= " where cla_id = $cla_id and  parent_id = $parent_id  ";
			
			$result_ord = dbQuery_PDO_no($sql_ord); //, $add_array);
//			echo 'Modified Success';
			echo $sql_add;
		
	
		}
		else
		{
				echo 'failure';
				exit();
		}
}
function edit()
{
	
	$add_array = array();
$isfile = false;
$isfile1 = false;
$str = $isfile1 . $isfile;
	if ( isset($_POST['hfcla_id']) && $_POST['hfcla_id'] != ""
		) {		
		
		$cla_id = ares($_POST['hfcla_id']);
		$cla_name = utf8_encode(ares($_POST['edcla_name']));
		$cla_name_en = utf8_encode(ares($_POST['edcla_name_en']));
		
		$cla_domain = utf8_encode(ares($_POST['edcla_domain']));
		$cla_domain_en = utf8_encode(ares($_POST['edcla_domain_en']));
		
		
		if (!($_FILES['fileedit']['size'] == 0 ))
		{
			$isfile = true;
			$images = uploadCustomerImage("fileedit", '../../images/class/' , 400 , 600 );
		$cla_image = $images['image'];
		$cla_thumbnail  = $images['thumbnail'];
		}
		
		
		if (!($_FILES['fileedit1']['size'] == 0 && $_FILES['fileedit1']['error'] == 0))
		{
			$isfile1 = true;
			$images1 = uploadCustomerImage("fileedit1", '../../images/class/' , 400 , 600 );
		$cla_image1 = $images1['image'];
		$cla_thumbnail1  = $images1['thumbnail'];
		}
		
		
		
		array_push($add_array , $cla_name);
		array_push($add_array , $cla_name_en);
		array_push($add_array , $cla_domain);
		array_push($add_array , $cla_domain_en);
		
		if($isfile)
		{
			array_push($add_array , $cla_image);	
			array_push($add_array , $cla_thumbnail);			
		}
		if($isfile1)
		{
			array_push($add_array , $cla_image1);	
			array_push($add_array , $cla_thumbnail1);			
		}
		array_push($add_array , $cla_id);
		
		
	} else {
		header('Location: ../index.php');
	}
	

	$sql_add = " update class set cla_name = ? , cla_name_en = ? 
	 " . ", cla_domain = ? , cla_domain_en = ?"
	   . ($isfile == true ?",  cla_image = ? , cla_thumbnail = ?" : "") 
	   . ($isfile1 == true ?",  cla_image1 = ? , cla_thumbnail1 = ?" : "") ;
	$sql_add .= " where cla_id = ?";
	//echo $isfile . $isfile1.  $_FILES['fileedit1']['size'] ."before:".$str . "----" . $sql_add ;
	$result_mod = dbQuery_PDO($sql_add , $add_array);
		
		
//			update_trans($cat_name , "" , "2" ,$cat_id );
			 echo 'Modified Success';
			exit();
	
	
}

function delete()
{
	
	$add_array = array();

	if ( isset($_POST['cla_id']) && $_POST['cla_id'] != ""
		) {		
		$cla_id = ares($_POST['cla_id']);
		
		
		
		array_push($add_array , $cla_id);
		
		
	} else {
		header('Location: ../index.php');
	}
	

	$sql_add = " delete from class where cla_id = ? ";
	$result_mod = dbQuery_PDO($sql_add , $add_array);
			 echo 'Success deleted';
			exit();
	
	
}

//==================================
function update_active()
{
	
	$add_array = array();

	if ( isset($_POST['cla_active']) && isset($_POST['cla_id']) ) {		
		
		$cla_id = ares($_POST['cla_id']);
		$cla_active = ares($_POST['cla_active']);
		

		
		array_push($add_array , ($cla_active == "on" ? "off" : "on"));
		array_push($add_array , $cla_id);
		
		
		
	} else {
		header('Location: ../index.php');
	}
	

	$sql_add = " update class set cla_active = ? ";
	$sql_add .= " where cla_id = ?";
	$result_mod = dbQuery_PDO($sql_add , $add_array);
		

			 echo 'Modified Success';
			exit();
	
	
}

?>