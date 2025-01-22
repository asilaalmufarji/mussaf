<script>
	$(document).ready(function(e) {
                    $("#wha_id").val(
					<?php echo isset($_GET["wha_id"]) ? $_GET["wha_id"]: ""; ?>);
                });
                </script>
<script type="text/javascript" src="whatsapp_customer/process.js"></script>
<script type="text/javascript" src="../library/common.js"></script>

<input type="hidden" id="wha_id" />



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

