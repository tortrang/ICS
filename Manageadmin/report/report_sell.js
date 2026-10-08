function switchmode() {
	var TYPE="POST";
	var URL="report_sell_action.php";
	$('#myaction').val('switchmode');
	var dataSet= jQuery("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){			
		}
	});
}

function modLoadAddNew(row_id) {
	var customer_id = document.getElementById('customer_id_IC').value;
	if(customer_id==0) { 
		$("#customer_id_IC").addClass("error")
		$('#customer_id_IC').focus();return false;
	}else{
		$("#customer_id_IC").removeClass("error");
	}

	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_sell_action.php";
	$('#myaction').val('addnew');
	$('#row_id').val(row_id);
	$('#customer_id').val(customer_id);
	var dataSet= $("#myForm").serialize();
	// console.log(dataSet);
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#load_mainContant").show();
			jQuery("#load_mainContant").html(html);
			jQuery("#load_mainwaiting").hide();

			jQuery('.nk-body').removeClass('modal-open');
			jQuery('.modal-backdrop').removeClass('show');
			jQuery('.modal-backdrop').removeClass('modal-backdrop');
		}
	});
}

function modLoadAddNew_2(row_id,customer_id,order_ID) {
	// var customer_id = customer_id;
	// if(customer_id==0) { 
	// 	$("#customer_id").addClass("error")
	// 	$('#customer_id').focus();return false;
	// }else{
	// 	$("#customer_id").removeClass("error");
	// }

	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_sell_action.php";
	$('#myaction').val('addnew');
	$('#row_id').val(row_id);
	$('#customer_id').val(customer_id);
	$('#customerID').val(customer_id);
	var dataSet= $("#myForm").serialize();
	// console.log(dataSet);
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#load_mainContant").show();
			jQuery("#load_mainContant").html(html);
			jQuery("#load_mainwaiting").hide();

			if(order_ID){
				document.getElementById("product_reason_cr["+order_ID+"]").focus();
			}

			jQuery('.nk-body').removeClass('modal-open');
			jQuery('.modal-backdrop').removeClass('show');
			jQuery('.modal-backdrop').removeClass('modal-backdrop');
		}
	});
}

function loadproduct_id(p_code,c_id,row_id) {
	// console.log(my_id);
	var TYPE="POST";
	var URL="report_sell_action.php"; 
	var dataSet= {
		p_code: p_code,
		c_id : c_id,
		row_id : row_id,
		customer_id : c_id,
		myaction : 'loadproduct_id'
	};
	// console.log(dataSet);
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			// console.log(html);
			const obj = JSON.parse(html);
			var product_id=obj.product_id; 
			var customer_id=obj.customer_id; 
			var priceproduct=obj.priceproduct;  
			var row_id=obj.row_id; 
			var status=obj.status; 
			
			var objSet= {
				product_id : product_id,
				customer_id : customer_id,
				priceproduct : priceproduct,
				row_id : row_id,
				status : status
			};
			// console.log(objSet);
			 
			if(status=='success'){  
				modInsertProduct_2(objSet);
			}else{
				Swal.fire(
					'Error',
					'เพิ่มสินค้าไม่สำเร็จ !! ไม่พบรายการสินค้า',
					'error'
				).then(() =>{ 

				}) 
			}  

			// modLoadAddNew();
			// jQuery("#load_mainContant").show();
			// jQuery("#load_mainContant").html(html);
			// jQuery("#load_mainwaiting").hide();
		}
	});
}

function modloadProduce(my_id) {
	// console.log(my_id);
	var TYPE="POST";
	var URL="report_sell_action.php"; 
	var dataSet= {
		my_id : my_id,
		myaction : 'modloadproduct'
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadproduct").show();
			jQuery("#loadproduct").html(html); 
		}
	});
}

