<?php
require_once '../library/config.php';
include 'init.php';
if(isset($_SESSION["emp_id"]) && is_numeric($_SESSION["emp_id"]))
{

}
else
{
     header('Location: ../login/');
}
?>

<script src="https://code.jquery.com/jquery-3.5.1.js">

</script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!--//========================== buttons print excel ---->

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!--<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<script src="../js/pdfmake.js"></script>
<script src="../js/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>

<!--//========================== end buttons print excel ---->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


<link href="themes/css/bootstrip5.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="../css/dropify.min.css">
<script src="../js/dropify.min.js"></script>

<link href="../css/toastr.css" rel="stylesheet" type="text/css" />
<script src="../js/toastr.js"></script>
<style>
    .form-control {
        border: 1px solid #ced4da;
    }

    .toast-success {
        background-color: yellowgreen;
    }

    .dt-button {
        border: none;
        margin-right: 2px;
    }

    #classList {
        border-top: 3px solid #FFBCA6;
    }

    .navbar-light {
        position: fixed;
        z-index: 1;
        width: 100%;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #fff !important;
        border: 1px solid #fb9678;
        background-color: #fb9678 !important;
    }

    .con_div_header {
        width: 100%;
        height: 75px;
        margin: auto 0;
        background-color: white;
        margin-top: 20px;

    }

    .child_div {
        width: 90px;

        float: right;

        text-align: center;
        padding-top: 2px;
    }
    .input-group > select {
    position: relative;
    flex: 1 1 auto;
    width: 1%;
    min-width: 0;
    border: 1px solid #CED4DA;
}
.sidebar-dark {
    background-color: #FF8000;
    
}
.sidebar-dark .nav-sidebar .nav-link, .sidebar-light .card[class*=bg-]:not(.bg-light):not(.bg-white):not(.bg-transparent) .nav-sidebar .nav-link {
    color: white;
}
.navbar-light {
    background-color: #F0F0F0;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    /* background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, #dcdcdc)); */
    /* background: -webkit-linear-gradient(top, white 0%, #dcdcdc 100%); */
    background: -moz-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -ms-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -o-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: none;
}
</style>
<script>
    $(document).ready(function() {
        /* if ($('body').hasClass("sidebar-xs")) {
             setCookie("hide_sidebar", 1, 365);
         } else {*/
        //setCookie("hide_sidebar", 0, 0);
        //setCookie("hide_sidebar", 1, 365);
        //alert("d");
        //  $('body').addClass("sidebar-xs");
        /* };*/
    });
</script>
<div class="content-wrapper">
    <div class="content" style="background-color:#EBEBEB ;">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12" style=" padding-right: 0px; padding-left: 0px;">

                    <!--    content here -->
                    <script>
                        toastr.options = {
                            "closeButton": true,
                            "debug": true,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "1000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                    </script>

                    <?php
                    @$p = $_GET['module'];
                    $per = "0";
                    if (!isset($p)) {
                        $p = "home";
                        include 'main.php';
                    } else {
                        if ($p == 'home') {
                            include 'main.php';
                        }

                        //=============== admin			
                        elseif ($p == 'class') {
                            include 'class/index.php';
                            $per = 1;
                        } 
                         elseif ($p == 'customer') {
                            include 'customer/index.php';
                            $per = 2;
                        } 
                         elseif ($p == 'insurance') {
                            include 'insurance/index.php';
                            $per = 3;
                        } 
                          elseif ($p == 'health_care') {
                            include 'health_care/index.php';
                            $per = 4;
                        } 
                            elseif ($p == 'study_outside') {
                            include 'study_outside/index.php';
                            $per = 5;
                        } 
                            elseif ($p == 'worker') {
                            include 'worker/index.php';
                            $per = 6;
                        } 
                         elseif ($p == 'medical') {
                            include 'medical/index.php';
                            $per = 7;
                        } 
                        else {
                            include 'main.php';
                        }
                    }

                    echo "<script>";

                    echo "$('#menu_" . $p . "').addClass('active')";
                    echo "</script>";
                    ?>
                    <!-- end Content-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<?php //include $tem . 'footer_section.php';
include $tem . 'footer.php';

?>