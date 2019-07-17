<?php
$title = 'ttd';
$jmldata = $_REQUEST['jmldata']; 
$jmlattr = $_REQUEST['jmlattr']; 
$attrib = $_REQUEST['attrib']; 
$class = $_REQUEST['class']; 
$cari = $_REQUEST['cari']; 
?>
<html>
<head>
<title>Tugas Statistika | Tanda Tangan</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" />
<script src="highcharts.js"></script>
<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
include "menu.php";
?>
<div class="container">
	<form class="form-inline" action="naive-bayes.php" method="POST" autocomplete="off" >
		<div class="row">
			<div class="col-md-3">
				<div style="position:fixed">
				<canvas id="myCanvas" width="200" height="100" style="border:1px solid #000000;margin:10px 0px;">
				</canvas><br>
				<button type="button" onclick="simpan();" class="btn btn-primary" value="">Simpan</button>
				<button type="button" onclick="listdata();" class="btn btn-success" value="">Cari</button>
				</div>
			</div>
			<div class="col-md-8">
				<table id="myTable" class="table table-responsive table-bordered">
					<thead>
					<tr>
						<td>NO</td>
						<td>Foto</td>
						<td>Mean 1</td>
						<td>Median 1</td>
						<td>Deviation 1</td>
						<td>Mean 2</td>
						<td>Median 2</td>
						<td>Deviation 2</td>
					</tr>
					</thead>
					<tbody id="asd">
					<?php 
					include "listdata.php";
					?>
					</tbody>
				</table>
			</div>
		</div>
	</form>	
</div>
</body>
</html>
<script>
 var mousePressed = false;
var lastX, lastY;
var ctx;
InitThis();
function InitThis() {
    ctx = document.getElementById('myCanvas').getContext("2d");
    $('#myCanvas').mousedown(function (e) {
        mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
    });

    $('#myCanvas').mousemove(function (e) {
        if (mousePressed) {
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
        }
    });
	$('#myCanvas').mouseup(function (e) {
        mousePressed = false;
    });
	$('#myCanvas').mouseleave(function (e) {
        mousePressed = false;
    }); 
	$('#myCanvas').touchstart(function (e) {
        mousePressed = true;
		alert('asd');
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
    });

    $('#myCanvas').touchmove(function (e) {
        if (mousePressed) {
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
        }
    });
	$('#myCanvas').touchend(function (e) {
        mousePressed = false;
    });
	$('#myCanvas').mouseleave(function (e) {
        mousePressed = false;
    });
}

function Draw(x, y, isDown) {
    if (isDown) {
        ctx.beginPath();
        ctx.strokeStyle = "#000000";
        ctx.lineWidth = 1;
        ctx.lineJoin = "round";
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.closePath();
        ctx.stroke();
    }
    lastX = x; lastY = y;
}
	
function clearArea() {
    // Use the identity matrix while clearing the canvas
    ctx.setTransform(1, 0, 0, 1, 0, 0);
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
}
function simpan(){
	canvas = document.getElementById('myCanvas');
	//alert(canvas);
	var image = canvas.toDataURL("image/png");  // here is the most important part because if you dont replace you will get a DOM 18 exception.
	var image1 = new Image();
	image1.src = image;
	simpanimg(image);
}
function simpanimg(img){
	
	$.ajax({ 
    type: "POST", 
    url: 'simpanimg.php',
    dataType: 'text',
    data: {
        foto : img
    },
	success: function(data){
		ctx.clearRect(0, 0, canvas.width, canvas.height);
       $('#asd').load("listdata.php");
    }
	});
}
</script>