function checkweight(weight,p_id,row_id,order_id) {
	
	var TYPE="POST";
	var URL="report_sell_action.php"; 
	var dataSet= {
		weight : weight,
		p_id : p_id,
		row_id : row_id,
		order_id : order_id,
		myaction : 'checkweight'
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			// console.log(html);
			const obj = JSON.parse(html);
			var product_id=obj.product_id; 
			var row_id=obj.row_id; 
			var balance_stock=obj.balance_stock;  
			var order_id=obj.order_id;  
			var status=obj.status;  
			if(status=='error'){
				Swal.fire(
					'Error',
					'สินค้าหมดสต็อก กรุณาตรวจสอบสต็อกสินค้า !!'+"<br>"+"จำนวนสต็อกปัจจุบัน "+balance_stock+" กก.",
					'error'
				).then(() =>{  
					document.getElementById('product_weight_cr['+order_id+']').value=0; 
					// return false;
				}) 
	
			}else{
				return false;
			}
			
			// jQuery("#loadproduct").show();
			// jQuery("#loadproduct").html(html); 
		}
	});
}

function modLoadtype(input_catalog,my_id) {
	var TYPE="POST";
	var URL="report_sell_action.php";
	var dataSet= {
		input_catalog : input_catalog,
		my_id : my_id,
		myaction : 'modloadproduct'
	};
	// console.log(dataSet);
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadproduct").show();
			jQuery("#loadproduct").html(html); 
		}
	});
}
function modLoadsearch(InputSearch_p) {
	var TYPE="POST";
	var URL="report_sell_action.php";
	var dataSet= {
		InputSearch_p : InputSearch_p,
		myaction : 'modloadproduct'
	};
	// console.log(dataSet);
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadproduct").show();
			jQuery("#loadproduct").html(html); 
		}
	});
}

// function modloadproduct() {
// 	var TYPE="POST";
// 	var URL="report_sell_action.php";
// 	$('#myaction').val('modloadproduct');
// 	var dataSet= $("#myForm").serialize();
// 	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
// 		success:function(html){
// 			jQuery("#loadproduct").show();
// 			jQuery("#loadproduct").html(html); 
// 		}
// 	});
// }

function modLoadSelectProduct() {
	var TYPE="POST";
	var URL="report_sell_action.php";
$('#myaction').val('selectproduct');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadmodalcontent").html(html);
			jQuery('#loadmodal').modal('show');
		}
	});
}

function modLoadcreatebill() {
	var TYPE="POST";
	var URL="report_sell_action.php";
$('#myaction').val('modLoadcreatebill');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadmodalcreatebill").html(html); 
			jQuery("#loadmodalcreatebill").show();
		}
	});
}

function modLoadAddProduct() {
	var customer_id = document.getElementById('customer_id').value;
	if(customer_id==0) { 
		$("#customer_id").addClass("error")
		$('#customer_id').focus();return false;
	}else{
		$("#customer_id").removeClass("error");
	} 
 
	var walletstock = $("#product_waletstock").val(); 
	if(walletstock<=0){
		Swal.fire(
			'Error',
			'สินค้าหมดสต็อก กรุณาตรวจสอบสต็อกสินค้า !!',
			'error'
		).then(() =>{ 
			return false;
		}) 
	}else{
		var TYPE="POST";
		var URL="report_sell_action.php";
		$('#myaction').val('addproduct');
		var dataSet= $("#myForm").serialize();
		// console.log(dataSet);
		jQuery.ajax({type:TYPE,url:URL,data:dataSet,
			success:function(html){
				jQuery("#loadmodalcontent").html(html);
				jQuery('#loadmodal').modal('show');
			}
		});
	}
}
 
function hideModal() {
	// $('#modvatload').on('shown.bs.modal', function (e) {
    //     $("#modvatload").modal('hide');
    // })
	// window.location.href = 'billing.php?masterkey=bill&&menukeyid=52&&MenuActive=52';
	jQuery('.nk-body').removeClass('modal-open');
	jQuery('.modal-backdrop').removeClass('show');
	jQuery('.modal-backdrop').removeClass('modal-backdrop');
}

function modInsertContent() {
	// jQuery(".modvatload").modal('hide'); 
	if(document.getElementById("TotalCheckBoxID").value>0){
		jQuery("#load_mainwaiting").show();
		jQuery("#load_mainContant").hide(); 
		var TYPE="POST";
		var URL="report_sell_action.php";
		$('#myaction').val('insert');
		var dataSet= $("#myForm").serialize();
		// console.log(dataSet);
		jQuery.ajax({type:TYPE,url:URL,data:dataSet,
			success:function(html){ 
				// console.log(html);  
				jQuery("#loadprice").html(html);
				// modLoadContent(); 
				hideModal();
			}
		});
	}else{
		alert("กรุณาเพิ่มสินค้า");
	}
}

