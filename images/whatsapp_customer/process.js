//========================open drawar =============
var G_begin = 0;
function search_table()
{
	G_begin = 0;
	$(".list_data").html("");
	get_items();
	countdata();
}
function cmbcou_change(val)
{
	filldata_sel("select * from city where cou_id = " + val + " order by cit_order" 
	, "cit_name_en" , "cit_id" , "" , "Select City" , "list");
}

$(document).ready(function () {
	
	countdata();
    $(".list_data").css("height", $(window).height() -300);
	get_items();
   
/*   filldata_sel("select * from city order by cit_name_en" 
	, "cit_name_en" , "cit_id" , "" , "select City" , "list");
*/	
	filldata_sel("select * from country order by cou_order" 
	, "cou_name_en" , "cou_id" , "" , "Select Country" , "list");
	filldata_sel("select * from city where cou_id = 0 order by cit_order" 
	, "cit_name_en" , "cit_id" , "" , "Select City" , "list");
	// console.log("begin:" + G_begin);
	$(".list_data").scroll(function () {

		//    if($(window).scrollTop() == $(document).height() - $(window).height()) {
		if ($(".list_data").scrollTop() + $(".list_data").height() >= $(document).height() -600) {
			// ajax call get data from server and append to the div
//			 alert("thaer");
			G_begin = G_begin + 10;
			get_items();

		}
	});

});
//=======================================================getitems
function refreshdata()
{
	$(".list_data").html("");
	G_begin = 0;
	get_items();
}
function countdata() {
	var _txtsearch = $("#txtsearch").val();
		var _cou_id = $("#listcmbcou_id").val();
			var _cit_id = $("#listcmbcit_id").val();
				var _cus_gender = $("#cmbgender").val();
								var _cus_active = $("#cmbactive").val();
	/*if(_txtsearch != "")
	{
		
	}*/
  $.ajax({
    url: 'whatsapp_customer/process.php',
    type: 'POST',
    data: { action:'countdata' ,txtsearch : _txtsearch
	, cou_id : _cou_id
	, cit_id : _cit_id
	, cus_gender : _cus_gender
	, cus_active : _cus_active
	} ,

    success: function (data) {
				   //alert(data);
           $("#lblcount").text(data);

        },
         error: function () {
        //alert("error");
    }
    });
}
function get_items() {
	var _txtsearch = $("#txtsearch").val();
	var _cou_id = $("#listcmbcou_id").val();
	var _cit_id = $("#listcmbcit_id").val();
	var _cus_gender = $("#cmbgender").val();
	var _cus_active = $("#cmbactive").val();
	var _cus_id = $("#cus_id").val();
	var _wha_id = $("#wha_id").val();
				
  $.ajax({
    url: 'whatsapp_customer/process.php',
    type: 'POST',
    data: { action:'getdata' , start : G_begin  
	, txtsearch : _txtsearch
	, cou_id : _cou_id
	, cit_id : _cit_id
	, cus_id : _cus_id
	, cus_gender : _cus_gender
	, cus_active : _cus_active
	, wha_id : _wha_id
		} ,

    success: function (data) {
				   //alert(data);
           $(".list_data").append(data);

        },
         error: function () {
        //alert("error");
    }
    });
}
//=======================================================fill data
function edcmbcou_change(val)
{
	filldata_sel("select * from city where cou_id = " + val + " order by cit_order" 
	, "cit_name_en" , "cit_id" , "" , "Select City" , "ed");
}

