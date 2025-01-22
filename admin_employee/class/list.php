<div class="con_div_header">

  <div style="padding: 10px;">
    <table width="100%" border="0">
      <tr>

        <td width="40%">
          <p style="margin-bottom: 0px ;">Admin
          </p>
          <a href="index.php" style="color:black;text-decoration: none;"> Home </a>
          > <a href=href="index.php?module=class" style="color:#fb9678;text-decoration: none;"> Category</a>

        </td>
        <td>
          <div class="child_div per_add" onclick="add_show();">
            <button type="button" class="btn btn-success btn-sm" style="background-color: #1879DA;border-color:#1879DA;">
              <i class="	fa fa-plus"></i>&nbsp; Add</button>
          </div>
        </td>
      </tr>
    </table>
  </div>


</div>

<!-- ======================================list -->
<style>
  .dataTables_wrapper .dataTables_filter {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
  }
</style>
<div style="padding: 5px;">
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-12 card">
        <div style="padding: 10px;">
          <table id="classList" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th></th>
                <th>#</th>
                <th>Name</th>
                <th>Name en</th>

                <th></th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- =====================================end list -->