<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
  <script type="text/javascript" src="../js/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./styleparticles.css">
  <!-- JS includes -->
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      width: 300px;
      margin: 0 auto;
      padding: 20px;
   
    }

    .container h2 {
      text-align: center;
    }

    .container input[type="text"],
    .container input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: none;
      background-color: #E7E7E7;
    }

    #btnlogin{
      width: 100%;
      padding: 10px;
      background-color: #F15A24;
      color: #fff;
      border: none;
      cursor: pointer;
    }
    ::placeholder {
   text-align: center; 
}

/* or, for legacy browsers */

::-webkit-input-placeholder {
   text-align: center;
}

:-moz-placeholder { /* Firefox 18- */
   text-align: center;  
}

::-moz-placeholder {  /* Firefox 19+ */
   text-align: center;  
}

:-ms-input-placeholder {  
   text-align: center; 
}
 .centered-div {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    
    }
  </style>
</head>
<body>
  <div id="particles-js"></div>
  <div class="container count-particles centered-div">
    <div align="center">
    <img class="block" id="u85_img" src="images/logo.png" alt="" width="122" height="64"/>
  </div>
    <form method="post" name="frmLogin" id="frmLogin" runat ="server">
      <label for="username"></label>
      <p></p>

      <input type="text" ID="txtemp_name" placeholder ="Username" required><br>

      <label for="password"></label>

      <input type="password" id="txtemp_pwd" name="txtemp_pwd"  placeholder = "Password"  required><br>
<p></p><p></p>
      <p id ="btnlogin" style="" onclick="login();" align="center" >Login</p>
    </form>

    <div align="center" style="font-size: 12px;margin-top: 20px;">
      Use a valid username and password to gain access to the Administrator consol
    </div>
      <div>


      <div align="center" style="margin-top: 20px;">
      <img class="block" id="u91_img" src="images/ls.png" alt="" width="50" height="50">
        <p style="font-size: 12px;">

      All right reserved to Grand Lemited
      </p>
    </div>

    </div>
  </div>

   <script>
  $(document).ready(function(e) {
  //alert("ready");
    //window.location.replace("login/index.php");
  
});
//============================login
function  login(){
  //alert("cx");
  _emp_name = $("#txtemp_name").val();    
  _emp_pwd = $("#txtemp_pwd").val();
  if($.trim(_emp_name) == "" || $.trim(_emp_pwd) == "")
  {
    alert("Please fill data");
    return;
  }
  
    $.ajax({
        type: 'POST',
        url:'process.php',
    data: { action:'checklogin',emp_name : _emp_name , emp_pwd:_emp_pwd , } ,
        dataType: "json",
        success: function (data) {
      //  alert(data);
      if(data.result == "failure")
        { 
          alert(data.message);  
          return; 
        }
            for (var i = 0; i < data.message.length; i++) {
                var counter = data.message[i];
            
                window.location.replace("../admin_employee/");
        

            }

            

        },
        error: function (a, e, d) {
            var err = a.responseText + ' ' + e + ' ' + d;
                //alert(err);
        }
    });
}



  
          
  </script>
<!-- ==================================background -->

  <script src='https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js'></script>
<script src='https://threejs.org/examples/js/libs/stats.min.js'></script><script  src="./script.js"></script>
<!-- ==================================end background -->
</body>
</html>