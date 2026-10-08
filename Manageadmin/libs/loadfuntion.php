<?php
include("../libs/session.php");
include("../libs/config.php");
include("../libs/connect.php");
include("../libs/function.php");
		if($_SESSION['core_session_sys_language']=="thai"){
			include("../libs/language_thai.php");
		}else if($_SESSION['core_session_sys_language']=="eng"){
			include("../libs/language_eng.php");	
		}
?>
<?php if($_POST["myaction"]=="loadamphures"){?>
<?php 
	$sql_amphures = "SELECT * FROM sys_amp WHERE 1=1 AND sys_amp_provid='".$_POST['myid']."'";
		$Query_amphures=$mysqli->query($sql_amphures) OR DIE("Error sql_amphures: <br>$sql_amphures<br>\n");
		?>
																		
																			<option value=""><?php echo $txt_language["alert:select"]?></option>
                                                                            <?php while($Row_amphures=$Query_amphures->fetch_array()){
																				$row_amphures_id=$Row_amphures['sys_amp_id'];
																				$row_amphures_name=$Row_amphures['sys_amp_name'.$_SESSION["core_session_sys_language"]];
																				
																				?>
																			<option value="<?php echo $row_amphures_id?>"><?php echo $row_amphures_name?></option>
                                                                            <?php }?>
																			
																		
<?php }elseif($_POST["myaction"]=="loadtambon"){?>
<?php 
																	$sql_tambon = "SELECT * FROM sys_tam WHERE 1=1 AND sys_tam_ampid	='".$_POST['myid']."'";
		$Query_tambon=$mysqli->query($sql_tambon) OR DIE("Error sql_tambon: <br>$sql_tambon<br>\n");
		?>
																		
																			<option value=""><?php echo $txt_language["alert:select"]?></option>
                                                                            <?php while($Row_tambon=$Query_tambon->fetch_array()){
																				$row_tambon_id=$Row_tambon['sys_tam_id'];
																				$row_tambon_name=$Row_tambon['sys_tam_name'.$_SESSION["core_session_sys_language"]];
																				
																				?>
																			<option value="<?php echo $row_tambon_id?>"><?php echo $row_tambon_name?></option>
                                                                            <?php }?>
																			
																		

<?php }elseif($_POST["myaction"]=="loadpostcode"){?>
<?php 
		$sql_tambon = "SELECT * FROM sys_tam WHERE sys_tam_id='".$_POST['myid']."'";
		$Query_tambon=$mysqli->query($sql_tambon) OR DIE("Error sql_tambon: <br>$sql_tambon<br>\n");
		$Row_tambon=$Query_tambon->fetch_array();

		$sql_postcode = "SELECT * FROM sys_post WHERE sys_post_tamcode='".$Row_tambon["sys_tam_code"]."'";
		$Query_postcode=$mysqli->query($sql_postcode) OR DIE("Error sql_postcode: <br>$sql_postcode<br>\n");
		$Row_postcode=$Query_postcode->fetch_array();
																				
		$row_postcode_code=$Row_postcode['sys_post_code'];																			
?>
<input type="text" id="input_zipcode" name="input_zipcode" class="form-control"  value="<?php echo $row_postcode_code?>" maxlength="5"/>
<?php }else if($_POST["myaction"]=="switchmode"){ 
 if($_SESSION["core_session_sys_mode"]==""){
	 $_SESSION["core_session_sys_mode"]="darkmode";
 }else{
	 $_SESSION["core_session_sys_mode"]="";
 }?>
<?php }?>                                                                    