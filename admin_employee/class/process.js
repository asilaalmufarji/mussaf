//========================open drawar =============
var dataRecords


$(document).ready(function() {


	dataRecords = $('#classList').DataTable({
		//dom: 'lrtip',\
		dom: 'Blfrtip',
        buttons: [
           'copy', 'csv', 'excel', 'pdf', 'print'
        ],
		"autoWidth": false,
		"lengthChange": true,
		"processing": true,
		"serverSide": true,
		'serverMethod': 'post',
		"order": [],
		"ajax": {
			url: "class/process.php",
			type: "POST",
			data: {
				action: 'listClass'
			},
			dataType: "json"
		},
	
		"columnDefs": [{
			"targets": [ 0,4,5 ], // hide sort 
			"orderable": false,
			
		},
		{className: 'dt-center',"width": "10px" ,
		targets:[ 4,5 ] }, //targets: '_all'  
		//https://datatables.net/forums/discussion/72194/datatables-align-text-using-columndefs
		/*{"width": "10px" ,
		targets:[ 3,4 ] },*/
		{
			target: 0,
			visible: false,
		},
	
	],

		
		"pageLength": 10
	});

});


//=======================================================fill data
function getdata_byid(id) {
//	//alert(id);

    $.ajax({
        type: 'POST',
        url:'class/process.php',
		data: { action:'getdata_byid',cla_id:id} ,
        dataType: "json",
        success: function (data) {
          console.log(data.message);
            for (var i = 0; i < data.message.length; i++) {
                var counter = data.message[i];
         		$("#txtcla_name").val(counter.cla_name);
				$("#txtcla_name_en").val(counter.cla_name_en);				
				$("#txtcla_domain").val(counter.cla_domain);
				$("#txtcla_domain_en").val(counter.cla_domain_en);				
				
				$("#hfcla_id").val(counter.cla_id);
				$("#action").val("edit");

//====================================fileadd
				img = "";
				if(counter.cla_thumbnail != "")
				{
					img = "data-default-file=" +
					"../images/class/" + counter.cla_thumbnail;
				}
				$("#div_fileadd").html("<input type='file' name='fileadd' id='fileadd' " +
				img
				+ " class='dropify' required />");
				var drEvent = $('#fileadd').dropify({});
				drEvent.on('dropify.beforeClear', function(event, element) {

					if ($("#hfcla_id").val() != "") {
						delimage("cla_image" , "cla_thumbnail");
					}
				  });

//====================================fileaddhover
				img1 = "";
				if(counter.cla_thumbnail1 != "")
				{
					img1 = "data-default-file=" +
					"../images/class/" + counter.cla_thumbnail1;
				}
				  $("#div_fileaddhover").html("<input type='file' name='fileaddhover' id='fileaddhover' " +
				img1
				+ " class='dropify' required />");
				var drEvent1 = $('#fileaddhover').dropify({});
				drEvent1.on('dropify.beforeClear', function(event, element) {

					if ($("#hfcla_id").val() != "") {
						delimage("cla_image1" , "cla_thumbnail1");
					}
				  });
			
//=========================================
/*drEvent1 = $('#fileaddhover').dropify();
				drEvent1 = drEvent1.data('dropify');
				drEvent1.resetPreview();
				drEvent1.clearElement();
				drEvent1.settings.defaultFile = "../images/class/" + counter.cla_thumbnail1;
				drEvent1.destroy();
				drEvent1.init();
				$('.dropify#fileaddhover').dropify({
				defaultFile: "../images/class/" + counter.cla_thumbnail1,
				});*/
//======================================
              
            }

            

        },
        error: function (a, e, d) {
            var err = a.responseText + ' ' + e + ' ' + d;
                //alert(err);
        }
    });
}
function declared(variable) {
	let declared = true;
	try {
	  eval(variable);
	} catch (e) {
	  if (e.name === "ReferenceError") {
		declared = false;
	  }
	}
	return declared;
  }
