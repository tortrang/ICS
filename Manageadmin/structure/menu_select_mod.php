<?php
include("../libs/config.php");
$CurrentPath=$_REQUEST["CurrentPath"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Select Module</title>
		<meta name="description" content="top menu &amp; navigation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="stylesheet" href="../../assets/css/dashlite.css?ver=2.2.0">
    	<link id="skin-default" rel="stylesheet" href="../../assets/css/theme.css?ver=2.2.0">
		<script src="../structure/menu.js"></script>
		<style type="text/css">

			.linkbox a:link {color: #666666;text-decoration: none;font-weight: bold;} /* unvisited link สีแดง*/ 
			.linkbox a:visited {color: #666666;text-decoration: none;} /* visited link สีเขียว*/ 
			.linkbox a:hover {color: #FFF;text-decoration: none;} /* mouse over link สีชมพู */ 
			.linkbox a:active {color: #666666;text-decoration: none;} /* selected link สีน้ำเงิน*/ 
			</style>
		</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#f5f5f5 !important;">
  <tr>
    <td   align="center" bgcolor="#C3C3C3">
    <table width="450" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td width="369" height="20" align="left" ><h5>คลิ๊กที่รูปภาพเพื่อทำการเลือก   </h5></td>
         <td width="81" height="20" align="right" style="padding-right:5px;" ><span style="cursor:pointer;"  onClick="window.close(); "><h5>ปิด</h5></span>     </td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td valign="top"  align="center"><table width="400" height="250" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td valign="top" >
    
<?php

function formatImageSize($mySize) {
	if($mySize>1024*1024) {
		return sprintf("%1.2f",$mySize/(1024*1024)) . "M";
	} else {
		return sprintf("%1.2f",$mySize/1024) . "k";
	}
}

function removeEndSlash($myURL) {
	if($myURL[strlen($myURL)-1]=="/") {
		return substr($myURL,0,strlen($myURL)-1);
	} else {
		return $myURL;
	}
}

function removeEndURL($myURL) {
	$myURLArray = explode("/",$myURL);
	$myURL  = $myURLArray[0];
	for($i=1;$i<count($myURLArray)-1;$i++) {
		$myURL =  $myURL . "/" . $myURLArray[$i];
	}
	return $myURL;
}

function getFileOrFolderName($myURL) {
	$myURLArray = explode("/",$myURL);
	return $myURLArray[count($myURLArray)-1];
}

function getFileOrFolderNameUpload($myURL) {
	$myURLArray = explode("\\",$myURL);
	return $myURLArray[count($myURLArray)-1];
}

?>
      <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
        
        <tr> 
          <td align="center" valign="top" > 
            <?php
$ImagePath = "..";
if($CurrentPath=="") { $CurrentPath = $ImagePath; }
$CurrentPath =removeEndSlash($CurrentPath);
$UpPath = removeEndURL($CurrentPath);
?>
            <table width="100%" border="0" cellpadding="1" cellspacing="0" id="htmltool_table">
              <tr> 
                <td height="22" align="center" valign="middle">&nbsp;</td>
                <td height="22" colspan="2" align="left"><span class="font_style10">
                  <?php echo $CurrentPath?>
                  </span></td>
              </tr>
              <?php
if($CurrentPath!=$ImagePath) {
	$FullPathBaseURL = $FullPath . "/" . substr($CurrentPath,strlen($ImagePath)+1,strlen($CurrentPath));
?>
              <tr onMouseOver="this.style.background='#C3C3C3'" onMouseOut="this.style.background=''"> 
                <td width="18" height="18" align="center" valign="middle"><i class="ace-icon fa fa-home bigger-150"></i></td>
                <td width="638" height="18" align="left" class="linkbox"> <a href="?CurrentPath=<?php echo $UpPath . "/" . $file ?>">&nbsp;&nbsp;..</a></td>
                <td width="41">&nbsp;</td>
              </tr>
              <?php
} else {
	$FullPathBaseURL = $FullPath;
}

// Get Folder
$handle = opendir($CurrentPath); 
while (false !== ($file = readdir($handle))) { 
    if ($file != "." && $file != "..") { 
		if(is_dir($CurrentPath . "/". $file)) {
				// Get Files Inside
				$FileInside=0;
				$ImageFileInside=0;
				$FileInsideHandle = opendir($CurrentPath . "/". $file); 
				while (false !== ($FileInsideFile = readdir($FileInsideHandle))) { 
					if ($FileInsideFile != "." && $FileInsideFile != "..") { 
							$FileInside++;
							if( is_file($CurrentPath . "/". $file . "/". $FileInsideFile) ) {
								//$size=GetImageSize($CurrentPath . "/". $file . "/". $FileInsideFile); 
								//if($size!=NULL) {
								$ImageFileInside++;
								//}
							}
						}
					}
					closedir($FileInsideHandle); 
			?>
			
              <tr onMouseOver="this.style.background='#C3C3C3'" onMouseOut="this.style.background=''"> 
                <td width="18" height="18" align="center" valign="middle"> 
                  <?php if($FileInside==0) { ?>
                 <em class="icon ni ni-folder-fill"></em> 
                  <?php } else { ?>
                  <em class="icon ni ni-folder-fill"></em>
                  <?php } ?>                </td>
                <td height="20" align="left" class="linkbox">&nbsp;<a href="?CurrentPath=<?php echo $CurrentPath . "/" . $file ?>"> 
                  <?php echo $file?>
                  </a></td>
                <td width="41">&nbsp;</td>
              </tr>
              <?php
		}
    } 
}
closedir($handle); 

// Get Files
$handle = opendir($CurrentPath); 
while (false !== ($file = readdir($handle))) { 
    if ($file != "." && $file != "..") { 
		if( is_file($CurrentPath . "/". $file) ) {
				?>
              <tr onMouseOver="this.style.background='#C3C3C3'" onMouseOut="this.style.background=''"> 
                <td width="18" height="20" align="center" valign="middle"> <em class="icon ni ni-folder-fill"></em>                </td>
                <td height="20" align="left"  class="linkbox"> <a href="#" onClick="setPath('<?php echo $file?>')">
                   &nbsp;&nbsp;<?php echo $file?>
                  </a></td>
                <td width="41"> 
                  <?php echo formatImageSize(filesize($CurrentPath . "/". $file))?>                </td>
              </tr>
              <?php
		}
    } 
}
closedir($handle); 
?>
            </table>            </td>
        </tr>
      </table>
      <script language="JavaScript" type="text/JavaScript">
function setPath(myFile) {
	window.opener.document.myForm.inputlinkpath.value = '<?php echo $CurrentPath?>'+'/'+myFile;
	window.close();
}
	  </script>
      
    </td>
  </tr>
</table>
</td>
  </tr>

    <tr>
    <td  class="bg_footerbarhome" ></td>
  </tr>  
  <tr>
    <td align="center" style="padding-top:5px;"></td>
  </tr>
</table>

</body>
</html>
