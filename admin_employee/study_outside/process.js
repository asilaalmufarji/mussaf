//========================open drawar =============
var dataRecords


$(document).ready(function() {
	//{extend:'pdf' , text :'pdf' ,customize:function(doc){doc.defaultStyle.font = 'Arial'}}
	fillgov();
	filltype_study();
	filltype_school();

	dataRecords = $('#study_outsideList').DataTable({
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
			url: "study_outside/process.php",
			type: "POST",
			data: {
				action: 'liststudy_outside'
			},
			dataType: "json"
		},
	
		"columnDefs": [{
			"targets": [ 0,4,5 ], // hide sort 
			"orderable": false,
			
		},
		{study_outsideName: 'dt-center',"width": "10px" ,
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
        url:'study_outside/process.php',
		data: { action:'getdata_byid',stu_id:id} ,
        dataType: "json",
        success: function (data) {
          console.log(data.message);
            for (var i = 0; i < data.message.length; i++) {
                var counter = data.message[i];
         		$("#txtstu_name").val(counter.stu_name);
				$("#txtstu_name_en").val(counter.stu_name_en);				
				$("#txtstu_domain").val(counter.stu_domain);
				$("#txtstu_domain_en").val(counter.stu_domain_en);				

				$("#txtstu_mobile1").val(counter.stu_mobile1);
				$("#txtstu_mobile2").val(counter.stu_mobile2);				
				$("#txtstu_mail").val(counter.stu_mail);
				$("#txtstu_website").val(counter.stu_website);				
				$("#txtstu_loc").val(counter.stu_loc);
				$("#cmbgov_id").val(counter.gov_id);				
								
				$("#cmbtyp_study_id").val(counter.typ_study_id);
				$("#cmbtyp_school_id").val(counter.typ_school_id);
				
				
				$("#hfstu_id").val(counter.stu_id);
				$("#action").val("edit");


				$("#hfwil_id").val(counter.wil_id);
				$("#hfreg_id").val(counter.reg_id);
				fillwil();
				fillreg();
//====================================fileadd
				img = "";
				if(counter.stu_thumbnail != "")
				{
					img = "data-default-file=" +
					"../images/study_outside/" + counter.stu_thumbnail;
				}
				$("#div_fileadd").html("<input type='file' name='fileadd' id='fileadd' " +
				img
				+ " class='dropify' required />");
				var drEvent = $('#fileadd').dropify({});
				drEvent.on('dropify.beforeClear', function(event, element) {

					if ($("#hfstu_id").val() != "") {
						delimage("stu_image" , "stu_thumbnail");
					}
				  });

//====================================fileaddhover
				img1 = "";
				if(counter.stu_thumbnail1 != "")
				{
					img1 = "data-default-file=" +
					"../images/study_outside/" + counter.stu_thumbnail1;
				}
				  $("#div_fileaddhover").html("<input type='file' name='fileaddhover' id='fileaddhover' " +
				img1
				+ " class='dropify' required />");
				var drEvent1 = $('#fileaddhover').dropify({});
				drEvent1.on('dropify.beforeClear', function(event, element) {

					if ($("#hfstu_id").val() != "") {
						delimage("stu_image1" , "stu_thumbnail1");
					}
				  });
			
//=========================================
/*drEvent1 = $('#fileaddhover').dropify();
				drEvent1 = drEvent1.data('dropify');
				drEvent1.resetPreview();
				drEvent1.clearElement();
				drEvent1.settings.defaultFile = "../images/study_outside/" + counter.stu_thumbnail1;
				drEvent1.destroy();
				drEvent1.init();
				$('.dropify#fileaddhover').dropify({
				defaultFile: "../images/study_outside/" + counter.stu_thumbnail1,
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
	if($("#hfstu_id").val()!= "")
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
	 	_stu_name = $("#txtstu_name").val();	
	_stu_name_en = $("#txtstu_name_en").val();	
	_stu_mail = $("#txtstu_mail").val();	
	_stu_mobile1 = $("#txtstu_mobile1").val();	
	_stu_mobile2 = $("#txtstu_mobile2").val();	
	_stu_loc = $("#txtstu_loc").val();	
	_gov_id = $("#cmbgov_id").val();	
	if($.trim(_stu_name) == "" || $.trim(_stu_name_en) == ""
		|| $.trim(_stu_mail) == "" || $.trim(_stu_mobile1) == ""
		|| $.trim(_stu_mobile2) == ""|| $.trim(_stu_loc) == ""
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
    url: 'study_outside/process.php',
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
    url: 'study_outside/process.php',
    type: 'POST',
	data: new FormData(form1),
	contentType: false, 
	cache: false, 
	processData:false, 

    success: function (data) {
		//alert(data);
		/*$("#tdstu_name" + _stu_id).html(_stu_name);
		$("#tdstu_name_en" + _stu_id).html(_stu_name_en);		

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
	if($("#hfstu_id").val() == "")
					{
						return;
					}
					

	
	
	$.ajax({
    url: 'study_outside/process.php',
    type: 'POST',
    data: { action:'delimage',stu_id:$("#hfstu_id").val() , 
col1:_col1 , col2:_col2} ,

    success: function (data) {
	  //alert(data);
		//$("#tbl_" + _stu_id).hide();

		dataRecords.ajax.reload();
	toastr["success"]("Deleted succefully");
    },
    error: function () {
        //alert("error");
    }
}); 
	
}
//=======================================================delete 
function  del(_stu_id)
{
	if(_stu_id == "")
					{
						return;
					}
	
		if(!confirm("are you sure delete"))
		{
			return;
		}
	
	$.ajax({
    url: 'study_outside/process.php',
    type: 'POST',
    data: { action:'delete',stu_id:_stu_id} ,

    success: function (data) {
	  //alert(data);
		//$("#tbl_" + _stu_id).hide();

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
function study_outside_active(_stu_id) {
	active = $("#active_" + _stu_id).attr("data_active");
	$.ajax({
    url: 'study_outside/process.php',
    type: 'POST',
    data: { action:'update_active', stu_id:_stu_id ,
	 stu_active:active} ,

    success: function (data) {
//		//alert(data);
		if(active == "off" || active == "")
		{
			$("#active_" + _stu_id).attr("data_active", "on")
			$("#active_" + _stu_id).html("<img src = '../icon/true.gif'>");
		}
		else
		{
			$("#active_" + _stu_id).attr("data_active", "off")
			$("#active_" + _stu_id).html("<img src = '../icon/false.gif'>");
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
					study_outside_active($(this).attr("check_value") );
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
      url: 'study_outside/process.php', // Replace 'get_options.php' with your PHP script URL
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

function filltype_study()
{
 const selectElement = $('#cmbtyp_study_id');

    // Make an AJAX request
    $.ajax({
      url: 'study_outside/process.php', // Replace 'get_options.php' with your PHP script URL
      type: 'POST',
      data: { action: 'gettype_study' }, 
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
function filltype_school()
{
 const selectElement = $('#cmbtyp_school_id');

    // Make an AJAX request
    $.ajax({
      url: 'study_outside/process.php', // Replace 'get_options.php' with your PHP script URL
      type: 'POST',
      data: { action: 'gettype_school' }, 
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
      url: 'study_outside/process.php', // Replace 'get_options.php' with your PHP script URL
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
      url: 'study_outside/process.php', // Replace 'get_options.php' with your PHP script URL
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