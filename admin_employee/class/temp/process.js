//========================open drawar =============
var G_begin = 0;
function search_table()
{
	G_begin = 0;
	$(".list_data").html("");
	get_items();
	countdata(0);
}
$(document).ready(function () {
	countdata();
    $(".list_data").css("height", $(window).height() -300);
	get_items(0);
   
	// console.log("begin:" + G_begin);
	$(".list_data").scroll(function() {

		//    if($(window).scrollTop() == $(document).height() - $(window).height()) {
		if ($(".list_data").scrollTop() + $(".list_data").height() >= $(document).height() -600) 
		{
			// ajax call get data from server and append to the div
			// //alert("thaer");
			G_begin = G_begin + 10;
			get_items(1);

		}
	});

});
//=======================================================getitems

function getchild(parent_id)
{

	getlink_parent(parent_id);
	$("#hf_parent").val(parent_id);
		$("#hf_par_add").val(parent_id);
	$(".list_data").html("");
	G_begin = 0;
	
	get_items(0);
}
//===============================================================
function refreshdata()
{
	$(".list_data").html("");
	G_begin = 0;
	get_items();
}
function countdata(_parent_id) {
	var _txtsearch = $("#txtsearch").val();
	/*if(_txtsearch != "")
	{
		
	}*/
	
  $.ajax({
    url: 'class/process.php',
    type: 'POST',
    data: { action:'countdata' ,txtsearch : _txtsearch 
	,parent_id: _parent_id } ,

    success: function (data) {
				  // alert(data);
           $("#lblcount").text(data);

        },
         error: function () {
        //alert("error");
    }
    });
}
function get_items(is_begin) {
	var _txtsearch = $("#txtsearch").val();

if(is_begin == 0)
{
	G_begin = 0;
	}
//		//alert($("#hf_parent").val() + " begin : " + G_begin);
  $.ajax({
    url: 'class/process.php',
    type: 'POST',
    data: { action:'getdata' , start : G_begin  
	, parent_id : $("#hf_parent").val(),txtsearch : _txtsearch} ,

    success: function (data) {
				   ////alert(data);
           $(".list_data").append(data);
		   countdata( $("#hf_parent").val());

        },
         error: function () {
        //alert("error");
    }
    });
}
//====================================================link class
function getlink_parent(_parent_id) {

//alert(_parent_id);
  $.ajax({
    url: 'class/process.php',
    type: 'POST',
    data: { action:'getlink_parent' , parent_id : _parent_id} ,

    success: function (data) {
		$("#link_cat").html(data);
		
//           $(".list_data").append(data);

        },
         error: function () {
        //alert("error");
    }
    });
}
//=======================================================fill data
function getdata_byid(id) {
//	//alert(id);
	
    $.ajax({
        type: 'POST',
        url:'class/process.php',
		data: { action:'getdata_byid',cla_id:id} ,
        dataType: "json",
        success: function (data) {
          // //alert(data.message);
            for (var i = 0; i < data.message.length; i++) {
                var counter = data.message[i];
         		$("#edcla_name").val(counter.cla_name);
				$("#edcla_name_en").val(counter.cla_name_en);				
				$("#edcla_domain").val(counter.cla_domain);
				$("#edcla_domain_en").val(counter.cla_domain_en);				
				
				$("#hfcla_id").val(counter.cla_id);
				console.log(counter.cla_name + "one " + counter.cla_thumbnail + " - tow : " + counter.cla_thumbnail1);
				$("#cla_thumbnail").attr("src" ,"../images/class/" + counter.cla_thumbnail);
				$("#cla_thumbnail1").attr("src" ,"../images/class/" + counter.cla_thumbnail1);
				
//                var new_detail = parseline(counter.new_detail);
//				//alert(counter.cat_name);
              
            }

            

        },
        error: function (a, e, d) {
            var err = a.responseText + ' ' + e + ' ' + d;
                //alert(err);
        }
    });
}
//=======================================================add
function  add()
{
		$("#butadd").hide();
		////alert($("#txtcla_name").val());
	_cla_name = $("#txtcla_name").val();
	
	_cla_name_en = $("#txtcla_name_en").val();
	
	
		
	if($.trim(_cla_name) == "" || $.trim(_cla_name_en) == "")
	{
		$("#butadd").show();
		//alert("ÇÏÎá ÌãíÚ ÇáÈíÇäÇÊ ÇáãØáæÈÉ");
		return ;
	}
	var form = document.getElementById('addform');
	$.ajax({
    url: 'class/process.php',
    type: 'POST',
	data: new FormData(form),
	contentType: false, 
	cache: false, 
	processData:false, 

    success: function (data) {
	    //alert(data);
		
			$("#butadd").show();
		$(".list_data").html("");
		G_begin = 0;
		get_items();
		add_hide();
		
	
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//======================================================end add
//=======================================================Edit
function  edit()
{

	_cla_id = $("#hfcla_id").val();
	_cla_name = $("#edcla_name").val();
		_cla_name_en = $("#edcla_name_en").val();
	

	
	if($.trim(_cla_name) == "" || $.trim(_cla_name_en) == "")
	{
		//alert("Enter All Data");
		return ;
	}
	var form1 = document.getElementById('editform');
	$.ajax({
    url: 'class/process.php',
    type: 'POST',
	data: new FormData(form1),
	contentType: false, 
	cache: false, 
	processData:false, 

    success: function (data) {
		$("#tdcla_name" + _cla_id).html(_cla_name);
		$("#tdcla_name_en" + _cla_id).html(_cla_name_en);		

	    ////alert(data);
		$("#fileedit").val('');
		$("#fileedit1").val('');		
	edit_hide();
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//======================================================end Edit

//=======================================================delete 
function  del(_cla_id , _show_msg)
{
	if(_show_msg == 1)
	{
		if(!confirm("are you sure delete"))
		{
			return;
		}
	}
	$.ajax({
    url: 'class/process.php',
    type: 'POST',
    data: { action:'delete',cla_id:_cla_id} ,

    success: function (data) {
	  //  //alert(data);
		$("#tbl_" + _cla_id).hide();
	
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//=======================================================end delete 

function close_order()
{
	$("#div_order").hide();
	$("#div_bg").hide();
}
//========================================
function show_order(cla_id , cla_order)
{
	
	$("#div_bg").show();
	$("#div_order").show();
	$("#txtord_num").val(cla_order);
	$("#hf_ord_old").val(cla_order);
	$("#hf_ord_num").val(cla_id);	
	
}

function save_order()
{
	_cla_order = $("#txtord_num").val();
	_cla_order_old = $("#hf_ord_old").val();
	_cla_id = $("#hf_ord_num").val();		
	_parent_id = $("#hf_parent").val();
	////alert(_cla_order + " - " + _cla_id );
	$.ajax({
    url: 'class/process.php',
    type: 'POST',
    data: { action:'order_class',cla_id:_cla_id 
	, cla_order :_cla_order 
	, cla_order_old : _cla_order_old
	, parent_id:_parent_id} ,

    success: function (data) {
//	    //alert(data);
console.log(data);
		 refreshdata();
		 close_order();
	//	$("#tbl_" + _cla_id).hide();	
    },
    error: function () {
        //alert("error");
    }
	}); 
}



//=========================================




function class_active(_cla_id) {
//	//alert(_cla_id);
	/*//alert($("#state_" + _cha_id).attr("data_id"));
	//alert($("#state_" + _cha_id).attr("data_state"));*/
	active = $("#active_" + _cla_id).attr("data_active");
	$.ajax({
    url: 'class/process.php',
    type: 'POST',
    data: { action:'update_active', cla_id:_cla_id ,
	 cla_active:active} ,

    success: function (data) {
//		//alert(data);
		if(active == "off" || active == "")
		{
			$("#active_" + _cla_id).attr("data_active", "on")
			$("#active_" + _cla_id).html("<img src = '../icon/true.gif'>");
		}
		else
		{
			$("#active_" + _cla_id).attr("data_active", "off")
			$("#active_" + _cla_id).html("<img src = '../icon/false.gif'>");
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
   
   
   function delete_all()
   {
	   
	   		if(!confirm("are you sure delete"))
		{
			return;
		}
		else
		{
			var sList = "";
			$('input[type=checkbox]').each(function () {
				var sThisVal = (this.checked ? "1" : "0");
//				sList += (sList=="" ? sThisVal : "," + sThisVal);
				if(sThisVal != 0)
				{
					del($(this).attr("check_value") , 0);
				}
//				console.log($(this).attr("check_value"));
			});
//			console.log (sList);
		}

   }
   
   
    function active_all()
   {
	   
	   		if(!confirm("are you sure active all"))
		{
			return;
		}
		else
		{
			var sList = "";
			$('input[type=checkbox]').each(function () {
				var sThisVal = (this.checked ? "1" : "0");

				if($(this).attr("check_value") != 0)
				{
					class_active($(this).attr("check_value") );
				}

			});

		}

   }