function getdata_byid(id) {
//	alert(id);
	
    $.ajax({
        type: 'POST',
        url:'whatsapp_customer/process.php',
		data: { action:'getdata_byid',cus_id:id} ,
        dataType: "json",
        success: function (data) {
          // alert(data.message);
            for (var i = 0; i < data.message.length; i++) {
                var counter = data.message[i];
         		$("#edcus_name").val(counter.cus_name);
				$("#edcus_mobile").val(counter.cus_mobile);
				$("#edcus_email").val(counter.cus_email);
				$("#edcus_gender").val(counter.cus_gender);
				$("#edcus_birthdate").val(counter.cus_birthdate);
//				$("#edcou_id").val(counter.cus_api);
				//$("#edcus_price").val(counter.cus_price);
								
				filldata_sel("select * from country order by cou_order" 
				, "cou_name_en" , "cou_id" , counter.cou_id , "Select Country" , "ed");
				
				filldata_sel("select * from city  where cou_id = " + counter.cou_id + " order by cit_order" 
				, "cit_name_en" , "cit_id" , counter.cit_id , "Select city" , "ed");

				$("#hfcus_id").val(counter.cus_id);

				$("#cus_thumbnail").attr("src" ,"../images/customer/"
				 + counter.cus_thumbnail);

				
//                var new_detail = parseline(counter.new_detail);
//				alert(counter.cat_name);
              
            }

            

        },
        error: function (a, e, d) {
            var err = a.responseText + ' ' + e + ' ' + d;
                //alert(err);
        }
    });
}
//=======================================================add


function close_order()
{
	$("#div_order").hide();
	$("#div_bg").hide();
}
//========================================
function show_order(cus_id , cus_order)
{
	
	$("#div_bg").show();
	$("#div_order").show();
	$("#txtord_num").val(cus_order);
	$("#hf_ord_old").val(cus_order);
	$("#hf_ord_num").val(cus_id);	
	
}

function save_order()
{
	_cus_order = $("#txtord_num").val();
	_cus_order_old = $("#hf_ord_old").val();
	_cus_id = $("#hf_ord_num").val();		
	//alert(_cus_order + " - " + _cus_id );
	$.ajax({
    url: 'whatsapp_customer/process.php',
    type: 'POST',
    data: { action:'order_customer',cus_id:_cus_id 
	, cus_order :_cus_order 
	, cus_order_old : _cus_order_old} ,

    success: function (data) {
//	    alert(data);
console.log(data);
		 refreshdata();
		 close_order();
	//	$("#tbl_" + _cus_id).hide();	
    },
    error: function () {
        //alert("error");
    }
	}); 
}



//=========================================
/*function fill_country(_cou_id , _cit_id) {
    
       $.ajax({
    url: 'whatsapp_customer/process.php',
    type: 'POST',
    data: { action:'getcountry',cou_id:_cou_id
	, cit_id:_cit_id } ,
	    success: function (data) {

            fillcity(cou_id, cit_id);
            
            $("#cmbcou_id").empty();
            eval(str);
           // alert(str);
            $("#cmbcou_id").val(cou_id);
            getcode(cou_id, cit_id);
        },
        error: function (a, e, d) {
        }
    });
}*/
//=========================================



function customer_active(_cus_id) {
//	alert(_cus_id);
	/*alert($("#state_" + _cha_id).attr("data_id"));
	alert($("#state_" + _cha_id).attr("data_state"));*/
	active = $("#active_" + _cus_id).attr("data_active");
	$.ajax({
    url: 'whatsapp_customer/process.php',
    type: 'POST',
    data: { action:'update_active', cus_id:_cus_id ,
	 cus_active:active} ,

    success: function (data) {
//		alert(data);
		if(active == "off" || active == "")
		{
			$("#active_" + _cus_id).attr("data_active", "on")
			$("#active_" + _cus_id).html("<img src = '../icon/true.gif'>");
		}
		else
		{
			$("#active_" + _cus_id).attr("data_active", "off")
			$("#active_" + _cus_id).html("<img src = '../icon/false.gif'>");
		}
		//$("#tbladm_" + _adm_id).hide();
	
    },
    error: function () {
        //alert("error");
    }
	}); 
	/*$(".message").show();
	$(".list").hide();
	$("#hfcha_id_msg").val(_cha_id);*/
}

//=========================================




