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
		case 'sendwhats':
			//sendwhats($_POST['cus_id']);
		break;		
		case 'sendwhats_from':
			sendwhats_from();
		break;		
		case 'order_customer':
			order_customer();
		break;	
		case 'update_active':
			update_active();
		break;	
		case 'search_active':
			search_active();
		break;		
		case 'getcity':
			getcity();
		break;	
		case 'getcountry':
			getcountry();
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

function get_wh_customer($cus_id)
{
	$sql_sel = "select * from mes_cus_whats where cus_id = $cus_id";
	$result_sel = dbQuery_PDO_no($sql_sel);
	$str = '';
	if($result_sel->rowCount() >0)
	{	
		
		while($row = $result_sel->fetch(PDO::FETCH_ASSOC)) 
		{
			extract($row);
			$str .= $mes_regdate. " \t " . " WhatsApp";
            $str .= "\n";
            $str .= $mes_content;
            $str .= "\n";
            $str .= "------------------------------------------------------------------------";
            $str .= "\n";
		}
	}
	return $str;
}
function send_whatsapp($name,$message,$phone,$with , $path_file)
{
		echo $with;
//	echo "00961" . $phone;
	if($with == "1")
	{
		$message = "ÚäÇíÉ  " 
		.  $name 
		. " "
		. $message;
	}
	$data = [
    'phone' => "00966" . $phone, // Receivers phone
	'body' => $path_file, // Message
	'filename' => "wh.jpg", // Message
    'caption' => $message, // Message
];
$json = json_encode($data); // Encode data to JSON
// URL for request POST /message
$url = 'https://api.chat-api.com/instance71205/sendFile?token=8wtav6x7feeg1hrf';
// Make a POST request
$options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $json
    ]
]);
// Send a request
$result = file_get_contents($url, false, $options);
}