function modInsertContent_2() {
	// jQuery(".modvatload").modal('hide'); 
	if(document.getElementById("TotalCheckBoxID").value>0){
		jQuery("#load_mainwaiting").show();
		jQuery("#load_mainContant").hide(); 
		var TYPE="POST";
		var URL="report_sell_action.php";
		$('#myaction').val('insert_2');
		var dataSet= $("#myForm").serialize();
		// console.log(dataSet);
		jQuery.ajax({type:TYPE,url:URL,data:dataSet,
			success:function(html){ 
				// console.log(html);  
				jQuery("#loadprice").html(html);
				modLoadContent(); 
				hideModal();
			}
		});
	}else{
		alert("กรุณาเพิ่มสินค้า");
	}
}


function modInsertbillcheck() {
	if(document.getElementById("TotalCheckBoxID").value>0){
		jQuery("#load_mainwaiting").show();
		jQuery("#load_mainContant").hide();
		var TYPE="POST";
		var URL="report_sell_action.php";
		$('#myaction').val('insertbillcheck');
		var dataSet= $("#myForm").serialize();
		// console.log(dataSet);
		jQuery.ajax({type:TYPE,url:URL,data:dataSet,
			success:function(html){ 
				// console.log(html); 
				jQuery("#loadprice").html(html);
				modLoadContent(); 
				// jQuery("#load_mainContant").show();
				// jQuery("#load_mainContant").html(html);
				// jQuery("#load_mainwaiting").hide();
			}
		});
	}else{
		alert("กรุณาเพิ่มสินค้า");
	}
}


function updatereason_cr(my_value,customer_id,row_id,order_id) {
	
	var TYPE="POST";
	var URL="report_sell_action.php"; 
	var dataSet= {
		my_value : my_value,
		customer_id : customer_id,
		row_id : row_id,
		order_id : order_id,
		myaction : 'updatereason_cr'
	};
	// console.log(dataSet);
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			const obj = JSON.parse(html);
			var order_ID=obj.order_ID;   
			// var status=obj.status; 
			if(order_ID){
				document.getElementById("product_price_cr["+order_ID+"]").focus();
			}
			// return false;
			// jQuery("#load_mainContant").show();
			// jQuery("#load_mainContant").html(html);
			// jQuery("#load_mainwaiting").hide();
		}
	});
}


function updatepricr_cr(my_value,customer_id,row_id,order_id) {
	// console.log(order_id);
	var TYPE="POST";
	var URL="report_sell_action.php"; 
	var dataSet= {
		my_value : my_value,
		customer_id : customer_id,
		row_id : row_id,
		order_id : order_id,
		myaction : 'updatepricr_cr'
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			const obj = JSON.parse(html);
			var order_ID=obj.order_ID;   
			var next_id=obj.next_id;  
			var sumtotal=obj.sumtotal;  
			var amount_total=obj.amount_total; 
			var sumprice_total=obj.sumprice_total; 
			// var status=obj.status; 
			var weight_cr = document.getElementById("product_weight_cr["+order_ID+"]").value;
			// console.log("fff: "+weight_cr);
			if(weight_cr==0 || weight_cr==''){
				if(order_ID){
					document.getElementById("product_weight_cr["+order_ID+"]").focus();
				}
			} else{
				document.getElementById("product_total_cr["+order_ID+"]").innerHTML=sumtotal.toFixed(2);
				document.getElementById("sum_amount").innerHTML=amount_total.toFixed(2);
				document.getElementById("sum_pricetotal").innerHTML=sumprice_total.toFixed(2);
				if(next_id){  
					document.getElementById("product_reason_cr["+next_id+"]").focus();
				}else{ 
					document.getElementById("product_code_cr").focus();
				}
			}
			
			
			// return false;
			// jQuery("#load_mainContant").show();
			// jQuery("#load_mainContant").html(html);
			// jQuery("#load_mainwaiting").hide();
		}
	});
}

