<form id="addform" action="" method="post" enctype="multipart/form-data">

  <input type="hidden" id="action" name="action" value="add" />
  <input type="hidden" id="hfins_id" name="hfins_id" />
  <div class="con_div_header">

    <div style="padding: 10px;">
      <table width="100%" border="0">
        <tr>

          <td width="40%">
            <p style="margin-bottom: 0px ;">Admin
            </p>
            <a href="index.php" style="font-weight: bold;color:black;text-decoration: none;"> Home </a>
            > <a href="index.php?module=insurance" style="color: black;text-decoration: none;"> Insurance</a>
            > <a href="index.php?module=insurance" style="color:#fb9678;text-decoration: none;"> Add Insurance</a>

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
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                  <input type="text" id="txtins_name" name="txtins_name" class="form-control" placeholder="Name Ar" />
                </div>
              </div><!-- end test -->

              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Name En</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                  <input type="text" id="txtins_name_en" name="txtins_name_en" class="form-control" placeholder="Name En" />
                </div>
              </div><!-- end test -->

              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Mobile 1</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                  <input type="text" id="txtins_mobile1" name="txtins_mobile1" class="form-control" placeholder="Mobile 1" />
                </div>
              </div><!-- end test -->

              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Mobile 2</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o"></i>
                  <input type="text" id="txtins_mobile2" name="txtins_mobile2" class="form-control" placeholder="Mobile 2" />
                </div>
              </div><!-- end test -->

                      <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Email</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                  <input type="text" id="txtins_mail" name="txtins_mail" class="form-control" placeholder="Email" required />
                </div>
              </div><!-- end test -->

              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Website </p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o"></i>
                  <input type="text" id="txtins_website" name="txtins_website" class="form-control" placeholder="Website" />
                </div>
              </div><!-- end test -->

                <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Location </p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                  <input type="text" id="txtins_loc" name="txtins_loc" class="form-control" placeholder="Location" />
                </div>
              </div><!-- end test -->

              <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Gov</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                    <select id="cmbgov_id" name="cmbgov_id" onchange="fillwil();">
                      <option value="">Select Gov</option>
                    </select>  
                </div>
              </div><!-- end test -->

                <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Wil</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                  <input type="hidden" name="hfwil_id" id="hfwil_id">
                    <select id="cmbwil_id" name="cmbwil_id" onchange="$('#hfwil_id').val($('#cmbwil_id').val());fillreg()">
                      <option value="">Select Wil</option>
                    </select>  
                </div>
              </div><!-- end test -->

                <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">Reg</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                  <input type="hidden" name="hfreg_id" id="hfreg_id">
                    <select id="cmbreg_id" name="cmbreg_id">
                      <option value="">Select Region</option>
                    </select>  
                </div>
              </div><!-- end test -->


                <!-- service-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">نوع التأمين</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                    <select id="cmbtyp_ins_id" name="cmbtyp_ins_id">
                      <option value="">Select insurance</option>
                    </select>  
                </div>
              </div><!-- end service -->

                 <!-- service-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">نوع المركبة</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                    <select id="cmbtyp_car_id" name="cmbtyp_car_id">
                      <option value="">Select Type</option>
                    </select>  
                </div>
              </div><!-- end service -->

               <!-- service-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">المؤمن عليهم</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                    <select id="cmbtyp_driver_id" name="cmbtyp_driver_id">
                      <option value="">Select Type</option>
                    </select>  
                </div>
              </div><!-- end service -->

                  <!-- test-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">File 1 pdf/doc</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                   <input type="file" name="file" id="file">
                </div>
              </div><!-- end test -->

                   <!-- pdf2-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">File 2 pdf/doc</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                   <input type="file" name="file1" id="file1">
                </div>
              </div><!-- end pdf2 -->

               <!-- pdf3-->
              <div class="col-md-6 mb-1 mt-1">
                <p style="display: block !important;margin-bottom: 0px;">File 3 pdf/doc</p>
                <div class="input-group">
                  <i class="input-group-text fa fa-file-text-o" style="background-color: #FFCACA;color:white;border-color: #FFCACA;"></i>
                   <input type="file" name="file2" id="file2">
                </div>
              </div><!-- end pdf3 -->


            </div>
            <!-- end body-->
          </div>
        </div>
        <div class="col-lg-6" style="padding: 3px;">
          <div class="card" style="padding: 20px;">
            <div class="row">
              <!-- test-->
              <div class="col-md-12 mb-1 mt-1" id="div_fileadd">
                <input type="file" name="fileadd" id="fileadd" class="dropify" required />
              </div>
             <!-- <div class="col-md-6 mb-1 mt-1" id="div_fileaddhover">
                <input type="file" name="fileaddhover" id="fileaddhover" class="dropify" required />

              </div>-->
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</form>