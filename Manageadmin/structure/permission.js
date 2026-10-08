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
	var URL="permission_action.php";
$('#myaction').val('addnew');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//alert();
			jQuery("#load_mainContant").show();
			jQuery("#load_mainContant").html(html);
			jQuery("#load_mainwaiting").hide();
		}
	});
}

function modInsertContent() {
	
	var TYPE="POST";
	var URL="permission_action.php";
$('#myaction').val('insert');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
		//jQuery("#load_mainContant").html(html);
		modLoadContent();
		}
	});
}


function modDeleteContant() {
	jQuery("#load_mainwaiting").show();
	var TYPE="POST";
	var URL="permission_action.php";
$('#myaction').val('delete');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#load_mainContant").html(html);
			//modLoadContent();

		}
	});
}


function modLoadView() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="permission_action.php";
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
	var URL="permission_action.php";
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

function loadchkaddform() {

	with(document.myForm) {
		if(isBlank(InputNameGroup)) { 
			$("#InputNameGroup").addClass("error")
			$('#InputNameGroup').focus();return false;
		}else{
			$("#InputNameGroup").removeClass("error");
		}	
		if(isBlank(InputNameLevel)) { 
			$("#InputNameLevel").addClass("error")
			$('#InputNameLevel').focus();return false;
		}else{
			$("#InputNameLevel").removeClass("error");
		}
	}
	jQuery("#load_mainwaiting").show();
	genDataAdmin();
	document.myForm.Permission.value="";
	modInsertContent();
}

function isBlank(myObj) {
	if(myObj.value=='') { return true; }
	return false;
}

function checkNumber(){
	if (event.keyCode < 48 || event.keyCode > 57){
		event.returnValue = false;
	}
}

function changeStatus(loaddder,statusname,statusid,loadderstatus,myaction) {

	jQuery("#"+loaddder+"").show();

	var TYPE="POST";
	var URL="permission_action.php";
	var dataSet={
	Valueloaddder: loaddder,
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

function Paging_CheckAll(objCheckHeader,txtCheckBoxFirstName,intTotalItems) {
		if(intTotalItems>0)
			for(i=1;i<=intTotalItems;i++)
				document.getElementById(txtCheckBoxFirstName+i).checked = objCheckHeader.checked;
							
		return true;
	}
	
function Paging_CheckAllHandle(objCheckHeader,txtCheckBoxFirstName,intTotalItems) {
		var isCheckedAll = true;
		if(intTotalItems>0)
			for(i=1;i<=intTotalItems;i++)
				if(!document.getElementById(txtCheckBoxFirstName+i).checked) 
					isCheckedAll = false;
		objCheckHeader.checked = isCheckedAll;
		return true;
	}
function Paging_CountChecked(txtCheckBoxFirstName,intTotalItems) {
		var intChecked = 0;
		if(intTotalItems>0)
			for(i=1;i<=intTotalItems;i++)
				if(document.getElementById(txtCheckBoxFirstName+i).checked) 
					intChecked ++;
		return intChecked ;
	}
function Paging_CheckedThisItem(objCheckHeader,indexing,txtCheckBoxFirstName,intTotalItems) {
		if(intTotalItems>0)
			for(i=1;i<=intTotalItems;i++)
				if(i==indexing) {
					document.getElementById(txtCheckBoxFirstName+i).checked = true;
				} else {
					document.getElementById(txtCheckBoxFirstName+i).checked = false;
				}
		objCheckHeader.checked = false;
		return true;
	}