function countdata()
{	
	$search  =" where 1=1 ";
	if(isset($_POST['txtsearch']) && $_POST['txtsearch'] != "")
	{
		$search .= " and  (cus_name like '%" .utf8_encode($_POST['txtsearch'])
		. "%' or  cus_mobile like '%" .utf8_encode($_POST['txtsearch']). "%'"
		. " or  cus_email like '%" .utf8_encode($_POST['txtsearch']). "%') ";
	}
	if(isset($_POST['cou_id']) && $_POST['cou_id'] != "0" && $_POST['cou_id'] != "")
	{
		$search .= " and cou_id = " . $_POST['cou_id'];
	}
	if(isset($_POST['cit_id']) && $_POST['cit_id'] != "0" && $_POST['cit_id'] != "")
	{
		$search .= " and cit_id = " . $_POST['cit_id'];
	}
	if(isset($_POST['cus_gender']) && $_POST['cus_gender'] != "0" && $_POST['cus_gender'] != "")
	{
		$search .= " and cus_gender = " . $_POST['cus_gender'];
	}
	if(isset($_POST['cus_active']) && $_POST['cus_active'] != "0" && $_POST['cus_active'] != "")
	{
		$search .= " and (cus_active = " . ($_POST['cus_active'] == "on" ? "'on' ) " : "'off' or cus_active = '' )");
	}	
	$sql_sel = "select count(*) as cou from customer " .
	$search ;
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
	$end = "20";
	$start = "0";
	if(isset($_POST['start']) && is_numeric($_POST['start']))
	{
		$start = $_POST['start'];
	}
	else
	{
		echo 'start not correct';
		exit();
	}
		$search  =" where 1=1 ";
	if(isset($_POST['txtsearch']) && $_POST['txtsearch'] != "")
	{
		$search .= " and  (cus_name like '%" .utf8_encode($_POST['txtsearch'])
		. "%' or  cus_mobile like '%" .utf8_encode($_POST['txtsearch']). "%'"
		. " or  cus_email like '%" .utf8_encode($_POST['txtsearch']). "%') ";
	}
	if(isset($_POST['cou_id']) && $_POST['cou_id'] != "0" && $_POST['cou_id'] != "")
	{
		$search .= " and cou_id = " . $_POST['cou_id'];
	}
	if(isset($_POST['cus_id']) && $_POST['cus_id'] != "0" && $_POST['cus_id'] != "")
	{
		$search .= " and cus_id = " . $_POST['cus_id'];
	}
	if(isset($_POST['cit_id']) && $_POST['cit_id'] != "0" && $_POST['cit_id'] != "")
	{
		$search .= " and cit_id = " . $_POST['cit_id'];
	}
	if(isset($_POST['cus_gender']) && $_POST['cus_gender'] != "0" && $_POST['cus_gender'] != "")
	{
		$search .= " and cus_gender = " . $_POST['cus_gender'];
	}
	if(isset($_POST['cus_active']) && $_POST['cus_active'] == "0" )
	{
		
			
			$sql_sel = "select distinct cus.*  
				,  det_count , det_show , wha_id 
				, ( select cou_name from country where cou_id = cus.cou_id)
				as cou_name 
				, ( select cit_name from city where cit_id = cus.cit_id)
				as cit_name 
				from customer cus left outer join whats_customer
				on cus.cus_id = whats_customer.cus_id and   wha_id =  " 
				. $_POST["wha_id"] .
				
				$search . "  order by cus_id desc limit $start,$end";
				//LEFT(con_mobile, 1) = '5' and len(con_mobile) >= 9
	}
	else if(isset($_POST['cus_active']) && $_POST['cus_active'] == "on" )
	{
		$sql_sel = "select distinct cus.*  
				,  det_count , det_show , wha_id  
				, ( select cou_name from country where cou_id = cus.cou_id)
				as cou_name 
				, ( select cit_name from city where cit_id = cus.cit_id)
				as cit_name 
				from customer cus inner join whats_customer
				on cus.cus_id = whats_customer.cus_id and   wha_id =  " 
				. $_POST["wha_id"] .
				
				$search . "  order by cus_id desc limit $start,$end";
	}
	else if(isset($_POST['cus_active']) && $_POST['cus_active'] == "off" )
	{
		$sql_sel = "select distinct cus.*  
				,  det_count , det_show , wha_id  
				, ( select cou_name from country where cou_id = cus.cou_id)
				as cou_name 
				, ( select cit_name from city where cit_id = cus.cit_id)
				as cit_name 
				from customer cus left outer join whats_customer
				on cus.cus_id = whats_customer.cus_id and   wha_id =  " 
				. $_POST["wha_id"] .
				
				$search . " and wha_id is null order by cus_id desc limit $start,$end";
	}
	
	

//echo $sql_sel ;
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
				
							$str .= ' <table width ="100%"> <tr align="center" 						style="margin-top:5px;height:45px;background-color:' 
							.$_color. '" id = "tbl_'. $cus_id .'"> ';
							$str .= ' <td align="center" style="cursor:pointer;width:30px" 
							 > ';
							$str .= $cus_id;
							$str .= ' </td> ';
							$str .= '<td  style="width:30px">';
							$str .= '<input type ="checkbox" id = "chk_'.$cus_id.'" check_value = "'.
							$cus_id .'" />' ;
							$str .= '</td>';
							
							$str .= ' <td align="center" style="cursor:pointer;;width:250px" > ';
						
							$str .= '<p id ="tdcus_name'.$cus_id.'" style ="margin:0px"> ';
							$str .= utf8_decode($cus_name) ;
							$str .= '</p> ';
							$str .= '<p  id ="tdcus_mobile'.$cus_id.'"  style ="margin:0px"> ';
							 
							$str .= utf8_decode($cus_pwd) ;
							$str .= ' </p> ';
							$str .= ' </td> ';
							
						$str .= ' <td style=";width:150px"> ';
							$str .= $cus_email ;
							$str .= "<br>";
							$str .= $cus_mobile ;
							
							$str .= " <a href ='whatsapp_customer/message_customer.php?cus_id=$cus_id'
							 target ='_blank' ";
							$str .= " style ='color:#9497A1;text-decoration:none' ";
							$str .=  " title ='" 
							. get_wh_customer($cus_id) ."'>";
							$str .= " <span style ='background-color:#B7FFB7;width:10px;height:10px;display:inline-block;border-radius:50%;color:white;font-size:10px'></span> ";
							$str .= " </a> ";
							
							$str .= ' </td> ';
							
							
							$str .= ' <td style=";width:150px"> ';
							$str .= utf8_decode($cou_name) . " - " 
							. utf8_decode($cit_name);
							$str .= ' </td> ';
							
							
				
							$str .= ' <td align="center" style="cursor:pointer">';
							if($wha_id == $_POST["wha_id"])
							{
								$str .= "<img src = '../icon/true.gif'>";
							}
							else
							{
								$str .= "<img src = '../icon/false.gif'>";
							}
							
							$str .= ' </td> ';
							
							$str .= ' <td style=";width:100px"> ';
							
							$str .= $det_count;
							$str .= ' </td> ';
							
							
							$str .= ' <td style=";width:150px"> ';
							$str .= $cus_regdate ;

							$str .= ' </td> ';
							$str .= ' </tr> </table>';
//							$str .= ' </table> ';
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


function sendwhats_from()
{
	$search = " where 'a' = 'a' ";
	if(isset($_POST['txtsearch']) && $_POST['txtsearch'] != "")
	{
		$search .= " and  (cus_name like '%" .utf8_encode($_POST['txtsearch'])
		. "%' or  cus_mobile like '%" .utf8_encode($_POST['txtsearch']). "%'"
		. " or  cus_email like '%" .utf8_encode($_POST['txtsearch']). "%') ";
	}
	if(isset($_POST['cou_id']) && $_POST['cou_id'] != "0" && $_POST['cou_id'] != "")
	{
		$search .= " and cou_id = " . $_POST['cou_id'];
	}
	if(isset($_POST['cus_id']) && $_POST['cus_id'] != "0" 
	&& $_POST['cus_id'] != "")
	{
		$search .= " and cus.cus_id = " . $_POST['cus_id'];
	}
	if(isset($_POST['from']) && $_POST['from'] != "0" && $_POST['from'] != ""
&&	isset($_POST['to']) && $_POST['to'] != "0" && $_POST['to'] != "")
	{
		$search .= " and ( cus.cus_id >= " . $_POST['from'] . " and cus.cus_id <=" 
		.$_POST['to'] . " ) ";
	}
	if(isset($_POST['cit_id']) && $_POST['cit_id'] != "0" && $_POST['cit_id'] != "")
	{
		$search .= " and cit_id = " . $_POST['cit_id'];
	}
	if(isset($_POST['cus_gender']) && $_POST['cus_gender'] != "0" && $_POST['cus_gender'] != "")
	{
		$search .= " and cus_gender = " . $_POST['cus_gender'];
	}
	if(isset($_POST['cus_active']) && $_POST['cus_active'] == "0" )
	{
		
			
			$sql_sel = "select distinct cus.*  
				,  det_count , det_show , wha_id 
				, ( select cou_name from country where cou_id = cus.cou_id)
				as cou_name 
				, ( select cit_name from city where cit_id = cus.cit_id)
				as cit_name 
				from customer cus left outer join whats_customer
				on cus.cus_id = whats_customer.cus_id and   wha_id =  " 
				. 
				$_POST["wha_id"] 
				.
				
				$search . "  order by cus.cus_id desc ";
				//LEFT(con_mobile, 1) = '5' and len(con_mobile) >= 9
	}
	else if(isset($_POST['cus_active']) && $_POST['cus_active'] == "on" )
	{
		$sql_sel = "select distinct cus.*  
				,  det_count , det_show , wha_id  
				, ( select cou_name from country where cou_id = cus.cou_id)
				as cou_name 
				, ( select cit_name from city where cit_id = cus.cit_id)
				as cit_name 
				from customer cus inner join whats_customer
				on cus.cus_id = whats_customer.cus_id and   wha_id =  " 
				. $_POST["wha_id"] .
				
				$search . "  order by cus.cus_id desc ";
	}
	else if(isset($_POST['cus_active']) && $_POST['cus_active'] == "off" )
	{
		$sql_sel = "select distinct cus.*  
				,  det_count , det_show , wha_id  
				, ( select cou_name from country where cou_id = cus.cou_id)
				as cou_name 
				, ( select cit_name from city where cit_id = cus.cit_id)
				as cit_name 
				from customer cus left outer join whats_customer
				on cus.cus_id = whats_customer.cus_id and   wha_id =  " 
				. $_POST["wha_id"] .
				
				$search . " and wha_id is null order by cus.cus_id desc ";
	}
	
	

//echo $sql_sel ;
					$result_sel = dbQuery_PDO_no($sql_sel);
					$str = '';
					if($result_sel->rowCount() >0)
					{		$s = "";					
						while($row = $result_sel->fetch(PDO::FETCH_ASSOC)) 
						{
							extract($row);
							$s = $s . $cus_id . " - ";
							sendwhats($cus_id );
						}
						echo $s;
					}
}
function sendwhats($cus_id)
{
	
	$add_array = array();
$cus_name = "";
$cus_mobile = "";
	if ( $cus_id != ""  && $cus_id != NULL) {		
		
			$cus_id = $cus_id;		
			$with_name = ares($_POST['with_name']);
			$wha_id = ares($_POST['wha_id']);
			
			//===================get data user
			
			$sql_wha = "SELECT *
					FROM whatsapp
					WHERE wha_id = $wha_id ";		
			$result_wha = dbQuery_PDO_no($sql_wha );
			if($result_wha->rowCount() >0)
			{
				$row = $result_wha->fetch();
				$wha_info = $row["wha_info"];
				$wha_image = $row["wha_image"];
			}
			
				$sql_customer = "SELECT *
						FROM customer
						WHERE cus_id = $cus_id ";		
				$result_customer = dbQuery_PDO_no($sql_customer );
				if($result_customer->rowCount() >0)
				{
					$row = $result_customer->fetch();
					$cus_name = $row["cus_name"];
					$cus_mobile = $row["cus_mobile"];
				}
			
			//==================get chat_api send whatsapp
send_whatsapp($cus_name,$wha_info,$cus_mobile,$with_name ,
			"http://s756138061.onlinehome.us/images/whatsapp" .$wha_image);//.
			//==================insert to history
			$sql_insert = " insert into 
					mes_cus_whats(wha_id , cus_id,mes_content,mes_regdate) 
					value($wha_id,$cus_id,'$wha_info',now())";
					 dbQuery_PDO_no($sql_insert );
			//==================end insert to history
			
			//===================check is send whats app 
			$sql_send = "SELECT *
						FROM whats_customer
						WHERE wha_id = $wha_id and cus_id = $cus_id";		
				$result_send = dbQuery_PDO_no($sql_send );
				if($result_send->rowCount() >0)
				{
					
									$sql_update = " update whats_customer set 
					det_count = det_count  + 1
					where wha_id = $wha_id 
					and  cus_id =$cus_id ";
					 dbQuery_PDO_no($sql_update );
				}
				else
				{
					$sql_insert = " insert into 
					whats_customer(wha_id , cus_id,det_count,det_regdate) 
					value($wha_id,$cus_id,1,now())";
					 dbQuery_PDO_no($sql_insert );

				}
			//===================end check
			
			
			//=============end get data user
			
			
	
		}
		else
		{
				echo 'failure';
				exit();
		}
}



//==================================
?>