<?php
require_once 'config.php';
require_once 'database.php';

/*
	Make sure each key name in $requiredField exist
	in $_POST and the value is not empty
*/
if(isset($_POST["action"]) && $_POST["action"] == "filldata_sel")
{
	filldata_sel($_POST["sql"] , $_POST["name"] , $_POST["id"] 
	, $_POST["selected"] , $_POST["def_val"] , $_POST["ed"]);
}

function ares($input){

$input = stripslashes($input);
// return mysql_real_escape_string($input);
return $input;
}  
//======================fill select
function filldata_sel($sql , $name , $id , $selected , $def_val , $ed )
{
		$str = "";
		//$sql = "select * from type_outlet order by typ_name"  ;
		$result = dbQuery_PDO_no($sql);
		if($result->rowCount() >0)
		{		
			$str .= " var x = document.getElementById('" . $ed . "cmb" .$id. "');";	
			while($row = $result->fetch(PDO::FETCH_ASSOC)) 
			{
				extract($row);
				$str .= " var option = document.createElement('option');";
				$str .= " option.text = '" .utf8_decode(${$name}) . "';";
				$str .= " option.value = '" . ${$id}. "';";
				if($selected == ${$id})
				{
					$str .=" option.selected = 'true';";
				}
				$str .= " x.add(option);";
			}
			echo $str;
		}
		else
		{
			echo "0";
		}
		
	
}
//=========================total tables
	function get_total($sql)
	{

        $result = dbQuery_PDO_no($sql );
		$row    =  $result->fetch(PDO::FETCH_ASSOC);
		extract($row);
		echo $con;
	}
	


//=========send sms
function SendEmail($msg , $email){
/*$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
	$headers .= "From: info@haflh.com" . "\r\n" .
	"Reply-To: info@haflh.com" . "\r\n" .
	"X-Mailer: PHP/" . phpversion();
	mail($email, "حفلة", $msg, $headers);*/
}
//============================send email

//=================================================end send email
//pay by paypal
function pay_paypal($ite_id , $price)
{
	$url_paypal = "https://www.paypal.com/xclick/business=thaer_re@yahoo.com";
	$url_paypal .= "&item_name=" . "buy host";
	$url_paypal .= "&item_number=" . $ite_id;
	$url_paypal .= "&cm=host"  ;
	$url_paypal .= "&city=saudia" ;
	$url_paypal .= "&state=template-store"  ;
	$url_paypal .= "&amount=" . $price;
	$url_paypal .= "&currency=USD" ;
	$url_paypal .= "&return=http://www.template-store.com/success_pay.aspx"  ;
	$url_paypal .= "&cancel_return=http://www.template-store.com/faild_pay.aspx"  ;
	return $url_paypal;
}
//==============================================begin images 
function uploadCustomerImage($inputName, $uploadDir  , $thumbnail_width , $image_width)
{
	$image = $_FILES[$inputName];
	//echo "error " . $image['name'] . $image['tmp_name'] . "end;";	
	$imagePath = '';
	$thumbnailPath = '';
//	echo "before";
	// if a file is given
	if (trim($image['tmp_name']) != '') {
		$ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];

		// generate a random new file name to avoid name conflict
		$imagePath = md5(rand() * time()) . ".$ext";
		
		list($width, $height, $type, $attr) = getimagesize($image['tmp_name']); 

		// make sure the image width does not exceed the
		// maximum allowed width
		
		if (LIMIT_PRODUCT_WIDTH && $width > $image_width) {
//					echo "after";
			$result    = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, $image_width);
			$imagePath = $result;
		} else {
			$result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
		}	
		
		if ($result) {
			// create thumbnail
			$thumbnailPath =  md5(rand() * time()) . ".$ext";
			$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, $thumbnail_width);
			
			// create thumbnail failed, delete the image
			if (!$result) {
				unlink($uploadDir . $imagePath);
				$imagePath = $thumbnailPath = '';
			} else {
				$thumbnailPath = $result;
			}	
		} else {
			// the product cannot be upload / resized
			$imagePath = $thumbnailPath = '';
		}
		
	}

	
	return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}

function createThumbnail($srcFile, $destFile, $width, $quality = 75)
{
	$thumbnail = '';
	
	if (file_exists($srcFile)  && isset($destFile))
	{
		$size        = getimagesize($srcFile);
		$w           = number_format($width, 0, ',', '');
		$h           = number_format(($size[1] / $size[0]) * $width, 0, ',', '');
		
		$thumbnail =  copyImage($srcFile, $destFile, $w, $h, $quality);
	}
	
	// return the thumbnail file name on sucess or blank on fail
	return basename($thumbnail);
}

