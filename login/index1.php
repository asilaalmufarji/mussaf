<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
   
  
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="2015.0.0.309"/>
  <link rel="shortcut icon" href="images/login-favicon.ico?58722678"/>

  <title>Login</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="css/site_global.css?4052507572"/>
  <link rel="stylesheet" type="text/css" href="css/index.css?4266711638" id="pagesheet"/>
  <!-- Other scripts -->
 


  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <!-- JS includes -->
 
    <!--HTML Widget code-->
  
	<style>
	.particle {width: 100%px; height: 472px;}
	</style>
	
	
<style>
* {
       transition:all .5s ease;
	-webkit-transition: all .5s ease;
}

.clip_frame, .Container, .verticalspacer, #preloader, img {
  transition:none !important;
  -webkit-transition:none !important;
}
</style>

    
</head>
<body style = "margin:0px">
   <style>
    body
    {
        font-family:Tahoma;
        font-size:small;           
    }                
    .txt
	{
		border:1px solid #CCCCCC;
		height:20px;
		
	}
	
    </style>
    <link href="App_Themes/admin_css/style.css" rel="stylesheet" type="text/css" />
<form method="post" name="frmLogin" id="frmLogin" runat ="server">

   



			


		







    <div class="clearfix" id="page"><!-- group -->
   <div class="clearfix grpelem" id="pu75"><!-- group -->
    <div class="browser_width grpelem" id="u75-bw">
     <div id="u75"><!-- custom html -->
      
	<div class="particle"></div>
	
</div>
    </div>
    <div class="clip_frame grpelem" id="u85"><!-- image -->
     <img class="block" id="u85_img" src="images/logo.png" alt="" width="122" height="64"/>
    </div>
    <div class="grpelem" id="u111"><!-- custom html --></div>
    <div class="clearfix grpelem" id="u113"><!-- column -->
     <div class="rgba-background colelem" id="u101"><!-- simple frame --></div>
     <div class="rgba-background colelem" id="u103"><!-- simple frame --></div>
     <div class="clearfix colelem" id="u110"><!-- group -->
      <div class="clearfix grpelem" id="u108"><!-- group -->
       <div class="clearfix grpelem" id="u109-4"><!-- content -->
        <p id="u109-2" onclick="login();">

            	<span ID="butok"   Width = "100px"
        style = "border:1px solid #FFF;font-size:16px;
background-color:transparent;border:none;cursor:pointer;padding:10px;color:#FFF;
padding-bottom:3px;padding-top:3px" 
        >
        Login
