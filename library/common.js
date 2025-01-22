//===================================start fill 
function filldata_sel(_sql ,  _name , _id , _selected , _def_val , _ed)
{	
	$.ajax({
    url: '../library/common.php',
    type: 'POST',
    data: { action:'filldata_sel' 
	, sql: _sql 
	, name: _name 
	, id: _id 
	, selected : _selected
	, def_val : _def_val
	, ed : _ed} ,

    success: function (data) {


	$('#' + _ed + 'cmb' + _id)
    .empty()
    .append('<option selected="selected" value="0">' + _def_val + '</option>')
;
		//alert("before" + ref);
       // console.log(data);
		eval(data);
    },
    error: function () {
        //alert("error");
    }
}); 
	
}

//=========================================end fill
//===============================================
function trim(str)
{
	return str.replace(/^\s+|\s+$/g,'');
}

//-----------------------------------------checkemail
