<div class="con_div_header">

  <div style="padding: 10px;">
    <table width="100%" border="0">
      <tr>

        <td width="40%">
          <p style="margin-bottom: 0px ;">Admin
          </p>
          <a href="index.php" style="color:black;text-decoration: none;"> Home </a>
          > <a href="index.php?module=insurance" style="color:#fb9678;text-decoration: none;"> Insurance</a>

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
          <table id="insuranceList" class="table table-bordered table-striped">
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


<style>
  table.dataTable thead .sorting,table.dataTable thead .sorting_asc,table.dataTable thead .sorting_asc_disabled,table.dataTable thead .sorting_desc,table.dataTable thead .sorting_desc_disabled {
    background: 0 0
}

table.dataTable thead .sorting_asc:after {
    content: "\f0de";
    margin-left: 10px;
    font-family: fontawesome;
    cursor: pointer
}

table.dataTable thead .sorting_desc:after {
    content: "\f0dd";
    margin-left: 10px;
    font-family: fontawesome;
    cursor: pointer
}

table.dataTable thead .sorting:after {
    content: "\f0dc";
    margin-left: 10px;
    font-family: fontawesome!important;
    cursor: pointer;
    color: rgba(50,50,50,.5)
}

.dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    padding-top: .25em
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: .5em 1em;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    color: #212529;
    border: 1px solid #ddd
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #fff!important;
    border: 1px solid #fb9678;
    background-color: #fb9678
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active,.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
    cursor: default;
    color: #212529;
    border: 1px solid #e9ecef;
    background: 0 0;
    box-shadow: none
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: #fff;
    border: 1px solid #fb9678;
    background-color: #fb9678
}

.dataTables_wrapper .dataTables_paginate .paginate_button:active {
    outline: 0;
    background-color: #212529
}

.dataTables_wrapper .dataTables_paginate .ellipsis {
    padding: 0 1em
}
  </style>