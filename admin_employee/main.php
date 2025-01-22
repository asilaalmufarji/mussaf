
<div class="con_div_header" style="height:45px">

  <div style="padding: 10px;">
    <table width="100%" border="0">
      <tr>

        <td width="40%">
         
          <a href="index.php" style="color:black;text-decoration: none;"> Home </a>
          

        </td>
        <td>
         
        </td>
      </tr>
    </table>
  </div>


</div>


                <style>
                        .cont_home {
                                width: 98%;


                                margin-left: 10px;
                                margin-top: 10px;

                        }

                        .child_home {
                                width: 130px;
                                height: 170px;
                                background-color: #ECECEC;
                                float: left;
                                border: 1px solid #BFBFBF;
                                text-align: center;
                                padding: 5px;
                                margin-right: 10px;
                                margin-bottom: 10px;
                                transition: ease-out 0.5s;
                        }

                        .child_home:hover {

                                background-color: #F9BFCC;

                        }
                </style>

                <div class="cont_home">
                        <div class="child_home">
                                <table width="105px" align="center" border="0" cellpadding="0" cellspacing="5">
                                        <tr>
                                                <td style="border:1px solid #BFBFBF;background-color:#FAFAFA" height="105px" align="center">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=customer" style="background-color:#FFF">
                                                                <img src="<?php echo WEB_ROOT; ?>admin_employee/icon/ticket.png" height="80px" border="0" />
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-weight:bold">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=customer" style="text-decoration:none;color:#000">
                                                                Ticket
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-size:14px">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=customer" style="text-decoration:none;color:#000">
                                                                + Add(
                                                                <?php
 
                                                                get_total("select count(*) as con from customer
                                                                 where emp_id = " . $_SESSION["emp_id"]);
                                                                ?>
                                                                )
                                                        </a>
                                                </td>
                                        </tr>
                                </table>
                        </div>
                        <!--//====================================================================== whatsapp message -->

 
                         <div class="child_home">
                                <table width="105px" align="center" border="0" cellpadding="0" cellspacing="5">
                                        <tr>
                                                <td style="border:1px solid #BFBFBF;background-color:#FAFAFA" height="105px" align="center">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=insurance" style="background-color:#FFF">
                                                                <img src="<?php echo WEB_ROOT; ?>admin_employee/icon/insurance.png" height="80px" border="0" />
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-weight:bold">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=insurance" style="text-decoration:none;color:#000">
                                                                Insurance
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-size:14px">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=insurance" style="text-decoration:none;color:#000">
                                                                + Add(
                                                                <?php
 
                                                                get_total("select count(*) as con from insurance
                                                                 where emp_id = " . $_SESSION["emp_id"]);
                                                                ?>
                                                                )
                                                        </a>
                                                </td>
                                        </tr>
                                </table>
                        </div>



<!-- ==========================================-->

 <div class="child_home">
                                <table width="105px" align="center" border="0" cellpadding="0" cellspacing="5">
                                        <tr>
                                                <td style="border:1px solid #BFBFBF;background-color:#FAFAFA" height="105px" align="center">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=health_care" style="background-color:#FFF">
                                                                <img src="<?php echo WEB_ROOT; ?>admin_employee/icon/health_care.png" height="80px" border="0" />
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-weight:bold">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=health_care" style="text-decoration:none;color:#000">
                                                                health care
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-size:14px">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=health_care" style="text-decoration:none;color:#000">
                                                                + Add(
                                                                <?php
 
                                                                get_total("select count(*) as con from health_care
                                                                 where emp_id = " . $_SESSION["emp_id"]);
                                                                ?>
                                                                )
                                                        </a>
                                                </td>
                                        </tr>
                                </table>
                        </div>





<!-- ==========================================-->

 <div class="child_home">
                                <table width="105px" align="center" border="0" cellpadding="0" cellspacing="5">
                                        <tr>
                                                <td style="border:1px solid #BFBFBF;background-color:#FAFAFA" height="105px" align="center">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=study_outside" style="background-color:#FFF">
                                                                <img src="<?php echo WEB_ROOT; ?>admin_employee/icon/study_outside.png" height="80px" border="0" />
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-weight:bold">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=study_outside" style="text-decoration:none;color:#000">
                                                                Study outside
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-size:14px">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=study_outside" style="text-decoration:none;color:#000">
                                                                + Add(
                                                                <?php
 
                                                                get_total("select count(*) as con from study_outside
                                                                 where emp_id = " . $_SESSION["emp_id"]);
                                                                ?>
                                                                )
                                                        </a>
                                                </td>
                                        </tr>
                                </table>
                        </div>
<!-- ==========================================-->
<div class="child_home">
                                <table width="105px" align="center" border="0" cellpadding="0" cellspacing="5">
                                        <tr>
                                                <td style="border:1px solid #BFBFBF;background-color:#FAFAFA" height="105px" align="center">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=worker" style="background-color:#FFF">
                                                                <img src="<?php echo WEB_ROOT; ?>admin_employee/icon/worker.png" height="80px" border="0" />
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-weight:bold">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=worker" style="text-decoration:none;color:#000">
                                                                Worker
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-size:14px">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=worker" style="text-decoration:none;color:#000">
                                                                + Add(
                                                                <?php
 
                                                                get_total("select count(*) as con from worker
                                                                 where emp_id = " . $_SESSION["emp_id"]);
                                                                ?>
                                                                )
                                                        </a>
                                                </td>
                                        </tr>
                                </table>
                        </div>





<!-- ======================================================-->
<div class="child_home">
                                <table width="105px" align="center" border="0" cellpadding="0" cellspacing="5">
                                        <tr>
                                                <td style="border:1px solid #BFBFBF;background-color:#FAFAFA" height="105px" align="center">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=medical" style="background-color:#FFF">
                                                                <img src="<?php echo WEB_ROOT; ?>admin_employee/icon/medical.png" height="80px" border="0" />
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-weight:bold">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=medical" style="text-decoration:none;color:#000">
                                                                Medical coor
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td align="center" style="font-size:14px">
                                                        <a href="<?php echo WEB_ROOT . ADMIN_PATH; ?>/index.php?module=medical" style="text-decoration:none;color:#000">
                                                                + Add(
                                                                <?php
 
                                                                get_total("select count(*) as con from medical
                                                                 where emp_id = " . $_SESSION["emp_id"]);
                                                                ?>
                                                                )
                                                        </a>
                                                </td>
                                        </tr>
                                </table>
                        </div>