/*
	Copy an image to a destination file. The destination
	image size will be $w X $h pixels
*/


function copyImage($srcFile, $destFile, $w, $h, $quality = 75)
{
    $tmpSrc     = pathinfo(strtolower($srcFile));
    $tmpDest    = pathinfo(strtolower($destFile));
    $size       = getimagesize($srcFile);

    if ($tmpDest['extension'] == "gif" || $tmpDest['extension'] == "jpg"
	|| $tmpDest['extension'] == "jpeg" 
	|| $tmpDest['extension'] == "bmp" || $tmpDest['extension'] == "mpeg")
    {
       $destFile  = substr_replace($destFile, 'jpg', -3);
       $dest      = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } elseif ($tmpDest['extension'] == "png") {
    /*   $dest = imagecreatetruecolor($w, $h);
	   $white = imagecolorallocate($dest, 255, 255, 255); 
	   imagefill($dest,0,0,$white);
       imageantialias($dest, TRUE);*/
	   
	      $dest = imagecreatetruecolor($w, $h);
	    $background = imagecolorallocate($dest, 255, 255, 255);
        imagecolortransparent($dest, $background);
        imagealphablending($dest, false);
        imagesavealpha($dest, true);
		
		
    } else {
      return false;
    }

    switch($size[2])
    {
       case 1:       //GIF
           $src = imagecreatefromgif($srcFile);
           break;
       case 2:       //JPEG
           $src = imagecreatefromjpeg($srcFile);
           break;
       case 3:       //PNG
           $src = imagecreatefrompng($srcFile);
           break;
       default:
           return false;
           break;
    }

    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);

    switch($size[2])
    {
       case 1:
       case 2:
           imagejpeg($dest,$destFile, $quality);
           break;
       case 3:
           imagepng($dest,$destFile);
    }
    return $destFile;

}
//==============================================end images

	function calc_date(  $todate)
	{
		$date1 = date_create($todate);
		$date2 =  date_create(date('Y-m-d H:i:s'));
		
		//difference between two dates
		$diff = date_diff($date1,$date2);
		
		//count days
		//$day = $diff->format("%a");
		//$diff->d;
		//====================
		/*$seconds = strtotime($date2) - strtotime($date1);
		
		$mins = $seconds / 60 ;
		$hours = $seconds / 60 /  60;*/
		//=====================
		if($diff->d > 0 )
		{
			return date_format($date1,"Y-m-d");
		}
		else if($diff->h > 0)
		{
			return $diff->h . " ساعة ";
		}
		else if($diff->i > 0)
		{
			return $diff->i . " دقيقة ";
		}
		else if($diff->s > 0)
		{
			return $diff->s . " ثانية";
		}
		else
		{
			return date_format($date1,"Y-m-d");
		}

	}
	
	function getGender($cus_gender)
	{
		if($cus_gender == "1")
		{
			return "male";
		}
		else if($cus_gender == "2")
		{
			return "female";
		}
		else
		{
			return "";
		}
	}
	//===================================notification
	//==============================send notification



