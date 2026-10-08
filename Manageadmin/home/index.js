function switchmode() {
	var TYPE="POST";
	var URL="../libs/loadfuntion.php";
	$('#myaction').val('switchmode');
	var dataSet= jQuery("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){			
		}
	});
}
function modLoadAddNew() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="index_action.php";
$('#myaction').val('addnew');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#load_mainContant").show();
			jQuery("#load_mainContant").html(html);
			jQuery("#load_mainwaiting").hide();
		}
	});
}

function modInsertContent() {
	var TYPE="POST";
	var URL="index_action.php";
$('#myaction').val('insert');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
		//jQuery("#load_mainContant").html(html);
		modLoadContent();
		}
	});
}

function addContantMenu(parentID) {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="index_action.php";
$('#myaction').val('addnew');
$('#myParentID').val(parentID);
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#load_mainContant").show();
			jQuery("#load_mainContant").html(html);
			jQuery("#load_mainwaiting").hide();
			
		}
	}); 
}

function modDeleteContant() {
	var TYPE="POST";
	var URL="index_action.php";
$('#myaction').val('delete');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//jQuery("#load_mainContant").html(html);
			modLoadContent();

		}
	});
}


function modLoadView() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="index_action.php";
$('#myaction').val('view');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#load_mainContant").show();
			jQuery("#load_mainContant").html(html);
			jQuery("#load_mainwaiting").hide();
		}
	});
}


function modLoadContent() {
	
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();

	var TYPE="POST";
	var URL="index_action.php";
$('#myaction').val('datalist');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#load_mainContant").show();
			jQuery("#load_mainContant").html(html);
			jQuery("#load_mainwaiting").hide();
		}
	});
}

function modSaveBox(boxid) {
	var TYPE="POST";
	var URL="index_action.php";
$('#myaction').val('updatebox');
$('#boxid').val(boxid);
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//jQuery("#load_mainContant").html(html);
			modLoadContent();
		}
	}); 
}

	


function isBlank(myObj) {
		if(myObj.value=='') { return true; }
		return false;
}

function changeStatus(loaddder,tablename,statusname,statusid,loadderstatus,myaction) {

	jQuery("#"+loaddder+"").show();

	var TYPE="POST";
	var URL="index_action.php";
	var dataSet={
	Valueloaddder: loaddder,
	Valuetablename : tablename ,
	Valuestatusname : statusname ,
	Valuestatusid : statusid ,
	Valueloadderstatus : loadderstatus,
	myaction : myaction
	};

	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){

			jQuery("#"+loadderstatus+"").show();
			jQuery("#"+loadderstatus+"").html(html)
			jQuery("#"+loaddder+"").hide();
		}
	});
}

$(function(){
  	setInterval(function(){ // เขียนฟังก์ชัน javascript ให้ทำงานทุก ๆ 30 วินาที
	// 1 วินาที่ เท่า 1000
	// คำสั่งที่ต้องการให้ทำงาน ทุก ๆ 3 วินาที
	var getDataContact=$.ajax({ // ใช้ ajax ด้วย jQuery ดึงข้อมูลจากฐานข้อมูล
		url:"getcontact.php",
		data:"getcontact=1",
		async:false,
		success:function(getDataContact){
			$("li#showDataContact").html(getDataContact); // ส่วนที่ 3 นำข้อมูลมาแสดง
									}
	 	}).responseText;
		
	},60000);	
});

