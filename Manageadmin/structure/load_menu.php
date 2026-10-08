<?
include("../lib/session.php");
include("../lib/config.php");
include("../lib/connect.php");
include("../mod_structure/config.php");
include("../lib/function.php");
include("../mod_structure/config.php");
		if($_SESSION['core_session_chkup_language']=="Thai"){
		include("../lib/language_thai.php");
		include("../mod_structure/language_thai.php");
		
		}else if($_SESSION['core_session_chkup_language']=="Eng"){
			include("../lib/language_eng.php");
			include("../mod_structure/language_eng.php");
		}
?>

   
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
    <td align="left" style="padding-left:5px;">
      <a href="javascript:void(0)" class="font_style06"   
          onClick="addContantMenu('<?=trim($inputSearch)?>','<?=$module_orderby?>','<?=$module_pageshow?>','<?=$module_pagesize?>','core/add_managemenu','0')"><?=$txt_language["but:addnew"]?></a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
   <a href="javascript:void(0)" class="font_style06"  onClick="sortContantMenu('<?=trim($inputSearch)?>','<?=$module_orderby?>','<?=$module_pageshow?>','<?=$module_pagesize?>','core/sort_managemenu','0')"> <?=$txt_language["but:sort"]?></a>&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>

    <tr>
    <td height="10"></td>
  </tr>
</table>

<form action="" method="post" name="myForm" id="myForm">
<input name="modmenuid" type="hidden" id="modmenuid" value="" />
<input name="myParentID" type="hidden" id="myParentID" value="<?=$myParentID?>" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
           <tr>
    <td align="left"   valign="middle" style=" padding-bottom:5px;border-left:1px solid #dadada;border-top:1px solid #dadada;border-right:1px solid #dadada; background-color:#FFF;  "   height="40">
    
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-left:10px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="82%" align="left"> <?=$txt_language["menu:listmenu"]?></td>
    <td width="18%" align="right">&nbsp;</td>
  </tr>
</table>    </td>
  </tr>
</table>      </td></tr>
          <tr>
    <td align="left"   valign="top"  style=" border:1px solid #dadada; background-color:#FFF; ">
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr > 
                  <td height="80" align="left" valign="top" style="padding-left:10px;padding-right:10px;padding-bottom:10px;"> 
                    <? 

include("treemenu.php"); 
$myParentGroupID=0;
$MID=0;
loadTreeMenu($myParentGroupID,$MID,0);
?>                  </td>
                </tr>
              </table>      </td>
  </tr>
       

</table>
</form>
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
    <td height="5"></td>
  </tr>
         <tr>
    <td align="left" style="padding-left:5px;">
     <a href="javascript:void(0)" class="font_style06"   
          onClick="addContantMenu('<?=trim($inputSearch)?>','<?=$module_orderby?>','<?=$module_pageshow?>','<?=$module_pagesize?>','core/add_managemenu','0')"><?=$txt_language["but:addnew"]?></a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
   <a href="javascript:void(0)" class="font_style06"  onClick="sortContantMenu('<?=trim($inputSearch)?>','<?=$module_orderby?>','<?=$module_pageshow?>','<?=$module_pagesize?>','core/sort_managemenu','0')"> <?=$txt_language["but:sort"]?></a>&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>

    <tr>
    <td height="10"></td>
  </tr>
</table>