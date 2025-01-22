
<div id ="div_order" 
style ="border:1px solid #808080;width:200px;height:100px;
border-radius:3px;position:fixed;background-color:white;top:150px;left:50%;z-index:11;display:none">
<table width="100%">
<tr>
<td onclick="close_order();">
<img src="../icon/cancel-icon.png" height="24px"/>
</td>
<td>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="number" id="txtord_num"  style="text-align:center;"/>
<input type="hidden" id="hf_ord_num" />
<input type="hidden" id="hf_ord_old" />

</td>
</tr>
<tr>
<td colspan="2" align="center">
<br />
<span style="padding:8px;background-color:#F15A24;color:white;border-radius:5px" onclick="save_order();">
Save
</span>
</td>
</tr>
</table>
</div>
<table width = "100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td height="35px" style="border-bottom:1px solid #BEBEBE;background-color:#E4E4E4">
  
   <div runat = "server" id ="div_link1" style="margin-left:10px" >
<a href = "home.php?module=home" class ="a_cat">
    Home
    </a>
         <b>
    >
    </b>
    <a href="home.php?module=whatsapp" style="text-decoration:none;color:black">
 WhatsApp Templates 
 </a>
     <b>
    >
    </b>
 
        <a href="" class ="a_catsub" >
         Sending WhatsApp Template to Users   
         <span style="color:black"><?php echo $_GET["wha_name"];?></span>
         </a> 
   
        <b>
   
 

        
    </div>
  

</td>
</tr>

<tr>
<td height="68px" style="border-bottom:1px solid #BEBEBE;background-color:#FAFAFA;font-weight:bold">
  
    
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td style="width:5px">
</td>
<td width="340px" align="left">
<img src="../icon/customer.jpg" height="64px" border="0" style="vertical-align:middle"> 

<font style="font-size:14px;font-weight:bold;color:#0169B4">  Sending WhatsApp Template to Users</font>
</td>
<td align="right">
<div class="con_div">

<!--<div class="child_div" onclick="add_show();">
<img  src="../icon/new-icon.png" style="width:36px;">
<br>
<span id="ContentPlaceHolderButton_add" style="font-weight:normal">Add</span>
</div>-->

<div class="child_div per_edit" onclick = "sent_all(0);">
<img  src="../icon/whats_content2.png" style="width:36px;">
<br>
<span id="ContentPlaceHolderButton_Label5" style="font-weight:normal">Send Content</span>
</div>


<div class="child_div per_del" onclick = "sent_all(1);">
<img  src="../icon/whats_template.png" 
 style="width:36px;">
<br>
<span id="ContentPlaceHolderButton_Label1" style="font-weight:normal">Send WA</span>
</div>



<div class="child_div per_search" onclick="search_table()">
<img  src="../icon/search-icon.png" style="width:36px;">
<br>
<span id="ContentPlaceHolderButton_Label4" style="font-weight:normal">Search</span>
</div>
    <div class="child_div" onclick="search_table()" style="line-height:50px"> 
<span id="lblcount" class ="lblcount">0</span>
</div>



</div>
  
     

</td>
</tr>
</tbody></table>


 </td>



</tr>

   <tr>
<td >
<p style="margin:20px"></p>
<!-- body -->
<style>
.listview_title
{
  background:url(../icon/header.gif);
            height:25px;
           
			border-bottom:2px solid #0075A1;border-top:2px solid #0075A1;margin-top:20px
}
</style>
<table>
<tr>
<td width ="1px">
</td>

<td>
<select id = 'cmbactive'  name = 'cmbactive'  class="cmbsel"  >
<option value="0"> Template status</option>
<option value="on"> sent </option>
<option value="off"> not sent</option>
             </select>
             
</td>
<td>

<select id = 'listcmbcou_id'  name = 'listcmbcou_id'  class="cmbsel"  onchange="cmbcou_change(this.value);">
             </select>

</td>
<td>

</td>
<td>

</td>
</tr>
<tr>
  <td></td>
  <td><input type="text" id ="txtsearch" placeholder="Search by name"  style = " width:226px"/></td>
  <td><select id = 'listcmbcit_id'  name = 'listcmbcit_id'  class="cmbsel"  onchange="cmbcit_change(this.value);">
  </select></td>
  <td></td>
</tr>
<tr>
<td>
</td>
<td><input type="number" placeholder="from"  id="txtfrom"/></td>
<td><input type="number" placeholder="to" id = "txtto"/></td>
<td>
All Pages <input type="checkbox" id="chk_all" />
</td>

</tr>
</table>
<br />
<table ID="table1" 
 border="1"  width = "100%"
 style="border-collapse: collapse;font-family:Arial;">
 <tr runat="server" width = "100%" class = "listview_title">
 <th style=";width:30px">    
 #
   </th> 
   <th id="Th3" style=";width:30px">
       <input type="checkbox" id="checkAll" runat="server"  check_value = "0"/>
   </th>  
   <th style=";width:250px">    
 Name / password
   </th>    <th style=";width:150px">
   Tel / Email
   </th>  

     
      
         <th style=";width:150px">
   
 Country - City
   </th>   
   <th >
   
 Template status
   </th>

<th >
   
Count
   </th>
   <th style=";width:150px">
   
 Regdate
   </th> 
   
 </tr> 

 </table>
  <div class ="list_data" style="height:400px;overflow:auto">
</div>
<!-- end body-->
  
  </td>

</tr>
   
   
   </table>
   
   
  <script>
  $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

  </script>