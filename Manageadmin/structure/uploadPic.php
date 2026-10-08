<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Uuload File</title>
<script language="JavaScript" src="../libs/js/jquery-1.3.2.js" type="text/javascript"></script>
<script language="JavaScript" src="../md_structure/set_staff.js" type="text/javascript"></script>

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
			include("config.php");

			$inputGallery=$_FILES['inputPicUpload']['tmp_name'];
			$arrfile=$_FILES['inputPicUpload'];
			$ERROR=$_FILES['inputPicUpload']['error'];
			$TIME=time();
			$p=new pic();
			$p->addpic($arrfile);
			$p->chktypepic(); 
			$ext=$p->ret();
		if($ext=="jpg" || $ext=="jpeg" || $ext=="gif"){
				
			if(!is_dir($core_pathname_upload."/".$_REQUEST["masterkey"])) { mkdir($core_pathname_upload."/".$_REQUEST["masterkey"],0777); }
			if(!is_dir($mod_path_pictures)) { mkdir($mod_path_pictures,0777); }  

			
			if(!$ERROR) {
			$myrand = rand(1111111111,9999999999);
			$filename= $_REQUEST["mycontantid"]."$myrand";
			
			 
			$picname=$filename.".".$ext;
			
			##  Real ################################################################################
			if(copy($inputGallery,$mod_path_pictures."/".$picname)){
				@chmod($mod_path_pictures."/".$picname,0777);
			}
			
			$imgReal = $mod_path_pictures."/".$picname; // File image location
			
			##  Pictures ################################################################################
			$newename = "pic-".$picname; // New file name for thumb
			$newfilename = $mod_path_pictures."/pic-".$picname; // New file name for thumb
			$w = $sizeWidthPic;
			//$h = $sizeHeightPic;
			$thumbnail = resize($imgReal, $w, $h, $newfilename);
			
			if(file_exists($imgReal)) {	
				@unlink($imgReal);
			}
		if($_REQUEST["mycontantid"]!=""){
			
			$sql_deleletfilet="SELECT * FROM ".$mod_sys_staff." WHERE ".$mod_sys_staff."_id	='".$_REQUEST["mycontantid"]."'";
			$query_deleletfilep=$mysqli->query($sql_deleletfilet);
			$row_deleletfilet=$query_deleletfilep->fetch_array();
			if($row_deleletfilet[$mod_sys_staff."_picname"]!=""){
				$linkRelativePathDelelet = $mod_path_pictures."/".$row_deleletfilet[$mod_sys_staff."_picname"];
				if(file_exists($linkRelativePathDelelet)) {	
					@unlink($linkRelativePathDelelet);
				}
			}
			
		$update[]=$mod_sys_staff."_picname='".$newename."'";
	
		$sql_update="UPDATE ".$mod_sys_staff." SET ".implode(",",$update)." WHERE ".$mod_sys_staff."_id='".$_REQUEST["mycontantid"]."'";
		$Query=$mysqli->query($sql_update) OR DIE("Error sql_update: <br>$sql_update<br>\n");
	
	
			$sql_filetemp="SELECT * FROM ".$mod_sys_staff." WHERE ".$mod_sys_staff."_id	='".$_REQUEST["mycontantid"]."'";
			$query_filetemp=$mysqli->query($sql_filetemp);
			$number_filetemp=$query_filetemp->num_rows;
			if($number_filetemp>=1){
			while($row_filetemp=$query_filetemp->fetch_array()){
			$linkRelativePath = $mod_path_pictures."/".$row_filetemp[$mod_sys_staff."_picname"];
			$downloadID = $row_filetemp[$mod_sys_staff."_id"];
																
				
				$msg = "<img id=\"avatar\" class=\"editable\" width=\"180\" height=\"200\" alt=\"Avatar\"  src=\"$linkRelativePath\"/>";
				}}
		}else{//if($_REQUEST["mycontantid"]!=""){
				$linkRelativePath = $mod_path_pictures."/".$newename;
				$msg = "<img id=\"avatar\" class=\"editable img-responsive\" alt=\"Avatar\"  src=\"$linkRelativePath\"/>";
				$msg .= "<input type=\"hidden\" id=\"input_picnoinsert\" name=\"input_picnoinsert\" value=\"$newename\" />";
		}//if($_REQUEST["mycontantid"]!=""){
	
	}
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "'\n";
		echo "}";
	}else{
		$error="Please check image files";
		$sql_filetemp="SELECT * FROM ".$mod_sys_staff." WHERE ".$mod_sys_staff."_id	='".$_REQUEST["mycontantid"]."'";
		$query_filetemp=$mysqli->query($sql_filetemp);
		$number_filetemp=$query_filetemp->num_rows;
		$row_filetemp=$query_filetemp->fetch_array();
		$linkRelativePath = $mod_path_pictures."/".$row_filetemp[$mod_sys_staff."_picname"];
		$msg = "<img id=\"avatar\" class=\"editable img-responsive\" alt=\"Avatar\"  src=\"$linkRelativePath\"/>";
		
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "'\n";
		echo "}";
	}//if($ImageType==".jpg" || $ImageType==".jpeg" || $ImageType==".gif"){
	}		
	
?>

</body>
</html>