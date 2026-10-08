<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Uuload File</title>

</head>
<body>
<?php
	$error = "";
	$msg = "";
	$fileElementName = 'inputPicUpload';
	if(!empty($_FILES['inputPicUpload']['error'])){
		switch($_FILES['inputPicUpload']['error']){

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;

			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif($_FILES['inputPicUpload']['tmp_name'] == 'none'){
		$error = 'No file was uploaded..';
	}else{
			
			include("../libs/connect.php");
			include("../libs/function.php");
			include("../libs/classpic.php");
			include("../libs/config.php");
			

			$myContantID=$_REQUEST["myContantID"];
			$masterkey=$_REQUEST["masterkey"];
			$inputGallery=$_FILES['inputPicUpload']['tmp_name'];
			$arrfile=$_FILES['inputPicUpload'];
			$ERROR=$_FILES['inputPicUpload']['error'];
			$TIME=time();
			$p=new pic();
			$p->addpic($arrfile);
			$p->chktypepic(); 
			$ext=$p->ret();
		if($ext=="jpg" || $ext=="JPG" || $ext=="jpeg" || $ext=="JPEG" || $ext=="gif" || $ext=="GIF" || $ext=="png" || $ext=="PNG"){
			
			$mod_path_pictures_fornt="../../uploads/api/pictures/";
			$mod_path_index_fornt="../../uploads/api/index/";
			if(!is_dir($core_pathname_upload_fornt."/".$_REQUEST["masterkey"])) { mkdir($core_pathname_upload_fornt."/".$_REQUEST["masterkey"],0777); }
			if(!is_dir($mod_path_pictures_fornt)) { mkdir($mod_path_pictures_fornt,0777); } 
			if(!is_dir($mod_path_index_fornt)) { mkdir($mod_path_index_fornt,0777); }
			
			if(!$ERROR) {
			$myrand = rand(1111111111,9999999999);
			$date=time(date("Y-m-d H:i:s"));
			$filename= $_REQUEST["myContantID"].$date."$myrand";
			
			 
			$picname=$filename.".jpg";
			
			##  Real ################################################################################
			if(copy($inputGallery,$mod_path_pictures_fornt."/".$picname)){
				@chmod($mod_path_pictures_fornt."/".$picname,0777);
			}
			
			$imgReal = $mod_path_pictures_fornt."/".$picname; // File image location
			
			##  Pictures ################################################################################
			$newename = "pic-".$picname; // New file name for thumb
			$newfilename = $mod_path_pictures_fornt."/pic-".$picname; // New file name for thumb
			$w = 300;
			//$h = $sizeHeightPic;
			/*$thumbnail = resize($imgReal, $w, $h, $newfilename);
			
			##  index ################################################################################
			$newfilename = $mod_path_index_fornt."/pic-".$picname; // New file name for thumb
			$w = $sizeWidthIndex;
			//$h = $sizeHeightIndex;
			$thumbnail = resize($imgReal, $w, $h, $newfilename);
			
			if(file_exists($imgReal)) {	
				@unlink($imgReal);
			}
		if($_REQUEST["myContantID"]!=""){
			
			$sql_deleletfilet="SELECT * FROM md_api WHERE md_api_id	='".$_REQUEST["myContantID"]."'";
			$query_deleletfilep=$mysqli->query($sql_deleletfilet)OR DIE("Error sql_deleletfilet: <br>$sql_deleletfilet<br>\n");
			$row_deleletfilet=$query_deleletfilep->fetch_array();
			if($row_deleletfilet["md_api_picname"]!=""){;
				$linkRelativePathDelelet = $mod_path_pictures_fornt."/".$row_deleletfilet["md_api_picname"];
				$linkRelativePathDeleletindex = $mod_path_index_fornt."/".$row_deleletfilet["md_api_picname"];
				if(file_exists($linkRelativePathDelelet)) {	
					@unlink($linkRelativePathDelelet);
				}
				if(file_exists($linkRelativePathDeleletindex)) {	
					@unlink($linkRelativePathDeleletindex);
				}
			}
			
			$update[]="md_api_picname='".$newename."'";
		
			$sql_update="UPDATE md_api SET ".implode(",",$update)." WHERE md_api_id='".$_REQUEST["myContantID"]."'";
			$Query=$mysqli->query($sql_update) OR DIE("Error sql_update: <br>$sql_update<br>\n");
	
	
			$sql_filetemp="SELECT * FROM md_api WHERE md_api_id	='".$_REQUEST["myContantID"]."'";
			$query_filetemp=$mysqli->query($sql_filetemp);
			$number_filetemp=$query_filetemp->num_rows;
			if($number_filetemp>=1){
			$row_filetemp=$query_filetemp->fetch_array();
			$linkRelativePath = $mod_path_pictures_fornt."/".$row_filetemp["md_api_picname"];
			$downloadID = $row_filetemp[$mod_md_timetable."_id"];
																
				
				$msg = "<img  src=\"$linkRelativePath\"/>";
				}
		}else{//if($_REQUEST["myContantID"]!=""){
				$linkRelativePath = $mod_path_pictures_fornt."/".$newename;
				$msg = "<img  src=\"$linkRelativePath\"/>";
				$msg .= "<input type=\"hidden\" id=\"input_picnoinsert\" name=\"input_picnoinsert\" value=\"$newename\" />";				
		}//if($_REQUEST["myContantID"]!=""){*/
	
	}//if(!$ERROR) {
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "'\n";
		echo "}";
	/*}else{
		$error="Please check image files";
		$sql_filetemp="SELECT * FROM md_api WHERE md_api_id	='".$_REQUEST["myContantID"]."'";
		$query_filetemp=$mysqli->query($sql_filetemp);
		$number_filetemp=$query_filetemp->num_rows;
		$row_filetemp=$query_filetemp->fetch_array();
		$linkRelativePath = $mod_path_pictures_fornt."/".$row_filetemp["md_api_picname"];
		$msg = "<img src=\"$linkRelativePath\"/>";
		
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "'\n";
		echo "}";*/
	}//if($ImageType==".jpg" || $ImageType==".jpeg" || $ImageType==".gif"){
	}		
	
?>

</body>
</html>