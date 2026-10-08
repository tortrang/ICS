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
	var URL="info_action.php";
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
	var URL="info_action.php";
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
	var URL="info_action.php";
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
	var URL="info_action.php";
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
	var URL="info_action.php";
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

function loadchkaddform() {

	with(document.myForm) {
		if(isBlank(info_company)) { 
			$("#info_company").addClass("error")
			$('#info_company').focus();return false;
		}else{
			$("#info_company").removeClass("error");
		}	
		if(isBlank(info_url)) { 
			$("#info_url").addClass("error")
			$('#info_url').focus();return false;
		}else{
			$("#info_url").removeClass("error");
		}
		if(isBlank(info_title)) { 
			$("#info_title").addClass("error")
			$('#info_title').focus();return false;
		}else{
			$("#info_title").removeClass("error");
		}
		if(isBlank(info_phone)) { 
			$("#info_phone").addClass("error")
			$('#info_phone').focus();return false;
		}else{
			$("#info_phone").removeClass("error");
		}
		if(isBlank(info_tel)) { 
			$("#info_tel").addClass("error")
			$('#info_tel').focus();return false;
		}else{
			$("#info_tel").removeClass("error");
		}
		if(isBlank(info_fax)) { 
			$("#info_fax").addClass("error")
			$('#info_fax').focus();return false;
		}else{
			$("#info_fax").removeClass("error");
		}
		if(isBlank(info_email)) { 
			$("#info_email").addClass("error")
			$('#info_email').focus();return false;
		}else{
			$("#info_email").removeClass("error");
		}
		if(isBlank(info_emailsystem)) { 
			$("#info_emailsystem").addClass("error")
			$('#info_emailsystem').focus();return false;
		}else{
			$("#info_emailsystem").removeClass("error");
		}
		if(isBlank(info_address)) { 
			$("#info_address").addClass("error")
			$('#info_address').focus();return false;
		}else{
			$("#info_address").removeClass("error");
		}	
	}
	jQuery("#load_mainwaiting").show();
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
	var URL="info_action.php";
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