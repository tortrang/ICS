<?
include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../lib/function.php");
include("../mod_structure/config.php");


		include("../lib/language_".$_SESSION['core_session_chkup_language'].".php");
		include("../mod_structure/language_".$_SESSION['core_session_chkup_language'].".php");

?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td align="left" style="padding-left:5px;">
    <a href="javascript:void(0)" class="font_style06" onclick="updateContantSort()"><?=$txt_language["but:save"]?></a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
   <a href="javascript:void(0)" class="font_style06"   onclick="loadMainContant('<?=trim($inputSearch)?>','<?=$module_orderby?>','<?=$module_pageshow?>','<?=$module_pagesize?>','core/load_menu');"> <?=$txt_language["but:cancel"]?></a>&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
    <tr>
    <td height="10"></td>
  </tr>
</table>

<form action="?" method="post" name="myForm" id="myForm">
<input name="execute" type="hidden" id="execute" value="sort" />
<input name="myParentID" type="hidden" id="myParentID" value="<?=$myParentID?>" />
<input name="modmenuid" type="hidden" id="modmenuid" value="<?=$modmenuid?>" />
 <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?=$module_pageshow?>" />
<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?=$module_pagesize?>" />
<input name="module_orderby" type="hidden" id="module_orderby" value="<?=$module_orderby?>" />
<input name="inputSearch" type="hidden" id="inputSearch" value="<?=$inputSearch?>" />
     <?php if($myParentID==""){
			$myParentID=0;
			}
 	echo $sql = "SELECT ".$mod_set_menu."_id,".$mod_set_menu."_name,".$mod_set_menu."_moduletype,".$mod_set_menu."_status FROM ".$mod_set_menu." WHERE ".$mod_set_menu."_parentid='".$myParentID."'  ORDER BY ".$mod_set_menu."_order ASC ";
			$Query=mssql_query($sql) ;
			$RecordCount=mssql_num_rows($Query);

		?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	<tr>
    	<td align="left"   valign="top" style=" padding-bottom:5px;border-left:1px solid #dadada;border-top:1px solid #dadada;border-right:1px solid #dadada; background-color:#FFF;  "   height="30">
    		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  				<tr>
    				<td height="30" class="font_style07" style="padding-left:10px;" ><?=$txt_language["menu:sortingpermis"]?></td>
  				</tr>
			</table>      
       	</td>
  	</tr>
  	<tr>
    	<td align="left"   valign="top"  style=" border:1px solid #dadada; background-color:#FFF; ">
    		<table width="100%" border="0"  cellpadding="0" cellspacing="0" class="mytable_inner">
          		<tr> 
                  	<td height="40" align="left" >
                  		<div style="max-width:826px; " >
							<ul id="sortable"  class="sortingul">

								<?
                                $i=0;
                                while($row=mssql_fetch_array($Query)) { 
                                $row_id=$row[0];
                                        $row_name=$row[1];
                                        $row_type=$row[2];
                                        $row_status=$row[3];
                                $i++;
                                
                                 ?>
                                 
		    					<li class="ui-state-default" id="<?=$row_id?>">
            			<table width="100%" border="0" cellspacing="0" cellpadding="0">
  							<tr>
                                <td width="4%"  valign="top" height="30"></td>
                                <td width="74%" >
                                  <span class="font_style15">
                                  <?=$row_name?>
                                  </span></span></td>
                                <td width="11%"    ><?=$row_type?></td>
                                <td width="11%"     >
								<?php if($row_status=="Enable"){ ?>
								  <span class="font_style09"><img src="../img/icon/enable.png" alt="Enable" align="absmiddle" hspace="10" border="0" /><?=$row_status?></span>

               				 	<?php }else{ ?>
                
								  <span class="font_style09"><img src="../img/icon/disable.png" alt="Enable" align="absmiddle" hspace="10" border="0" /><?=$row_status?></span>
                
               					<?php } ?></td>
    						</tr>
						</table>

         						</li>
								
								<?php } ?><!--close While-->
                			</ul>
                		</div>
                  	</td>
                </tr>
    		</table>
		</td>
  	</tr>
</table>
</form>

   <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td align="left" style="padding-left:5px;">
    <a href="javascript:void(0)" class="font_style06" onclick="updateContantSort()"><?=$txt_language["but:save"]?></a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
   <a href="javascript:void(0)" class="font_style06"   onclick="loadMainContant('<?=trim($inputSearch)?>','<?=$module_orderby?>','<?=$module_pageshow?>','<?=$module_pagesize?>','core/load_menu');"> <?=$txt_language["but:cancel"]?></a>&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
    <tr>
    <td height="10"></td>
  </tr>
</table>

  <script language="JavaScript"  type="text/javascript">
var idlist=null;
var allidlist=null;

	
	jQuery(function() {
		jQuery("#sortable").sortable({
		placeholder: 'ui-state-highlightSort',
		update:function(){
		var items = jQuery(".ui-state-default");
		var photos = [];
		allidlist=null;
		for(var x=0; x<items.length; x++)
		{
		var photo = {}
		photo.id = items[x].id;       
		allidlist= allidlist+'|x|'+photo.id;
		}
		}
	
	});
	jQuery("#sortable").disableSelection();
	});


  </script>