function search_active(_cus_id) {
	//alert(_cus_id);
	/*alert($("#state_" + _cha_id).attr("data_id"));
	alert($("#state_" + _cha_id).attr("data_state"));*/
	active = $("#search_" + _cus_id).attr("data_active");
//	alert(active);
	$.ajax({
    url: 'whatsapp_customer/process.php',
    type: 'POST',
    data: { action:'search_active', cus_id:_cus_id ,
	 cus_search:active} ,

    success: function (data) {
				alert(data);
		if(active == "off" || active == "")
		{
			$("#search_" + _cus_id).attr("data_active", "on")
			$("#search_" + _cus_id).html("<img src = '../icon/true.gif'>");
		}
		else
		{
			$("#search_" + _cus_id).attr("data_active", "off")
			$("#search_" + _cus_id).html("<img src = '../icon/false.gif'>");
		}
		//$("#tbladm_" + _adm_id).hide();
	
    },
    error: function () {
        //alert("error");
    }
	}); 
	/*$(".message").show();
	$(".list").hide();
	$("#hfcha_id_msg").val(_cha_id);*/
}
   
   
   function sent_all(_with)
   {
	   
	   		if(!confirm("are you sure send ? "))
		{
			return;
		}
		else
		{
				
	
			var sList = "";
			$('input[type=checkbox]').each(function () {
				var sThisVal = (this.checked ? "1" : "0");
//				
				//alert($(this).attr("check_value") );
				if(sThisVal != 0 && $(this).attr("check_value") != undefined)
				{
					sList = "1";
					
					sendwha($(this).attr("check_value") , _with);
				}
//				console.log($(this).attr("check_value"));
			});
//alert("0" + sList) ;
			if(sList != "1")
			{
				from = $("#txtfrom").val();
					to = $("#txtto").val();
				
					if(from != "" && to != "")
					{
						//alert("0");
						sendwha_from(_with , "" , from , to)
						return;	
					}
					else if($("#chk_all").is(':checked') == true)
					{				

						sendwha_from(_with , "1" , "" , "")
						return;
					}

			}

			sList = "";
			 G_begin = 0;
	    $(".list_data").html("");
	   get_items();
//			console.log (sList);
		}

   }
   
function  sendwha(_cus_id , _with_name)
{
	
	
	$.ajax({
    url: 'whatsapp_customer/process.php',
    type: 'POST',
    data: { action:'sendwhats'
	, cus_id:_cus_id 
	, with_name : _with_name 
	, wha_id : $("#wha_id").val()} ,

    success: function (data) {
	   alert(data);
		//$("#tbl_" + _cus_id).hide();
	
    },
    error: function () {
        alert("error");
    }
}); 
	
}


function  sendwha_from(_with_name , _allchk , _from , _to )
{
		
	var _txtsearch = $("#txtsearch").val();
	var _cou_id = $("#listcmbcou_id").val();
	var _cit_id = $("#listcmbcit_id").val();
	var _cus_gender = $("#cmbgender").val();
	var _cus_active = $("#cmbactive").val();
	var _cus_id = $("#cus_id").val();
	var _wha_id = $("#wha_id").val();
		
  $.ajax({
    url: 'whatsapp_customer/process.php',
    type: 'POST',
    data: { action:'sendwhats_from' , start : G_begin  
	, txtsearch : _txtsearch
	, cou_id : _cou_id
	, cit_id : _cit_id
	, cus_id : _cus_id
	, cus_gender : _cus_gender
	, cus_active : _cus_active
	, wha_id : _wha_id
	, allchk:_allchk
	, from:_from
	, to:_to
	, with_name : _with_name 
	
		} ,
		
	

    success: function (data) {
	   //console.log(data);
	   alert(data);
	   G_begin = 0;
	    $(".list_data").html("");
	   get_items();
		//$("#tbl_" + _cus_id).hide();
	
    },
    error: function () {
        alert("error");
    }
}); 
	
}

 