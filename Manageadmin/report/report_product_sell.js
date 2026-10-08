function switchmode() {
	var TYPE="POST";
	var URL="report_product_sell_action.php";
	$('#myaction').val('switchmode');
	var dataSet= jQuery("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){			
		}
	});
}

function modLoadAddNew() {
	var TYPE="POST";
	var URL="report_product_sell_action.php";
$('#myaction').val('addnew');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadmodalcontent").html(html);
			jQuery('#loadmodal').modal('show');
		}
	});
}

function modInsertContent() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_product_sell_action.php";
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
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_product_sell_action.php";
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
	var TYPE="POST";
	var URL="report_product_sell_action.php";
$('#myaction').val('view');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadmodalcontent").html(html);
			jQuery('#loadmodal').modal('show');
		}
	});
}



function modLoadContent() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_product_sell_action.php";
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

function Reject() {
	jQuery('#modalveiw'+$('#myContantID').val()).modal('hide');
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_product_sell_action.php";
$('#myaction').val('reject');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
		//jQuery("#load_mainContant").html(html);
		modLoadContent();
		}
	});
}

function loadchkaddform() {

	with(document.myForm) {
		if(isBlank(deposit_amount)) { 
			$("#deposit_amount").addClass("error")
			$('#deposit_amount').focus();return false;
		}else{
			$("#deposit_amount").removeClass("error");
		}
		if(isBlank(deposit_file)) { 
			$("#deposit_file").addClass("error")
			$('#deposit_file').focus();return false;
		}else{
			$("#deposit_file").removeClass("error");
		}	
	}
	jQuery("#load_mainwaiting").show();
	jQuery('#loadmodal').modal('hide');
	$('#myaction').val('insert');
	document.myForm.submit();
	//modInsertContent();
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


function LoadAmphures(myid,div) {
	var TYPE="POST";
	var URL="../libs/loadfuntion.php";
	var dataSet={
	myid: myid,
	div : div ,
	myaction : "loadamphures"
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//document.getElementById("input_district").value="";
			LoadTambon('','input_tambon');
			jQuery("#"+div+"").html(html)
			
		}
	});
}
function LoadTambon(myid,div) {
	var TYPE="POST";
	var URL="../libs/loadfuntion.php";
	var dataSet={
	myid: myid,
	div : div ,
	myaction : "loadtambon"
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//alert(myid);
			//jQuery("#load_mainContant").html(html);
			jQuery("#"+div+"").html(html)
		}
	});
}
function LoadPostcode(myid) {
	var TYPE="POST";
	var URL="../libs/loadfuntion.php";
	var dataSet={
	myid: myid,
	myaction : "loadpostcode"
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//jQuery("#load_mainContant").html(html);
			//alert(myid);
			jQuery("#loadpostcode").html(html)
		}
	});
}
function changeStatus(loaddder,statusname,statusid,loadderstatus,myaction) {

	jQuery("#"+loaddder+"").show();

	var TYPE="POST";
	var URL="report_product_sell_action.php";
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