function send_notification( $_id , $_name , $message , $sql) {
	
    //    $sql = "select * from fcm_users";

	$result = dbQuery_PDO_no($sql) ;
	$group_fcm= array();
	$i = 0;
	if($result->rowCount() > 0)
	{
		while($row = $result->fetch(PDO::FETCH_ASSOC)) 
		{
			$i = $i + 1;
			extract($row);
			array_push($group_fcm, $fcm_regid);
			if($i == 998)
			{
				sendGCM($message , $group_fcm , $_id, $_name );
				$group_fcm= array();
				$i = 0;
			}
			//array_push($group_fcm, $fcm_regid);
			/*extract($row);
			sendGCM( $message ,  $fcm_regid , $_id, $_name );						*/
		}
			
	}
	sendGCM($message , $group_fcm , $_id, $_name );
}
function sendGCM($message, $fcm_id , $p_id, $p_name) {
//	$message = strip_tags($message);
//	$message = str_replace("&nbsp;", "", $message);
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array (
            'registration_ids' => $fcm_id ,
'priority' =>'high',
'content_available' => true,

            'notification' => array (
			"body" =>  $message,
      		"title" =>  "SabaMarket",
			"click_action" => "FCM_PLUGIN_ACTIVITY",
					"sound" => "default"
					
            ),
			 'data' => array (
			
					"page_id" => $p_id ,
					"page_name" => $p_name ,
					"message" => $message
//			'message' => 'Hello World!'
					
            )
			
    );
    $fields = json_encode ( $fields );

    $headers = array (
           // 'Authorization: key=' . "AIzaSyBUuLepXI4xjIuWBO78hagHX9ntj9j_mU4",
		    'Authorization: key=' . "AAAAC8jihzU:APA91bH_quT0Je4tOUm2vY3mDQxKSphUIynGBmrPrFK-G1KbpEVEyvUTgU_xZy_6S8Rnjh2pM8HJAiqm_eLUdHKvQXC77zH64cj5xrl6Mj7wxxLs3-UA5hmOd7LLjxIP5xxRAdReOfOJ-EpZdFX9ng7xC0OhTYTwtQ",
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
	return $result;
    curl_close ( $ch );
}

	//===================================end notification
	
	
	function SendSms($msg , $phone){
	//$message = mb_convert_encoding($msg,  "UTF-8", "UTF-32") ;
	$message= ToUTF($msg);//urlencode("3232" );
	//$message = convertToUnicode($msg);
	$url= "http://www.mobily.ws/api/msgSend.php?mobile=966544999880&password=homealone65"
 	."&numbers=". $phone ."&unicode=E&msg=".$message."&sender=EliteDoctor&applicationType=24&msgId=0";
	if(!$url || $url==""){
	return "No URL";
	}else{
			 $ch = curl_init();
			 curl_setopt($ch, CURLOPT_URL,$url);
			 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			 curl_setopt($ch, CURLOPT_VERBOSE, 0);
			 curl_setopt($ch, CURLOPT_HEADER,0);
			 curl_setopt($ch, CURLE_HTTP_NOT_FOUND,1);
			 //curl_setopt($ch, CURLOPT_FAILONERROR,1);
			 $LastData = curl_exec ($ch);
			  curl_close ($ch);
	echo $LastData;
	}
}


function ToUTF($message)

	{

	$chrArray[0]="،";

	$unicodeArray[0]="060C";

	$chrArray[1]="؛";

	$unicodeArray[1]="061B";

	$chrArray[2]="؟";

	$unicodeArray[2]="061F";

	$chrArray[3]="ء";

	$unicodeArray[3]="0621";

	$chrArray[4]="آ";

	$unicodeArray[4]="0622";

	$chrArray[5]="أ";

	$unicodeArray[5]="0623";

	$chrArray[6]="ؤ";

	$unicodeArray[6]="0624";

	$chrArray[7]="إ";

	$unicodeArray[7]="0625";

	$chrArray[8]="ئ";

	$unicodeArray[8]="0626";

	$chrArray[9]="ا";

	$unicodeArray[9]="0627";

	$chrArray[10]="ب";

	$unicodeArray[10]="0628";

	$chrArray[11]="ة";

	$unicodeArray[11]="0629";

	$chrArray[12]="ت";

	$unicodeArray[12]="062A";

	$chrArray[13]="ث";

	$unicodeArray[13]="062B";

	$chrArray[14]="ج";

	$unicodeArray[14]="062C";

	$chrArray[15]="ح";

	$unicodeArray[15]="062D";

	$chrArray[16]="خ";

	$unicodeArray[16]="062E";

	$chrArray[17]="د";

	$unicodeArray[17]="062F";

	$chrArray[18]="ذ";

	$unicodeArray[18]="0630";

	$chrArray[19]="ر";

	$unicodeArray[19]="0631";

	$chrArray[20]="ز";

	$unicodeArray[20]="0632";

	$chrArray[21]="س";

	$unicodeArray[21]="0633";

	$chrArray[22]="ش";

	$unicodeArray[22]="0634";

	$chrArray[23]="ص";

	$unicodeArray[23]="0635";

	$chrArray[24]="ض";

	$unicodeArray[24]="0636";

	$chrArray[25]="ط";

	$unicodeArray[25]="0637";

	$chrArray[26]="ظ";

	$unicodeArray[26]="0638";

	$chrArray[27]="ع";

	$unicodeArray[27]="0639";

	$chrArray[28]="غ";

	$unicodeArray[28]="063A";

	$chrArray[29]="ف";

	$unicodeArray[29]="0641";

	$chrArray[30]="ق";

	$unicodeArray[30]="0642";

	$chrArray[31]="ك";

	$unicodeArray[31]="0643";

	$chrArray[32]="ل";

	$unicodeArray[32]="0644";

	$chrArray[33]="م";

	$unicodeArray[33]="0645";

	$chrArray[34]="ن";

	$unicodeArray[34]="0646";

	$chrArray[35]="ه";

	$unicodeArray[35]="0647";

	$chrArray[36]="و";

	$unicodeArray[36]="0648";

	$chrArray[37]="ى";

	$unicodeArray[37]="0649";

	$chrArray[38]="ي";

	$unicodeArray[38]="064A";

	$chrArray[39]="ـ";

	$unicodeArray[39]="0640";

	$chrArray[40]="ً";

	$unicodeArray[40]="064B";

	$chrArray[41]="ٌ";

	$unicodeArray[41]="064C";

	$chrArray[42]="ٍ";

	$unicodeArray[42]="064D";

	$chrArray[43]="َ";

	$unicodeArray[43]="064E";

	$chrArray[44]="ُ";

	$unicodeArray[44]="064F";

	$chrArray[45]="ِ";

	$unicodeArray[45]="0650";

	$chrArray[46]="ّ";

	$unicodeArray[46]="0651";

	$chrArray[47]="ْ";

	$unicodeArray[47]="0652";

	$chrArray[48]="!";

	$unicodeArray[48]="0021";

	$chrArray[49]='"';

	$unicodeArray[49]="0022";

	$chrArray[50]="#";

	$unicodeArray[50]="0023";

	$chrArray[51]="$";

	$unicodeArray[51]="0024";

	$chrArray[52]="%";

	$unicodeArray[52]="0025";

	$chrArray[53]="&";

	$unicodeArray[53]="0026";

	$chrArray[54]="'";

	$unicodeArray[54]="0027";

	$chrArray[55]="(";

	$unicodeArray[55]="0028";

	$chrArray[56]=")";

	$unicodeArray[56]="0029";

	$chrArray[57]="*";

	$unicodeArray[57]="002A";

	$chrArray[58]="+";

	$unicodeArray[58]="002B";

	$chrArray[59]=",";

	$unicodeArray[59]="002C";

	$chrArray[60]="-";

	$unicodeArray[60]="002D";

	$chrArray[61]=".";

	$unicodeArray[61]="002E";

	$chrArray[62]="/";

	$unicodeArray[62]="002F";

	$chrArray[63]="0";

	$unicodeArray[63]="0030";

	$chrArray[64]="1";

	$unicodeArray[64]="0031";

	$chrArray[65]="2";

	$unicodeArray[65]="0032";

	$chrArray[66]="3";

	$unicodeArray[66]="0033";

	$chrArray[67]="4";

	$unicodeArray[67]="0034";

	$chrArray[68]="5";

	$unicodeArray[68]="0035";

	$chrArray[69]="6";

	$unicodeArray[69]="0036";

	$chrArray[70]="7";

	$unicodeArray[70]="0037";

	$chrArray[71]="8";

	$unicodeArray[71]="0038";

	$chrArray[72]="9";

	$unicodeArray[72]="0039";

	$chrArray[73]=":";

	$unicodeArray[73]="003A";

	$chrArray[74]=";";

	$unicodeArray[74]="003B";

	$chrArray[75]="<";

	$unicodeArray[75]="003C";

	$chrArray[76]="=";

	$unicodeArray[76]="003D";

	$chrArray[77]=">";

	$unicodeArray[77]="003E";

	$chrArray[78]="?";

	$unicodeArray[78]="003F";

	$chrArray[79]="@";

	$unicodeArray[79]="0040";

	$chrArray[80]="A";

	$unicodeArray[80]="0041";

	$chrArray[81]="B";

	$unicodeArray[81]="0042";

	$chrArray[82]="C";

	$unicodeArray[82]="0043";

	$chrArray[83]="D";

	$unicodeArray[83]="0044";

	$chrArray[84]="E";

	$unicodeArray[84]="0045";

	$chrArray[85]="F";

	$unicodeArray[85]="0046";

	$chrArray[86]="G";

	$unicodeArray[86]="0047";

	$chrArray[87]="H";

	$unicodeArray[87]="0048";

	$chrArray[88]="I";

	$unicodeArray[88]="0049";

	$chrArray[89]="J";

	$unicodeArray[89]="004A";

	$chrArray[90]="K";

	$unicodeArray[90]="004B";

	$chrArray[91]="L";

	$unicodeArray[91]="004C";

	$chrArray[92]="M";

	$unicodeArray[92]="004D";

	$chrArray[93]="N";

	$unicodeArray[93]="004E";

	$chrArray[94]="O";

	$unicodeArray[94]="004F";

	$chrArray[95]="P";

	$unicodeArray[95]="0050";

	$chrArray[96]="Q";

	$unicodeArray[96]="0051";

	$chrArray[97]="R";

	$unicodeArray[97]="0052";

	$chrArray[98]="S";

	$unicodeArray[98]="0053";

	$chrArray[99]="T";

	$unicodeArray[99]="0054";

	$chrArray[100]="U";

	$unicodeArray[100]="0055";

	$chrArray[101]="V";

	$unicodeArray[101]="0056";

	$chrArray[102]="W";

	$unicodeArray[102]="0057";

	$chrArray[103]="X";

	$unicodeArray[103]="0058";

	$chrArray[104]="Y";

	$unicodeArray[104]="0059";

	$chrArray[105]="Z";

	$unicodeArray[105]="005A";

	$chrArray[106]="[";

	$unicodeArray[106]="005B";

	$char="\ ";

	$chrArray[107]=trim($char);

	$unicodeArray[107]="005C";

	$chrArray[108]="]";

	$unicodeArray[108]="005D";

	$chrArray[109]="^";

	$unicodeArray[109]="005E";

	$chrArray[110]="_";

	$unicodeArray[110]="005F";

	$chrArray[111]="`";

	$unicodeArray[111]="0060";

	$chrArray[112]="a";

	$unicodeArray[112]="0061";

	$chrArray[113]="b";

	$unicodeArray[113]="0062";

	$chrArray[114]="c";

	$unicodeArray[114]="0063";

	$chrArray[115]="d";

	$unicodeArray[115]="0064";

	$chrArray[116]="e";

	$unicodeArray[116]="0065";

	$chrArray[117]="f";

	$unicodeArray[117]="0066";

	$chrArray[118]="g";

	$unicodeArray[118]="0067";

	$chrArray[119]="h";

	$unicodeArray[119]="0068";

	$chrArray[120]="i";

	$unicodeArray[120]="0069";

	$chrArray[121]="j";

	$unicodeArray[121]="006A";

	$chrArray[122]="k";

	$unicodeArray[122]="006B";

	$chrArray[123]="l";

	$unicodeArray[123]="006C";

	$chrArray[124]="m";

	$unicodeArray[124]="006D";

	$chrArray[125]="n";

	$unicodeArray[125]="006E";

	$chrArray[126]="o";

	$unicodeArray[126]="006F";

	$chrArray[127]="p";

	$unicodeArray[127]="0070";

	$chrArray[128]="q";

	$unicodeArray[128]="0071";

	$chrArray[129]="r";

	$unicodeArray[129]="0072";

	$chrArray[130]="s";

	$unicodeArray[130]="0073";

	$chrArray[131]="t";

	$unicodeArray[131]="0074";

	$chrArray[132]="u";

	$unicodeArray[132]="0075";

	$chrArray[133]="v";

	$unicodeArray[133]="0076";

	$chrArray[134]="w";

	$unicodeArray[134]="0077";

	$chrArray[135]="x";

	$unicodeArray[135]="0078";

	$chrArray[136]="y";

	$unicodeArray[136]="0079";

	$chrArray[137]="z";

	$unicodeArray[137]="007A";

	$chrArray[138]="{";

	$unicodeArray[138]="007B";

	$chrArray[139]="|";

	$unicodeArray[139]="007C";

	$chrArray[140]="}";

	$unicodeArray[140]="007D";

	$chrArray[141]="~";

	$unicodeArray[141]="007E";

	$chrArray[142]="©";

	$unicodeArray[142]="00A9";

	$chrArray[143]="®";

	$unicodeArray[143]="00AE";

	$chrArray[144]="÷";

	$unicodeArray[144]="00F7";

	$chrArray[145]="×";

	$unicodeArray[145]="00F7";

	$chrArray[146]="§";

	$unicodeArray[146]="00A7";

	$chrArray[147]=" ";

	$unicodeArray[147]="0020";

	$chrArray[148]="\n";

	$unicodeArray[148]="000D";

	$chrArray[149]="\r";

	$unicodeArray[149]="000A";

	$chrArray[150]="\t";

	$unicodeArray[150]="0009";
	$chrArray[151]="é";

	$unicodeArray[151]="00E9";

	$chrArray[152]="ç";

	$unicodeArray[152]="00E7";
	$chrArray[153]="à";

	$unicodeArray[153]="00E0";
	$chrArray[154]="ù";

	$unicodeArray[154]="00F9";
	$chrArray[155]="µ";

	$unicodeArray[155]="00B5";
	$chrArray[156]="è";

	$unicodeArray[156]="00E8";


	            $strResult="";

	            for($i=0;$i<strlen($message);$i++)

	                {

	                  for($c=0;$c<count($chrArray);$c++)

	                     {


	                    if($chrArray[$c]==substr($message,$i,1))

	                       {
						    substr($message,$i,1);


	                        $strResult .=$unicodeArray[$c];

	                    //   echo "[".$unicodeArray[$c]."]<br>";

	                       }

	                      }

	               }



	           return $strResult;

	}
