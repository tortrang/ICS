<?php
require_once("../libs/session.php");
require_once("../libs/config.php");
require_once("../libs/connect.php");
require_once("../libs/function.php");
	
if($_SESSION['core_session_sys_language']=="thai"){
	include("../structure/language_thai.php");
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../structure/language_eng.php");	
	include("../libs/language_eng.php");
}

?>
<?php if($_POST["myaction"]=="datalist"){?>
			
<?php }elseif($_POST["myaction"]=="addnew"){?> 
<form action="" method="post" name="myForm" id="myForm" class="form-validate is-alter">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="<?php echo $_REQUEST["myContantID"]?>" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" />
            <?php
			//if($_POST["myContantID"]!=""){
             $sql = "SELECT * FROM sys_info WHERE sys_info_id='1'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			//}
			 ?>
<div class="nk-block nk-block-lg">
                                    
                                    <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                 <h4 class="nk-block-title"><?php echo getNameMenu($_POST["menukeyid"]);?></h4>
                                                 <br />
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-gs">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inptfee"><?php echo $txt_mod["info:company"]?></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="info_company" name="info_company" value="<?php echo $Row['sys_info_company']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inptfee"><?php echo $txt_mod["info:url"]?></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="info_url" name="info_url" value="<?php echo $Row['sys_info_url']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["info:title"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="info_title" name="info_title" value="<?php echo $Row['sys_info_title']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["info:phone"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="info_phone" name="info_phone" value="<?php echo $Row['sys_info_phone']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["info:tel"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="info_tel" name="info_tel" value="<?php echo $Row['sys_info_tel']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["info:fax"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="info_fax" name="info_fax" value="<?php echo $Row['sys_info_fax']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["info:email"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="info_email" name="info_email" value="<?php echo $Row['sys_info_email']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["info:emailsystem"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="info_emailsystem" name="info_emailsystem" value="<?php echo $Row['sys_info_emailsystem']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["info:address"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control" id="info_address" name="info_address" ><?php echo $Row['sys_info_address']?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary" onClick="loadchkaddform();"><?php echo $txt_language["but:save"]?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
</form>
<?php }elseif($_POST["myaction"]=="insert"){

					$update[]="sys_info_title ='".$_POST['info_title']."'";
					$update[]="sys_info_phone='".$_POST['info_phone']."'";
					$update[]="sys_info_tel='".$_POST['info_tel']."'";
					$update[]="sys_info_fax='".$_POST['info_fax']."'";
					$update[]="sys_info_email='".$_POST['info_email']."'";
					$update[]="sys_info_emailsystem='".$_POST['info_emailsystem']."'";
					$update[]="sys_info_company='".$_POST['info_company']."'";
					$update[]="sys_info_address='".$_POST['info_address']."'";
					$update[]="sys_info_url='".$_POST['info_url']."'";
					$update[]="sys_info_company='".$_POST['info_company']."'";

					$update[]="sys_info_updatedate=NOW()";
					$update[]="sys_info_updatebyid='".$_SESSION["core_session_sys_id"]."'";
	
					$sql_update="UPDATE sys_info SET ".implode(",",$update)." WHERE sys_info_id='1'";
					$Query=$mysqli->query($sql_update) OR DIE("Error sql_update: <br>$sql_update<br>\n");
					

}elseif($_POST["myaction"]=="changestatus"){
	$loaddder=$_POST['Valueloaddder'];
		$statusname=$_POST['Valuestatusname'];
		$statusid=$_POST['Valuestatusid'];
		$loadderstatus=$_POST['Valueloadderstatus'];
		$filestatus=$_POST['Valuefilestatus'];
		$myaction=$_POST['myaction'];
		
		
		if($statusname=="1"){
		$inputstatusname="2";
		}else if($statusname=="2"){
		$inputstatusname="1";
		}
     	$sql = "UPDATE sys_staff SET sys_staff_status= '$inputstatusname'  WHERE sys_staff_id='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
	?>
    <a href="javascript:void(0)"  onclick="changeStatus('load_mainwaiting','<?php echo $inputstatusname?>','<?php echo $statusid?>','load_status<?php echo $statusid?>','<?php echo $myaction?>')">
    <?php  if($inputstatusname=="1"){?>
         <span class="badge badge-dim badge-outline-success d-none d-md-inline-flex"><?php echo $txt_language["system:status:name"][$inputstatusname]?></span>
    <?php }else{?>
		<span class="badge badge-dim badge-outline-danger d-none d-md-inline-flex"><?php echo $txt_language["system:status:name"][$inputstatusname]?></span>
    <?php }?>
     </a>
<?php }elseif($_POST["myaction"]=="delete"){
	
		for($i=1;$i<=$_POST["TotalCheckBoxID"];$i++) {
		$myVar=$_POST["CheckBoxID".$i];
		if(strlen($myVar)>0) {
		 $permissionID=$myVar;
		
		 $sql="DELETE FROM sys_staff WHERE sys_staff_id='".$permissionID."'";
		 $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		}}
?>
<?php }elseif($_POST["myaction"]=="view"){?>

             
<?php }?>