//=======================================================add
function saveData()
{
	if($("#hfcla_id").val()!= "")
	{
		editData();
	}
	else
	{
		addData();
	}
}
function  addData()
{
		$("#butadd").hide();
		////alert($("#txtcla_name").val());
	_cla_name = $("#txtcla_name").val();
	
	_cla_name_en = $("#txtcla_name_en").val();
	
	
		
	if($.trim(_cla_name) == "" || $.trim(_cla_name_en) == "")
	{
		$("#butadd").show();
		console.log("validate");
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
	
		
			$("#butadd").show();
		
		add_hide();
		toastr["success"]("Save succefully");
		dataRecords.ajax.reload();
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//======================================================end add
//=======================================================Edit
function  editData()
{

	_cla_id = $("#hfcla_id").val();
	_cla_name = $("#txtcla_name").val();
		_cla_name_en = $("#txtcla_name_en").val();
	

	
	if($.trim(_cla_name) == "" || $.trim(_cla_name_en) == "")
	{
		alert("Enter All Data");
		return ;
	}
	var form1 = document.getElementById('addform');
	$.ajax({
    url: 'class/process.php',
    type: 'POST',
	data: new FormData(form1),
	contentType: false, 
	cache: false, 
	processData:false, 

    success: function (data) {
		//alert(data);
		/*$("#tdcla_name" + _cla_id).html(_cla_name);
		$("#tdcla_name_en" + _cla_id).html(_cla_name_en);		

	    ////alert(data);
		$("#fileadd").val('');
		$("#fileadd1").val('');	*/
		dataRecords.ajax.reload();
		toastr["success"]("update succefully");	
	add_hide();
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//======================================================end Edit
function  delimage(_col1 , _col2)
{
	if($("#hfcla_id").val() == "")
					{
						return;
					}
					

	
	
	$.ajax({
    url: 'class/process.php',
    type: 'POST',
    data: { action:'delimage',cla_id:$("#hfcla_id").val() , 
col1:_col1 , col2:_col2} ,

    success: function (data) {
	  //alert(data);
		//$("#tbl_" + _cla_id).hide();

		dataRecords.ajax.reload();
	toastr["success"]("Deleted succefully");
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//=======================================================delete 
function  del()
{
	if($("#hfcla_id").val() == "")
					{
						return;
					}
	
		if(!confirm("are you sure delete"))
		{
			return;
		}
	
	$.ajax({
    url: 'class/process.php',
    type: 'POST',
    data: { action:'delete',cla_id:_cla_id} ,

    success: function (data) {
	  //alert(data);
		//$("#tbl_" + _cla_id).hide();

		dataRecords.ajax.reload();
	toastr["success"]("Deleted succefully");
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//=======================================================end delete 
//========================================= active
function class_active(_cla_id) {
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

//===========================================================operation on form
function empty() {
	console.log("0");

	$('#addform')[0].reset();	 
	$("#div_fileadd").html("<input type='file' name='fileadd' id='fileadd'  class='dropify' required />");
	var drEvent = $('#fileadd').dropify({});

	$("#div_fileaddhover").html("<input type='file' name='fileaddhover' id='fileaddhover'  class='dropify' required />");
	var drEvent1 = $('#fileaddhover').dropify({});
}

function add_show() {
	empty();
	console.log("add_show");
	$("#action").val("add");
	$(".list").hide();
	$(".addpage").show();
	console.log("addd");
}

function add_hide() {
	$(".list").show();
	$(".addpage").hide();
}

function edit_show(id) {
	//id = $('input:checkbox:checked:first').not("#checkAll").attr('check_value');
	empty();
	if (id != "0" && id != undefined) {

		$(".list").hide();
		$(".addpage").show();
		//$("#hf_id").val();
		getdata_byid(id);
		//alert($("#hf_id").val());
	}
}

function edit_hide() {
	$(".list").show();
	$(".editpage").hide();
}


$(document).ready(function() {
	
	$('.dropify').dropify();

});


//===========================================================end operation on form