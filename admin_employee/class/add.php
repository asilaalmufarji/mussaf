<form id="addform" action="" method="post" enctype="multipart/form-data">

  <input type="hidden" id="action" name="action" value="add" />
  <input type="hidden" id="hfcla_id" name="hfcla_id" />
  <div class="con_div_header">

    <div style="padding: 10px;">
      <table width="100%" border="0">
        <tr>

          <td width="40%">
            <p style="margin-bottom: 0px ;">Admin
            </p>
            <a href="index.php" style="font-weight: bold;color:black;text-decoration: none;"> Home </a>
            > <a href=href="index.php?module=class" style="color: black;text-decoration: none;"> Category</a>
            > <a href=href="index.php?module=class" style="color:#fb9678;text-decoration: none;"> Add Category</a>

          </td>
          <td>
            <div class="child_div per_add" onclick="saveData();">

              <button type="button" class="btn btn-success btn-sm" style="background-color: #24C177;border-color:#24C177;">
                <i class="	fa fa-floppy-o"></i>&nbsp; Save</button>
            </div>


            <div class="child_div per_add" onclick="$('.addpage').hide();$('.list').show();">
              <button type="button" class="btn btn-success btn-sm" style="background-color: #FA7E5A;border-color:#FA7E5A;">
                <i class="	fa fa-floppy-o"></i>&nbsp; Cancel</button>

            </div>


          </td>
        </tr>
      </table>
    </div>


  </div>
  <div style="padding: 5px;">
    <div class="container-fluid">
      <div class="row">

        <div class="col-lg-6 " style="padding: 3px;">
          <!-- body -->
          <div class="card" style="padding: 20px;">




            <div class="row">
              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Name</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o"></i>
                  <input type="text" id="txtcla_name" name="txtcla_name" class="form-control" placeholder="Ar Category Name" />
                </div>
              </div><!-- end test -->

              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Name En</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o"></i>
                  <input type="text" id="txtcla_name_en" name="txtcla_name_en" class="form-control" placeholder="Category Name En" />
                </div>
              </div><!-- end test -->

              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Domain</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                  <input type="text" id="txtcla_domain" name="txtcla_domain" class="form-control" placeholder="Ar Domain Name" />
                </div>
              </div><!-- end test -->

              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Domain En</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o"></i>
                  <input type="text" id="txtcla_domain_en" name="txtcla_domain_en" class="form-control" placeholder="En Domain Name" />
                </div>
              </div><!-- end test -->
            </div>
            <!-- end body-->
          </div>
        </div>
        <div class="col-lg-6" style="padding: 3px;">
          <div class="card" style="padding: 20px;">
            <div class="row">
              <!-- test-->
              <div class="col-md-6 mb-1 mt-1" id="div_fileadd">
                <input type="file" name="fileadd" id="fileadd" class="dropify" required />
              </div>
              <div class="col-md-6 mb-1 mt-1" id="div_fileaddhover">
                <input type="file" name="fileaddhover" id="fileaddhover" class="dropify" required />

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</form>