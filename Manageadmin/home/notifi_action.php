<?php
require_once("../libs/session.php");
require_once("../libs/config.php");
require_once("../libs/connect.php");
require_once("../libs/function.php");
	
if($_SESSION['core_session_sys_language']=="thai"){
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../libs/language_eng.php");
}

?>
<?php if($_POST["myaction"]=="datalist"){?>
			<form action="deposit_action.php" method="post" name="myForm" id="myForm" enctype="multipart/form-data">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["$module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["$module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" /> 
           
<?php
  
	 $chk_permissionID = getUserPermissionOnMenu($_SESSION["front_session_sys_grpid"],$_REQUEST['menukeyid']);
	
	// Check to set default value #########################
	$module_default_pagesize = 10;
	$module_default_pageshow = 1;
	$module_sort_number = "DESC";
	
	$module_pagesize = $_REQUEST["module_pagesize"];
	$module_pageshow = $_REQUEST["module_pageshow"];
	$module_adesc = $_REQUEST["module_adesc"];
	$module_orderby = $_REQUEST["module_orderby"];
	$inputSearch=trim($_REQUEST["inputSearch"]);
	
	if($module_pagesize==""){ $module_pagesize = $module_default_pagesize; }
	if($module_pageshow==""){ $module_pageshow = $module_default_pageshow; }
	if($module_adesc==""){ $module_adesc = $module_sort_number; }
	if($module_orderby==""){ $module_orderby = $mod_md_member."account_user"; }
	if($inputSearch!=""){ $inputSearch=trim($inputSearch); }
	
	// SQL SELECT #########################

	
$sql = "SELECT * FROM md_log WHERE 1=1 ORDER BY md_log_id DESC LIMIT 1000";
	$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
	$count_totalrecord=$query->num_rows;
// Find max page size #########################
		if($count_totalrecord>$module_pagesize) {
			$numberofpage= ceil($count_totalrecord/$module_pagesize);
		} else {
			$numberofpage=1;
		}

// Recover page show into range #########################
		if($module_pageshow>$numberofpage) { $module_pageshow=$numberofpage; }

// Select only paging range #########################
	$recordstart = ($module_pageshow-1)*$module_pagesize;
	//$sql .= " ORDER BY $module_orderby $module_adesc LIMIT $recordstart , $module_pagesize ";

	$query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
	$count_record=$query->num_rows;
?>
							<div class="nk-block nk-block-lg">
                                    <div class="nk-block-head nk-block-head-sm">
                                        <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                <h3 class="nk-block-title page-title">Notifications</h3>
                                                <div class="nk-block-des text-soft">
                                                  <p>You have total <?php echo $count_record;?> record.</p>
                                                </div>
                                            </div><!-- .nk-block-head-content -->
                                        </div><!-- .nk-block-between -->
                                    </div><!-- .nk-block-head -->
                                    
                                    <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
    
                                            <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                        <th class="nk-tb-col"><span class="sub-text">วันที่</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">เจ้าหน้าที่</span></th>
                                                        <th class="nk-tb-col">รายละเอียด</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <?php
				$index=1;
				$color=0;
                if($count_record>0) {
				while($index<$count_record+1) {
					$row=$query->fetch_array();
					$row_id=		$row["md_log_id"];
					$row_status=	$row["md_log_status"];
				 	$coloractive=$txt_mod["order:color"][$row["md_log_status"]];

					?>    
                                                    <tr class="nk-tb-item">
                                                        <td class="nk-tb-col">
                                                        	<div class="nk-tnx-type">
                                                            	<div class="nk-tnx-type-icon bg-success-dim text-success">
                                                                	<em class="icon ni ni-curve-down-right"></em>
                                                                </div>
                                                                <div class="nk-tnx-type-text">
                                                                	<span class="tb-lead"><?php echo DateFormatTime($row["md_log_credate"])?></span>
                                                                </div>
                                                           </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span><?php echo getStaffName($row["md_log_crebyid"])?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span><?php echo $row["md_log_detail"];?></span>
                                                        </td>       
                                                    </tr><!-- .nk-tb-item  -->
                                          <?php $index++;$color++; 
									}//while($row=$query->fetch_array()){
							}//if($count_record>0) {?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- .card-preview -->
                                    </div><!-- .nk-block-head-content -->                  
                            </div><!-- .nk-block -->
</form>
<script type="text/javascript">
NioApp.DataTable('.datatable-init', {
      responsive: {
        details: true
      },
	  order: [0, 'desc']
    });
</script>
<?php }elseif($_POST["myaction"]=="addnew"){?>    
<?php }elseif($_POST["myaction"]=="insert"){?>  
<?php
					
					$sql = "SELECT * FROM md_log WHERE 1=1 ORDER BY md_log_id DESC LIMIT 1";
					$query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
					$Row=$query->fetch_array();
					$id=$Row["md_log_id"]+1;
					
					$number="DF-".$id.strtotime(date("Y-m-d H:i:s"));
					
					$FileName = $_FILES['deposit_file']['name'];		// รับค่าชื่อไฟล์
					$path="uploads/deposit/pictures/"; 
					if($FileName){ 	// มีการอัพโหลดไฟล์ใหม่
						//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
						 $type = strrchr($_FILES['deposit_file']['name'],".");
							
						//ตั้งชื่อไฟล์ใหม่โดยใช้รหัสบุคลากรตามด้วย _pic
						$picname = $number.$type;
						$path_copy=$path.$picname;
						$path_link="uploads/deposit/pictures/".$picname; 
			
					}
			
					unset($insert);
					$insert["md_log_branchid"] = "'".$_SESSION["front_session_sys_branch"]."'";
					$insert["md_log_number"] = "'".$number."'";
					$insert["md_log_amount"] = "'".$_REQUEST["deposit_amount"]."'";
					$insert["md_log_ip"] = "'".$_SERVER['REMOTE_ADDR']."'";
					$insert["md_log_slip"] = "'".$picname."'";
					$insert["md_log_status"] = "'1'";
					
					$insert["md_log_credate"] = "NOW()";
					$insert["md_log_date"] = "NOW()";

			//echo	"sql_insert=".
					$sql_insert="INSERT INTO md_log(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
					$Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
					
					$type = strrchr($_FILES['deposit_file']['name'],".");

				   if(@copy($_FILES['deposit_file']['tmp_name'],"uploads/deposit/pictures/".$picname))
				   {   	       $images ="uploads/deposit/pictures/".$picname;
				   			   $width=300; //*** Fix Width & Heigh (Autu caculate) ***//
							   $size=GetimageSize($images);
							   $height=round($width*$size[1]/$size[0]);
							   $images_fin = ImageCreateTrueColor($width, $height);
							   ImageDestroy($images_fin);		
				   }
					echo "<meta http-equiv='refresh' content='0;url=deposit.php?masterkey=".$_REQUEST['masterkey']."&&menukeyid=".$_REQUEST['menukeyid']."&&MenuActive=".$_REQUEST['MenuActive']."'>";
					
					
}elseif($_POST["myaction"]=="changestatus"){
	$loaddder=$_POST['Valueloaddder'];
		$statusname=$_POST['Valuestatusname'];
		$statusid=$_POST['Valuestatusid'];
		$loadderstatus=$_POST['Valueloadderstatus'];
		$filestatus=$_POST['Valuefilestatus'];
		
		
		if($statusname=="1"){
		$inputstatusname="2";
		}else if($statusname=="2"){
		$inputstatusname="3";
		}else if($statusname=="3"){
		$inputstatusname="4";
		}
     	$sql = "UPDATE md_log SET md_log_status= '$inputstatusname'  WHERE md_log_id='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
	?>
    <a href="javascript:void(0)"  onclick="changeStatus('load_mainwaiting','<?php echo $inputstatusname?>','<?php echo $statusid?>','load_status<?php echo $statusid?>','<?php echo $myaction?>')">
    <?php  if($inputstatusname=="3"){?>
         <span class="tb-status text-success"><?php echo $txt_mod["financial:status"][$inputstatusname]?></span>
	<?php  }else if($inputstatusname=="1"){?>   
		<span class="tb-status text-warning"><?php echo $txt_mod["financial:status"][$inputstatusname]?></span>
        <?php  }else if($inputstatusname=="2"){?>   
		<span class="tb-status text-warning"><?php echo $txt_mod["financial:status"][$inputstatusname]?></span>
    <?php }else{?>
		<span class="tb-status text-danger"><?php echo $txt_mod["financial:status"][$inputstatusname]?></span>
    <?php }?>
     </a>
<?php }elseif($_POST["myaction"]=="delete"){
		/*for($i=1;$i<=$TotalCheckBoxID;$i++) {
		$myVar="CheckBoxID".$i;
		if(strlen($$myVar)>0) {
		 $permissionID=$$myVar;
		
		 $sql="DELETE FROM sys_staff WHERE staff_id=".$permissionID." ";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		}}*/
?>
<?php }elseif($_POST["myaction"]=="view"){?>
<form action="" method="post" name="myForm" id="myForm">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["$module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["$module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" />
            <?php
             $sql = "SELECT * FROM md_log WHERE md_log_id='". $_POST["myContantID"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			 ?>
             
<?php }elseif($_POST["myaction"]=="reject"){
	$sql_updat = "UPDATE md_log SET md_log_status= '3'  WHERE md_log_id='".$_POST["myContantID"]."'";
	$Query_updat=$mysqli->query($sql_updat)OR DIE("Error sql: <br>$sql_updat<br>\n");
?>
<?php }else if($_POST["myaction"]=="switchmode"){ 
 if($_SESSION["front_session_sys_mode"]==""){
	 $_SESSION["front_session_sys_mode"]="darkmode";
 }else{
	 $_SESSION["front_session_sys_mode"]="";
 }?>
<?php }?>   