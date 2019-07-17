<?php
$title = 'knn';
$jmldata = $_REQUEST['jmldata']; 
$jmlk = $_REQUEST['jmlk']; 
$data = $_REQUEST['data']; 
$class = $_REQUEST['class']; 
$cari = $_REQUEST['cari']; 
?>
<html>
<head>
<title>Tugas Statistika | K-Means</title>
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
	<form class="form-inline" action="knn.php" method="POST" autocomplete="off" >
		<div class="row">
			<div class="col-xs-12">
				  <div class="form-group">
					<label for="jmldata">Jumlah Data:</label>
					<input type="text" class="form-control input-sm" name="jmldata" value="<?php echo $jmldata;?>" placeholder="Jumlah Data ">
				  </div>
				  <div class="form-group">
					<label for="jmldata">Jumlah K:</label>
					<input type="text" class="form-control input-sm" name="jmlk" value="<?php echo $jmlk;?>" placeholder="Jumlah K ">
				  </div>
				  <button type="submit" class="btn btn-success btn-sm">Submit</button>
				  <hr>
			</div>
		</div>
		<?php 
		if(!empty($jmldata)){
		for($i=1;$i<=$jmldata;$i++){
		?>
		<div class="row">
			<div class="col-xs-12"  style="overflow:auto;white-space:nowrap;padding-bottom:10px;">
			  <div class="form-group">
				<?php if($i==1){?><label for="jmldata">Data X</label><br><?php }?>
				<input type="text" class="form-control input-sm" name="data[<?php echo $i; ?>][x]" size="7" value="<?php echo $data[$i]['x'];?>">
			  </div>
			  <div class="form-group">
				<?php if($i==1){?><label for="jmldata">Data Y</label><br><?php }?>
				<input type="text" class="form-control input-sm" name="data[<?php echo $i; ?>][y]" size="7" value="<?php echo $data[$i]['y'];?>">
			  </div>
			  <div class="form-group">
				<?php if($i==1){?><label for="jmldata">Class</label><br><?php }?>
				<input type="text" class="form-control input-sm" name="class[<?php echo $i; ?>]" size="7" value="<?php echo $class[$i];?>">
			  </div>
			</div>
		</div>
		
		<?php }?>
			   <div class="form-group">
			   <label for="Pencarian">Pencarian</label><br>
				<input type="text" class="form-control input-sm" name="cari[x]" size="7" value="<?php echo $cari['x'];?>">
			  </div>
			   <div class="form-group">
			      <label for="Pencarian">&nbsp;</label><br>
				<input type="text" class="form-control input-sm" name="cari[y]" size="7" value="<?php echo $cari['y'];?>">
			  </div><hr>
			 <button type="submit" class="btn btn-success btn-sm">Submit</button>
		<?php }?>
	</form>	
	<?Php 
	if(!empty($data)){
		$jmlclass = jmlClass($class);
		$jarak = jarak($data, $cari);
		$kTerkecil = ambilK($jarak['total'], $jmlk, $class);
		//var_dump($kTerkecil);
		$hasil = hasil($kTerkecil);
	?>
	<div class="row">
		<div class="col-xs-5">
			<h3>Hasil</h3>
			<div class="table table-responsive">
				<table class="table table-bordered">
					<tr class="bg-primary">
						<td width="180px;"> Perbandingan Jarak</td>
						
						<td >Jarak <?php echo "(".$cari['x'].", ".$cari['y'].")"?></td>
						<td>Class</td>
					</tr>
					<?Php 
					for($i=1;$i<=$jmldata;$i++){
					?>
					<tr <?php if(inArray($kTerkecil, $i)){echo "class='bg-success'";}?>>
						<td><?php echo $data[$i]['x'].", ".$data[$i]['y'];?></td>
						<td><?php echo $jarak['total'][$i]?></td>
						<td><?php echo $class[$i];?></td>
					</tr>
					<?php 
					}
					?>
					<tr class="bg-danger">
						<td colspan="3">Hasil (<?php echo $cari['x'].", ".$cari['y'];?>) Adalah <?php echo $hasil;?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="col-xs-7">
			<div id="knn" style="height: 400px; width: 100%;"></div>
		</div>
	</div>
	<?php } ?>
</div>
	</body>
</html>
<?php
function jmlClass($class){
	$jmlclass = array_count_values($class);
	return $jmlclass;
}	
function jarak($data, $cari){
		foreach($data as $key => $value){
			$jarak[$key]['x'] = abs($cari['x'] - $value['x']);
			$jarak[$key]['y'] = abs($cari['y'] - $value['y']);
			$jarak['total'][$key] = $jarak[$key]['x'] + $jarak[$key]['y'];
		}
	return $jarak;
}

function ambilK($jarak, $jmlk, $class){
	$bantu = 1;
	uasort($jarak, 'asc');
	foreach($jarak as $key => $value){
		if($bantu<=$jmlk){
			$hasil[$key] = $class[$key];
		}
		$bantu++;
	}
	return $hasil;
}
function inArray($array, $cari){
	foreach($array as $key => $value){
		if($cari == $key){
			return true;
		}
	}
	return false;
}
function hasil($data){
	foreach($data as $key => $value){
		$bantu[$value]++;
	}
	$hasil = 0;
	foreach($bantu as $key => $value){
		if($hasil<$value){
			$hasil = $value;
			$tmp = $key;
		}
	}
	return $tmp;
}
function asc($a, $b) {   
    if ($a == $b) {        
        return 0;
    }   
        return ($a < $b) ? -1 : 1; 
}  
?>
<script>
Highcharts.chart('knn', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text: 'Perbandingan Jumlah CLuster'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        title: {
            enabled: true,
            text: ''
        },
        startOnTick: true,
        endOnTick: true,
        showLastLabel: true
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    legend: {
        layout: 'vertical',
        align: 'Right',
        verticalAlign: 'top',
        x: 580,
        y: 10,
        floating: false,
    },
    plotOptions: {
        scatter: {
            marker: {
                radius: 5,
                states: {
                    hover: {
                        enabled: true,
                        lineColor: 'rgb(100,100,100)'
                    }
                }
            },
            states: {
                hover: {
                    marker: {
                        enabled: false
                    }
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} , {point.y}'
            }
        }
    },
    series: [
	<?php 
	foreach($jmlclass as $keyc => $valuec){
	?>
	{
        name: '<?php echo $keyc;?>',
        data: [ 
				<?php
				foreach($data as $key => $value){ 
					if($class[$key] == $keyc)
					{ ?>[<?php echo $value['x']?>, <?php echo $value['y']?>],<?php } 
				} ?>
			  ]

    }, 
	<?Php
	}
	?>
	{
        name: 'Data Baru',
        data: [ [<?php echo $cari['x'].",".$cari['y'];?>]  ]
    }, 
	]
});
</script>