function updateweight_cr(my_value,customer_id,row_id,order_id) {
	// console.log(my_id);
	var TYPE="POST";
	var URL="report_sell_action.php"; 
	var dataSet= {
		my_value : my_value,
		customer_id : customer_id,
		row_id : row_id,
		order_id : order_id,
		myaction : 'updateweight_cr'
	};
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			// console.log(html); 
			const obj = JSON.parse(html);
			var order_ID=obj.order_ID;  
			var next_id=obj.next_id;  
			var sumtotal=obj.sumtotal;  
			var amount_total=obj.amount_total; 
			var sumprice_total=obj.sumprice_total; 
			var status=obj.status; 
			console.log(html);
			if(status=='success'){
				document.getElementById("product_total_cr["+order_ID+"]").innerHTML=sumtotal.toFixed(2);
				document.getElementById("sum_amount").innerHTML=amount_total.toFixed(2);
				document.getElementById("sum_pricetotal").innerHTML=sumprice_total.toFixed(2);
				if(next_id){  
					document.getElementById("product_reason_cr["+next_id+"]").focus();
				}else{
	
					document.getElementById("product_weight_cr["+order_ID+"]").setAttribute("disabled","disabled");
	
					document.getElementById("product_code_cr").focus();
				}
			}else{
				Swal.fire(
					'Error',
					'สินค้าหมดสต็อก กรุณาตรวจสอบสต็อกสินค้า !!',
					'error'
				).then(() =>{ 
					return false;
				}) 
			}
			
			// return false;
			// jQuery("#load_mainContant").show();
			// jQuery("#load_mainContant").html(html);
			// jQuery("#load_mainwaiting").hide();
		}
	});
}
function modInsertbillcheck_2() {
	if(document.getElementById("TotalCheckBoxID").value>0){
		jQuery("#load_mainwaiting").show();
		jQuery("#load_mainContant").hide();
		var TYPE="POST";
		var URL="report_sell_action.php";
		$('#myaction').val('insertbillcheck_2');
		var dataSet= $("#myForm").serialize();
		// console.log(dataSet);
		jQuery.ajax({type:TYPE,url:URL,data:dataSet,
			success:function(html){ 
				// console.log(html); 
				jQuery("#loadprice").html(html);
				modLoadContent(); 
				// jQuery("#load_mainContant").show();
				// jQuery("#load_mainContant").html(html);
				// jQuery("#load_mainwaiting").hide();
			}
		});
	}else{
		alert("กรุณาเพิ่มสินค้า");
	}
}


function modInsertProduct_2(objSet) {
	//jQuery("#load_mainwaiting").show();
	//jQuery("#load_mainContant").hide();
	// console.log(objSet);
	var TYPE="POST";
	var URL="report_sell_action.php";
	// $('#myaction').val('insertproduct');
	 
	var product_id=objSet.product_id; 
	var customer_id=objSet.customer_id; 
	var priceproduct=objSet.priceproduct;
	var row_id=objSet.row_id;  //null 
	var status=objSet.status; 
	
	var dataSet= {
		productid : product_id,
		customer_id : customer_id,
		product_buy : priceproduct,
		row_id : row_id,
		status : status,
		myaction : 'insertproduct'
	};
	
	// var paramArr = $("#myForm").serializeArray(); 
	// var row_id = customer_id;
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			 
			const obj = JSON.parse(html);
			var md_billing=obj.md_billing; 
			var customer_id=obj.customer_id;  
			var order_ID=obj.order_ID; 
			// var row_id=obj.md_billing; 
			var status=obj.status; 
			// console.log(obj);
			if(status=='success'){
				// $(".modal-backdrop fade").removeClass("show");
				Swal.fire(
					'Success',
					'เพิ่มสินค้าสำเร็จ',
					'success'
				).then(() =>{
					modLoadAddNew_2(md_billing,customer_id,order_ID);
				})	
			}else{
				Swal.fire(
					'Error',
					'เพิ่มสินค้าไม่สำเร็จ !!',
					'error'
				).then(() =>{ 
				}) 
			}  
		}
	});
}

function modInsertProduct() {
	//jQuery("#load_mainwaiting").show();
	//jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_sell_action.php";
	$('#myaction').val('insertproduct');
	var dataSet= $("#myForm").serialize();
	var paramArr = $("#myForm").serializeArray(); 
	var row_id = paramArr[15]['value'];
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){ 
			if(html.includes('success')){
					// $(".modal-backdrop fade").removeClass("show");
					Swal.fire(
						'Success',
						'เพิ่มสินค้าสำเร็จ',
						'success'
					).then(() =>{
						modLoadAddNew(row_id);
					})	
				}else{
					Swal.fire(
						'Error',
						'เพิ่มสินค้าไม่สำเร็จ !!',
						'error'
					).then(() =>{ 
					}) 
				}  
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
	window.open('printinvoice_sell.php?number='+number+'&myRadio='+myRadio+'&myRadio2='+myRadio2, '_blank')
}

