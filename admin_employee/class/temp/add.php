<form id="addform" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id ="hf_par_add" name ="hf_par_add" value="0" />
<table width = "100%" cellpadding="0" cellspacing="0" border="0">
<tr>

<td height="35px" style="border-bottom:1px solid #BEBEBE;background-color:#E4E4E4">

   <div runat = "server" id ="div_link1" style="margin-left:10px"  >
<a href = "home.php?module=home" class ="a_cat">
    Home
    </a>
         <b>
    >
    </b>
 
 
        <a href="#" class ="a_cat" onclick="$('.add').hide();$('.list').show();">
        Categories</a> 
   
        <b>
    >
    </b>
 
        <a href="#" class ="a_catsub">
        Add new Category</a> 

        
    </div>
  

</td>
</tr>

<tr>
<td height="68px" style="border-bottom:1px solid #BEBEBE;background-color:#FAFAFA;font-weight:bold">
  
    
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width = "300px" align="left">
<img src="../icon/class.jpg" height="64px" border="0" style="vertical-align:middle"> 

<font style="font-size:16px;font-weight:bold;color:#0169B4"> Add new Category</font>
</td>
<td align="right">
<div class = "con_div">

<div class = "child_div" onclick ="add();" id="butadd">

 
 <span>
 
    <img src = "../icon/save.png" />
<br />
Save
</span>
</div>

<div class = "child_div" onclick="$('.add').hide();$('.list').show();">

 <span>
 
    <img src = "../icon/back-icon.png" style="height:40px" />
<br />
Back
</span>
    
</div>

</div>
  
     

</td>
</tr>
</table>


 </td>



</tr>

   <tr>
<td >
<!-- body -->

<input type="hidden" id ="action" name ="action" value="add" />
 <table width="100%" border="0" cellpadding="5" cellspacing="1" style="border:1px solid #CCCCCC;border-bottom:2px solid #0075A1;border-top:2px solid #0075A1;margin-top:20px"  >
  <tr><td colspan = "2"  style="background:url(../icon/header.gif);height:18px;" >
  </td></tr>
  
  
<tr><td width = "100px" class="word">Ar domain Name<font color = "red">*</font></td>
<td > 
<input type="text" id="txtcla_name" name="txtcla_name"  
placeholder="Ar domain Name"/>

    
</td>
</tr>

<tr><td   class="word">En domain Name<font color = "red">*</font></td>
<td  > <input type="text"  id="txtcla_name_en" name="txtcla_name_en"  
placeholder="En domain Name"/>
 
</td>
</tr>


<tr><td width = "100px" class="word">Ar popup Name<font color = "red">*</font></td>
<td > 
<input type="text" id="txtcla_domain" name="txtcla_domain"  
placeholder="Ar popup Name"/>

    
</td>
</tr>

<tr><td   class="word">En popup Name<font color = "red">*</font></td>
<td  > <input type="text"  id="txtcla_domain_en" name="txtcla_domain_en" 
 placeholder="En popup Name"/>
 
</td>
</tr>



<tr><td class="word">Icon</td>
<td  > 
 <input type="file" name="fileadd" id="fileadd"  required />
</td>
</tr>





<tr><td class="word">Hover</td>
<td  > 
 <input type="file" name="fileaddhover" id="fileaddhover"  required />
</td>
</tr>


     




  </table>

  

<!-- end body-->
  
  </td>

</tr>
   
   
   </table>
     </form>