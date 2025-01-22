//========================open drawar =============
var dataRecords


$(document).ready(function() {
	//{extend:'pdf' , text :'pdf' ,customize:function(doc){doc.defaultStyle.font = 'Arial'}}
fillgov();
	

	dataRecords = $('#workerList').DataTable({
		//dom: 'lrtip',\
		dom: 'Blfrtip',
        buttons: [
           'copy', 'csv', 'excel','pdf' , 'print'
        ],
		"autoWidth": false,
		"lengthChange": true,
		"processing": true,
		"serverSide": true,
		'serverMethod': 'post',
		"order": [],
		"ajax": {
			url: "worker/process.php",
			type: "POST",
			data: {
				action: 'listworker'
			},
			dataType: "json"
		},
	
		"columnDefs": [{
			"targets": [ 0,4,5 ], // hide sort 
			"orderable": false,
			
		},
		{workerName: 'dt-center',"width": "10px" ,
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
        url:'worker/process.php',
		data: { action:'getdata_byid',wor_id:id} ,
        dataType: "json",
        success: function (data) {
          console.log(data.message);
            for (var i = 0; i < data.message.length; i++) {
                var counter = data.message[i];
         		$("#txtwor_name").val(counter.wor_name);
				$("#txtwor_name_en").val(counter.wor_name_en);				
				$("#txtwor_domain").val(counter.wor_domain);
				$("#txtwor_domain_en").val(counter.wor_domain_en);				

				$("#txtwor_mobile1").val(counter.wor_mobile1);
				$("#txtwor_mobile2").val(counter.wor_mobile2);				
				$("#txtwor_mail").val(counter.wor_mail);
				$("#txtwor_website").val(counter.wor_website);				
				$("#txtwor_loc").val(counter.wor_loc);
				$("#cmbgov_id").val(counter.gov_id);				
								
				$("#txtwor_info").val(counter.wor_info);
				$("#txtwor_country").val(counter.wor_country);
			
				
				$("#hfwor_id").val(counter.wor_id);
				$("#action").val("edit");


				$("#hfwil_id").val(counter.wil_id);
				$("#hfreg_id").val(counter.reg_id);
				fillwil();
				fillreg();
//====================================fileadd
				img = "";
				if(counter.wor_thumbnail != "")
				{
					img = "data-default-file=" +
					"../images/worker/" + counter.wor_thumbnail;
				}
				$("#div_fileadd").html("<input type='file' name='fileadd' id='fileadd' " +
				img
				+ " class='dropify' required />");
				var drEvent = $('#fileadd').dropify({});
				drEvent.on('dropify.beforeClear', function(event, element) {

					if ($("#hfwor_id").val() != "") {
						delimage("wor_image" , "wor_thumbnail");
					}
				  });

//====================================fileaddhover
				img1 = "";
				if(counter.wor_thumbnail1 != "")
				{
					img1 = "data-default-file=" +
					"../images/worker/" + counter.wor_thumbnail1;
				}
				  $("#div_fileaddhover").html("<input type='file' name='fileaddhover' id='fileaddhover' " +
				img1
				+ " class='dropify' required />");
				var drEvent1 = $('#fileaddhover').dropify({});
				drEvent1.on('dropify.beforeClear', function(event, element) {

					if ($("#hfwor_id").val() != "") {
						delimage("wor_image1" , "wor_thumbnail1");
					}
				  });
			
//=========================================
/*drEvent1 = $('#fileaddhover').dropify();
				drEvent1 = drEvent1.data('dropify');
				drEvent1.resetPreview();
				drEvent1.clearElement();
				drEvent1.settings.defaultFile = "../images/worker/" + counter.wor_thumbnail1;
				drEvent1.destroy();
				drEvent1.init();
				$('.dropify#fileaddhover').dropify({
				defaultFile: "../images/worker/" + counter.wor_thumbnail1,
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
	if($("#hfwor_id").val()!= "")
	{
		editData();
	}
	else
	{
		addData();
	}
}
function requiredData()
{
	 	_wor_name = $("#txtwor_name").val();	
	_wor_name_en = $("#txtwor_name_en").val();	
	_wor_mail = $("#txtwor_mail").val();	
	_wor_mobile1 = $("#txtwor_mobile1").val();	
	_wor_mobile2 = $("#txtwor_mobile2").val();	
	_wor_loc = $("#txtwor_loc").val();	
	_gov_id = $("#cmbgov_id").val();	
	if($.trim(_wor_name) == "" || $.trim(_wor_name_en) == ""
		|| $.trim(_wor_mail) == "" || $.trim(_wor_mobile1) == ""
		|| $.trim(_wor_mobile2) == ""|| $.trim(_wor_loc) == ""
		|| $.trim(_gov_id) == "")

	{
		
		toastr["warning"]("Enter All Data");
		return true ;
	}
	else
	{

		return false;
	}
}
function  addData()
{
	$("#butadd").hide();
	if(requiredData())
		{
			return;
		}

	var form = document.getElementById('addform');
	$.ajax({
    url: 'worker/process.php',
    type: 'POST',
	data: new FormData(form),
	contentType: false, 
	cache: false, 
	processData:false, 

    success: function (data) {
	console.log(data);
		
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

	//return 
	if(requiredData())
		{
			return;
		}
	var form1 = document.getElementById('addform');
	$.ajax({
    url: 'worker/process.php',
    type: 'POST',
	data: new FormData(form1),
	contentType: false, 
	cache: false, 
	processData:false, 

    success: function (data) {
		//alert(data);
		/*$("#tdwor_name" + _wor_id).html(_wor_name);
		$("#tdwor_name_en" + _wor_id).html(_wor_name_en);		

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
	if($("#hfwor_id").val() == "")
					{
						return;
					}
					

	
	
	$.ajax({
    url: 'worker/process.php',
    type: 'POST',
    data: { action:'delimage',wor_id:$("#hfwor_id").val() , 
col1:_col1 , col2:_col2} ,

    success: function (data) {
	  //alert(data);
		//$("#tbl_" + _wor_id).hide();

		dataRecords.ajax.reload();
	toastr["success"]("Deleted succefully");
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//=======================================================delete 
function  del(_wor_id)
{
	if(_wor_id == "")
					{
						return;
					}
	
		if(!confirm("are you sure delete"))
		{
			return;
		}
	
	$.ajax({
    url: 'worker/process.php',
    type: 'POST',
    data: { action:'delete',wor_id:_wor_id} ,

    success: function (data) {
	  //alert(data);
		//$("#tbl_" + _wor_id).hide();

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
function worker_active(_wor_id) {
	active = $("#active_" + _wor_id).attr("data_active");
	$.ajax({
    url: 'worker/process.php',
    type: 'POST',
    data: { action:'update_active', wor_id:_wor_id ,
	 wor_active:active} ,

    success: function (data) {
//		//alert(data);
		if(active == "off" || active == "")
		{
			$("#active_" + _wor_id).attr("data_active", "on")
			$("#active_" + _wor_id).html("<img src = '../icon/true.gif'>");
		}
		else
		{
			$("#active_" + _wor_id).attr("data_active", "off")
			$("#active_" + _wor_id).html("<img src = '../icon/false.gif'>");
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
					worker_active($(this).attr("check_value") );
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



function fillgov()
{
 const selectElement = $('#cmbgov_id');

    // Make an AJAX request
    $.ajax({
      url: 'worker/process.php', // Replace 'get_options.php' with your PHP script URL
      type: 'POST',
      data: { action: 'getgov' }, 
      dataType: 'json',
      success: function(response) {
        populateSelect(response);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });

    // Function to populate the select element with options
    function populateSelect(options) {
      for (let i = 0; i < options.length; i++) {
        const option = $('<option></option>');
        option.val(options[i].gov_id);
        option.text(options[i].gov_name);
        selectElement.append(option);
      }
    }
    //fillwil();
}

function filltype()
{
 const selectElement = $('#cmbtyp_id');

    // Make an AJAX request
    $.ajax({
      url: 'worker/process.php', // Replace 'get_options.php' with your PHP script URL
      type: 'POST',
      data: { action: 'gettype' }, 
      dataType: 'json',
      success: function(response) {
        populateSelect(response);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });

    // Function to populate the select element with options
    function populateSelect(options) {
      for (let i = 0; i < options.length; i++) {
        const option = $('<option></option>');
        option.val(options[i].typ_id);
        option.text(options[i].typ_name);
        selectElement.append(option);
      }
    }
    //fillwil();
}

function fillwil()
{
 const selectElement = $('#cmbwil_id');

    // Make an AJAX request
    $.ajax({
      url: 'worker/process.php', // Replace 'get_options.php' with your PHP script URL
      type: 'POST',
      data: { action: 'getwil' , gov_id:$("#cmbgov_id").val()}, 
      dataType: 'json',
      success: function(response) {
        populateSelect(response);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
     selectElement.empty();
     //======================insert first value
      const option = $('<option></option>');
        option.val("");
        option.text("Select Wil");
        selectElement.append(option);
        //======================end insert first value
    // Function to populate the select element with options
    function populateSelect(options) {
      for (let i = 0; i < options.length; i++) {
        const option = $('<option></option>');
        option.val(options[i].wil_id);
        option.text(options[i].wil_name);
        selectElement.append(option);
      }

        if($("#action").val() == "edit")
	    {	    	
	    	$("#cmbwil_id").val($("#hfwil_id").val()).change();
	    	
	    }
    }

  
}


function fillreg()
{
	
 const selectElement = $('#cmbreg_id');

    // Make an AJAX request
    $.ajax({
      url: 'worker/process.php', // Replace 'get_options.php' with your PHP script URL
      type: 'POST',
      data: { action: 'getreg' , wil_id:$("#hfwil_id").val()}, 
      dataType: 'json',
      success: function(response) {
        populateSelect(response);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
     selectElement.empty();
     //======================insert first value
      const option = $('<option></option>');
        option.val("");
        option.text("Select Region");
        selectElement.append(option);
        //======================end insert first value
    // Function to populate the select element with options
    function populateSelect(options) {
      for (let i = 0; i < options.length; i++) {
        const option = $('<option></option>');
        option.val(options[i].reg_id);
        option.text(options[i].reg_name);
        selectElement.append(option);
      }
      if($("#action").val() == "edit")
	    {	    	
	    	$("#cmbreg_id").val($("#hfreg_id").val()).change();
	    	
	    }
    }

   
}



//===========================================================end operation on form