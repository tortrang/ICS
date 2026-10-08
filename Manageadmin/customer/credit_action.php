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
$txt_mod["financial:color"] = array('','warning','success','danger');
$txt_mod["financial:walletgroup"] = array('DF'=>'เพิ่มหนี้','WF'=>'ตัดหนี้','BL'=>'ออกบิล','CC'=>'ยกเลิกบิล');
$txt_mod["financial:walletgroupcolor"] = array('DF'=>'success','WF'=>'danger','BL'=>'warning','CC'=>'primary');
$txt_mod["financial:walletgroupicon"] = array('DF'=>'ni-arrow-down-right','WF'=>'ni-arrow-up-right','BL'=>'ni-arrow-up-right','CC'=>'ni-arrow-down-right');
?>
<?php if($_POST["myaction"]=="datalist"){?>
<script type="text/javascript">
function submitpagelist(name,value) {
	if(name=="prev"){
		document.myForm.module_pageshow.value--;
	}else if(name=="next"){
		if(document.myForm.module_pageshow.value==""){document.myForm.module_pageshow.value=1;};
		document.myForm.module_pageshow.value++;
		
	}else if(name=="number"){
		document.myForm.module_pageshow.value=value;	  
	}else if(name=="size"){
		document.myForm.module_pagesize.value=value;		   
	}else{
		document.myForm.InputSearch.value=value;
	}
	 
	modLoadContent();  
 }
 </script>
			<form action="" method="post" name="myForm" id="myForm">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" />  
           
          <!-- Modal Form -->
                                    <div class="modal fade" tabindex="-1" id="loadmodal">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content" id="loadmodalcontent">
                                                
                                            </div>
                                        </div>
                                    </div>                           
                                    <!-- .modal -->
<?php
  
    $chk_permissionID = getUserPermissionOnMenu($_SESSION["front_session_sys_id"],$_REQUEST['menukeyid']);
	
	// Check to set default value #########################
	$module_default_pagesize = 10;
	$module_default_pageshow = 1;
	$module_sort_number = "DESC";
	
	$module_pagesize = $_REQUEST["module_pagesize"];
	$module_pageshow = $_REQUEST["module_pageshow"];
	$module_adesc = $_REQUEST["module_adesc"];
	$module_orderby = $_REQUEST["module_orderby"];
	$InputSearch=trim($_REQUEST["InputSearch"]);
	
	if($module_pagesize==""){ $module_pagesize = $module_default_pagesize; }
	if($module_pageshow==""){ $module_pageshow = $module_default_pageshow; }
	if($module_adesc==""){ $module_adesc = $module_sort_number; }
	if($module_orderby==""){ $module_orderby = $mod_md_member."md_wallet_id"; }
	if($inputSearch!=""){ $inputSearch=trim($inputSearch); }
	
	// SQL SELECT #########################

	
    $sql = "SELECT * FROM md_wallet_credit WHERE 1=1";
    if($_REQUEST["InputSearch"]!=0){
		$sql .= " AND (md_wallet_customerid ='".$_REQUEST["InputSearch"]."')";
	}
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
	$sql .= " ORDER BY $module_orderby $module_adesc LIMIT $recordstart , $module_pagesize ";
// echo $sql;
	$query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
	$count_record=$query->num_rows;
?>
							<div class="nk-block nk-block-lg">
                                    <div class="nk-block-head nk-block-head-sm">
                                        <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                <h3 class="nk-block-title page-title"><?php echo getNameMenu($_POST["menukeyid"]);?></h3>
                                                <div class="nk-block-des text-soft">
                                                  <p>You have total <?php echo $count_record;?> record.</p>
                                                </div>
                                            </div><!-- .nk-block-head-content -->
                                            <div class="nk-block-head-content">
                                            	 <!--<a href="javascript:void(0)" class="btn btn-primary" onclick="document.myForm.myContantID.value ='';modLoadDeposit();"><em class="icon ni ni-plus"></em><span>เติมหนี้</span></a>&nbsp;-->
                                                 <a href="javascript:void(0)" class="btn btn-danger" onclick="document.myForm.myContantID.value ='';modLoadWithdrawal();"><em class="icon ni ni-minus"></em><span>ตัดหนี้</span></a>&nbsp;
                                            </div>
                                        </div><!-- .nk-block-between -->
                                    </div><!-- .nk-block-head -->
                                    
                                    <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
    										<div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                
                                                
                                                <!-- <div class="col-md-6 col-lg-4"> -->
                                                    <div class="nk-wg-card is-s1 card card-bordered">
                                                        <div class="card-inner">
                                                            <div class="nk-iv-wg2">
                                                                <div class="nk-iv-wg2-title">
                                                                    <h6 class="title">ยอดหนี้คงค้าง <em class="icon ni ni-info"></em></h6>
                                                                </div>
                                                                <?php  
                                                                    if($_REQUEST["InputSearch"]!=0){
                                                                        $row_bl=$query->fetch_array();
                                                                        $PrevWallet_bk=$row_bl["md_wallet_balance"];
                                                                    }else{
                                                                        $sql_bk = "SELECT md_wallet_balance FROM md_wallet_credit WHERE 1=1 ORDER BY md_wallet_id DESC LIMIT 1";
                                                                        $Query_bk=$mysqli->query($sql_bk);
                                                                        $Row_bk=$Query_bk->fetch_array();
                                                                        $PrevWallet_bk=$Row_bk["md_wallet_balance"];
                                                                    }
                                                                ?>
                                                                <div class="nk-iv-wg2-text">
                                                                    <div class="nk-iv-wg2-amount text-<?php if($PrevWallet_bk<=0){ echo "danger";}else{ echo "primary";}?>"><?php echo number_format($PrevWallet_bk,2);?> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card -->
                                                <!-- </div> -->
                                                <br><br>
                                                
                                                <div  style="display: inline-block;width: 30%;"> 
                                                    <span class="d-none d-sm-inline-block">ลูกค้า/ลูกหนี้</span>
                                                    <select name="InputSearch" id="InputSearch" class="custom-select  form-control  formsss" data-search="on" onchange="submitpagelist('customer',this.value);">
                                                        <option value="0">ทั้งหมด</option>
                                                        <?php
                                                            $sql_customer = "SELECT * FROM md_customer WHERE md_customer_status='1' AND md_customer_delete='0' ORDER BY md_customer_code ASC";
                                                            $Query_customer=$mysqli->query($sql_customer) OR DIE("Error sql_customer: <br>$sql_customer<br>\n");
                                                            while($Row_customer=$Query_customer->fetch_array()){
                                                                $Row_customer_id=$Row_customer['md_customer_id'];
                                                                $Row_customer_name=$Row_customer['md_customer_name'];									
                                                            ?>
                                                            <option value="<?php echo $Row_customer_id?>" <?php echo ($Row_customer["md_customer_id"]==$_REQUEST["InputSearch"])?"selected":""?>><?php echo $Row_customer['md_customer_code']."  ".$Row_customer_name?></option>
                                                        <?php }?>
                                                    </select>  
                                                </div> 
                                                
                                                <div id="module_pagesize"  style="display: inline-block;">
                                                    <span class="d-none d-sm-inline-block">Show</span>
                                                    <div class="form-control-select"> 
                                                        <select name="module_pagesize" id="module_pagesize" aria-controls="module_pagesize" class="custom-select  form-control " onchange="submitpagelist('size',this.value);">
                                                            <option value="10" <?php echo ($module_pagesize==10)?"selected":""?>>10</option>
                                                            <option value="25" <?php echo ($module_pagesize==25)?"selected":""?>>25</option>
                                                            <option value="50" <?php echo ($module_pagesize==50)?"selected":""?>>50</option>
                                                            <option value="100" <?php echo ($module_pagesize==100)?"selected":""?>>100</option>
                                                        </select> 
                                                    </div>
                                                </div> 
                                                <a href="export_excel_credit.php?InputSearch=<?php echo $_REQUEST["InputSearch"] ?>" target="_blank" class="btn btn-md btn-outline-success"><em class="icon ni ni-printer"></em><span>ออกรายงาน</span></a>
                                                
    										<div class="datatable-wrap my-3"> 
                                            <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                        <th class="nk-tb-col"><span class="sub-text">#</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">ชื่อลูกค้า</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">จำนวนเงิน</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">คงเหลือ</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">รายละเอียด</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">วันที่ทำรายการ</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">เจ้าหน้าที่</span></th>
                                                        <th class="nk-tb-col nk-tb-col-tools text-right">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <?php
				$index=1;
				$color=0;
                if($count_record>0) {
				$query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
				while($index<$count_record+1) {
					$row=$query->fetch_array();
					$row_id=		$row["md_wallet_id"];
					//$row_status=	$row["md_wallet_credit_status"];
                    $row_customerid=	$row["md_wallet_customerid"];
				 	$coloractive=$txt_mod["financial:walletgroupcolor"][$row["md_wallet_group"]];
					if($row["md_wallet_deposit"]!=0){
						$amount=$row["md_wallet_deposit"];
					}else{
						$amount=$row["md_wallet_withdrawal"];
					}

                    $sql_customer = "SELECT * FROM md_customer WHERE md_customer_id='".$row_customerid."'";
                    $query_customer=$mysqli->query($sql_customer) or die("Error sql_customer: เกิดความผิดพลาด <br>$sql_customer\n"); 
                    $row_customer=$query_customer->fetch_array();

                    $sql_billing_sell = "SELECT * FROM md_billing_sell WHERE md_billing_number='".$row["md_wallet_credit_billingnumber"]."'";
                    $query_billing_sell=$mysqli->query($sql_billing_sell) or die("Error sql_billing_sell: เกิดความผิดพลาด <br>$sql_billing_sell\n"); 
                    $row_billing_sell=$query_billing_sell->fetch_array();

                    if($row_billing_sell['md_billing_carcode']!='' && $row_billing_sell["md_billing_customerid"]==1){
                        $carcode=$row_billing_sell['md_billing_carcode'];
                    }else{
                        $carcode=$row_customer['md_customer_code'];
                    }
					?>    
                                                    <tr class="nk-tb-item">
                                                        <td class="nk-tb-col">
                                                            <a href="#modalveiw<?php echo $row["md_wallet_id"]?>" data-toggle="modal">
                                                                <div class="nk-tnx-type">
                                                                    <div class="nk-tnx-type-icon bg-<?php echo $coloractive;?>-dim text-<?php echo $coloractive;?>">
                                                                        <em class="icon ni <?php echo $txt_mod["financial:walletgroupicon"][$row["md_wallet_group"]]?>"></em>
                                                                    </div>
                                                                    <div class="nk-tnx-type-text">
                                                                        <span class="tb-lead"><?php echo $txt_mod["financial:walletgroup"][$row["md_wallet_group"]]?></span>
                                                                    </div>
                                                            </div>
                                                            </a>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                        	<?php echo $row_customer['md_customer_name']." (".$carcode.")" ?> 
                                                        </td>
                                                        <td class="nk-tb-col">
                                                        	<?php echo number_format($amount,2)?><span class="dot dot-<?php echo $coloractive;?> d-md-none ml-1"></span>
                                                        </td>
                                                         <td class="nk-tb-col">
                                                        	<?php echo number_format($row["md_wallet_balance"],2)?><span class="dot dot-<?php echo $coloractive;?> d-md-none ml-1"></span>
                                                        </td>
                                                        
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span><?php echo $row["md_wallet_detail"];?></span>
                                                            <span><?php if($row['md_wallet_reason']!=''){ echo "หมายเหตุ: ".$row["md_wallet_reason"]; } ?></span>
                                                        </td>
                                                        
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span><?php echo $row["md_wallet_credate"];?></span>
                                                        </td>
                                                        
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span><?php echo getStaffName($row["md_wallet_crebyid"]);?></span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-2">
                                                            <li class="nk-tb-action-hidden">
                                                                <a href="#modalveiw<?php echo $row["md_wallet_id"]?>" data-toggle="modal" class="bg-white btn btn-sm btn-outline-light btn-icon btn-tooltip" title="ดูข้อมูล"><em class="icon ni ni-eye"></em></a>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown">
                                                                    <a href="#" class="dropdown-toggle bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <ul class="link-list-opt">
                                                                            <li><a href="#modalveiw<?php echo $row["md_wallet_id"]?>" data-toggle="modal"><em class="icon ni ni-eye"></em><span>ดูข้อมูล</span></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <!-- Modal Default -->
    <div class="modal fade" tabindex="-1" id="modalveiw<?php echo $row["md_wallet_id"]?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-body modal-body-md">
                    <div class="nk-modal-head mb-3 mb-sm-5">
                        <h4 class="nk-modal-title title">รหัสการทำรายการ <small class="text-primary"><?php echo $row["md_wallet_code"]?></small></h4>
                    </div>
                    <div class="nk-tnx-details">
                        <div class="nk-block-between flex-wrap g-3">
                            <div class="nk-tnx-type">
                                <div class="nk-tnx-type-icon bg-<?php echo $coloractive;?> text-white" id="modalstatus<?php echo $row["md_wallet_id"]?>">
                                    <em class="icon ni ni-arrow-up-right"></em>
                                </div>
                                <div class="nk-tnx-type-text">
                                    <h5 class="title"><?php echo number_format($amount,2)?> บาท</h5>
                                    <span class="sub-text mt-n1"><?php echo ShowDateTimeThai($row["md_wallet_credate"]);?></span>
                                </div>
                            </div>
                            <ul class="align-center flex-wrap gx-3">
                                <li>
                                   <span class="badge badge-sm badge-<?php echo $txt_mod["financial:walletgroupcolor"][$row["md_wallet_group"]]?>"><?php echo $txt_mod["financial:walletgroup"][$row["md_wallet_group"]]?></span
                                ></li>
                            </ul>
                        </div>
                       
                        <div class="nk-modal-head mt-sm-5 mt-4 mb-4">
                            <h5 class="title">รายละเอียด</h5>
                        </div>
                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <span><?php echo $row["md_wallet_detail"];?> บาท</span>
                                <span><?php if($row['md_wallet_reason']!=''){ echo "หมายเหตุ: ".$row["md_wallet_reason"]; } ?></span>
                            </div>
                        </div><!-- .row -->

                    </div><!-- .nk-tnx-details -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
    
                                                        </td>
                                                    </tr><!-- .nk-tb-item  -->
                                          <?php $index++;$color++; 
									}//while($row=$query->fetch_array()){
							}//if($count_record>0) {?>
                                                </tbody>
                                            </table>
                                            </div><!-- .datatable-wrap my-3  -->

                                        <?php
										$minpage = $module_pageshow-2;
										$maxpage = $module_pageshow+2;
										if($minpage<1) { $minpage=1; }
										if($maxpage>$numberofpage) { $maxpage=$numberofpage; }
										if($maxpage<5) { $maxpage=5; }
										if($maxpage-$minpage<=3) { $minpage=$maxpage-4; }
										if($numberofpage<5) { $maxpage=$numberofpage; }
										?>
                                            
                                            <div class="row align-items-center">
                                            	<?php //if($numberofpage>1){?> 
                                                <div class="col-7 col-sm-12 col-md-9">
                                                    <nav>    
                                                        <ul class="pagination">        
                                                            <li class="page-item <?php if($module_pageshow==1){echo "disabled";}?> "><a class="page-link"  href="javascript:void(0)" <?php if($module_pageshow!=1){?> onclick="submitpagelist('prev','');"<?php }?> tabindex="-1" aria-disabled="true">Prev</a></li>        											<?php for($i=$minpage;$i<=$maxpage;$i++){?>     
                                                            <li class="page-item <?php if($i==$module_pageshow){?> active <?php }?>" aria-current="page"><a class="page-link" href="javascript:void(0)" onclick="submitpagelist('number','<?php echo $i?>');"><?php echo $i;?> <span class="sr-only">(current)</span></a></li>        
                                                            <?php }?>      
                                                            <li class="page-item <?php if($maxpage==$module_pageshow){echo "disabled";};?>"><a class="page-link" href="javascript:void(0)" <?php if($maxpage!=$module_pageshow){?> onclick="submitpagelist('next','');"<?php }?>>Next</a></li>    
                                                        </ul>
                                                    </nav>
                                                </div><!-- .col-7 col-sm-12 col-md-9 -->
                                                <?php //}?>
                                                <div class="col-5 col-sm-12 col-md-3 text-left text-md-right">
                                                	<div class="dataTables_info" role="status" aria-live="polite"><?php echo $txt_language["system:All"]." ".$count_totalrecord." ".$txt_language["system:record"]?></div>
                                                </div>
                                            </div><!-- .row align-items-center -->
                                        
                                         </div><!-- .dataTables_wrapper -->
                                        </div>
                                    </div><!-- .card-preview -->
                                    </div><!-- .nk-block-head-content -->                  
                            </div><!-- .nk-block -->
</form>

<script >  
        NioApp.Select2('.formsss');  
    </script>   


<?php }elseif($_POST["myaction"]=="addnew"){?>    
<?php }elseif($_POST["myaction"]=="insert"){?>  
<?php
        $sql = "SELECT md_wallet_balance FROM md_wallet_credit WHERE md_wallet_customerid='".$_POST["customer_id"]."' ORDER BY md_wallet_id DESC LIMIT 1";
        $Query=$mysqli->query($sql);
        $Row=$Query->fetch_array();
        $PrevWallet=$Row["md_wallet_balance"];
        
        for($i=1;$i<=$_POST['TotalCheckBoxID'];$i++){
            $CheckBoxID=$_POST["CheckBoxID".$i];
            $billing_total=$_POST["billing_total".$i];
            $billing_detail_id=$_POST["billing_detail_id".$i];
            if($CheckBoxID!=""){
                $withdrawal=$withdrawal+$billing_total;
                $sql = "UPDATE md_billing_sell SET md_billing_pay= '1' WHERE md_billing_id='".$billing_detail_id."'";
				$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
            }
        }

        if($_POST["wallet_type"]==1){
            $outTradeNo= 'SD-'.strtotime(date('YmdHis')); //เพิ่มหนี้
            $type="DF";
            $detail="เติมหนี้ จำนวน ".$_POST["wallet_amount"];
            $deposit=$_POST["wallet_amount"];
            $BalanceWallet=$PrevWallet+$deposit;
            
        }else{
            $outTradeNo= 'SW-'.strtotime(date('YmdHis')); //ตัดหนี้
            $type="WF";
            $detail="ตัดหนี้ จำนวน ".$withdrawal;
            //$withdrawal=$_POST["wallet_amount"];
            $BalanceWallet=$PrevWallet-$withdrawal;
        }
        

        unset($insert);
        $insert["md_wallet_code"] = "'".$outTradeNo."'"; 
        $insert["md_wallet_customerid"] = "'".$_POST["customer_id"]."'";
        $insert["md_wallet_detail"] = "'".$detail."'";
        $insert["md_wallet_deposit"] = "'".$deposit."'";
        $insert["md_wallet_withdrawal"] = "'".$withdrawal."'";		
        $insert["md_wallet_prevbalance"] = "'".$PrevWallet."'";	
        $insert["md_wallet_balance"] = "'".$BalanceWallet."'";	
        $insert["md_wallet_group"] = "'".$type."'";	
        $insert["md_wallet_reason"] = "'".$_POST['wallet_detail']."'";				 
        $insert["md_wallet_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_credate"] = "NOW()";
        $insert["md_wallet_updatedate"] = "NOW()";
        //echo	"sql_insert=".
        $sql_insert="INSERT INTO md_wallet_credit(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        

   

        //////////////////////
        insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
									
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
     	$sql = "UPDATE md_wallet_credit SET md_wallet_credit_status= '$inputstatusname'  WHERE md_wallet_id='". $statusid."'";
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
             $sql = "SELECT * FROM md_wallet_credit WHERE md_wallet_id='". $_POST["myContantID"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			 ?>
             
<?php }elseif($_POST["myaction"]=="deposit"){?>
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มลูกหนี้</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <?php
                    $sql = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1'";
                    $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
                    $count_record=$query->num_rows; 
                ?>
                 
                <div class="form-group">
                    <label class="form-label">ชื่อลูกค้า</label> 
                    
                    <div class="form-control-wrap">
                        <select class="form-select form-control form-control-mf formsss " data-search="on" id="customer_id"  name="customer_id" >
                            <option value="0">กรุณาเลือกลูกค้า</option>
                            <?php 
                                while($row=$query->fetch_array()) { 
                                    $row_id=		$row["md_customer_id"];
                                    $row_name=		rechangeQuot($row["md_customer_name"])." (".$row["md_customer_code"].")";
                                    $row_status=	$row["md_customer_status"];  ?>    

                                    <option value="<?php echo $row_id ?>"><?php echo $row_name ?></option>
        
                            <?php } ?>
                        </select>
                    </div>
                </div>      

                <div class="form-group">
                    <label class="form-label" for="inptfee">จำนวนเงิน</label>
                    <div class="form-control-wrap">
                        <input type="number" class="form-control" id="wallet_amount" name="wallet_amount" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="inptfee">รายละเอียดการเพิ่มหนี้</label>
                    <div class="form-control-wrap">
                        <textarea class="form-control" name="wallet_detail" id="wallet_detail"></textarea>
                    </div>
                </div>
                <input type="hidden" class="form-control" id="wallet_type" name="wallet_type" value="1">

                
                <hr/>
                <div class="row g-3" align="right">
                    <div class="col-lg-6"><a href="javascript:void(0)" class="btn btn btn-block btn-lg btn-primary" id="modInsertContent_submit" onclick="modInsertContent();"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:save"];?></span></a></div>
                    <div class="col-lg-6">
                        <a href="javascript:void(0)" class="btn btn btn-block btn-lg btn-danger" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:cancel"];?></span></a>
                        </div>
                </div>
            </div>  

            <script >  
                NioApp.Select2('.formsss');  
                document.body.onkeydown = function(e) {
                    if (e.keyCode == 13)
                    // modInsertContent();
                    document.getElementById("modInsertContent_submit").click();
                };
            </script> 
<?php }elseif($_POST["myaction"]=="withdrawal"){?>
    <div class="modal-header">
        <h5 class="modal-title">ตัดหนี้</h5>
        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
        </a>
    </div>
    <div class="modal-body">
        <?php
            $sql = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1'";
            $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
            $count_record=$query->num_rows; 
        ?>                
        <div class="form-group">
            <label class="form-label">ชื่อลูกค้า</label> 
            <div class="form-control-wrap">
                <select class="form-select form-control form-control-mf formsss2 " data-search="on" id="customer_id"  name="customer_id" onchange="LoadCustomer(this.value);">
                    <option value="0">กรุณาเลือกลูกค้า</option>
                    <?php 
                        while($row=$query->fetch_array()) { 
                            $row_id=		$row["md_customer_id"];
                            $row_name=		rechangeQuot($row["md_customer_name"])." (".$row["md_customer_code"].")";
                            $row_status=	$row["md_customer_status"];  ?>    

                            <option value="<?php echo $row_id ?>"><?php echo $row_name ?></option>

                    <?php } ?>
                </select>
            </div>
        </div>  
        
        <div class="form-group" id="loadcustomer">
            
        </div>
        <input type="hidden" class="form-control" id="wallet_type" name="wallet_type" value="2">

        
        <hr/>
        <div class="row g-3" align="right">
            <div class="col-lg-6"><a href="javascript:void(0)" class="btn btn btn-block btn-lg btn-primary" id="modInsertContent_submit" onclick="modInsertContent();"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:save"];?></span></a></div>
            <div class="col-lg-6">
                <a href="javascript:void(0)" class="btn btn btn-block btn-lg btn-danger" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:cancel"];?></span></a>
                </div>
        </div>
    </div>
    <script >  
        NioApp.Select2('.formsss2');  
        document.body.onkeydown = function(e) {
            if (e.keyCode == 13)
            // modInsertContent();
            document.getElementById("modInsertContent_submit").click();
        };
    </script>
<?php }else if($_POST["myaction"]=="loadcustomer"){ 
    $txt_mod["billing:color"] = array('warning ','success','danger');
    $txt_mod["billing:status"]= array('รอดำเนินการ','สำเร็จ','ยกเลิก');?>
    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                    	<th class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            	<input type="checkbox" name="CheckBoxAll" id="CheckBoxAll" class="custom-control-input" onclick="Paging_CheckAll(this,'CheckBoxID',document.myForm.TotalCheckBoxID.value);LoadTotal()" />
                                                                <label class="custom-control-label" for="CheckBoxAll"></label>
                                                            </div>
                                                        </th>
                                                        <th class="nk-tb-col"><span class="sub-text">รหัสใบเสร็จ</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">ลูกค้า</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">จำนวนเงิน</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">การชำระเงิน</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">วันที่</span></th>
                                                        
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text"><?php echo $txt_language["txt:status"]?></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                $index=1;
                                                $color=0;
                                                $sql = "SELECT * FROM md_billing_sell WHERE md_billing_pay='0' AND md_billing_status='1' AND md_billing_customerid='".$_POST['customer_id']."'";
                                                $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
                                                while($row=$query->fetch_array()){
                                                    $row_id=		$row["md_billing_id"];
                                                    $row_name=		rechangeQuot($row["md_billing_fname"])." ".rechangeQuot($row["md_billing_lname"]);
                                                    $row_status=	$row["md_billing_status"];
                                                    
                                                    $paytype = $row['md_billing_type'];
                                                        if($paytype==0){   
                                                            $paytyp_status="เงินสด";
                                                            $paytyp_color="primary";
                                                        }elseif($paytype==1){  
                                                            $paytyp_status="เงินโอน";
                                                            $paytyp_color="info";
                                                        }elseif($paytype==2){  
                                                            $paytyp_status="เครดิต";
                                                            $paytyp_color="danger";
                                                        }
                                                    
                                                 ?>    
                                                                                    <tr class="nk-tb-item">
                                                                                        <td class="nk-tb-col nk-tb-col-check">
                                                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                                                <input type="checkbox" name="CheckBoxID<?php echo $index?>" id="CheckBoxID<?php echo $index?>" class="custom-control-input" onclick="Paging_CheckAllHandle(document.myForm.CheckBoxAll,'CheckBoxID',document.myForm.TotalCheckBoxID.value);LoadTotal()" value="<?php echo $row_id?>"/>
                                                                                                <label class="custom-control-label" for="CheckBoxID<?php echo $index?>"></label>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="nk-tb-col">
                                                                                            <div class="nk-tnx-type">
                                                                                                <div class="nk-tnx-type-text">
                                                                                                    <span class="tb-lead"><?php echo $row["md_billing_number"];?></span>
                                                                                                   
                                                                                                </div>
                                                                                           </div>
                                                                                         </td>
                                                                                         <td class="nk-tb-col">
                                                                                            <span><?php echo getCustomerName($row["md_billing_customerid"]);?></span>
                                                                                        </td>
                                                                                        <td class="nk-tb-col">
                                                                                        <input name="billing_total<?php echo $index?>" type="hidden" id="billing_total<?php echo $index?>" value="<?php echo $row["md_billing_total"]?>" />
                                                                                        <input name="billing_detail_id<?php echo $index?>" type="hidden" id="billing_detail_id<?php echo $index?>" value="<?php echo $row["md_billing_id"]?>" />
                                                                                            <span><?php echo number_format($row["md_billing_total"],2);?></span>
                                                                                        </td>
                                                                                        <td class="nk-tb-col tb-col-md" id="load_paystatus<?php echo $row_id?>">
                                                                                            <span class='badge badge-dim badge-outline-<?php echo $paytyp_color;?> d-none d-md-inline-flex'><?php echo $paytyp_status;?></span>
                                                                                        </td>
                                                                                        <td class="nk-tb-col tb-col-md">
                                                                                            <span><?php echo ShowDateTimeThai($row["md_billing_credate"]);?></span>
                                                                                        </td>
                                                                                        <td class="nk-tb-col tb-col-md" id="load_status<?php echo $row_id?>">
                                                                                        <span class='badge badge-dim badge-outline-<?php echo $txt_mod["billing:color"][$row["md_billing_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["billing:status"][$row["md_billing_status"]];?></span>
                                                                                        </td>
                                                                                        
                                                                                    </tr><!-- .nk-tb-item  --> 
                                    
                                                                          <?php $index++;$color++; 
                                                }//while($row=$query->fetch_array()){
                                                ?>
                                                <tr class="nk-tb-item">
                                                                                        
                                                                                        <td class="nk-tb-col" colspan="5">
                                                                                            
                                                                                        </td>
                                                                                        <td class="nk-tb-col tb-col-md" id="load_paystatus<?php echo $row_id?>">
                                                                                            <b>รวมเงิน</b>
                                                                                        </td>
                                                                                        <td class="nk-tb-col tb-col-md">
                                                                                            <div id="loadtotal"></div>
                                                                                        </td>
                                                                                        
                                                                                    </tr><!-- .nk-tb-item  --> 
                                                <input name="TotalCheckBoxID" type="hidden" id="TotalCheckBoxID" value="<?php echo $index-1?>" />
<?php }else if($_POST["myaction"]=="switchmode"){ 
 if($_SESSION["front_session_sys_mode"]==""){
	 $_SESSION["front_session_sys_mode"]="darkmode";
 }else{
	 $_SESSION["front_session_sys_mode"]="";
 }?>
<?php }?>   