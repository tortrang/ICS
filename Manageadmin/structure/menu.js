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
	var URL="menu_action.php";
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
	var URL="menu_action.php";
$('#myaction').val('insert');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
		//jQuery("#load_mainwaiting").hide();
		//jQuery("#load_mainContant").html(html);
		modLoadContent();
		}
	});
}

function addContantMenu(parentID) {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="menu_action.php";
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
	jQuery("#load_mainwaiting").show();
	var TYPE="POST";
	var URL="menu_action.php";
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
	var URL="menu_action.php";
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
	var URL="menu_action.php";
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

function sortContantMenu() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="menu_action.php";
$('#myaction').val('sortmenu');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#load_mainContant").show();
			jQuery("#load_mainContant").html(html);
			jQuery("#load_mainwaiting").hide();
			modLoadLastContent();
			
		}
	}); 
}
function modLoadLastContent() {
	//jQuery("#load_mainwaiting").show();
	var TYPE="POST";
	var URL="menu_action.php";
$('#myaction').val('lastcontent');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#divLoadLastContent").html(html);
			
		}
	}); 
}
function updateContantSort() {
	jQuery("#load_mainwaiting").show();
	var TYPE="POST";
	var URL="menu_action.php";
	$('#myaction').val('updatesortmenu');
	var dataSet= $("#myForm").serialize();
		jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//jQuery("#load_mainContant").show();
			//jQuery("#load_mainContant").html(html)
			//jQuery("#load_mainwaiting").hide();
			//jQuery("#load_mainContant").html(html);
			modLoadContent();
		}
	}); 
			
}
function setImageSelected(myPath) {
		
		window.opener.document.myForm.inputName.value = myPath;
		window.opener.document.myForm.inputIconName.value = myPath;
		window.close();
		
	}

function isBlank(myObj) {
		if(myObj.value=='') { return true; }
		return false;
}

function loadchkaddform() {

	with(document.myForm) {
		if(isBlank(inputName)) { 
			$("#inputName").addClass("error")
			$('#inputName').focus();return false;
		}else{
			$("#inputName").removeClass("error");
		}	
		if(isBlank(inputmenunamethai)) { 
			$("#inputmenunamethai").addClass("error")
			$('#inputmenunamethai').focus();return false;
		}else{
			$("#inputmenunamethai").removeClass("error");
		}
		if(isBlank(inputmenunameeng)) { 
			$("#inputmenunameeng").addClass("error")
			$('#inputmenunameeng').focus();return false;
		}else{
			$("#inputmenunameeng").removeClass("error");
		}
		
	}
	jQuery("#load_mainwaiting").show();
	modInsertContent();
}

function changeStatus(loaddder,tablename,statusname,statusid,loadderstatus,myaction) {

	jQuery("#"+loaddder+"").show();

	var TYPE="POST";
	var URL="menu_action.php";
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


