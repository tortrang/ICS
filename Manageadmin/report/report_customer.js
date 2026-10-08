function switchmode() {
	var TYPE="POST";
	var URL="report_customer_action.php";
	$('#myaction').val('switchmode');
	var dataSet= jQuery("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){			
		}
	});
}

function modLoadAddNew() {
	var TYPE="POST";
	var URL="report_customer_action.php";
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
	var URL="report_customer_action.php";
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
	var URL="report_customer_action.php";
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
	var URL="report_customer_action.php";
	$('#myaction').val('view');
	var dataSet= $("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadmodalcontent").html(html);
			jQuery('#loadmodal').modal('show');

			jQuery('.nk-body').removeClass('modal-open');
			jQuery('.modal-backdrop').removeClass('show');
			jQuery('.modal-backdrop').removeClass('modal-backdrop');
		}
	});
}

function modLoadView_detail(row_id) {
	var TYPE="POST";
	var URL="report_customer_action.php";
	// $('#myaction').val('modLoadView_detail');
	var dataSet= {
		row_id : row_id,
		myaction : 'modLoadView_detail'
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadmodalcontent_detail").html(html);
			jQuery('#loadmodal_detail').modal('show');

			jQuery('.nk-body').removeClass('modal-open');
			jQuery('.modal-backdrop').removeClass('show');
			jQuery('.modal-backdrop').removeClass('modal-backdrop');
		}
	});
}

function modLoadView_detail_sell(row_id) {
	var TYPE="POST";
	var URL="report_customer_action.php";
	// $('#myaction').val('modLoadView_detail');
	var dataSet= {
		row_id : row_id,
		myaction : 'modLoadView_detail_sell'
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadmodalcontent_detail").html(html);
			jQuery('#loadmodal_detail').modal('show');

			jQuery('.nk-body').removeClass('modal-open');
			jQuery('.modal-backdrop').removeClass('show');
			jQuery('.modal-backdrop').removeClass('modal-backdrop');
		}
	});
}

function Viewbill_coustomer(customer_id) {
	var TYPE="POST";
	var URL="report_customer_action.php";
	// $('#myaction').val('Viewbill_coustomer');
	var dataSet= {
		customer_id : customer_id,
		myaction : 'Viewbill_coustomer'
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadcontentview").html(html);
			jQuery('#viewbillload').modal('show');
		}
	});
}

function printinvoice(number) {
	var myRadio = $("input[name='customRadio']:checked").val();
	
	if(myRadio==0){
		var myRadio2 = $("input[name='customRadio2']:checked").val();
	}else{
		var myRadio2 = 0;
	}
	// var dataSet= { 
	// 	myRadio : myRadio,
	// 	number : number
	// };
	window.open('printinvoice.php?number='+number+'&myRadio='+myRadio+'&myRadio2='+myRadio2, '_blank')
}


function printinvoice_sell(number) {
	var myRadio = $("input[name='customRadio']:checked").val();
	
	if(myRadio==0){
		var myRadio2 = $("input[name='customRadio2']:checked").val();
	}else{
		var myRadio2 = 0;
	}
	// var dataSet= { 
	// 	myRadio : myRadio,
	// 	number : number
	// };
	window.open('printinvoice_sell.php?number='+number+'&myRadio='+myRadio+'&myRadio2='+myRadio2, '_blank')
}

function Viewbill() {
	var TYPE="POST";
	var URL="report_customer_action.php";
	$('#myaction').val('Viewbill');
	var dataSet= $("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadcontentview_2").html(html);
			jQuery('#viewbillload_2').modal('show');
		}
	});
}

function Viewbill_sell() {
	var TYPE="POST";
	var URL="report_customer_action.php";
	$('#myaction').val('Viewbill_sell');
	var dataSet= $("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadcontentview_2").html(html);
			jQuery('#viewbillload_2').modal('show');
		}
	});
}

function print_billreport(customer_id) {
	var report_b = $("input[name='report_b']:checked").val();
	var report_b_type = $("input[name='report_b_type']:checked").val();
  
	window.open('export_excel_customer.php?customer_id='+customer_id+'&report_b='+report_b+'&report_b_type='+report_b_type, '_blank');
}

function modLoadContent() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_customer_action.php";
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
	var URL="report_customer_action.php";
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
	var URL="report_customer_action.php";
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