function print_billreport(startdate,enddate) {
	var report_b = $("input[name='report_b']:checked").val();
	var report_b_type = $("input[name='report_b_type']:checked").val();
	var report_vat_type = $("input[name='report_vat_type']:checked").val();

	// console.log(startdate); 

	window.open('export_excel_report_sell.php?startdate='+startdate+'&enddate='+enddate+'&report_b='+report_b+'&report_b_type='+report_b_type+'&report_vat_type='+report_vat_type, '_blank')
}

function modDeleteContant() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_sell_action.php";
	$('#myaction').val('delete');
	var dataSet= $("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//jQuery("#load_mainContant").html(html);
			modLoadContent();
			// jQuery("#load_mainContant").show();
			// jQuery("#load_mainContant").html(html);
			// jQuery("#load_mainwaiting").hide();
		}
	});
}

function modDeleteProduct() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_sell_action.php";
	$('#myaction').val('deleteproduct');
	var dataSet= $("#myForm").serialize();
	var paramArr = $("#myForm").serializeArray(); 
	var row_id = paramArr[15]['value'];
	var customer_id = paramArr[17]['value'];
	// console.log(paramArr);
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			//jQuery("#load_mainContant").html(html);
			
			if(html.includes('success')){
				// $(".modal-backdrop fade").removeClass("show");
				Swal.fire(
					'Success',
					'ลบสินค้าสำเร็จ',
					'success'
				).then(() =>{
					modLoadAddNew_2(row_id,customer_id); 
				})	
			}else{
				Swal.fire(
					'Error',
					'ลบสินค้าไม่สำเร็จ !!',
					'error'
				).then(() =>{ 
				}) 
			}  
		}
	});
}
function viewvat() {
	var TYPE="POST";
	var URL="report_sell_action.php";
	$('#myaction').val('viewvat');
	var dataSet= $("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadvatview").html(html);
			jQuery('#modvatload').modal('show');
		}
	});
}

function modLoadView() {
	var TYPE="POST";
	var URL="report_sell_action.php";
	$('#myaction').val('view');
	var dataSet= $("#myForm").serialize();
	jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadmodalcontent").html(html);
			jQuery('#loadmodalview').modal('show');
		}
	});
}
function Viewbill() {
	var TYPE="POST";
	var URL="report_sell_action.php";
$('#myaction').val('Viewbill');
var dataSet= $("#myForm").serialize();
jQuery.ajax({type:TYPE,url:URL,data:dataSet,
		success:function(html){
			jQuery("#loadcontentview").html(html);
			jQuery('#viewbillload').modal('show');
		}
	});
}

function modLoadContent() {
	jQuery("#load_mainwaiting").show();
	jQuery("#load_mainContant").hide();
	var TYPE="POST";
	var URL="report_sell_action.php";
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
		if(isBlank(product_amount)) { 
			$("#product_amount").addClass("error")
			$('#product_amount').focus();return false;
		}else{
			$("#product_amount").removeClass("error");
		}
	}
	var product_amount_a=document.getElementById("product_amount").value;
	if(product_amount_a==0) { 
		$("#product_amount").addClass("error")
		$('#product_amount').focus();return false;
	}else{
		$("#product_amount").removeClass("error");
	}
	jQuery('#loadmodal').modal('hide');
	jQuery('.nk-body').removeClass('modal-open');
	jQuery('.modal-backdrop').removeClass('show');
	jQuery('.modal-backdrop').removeClass('modal-backdrop');
	modInsertProduct();
}

function calculate(number){
	var amount=document.getElementById("product_amount").value;
	if(number=='c'){
		document.getElementById("product_amount").value='';
	}else if(number=='d'){
		var str = amount.length;
		var strnum=str-1;
		var amount1 = amount.slice(0,strnum);
		document.getElementById("product_amount").value=amount1;
	}else{	
		amount=amount+number;
		document.getElementById("product_amount").value=amount;
	}
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
	var URL="report_sell_action.php";
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