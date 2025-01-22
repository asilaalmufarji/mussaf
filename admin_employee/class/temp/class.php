<script type="text/javascript" src="class/process.js"></script>






<script>

				function empty()
				{
				/*	$("#txtcat_info").val("");
					$("#txtcat_name").val("");
					$("#txtcat_price").val("");
*/

				}
			   function add_show() { 
			   	         
				   	 empty();			   	          
				   	$(".edit").hide(); 
					$(".list").hide();
					$(".add").show();
                 }
                 function add_hide() {
					$(".list").show();                     
					$(".add").hide();
					$(".edit").hide(); 
                 }
				  function edit_show() {                  
				  id = $('input:checkbox:checked:first').not("#checkAll").attr('check_value');
                   if(id != "0" && id != undefined)
				   {
			
						$(".list").hide();
						$(".edit").show();
						//$("#hf_id").val();
						getdata_byid(id);
						//alert($("#hf_id").val());
				   }
                 }
                 function edit_hide() {                     
                    $(".list").show();
					$(".edit").hide();                
                 }
				 
				 $(document).ready(function(e) {
                 width_elment();
                });
				
				$(window).resize(function(){
   				width_elment();
				});
				function width_elment()
				{
					//$(".add").css("height",$(window).height() -50);
					//$(".edit").css("height",$(window).height() -50);
					
								
					/*$(".list").css("height",$(window).height() -200);
					$(".edit").css("height",$(window).height() -200);
					$(".add").css("height",$(window).height() -200);*/
					
				
				}
</script>


<input type="hidden" id ="hf_parent" name ="hf_parent" value="0" />
<!-- list -->
<div class="list" >

<?php include"list.php"; ?>
</div>
<!--//==================================================Add ============================-->
<div class="add" style="display:none">
<?php include"add.php"; ?>
</div>
<!--//==================================================Edit ============================-->
<div class="edit" style="display:none">
<input type="hidden" id="hf_id" />
<?php include"edit.php"; ?>
</div>