</span>


        </p>
       </div>
      </div>
     </div>
     <div class="clearfix colelem" id="u106-4"><!-- content -->
      <p>&quot;Use a valid username and password to gain access to the Administrator consol&quot;</p>
     </div>
    </div>
    <div class="clearfix grpelem" id="u105-4"><!-- content -->
     <p id="u105-2">

       
        


           <input type="text" ID="txtemp_pwd" runat="server" 
                CssClass = "txt"  placeholder = "Password" 
                TextMode="Password" Style = "border:0px;Width:350px;height:20px;text-align:center;
                    font-size:18px;margin-left:-130px;line-height:20px;outline:none;background-color:transparent" />
        
           


     </p>
    </div>
    <div class="clearfix grpelem" id="u104-4"><!-- content -->
     <p id="u104-2">
           <input type="text" ID="txtemp_name" placeholder ="Username"
             Style = "border:0;height:20px;line-height:20px;Width:350px;font-size:18px;
            text-align:center;margin-left:-118px;outline:none;background-color:transparent" />
         
			

     </p>
    </div>
   </div>
   <div class="verticalspacer"></div>
   <div class="clearfix grpelem" id="u99"><!-- column -->
    <div class="clip_frame colelem" id="u91"><!-- image -->
     <img class="block" id="u91_img" src="images/ls.png" alt="" width="50" height="50"/>
    </div>
    <div class="clearfix colelem" id="u97-4"><!-- content -->
     <p>All right reserved to Grand Lemited</p>
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

  </script>
  <!-- JS includes -->
  <script type="text/javascript">
      if (document.location.protocol != 'https:') document.write('\x3Cscript src="http://musecdn2.businesscatalyst.com/scripts/4.0/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script type="text/javascript">
      window.jQuery || document.write('\x3Cscript src="scripts/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script src="scripts/museutils.js?183364071" type="text/javascript"></script>
  <script src="scripts/jquery.watch.js?71412426" type="text/javascript"></script>
  <!-- Other scripts -->

  
  <!--HTML Widget code-->
  
		<script>
		    $(function () {
		        $(".particle").jParticle({
		            background: 'rgba(255,255,255, 0)',
		            color: '#E6E6E6',
                    width:300,
		            particlesNumber: 80,
		        });
		    });
	</script>
	<script>
	    !function (e) { "use strict"; var t, n; n = {}, e.fn.jParticle = function (n) { return this.each(function (i, a) { "object" == typeof a.sandbox && e(a).removeJParticle(), a.sandbox = t(a, n) }), this }, e.fn.removeJParticle = function () { return this.each(function (e, t) { t.sandbox && (t.sandbox.remove(), delete t.sandbox) }), this }, e.fn.freezeJParticle = function () { return this.each(function (e, t) { t.sandbox && t.sandbox.freeze() }), this }, e.fn.unfreezeJParticle = function () { return this.each(function (e, t) { t.sandbox && t.sandbox.unfreeze() }), this }, t = function (t, i) { var a, o; return a = {}, a.canvas = {}, a.mouse = {}, a.particles = [], a.isAnimated = !1, a.initialize = function (e, t) { a.initParams(t), a.initHTML(e), a.initParticles(), a.initEvents(), a.initAnimation() }, a.initParams = function (t) { t && t.color && (!t.particle || t.particle && !t.particle.color) && (t.particle || (t.particle = {}), t.particle.color = t.color), a.params = e.extend({ particlesNumber: 100, linkDist: 50, createLinkDist: 150, disableLinks: !1, disableMouse: !1, width: null, height: null, linksWidth: 1 }, t) }, a.initHTML = function (t) { var n; n = a.canvas, n.container = e(t), n.element = e("<canvas/>"), n.context = n.element.get(0).getContext("2d"), n.container.append(n.element), n.element.css("display", "block"), n.element.get(0).width = a.params.width ? a.params.width : n.container.width(), n.element.get(0).height = a.params.height ? a.params.height : n.container.height(), n.element.css("background", a.params.background) }, a.resize = function (e, t) { e && (canvas.element.get(0).width = e), t && (canvas.element.get(0).height = t) }, a.initParticles = function () { var e, t; for (e = 0, t = a.params.particlesNumber; t > e; e += 1) a.particles.push(o(a.canvas.element.get(0), a.params.particle)) }, a.initEvents = function () { a.canvas.element.mouseenter(function () { a.mouse.hoverCanvas = !0, a.isAnimated || a.draw() }), a.canvas.element.mouseleave(function () { a.mouse.hoverCanvas = !1 }), a.canvas.element.mousemove(function (t) { a.mouse = e.extend(a.mouse, n.getMousePosition(t, a.canvas.element[0])) }) }, a.initAnimation = function () { window.requestAnimFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.ORequestAnimationFrame || window.msRequestAnimationFrame || function (e) { setTimeOut(e, 1e3 / 60) }, a.isAnimated = !0, a.draw() }, a.draw = function () { var e, t, n, i, o, r; for (e = 0, n = a.particles.length, i = a.canvas, i.context.clearRect(0, 0, i.element.get(0).width, i.element.get(0).height) ; n > e; e += 1) if (o = a.particles[e], a.isAnimated && o.update(), o.draw(), !a.params.disableMouse && a.mouse.hoverCanvas && a.drawLink(o.getPosition("x"), o.getPosition("y"), a.mouse.x, a.mouse.y), !a.params.disableLinks) for (t = e + 1; n > t; t += 1) r = a.particles[t], a.drawLink(o.getPosition("x"), o.getPosition("y"), r.getPosition("x"), r.getPosition("y")); a.requestID = window.requestAnimFrame(a.draw) }, a.drawLink = function (e, t, i, o) { var r; n.getDistance(e, t, i, o) <= a.params.createLinkDist && (r = a.canvas.context, r.save(), r.beginPath(), r.lineWidth = a.params.linksWidth, r.moveTo(e, t), r.lineTo(i, o), r.globalAlpha = a.getOpacityLink(e, t, i, o), r.strokeStyle = a.params.color, r.lineCap = "round", r.stroke(), r.closePath(), r.restore()) }, a.getOpacityLink = function (e, t, i, o) { var r, s, c, u; return r = n.getDistance(e, t, i, o), c = a.params.linkDist, u = a.params.createLinkDist, s = c >= r ? 1 : r > u ? 0 : 1 - 100 * (r - c) / (u - c) / 100 }, a.freeze = function () { a.isAnimated && (a.isAnimated = !1) }, a.unfreeze = function () { a.isAnimated || (a.isAnimated = !0) }, a.remove = function () { a.canvas.element.remove() }, o = function (t, i) { var a; return a = {}, a.canvas = {}, a.vector = {}, a.initialize = function (t, n) { a.params = e.extend({ color: "white", minSize: 2, maxSize: 4, speed: 60 }, n), a.setCanvasContext(t), a.initSize(), a.initPosition(), a.initVectors() }, a.initPosition = function () { a.x = n.getRandNumber(0 + a.radius, a.canvas.element.width - a.radius), a.y = n.getRandNumber(0 + a.radius, a.canvas.element.height - a.radius) }, a.initSize = function () { a.size = n.getRandNumber(a.params.minSize, a.params.maxSize), a.radius = a.size / 2 }, a.initVectors = function () { do a.vector.x = n.getRandNumber(-a.params.speed / 60, a.params.speed / 60, !1), a.vector.y = n.getRandNumber(-a.params.speed / 60, a.params.speed / 60, !1); while (0 == a.vector.x || 0 == a.vector.y) }, a.setCanvasContext = function (e) { var t; if (a.canvas.element = e, t = e.getContext("2d"), "object" != typeof t || "object" != typeof t.canvas) throw "Error: Can't set canvas context to Particle because context isn't a CanvasRenderingContext2D object."; a.canvas.context = t }, a.draw = function () { var e = a.canvas.context; e.beginPath(), e.arc(a.x, a.y, a.size / 2, 0, 2 * Math.PI), e.fillStyle = a.params.color, e.fill(), e.closePath() }, a.update = function () { a.x += a.vector.x, a.y += a.vector.y, (0 > a.x - a.radius || a.x + a.radius > a.canvas.element.width) && (a.vector.x = -a.vector.x), (0 > a.y - a.radius || a.y + a.radius > a.canvas.element.height) && (a.vector.y = -a.vector.y) }, a.getPosition = function (e) { return "string" == typeof e && "x" != e && "y" != e && (e = null), "string" == typeof e ? a[e] : { x: a.x, y: a.y } }, a.initialize(t, i), { getPosition: a.getPosition, update: a.update, draw: a.draw } }, a.initialize(t, i), { remove: a.remove, freeze: a.freeze, unfreeze: a.unfreeze, resize: a.resize } }, n.getRandNumber = function (e, t, n) { var i; return null == e && (e = 0), null == t && (t = 10), null == n && (n = !0), i = Math.random() * (t - e) + e, n ? Math.round(i) : i }, n.getDistance = function (e, t, n, i) { return Math.sqrt(Math.pow(n - e, 2) + Math.pow(i - t, 2)) }, n.getMousePosition = function (t, n) { var i; return "undefined" == typeof n && (n = e("body")[0]), i = n.getBoundingClientRect(), { x: t.clientX - i.left, y: t.clientY - i.top } } }(jQuery);
	</script>
		



</form>
</body>
</html>
