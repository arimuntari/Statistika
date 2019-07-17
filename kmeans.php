<?php
include "error.php";
$title = 'kmeans';
$jmldata = $_REQUEST['jmldata']; 
$jmlk = $_REQUEST['jmlk']; 
$data = $_REQUEST['data']; 
$r = $_REQUEST['r']; 
$cari = $_REQUEST['cari']; 
?>
<html>
<head>
<title>Tugas Statistika | K-(Mean, Modus, Median)</title>
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
	<form class="form-inline" action="kmeans.php" method="POST" autocomplete="off" >
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
		?>
		<div class="row">
			<div class="col-xs-6">
			<?Php 
			for($i=1;$i<=$jmldata;$i++){
			?>
			<div class="row">
				<div class="col-xs-6"  style="overflow:auto;white-space:nowrap;padding-bottom:10px;">
				  <div class="form-group">
					<?php if($i==1){?><label for="jmldata">Data X</label><br><?php }?>
					<input type="text" class="form-control input-sm" name="data[<?php echo $i; ?>][x]" size="7" value="<?php echo $data[$i]['x'];?>">
				  </div>
				  <div class="form-group">
					<?php if($i==1){?><label for="jmldata">Data Y</label><br><?php }?>
					<input type="text" class="form-control input-sm" name="data[<?php echo $i; ?>][y]" size="7" value="<?php echo $data[$i]['y'];?>">
				  </div>
				</div>
				<div class="col-xs-6"  style="overflow:auto;white-space:nowrap;padding-bottom:10px;">
				  <?php 
			
				  if($i<=$jmlk){
				  ?>
				  <div class="form-group">
					<?php if($i==1){?><br><?php }?><label for="jmldata">R <?php echo $i; ?></label>
					<input type="text" class="form-control input-sm" name="r[<?php echo $i; ?>][x]" size="7" value="<?php echo $r[$i]['x'];?>">
				  </div>
				  <div class="form-group">
					<?php if($i==1){?><label for="jmldata">&nbsp;</label><br><?php }?>
					<input type="text" class="form-control input-sm" name="r[<?php echo $i; ?>][y]" size="7" value="<?php echo $r[$i]['y'];?>">
				  </div>
				  <?php 
				  }
				  ?>
				</div>
			</div>
			
			<?php }?><hr>
				 <button type="submit" class="btn btn-success btn-sm">Submit</button>
			 </div>
			 <?Php 
			 
			if(!empty($data)){
				$jarak = jarak($data, $r);
			 ?>
			 <div class="col-xs-6">
				 <div class="row">
					 <div class="col-xs-12">
						<div class="table table-responsive">
							<table class="table table-bordered">
								<tr class="bg-primary">
									<td width="180px;"> Perbandingan Jarak</td>
									<?Php 
									foreach($r as $keyr => $valuer){
									?>
									<td > R<?php echo $keyr."(".$valuer['x'].", ".$valuer['y'].")"?></td>
									<?php 
									}
									?>
									<td>Hasil</td>
								</tr>
								<?Php 
								for($i=1;$i<=$jmldata;$i++){
								?>
								<tr>
									<td ><?php echo $data[$i]['x'].",".$data[$i]['y'];?></td>
									<?Php 
									$hasil = 2147483647;
									foreach($r as $keyr => $valuer){
										if($hasil> $jarak[$keyr][$i]['total']){
											$hasil = $jarak[$keyr][$i]['total'];
											$bantu = $keyr;
										}
									?>
									<td><?php echo $jarak[$keyr][$i]['total']?></td>
									<?php 
									}
									$kelompok[$bantu][] = $i; 
									$datakelompok[$bantu]['x'][] =  $data[$i]['x']; 
									$datakelompok[$bantu]['y'][] =  $data[$i]['y']; 
									?>
									<td>R<?php echo $bantu;?></td>
								</tr>
								<?php 
								}
								?>
							</table>
						</div>
					 </div>
				 </div>
			</div>
			<?Php } ?>
		</div>
		<?php }?>
	</form>	
	<?php 
	if(!empty($data) && !empty($datakelompok)){
	?>
	<div class="row">
		<div class="col-xs-6">
			<div id="k-means" style="height: 400px; width: 100%;"></div>
		</div>
		<div class="col-xs-6">
			<h3>Hasil</h3>
			<div class="table table-responsive">
				<table class="table table-bordered">
					<tr class="bg-primary">
						<td>Cluster</td>
						<td>Mean</td>
						<td>Median</td>
						<td>Modus</td>
					</tr>
					<?php 
					foreach($r as $keyr => $valuer){
					?>
					<tr>
						<td>R<?php echo $keyr;?></td>
						<td><?php echo "X=".mean($datakelompok[$keyr]['x'])."<br> Y=".mean($datakelompok[$keyr]['y']);?></td>
						<td><?php echo "X=".median($datakelompok[$keyr]['x'])."<br> Y=".median($datakelompok[$keyr]['y']);?></td>
						<td><?php echo "X=".modus($datakelompok[$keyr]['x'])."<br> Y=".modus($datakelompok[$keyr]['y']);?></td>
					</tr>
					<?Php 
					}
					?>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
	</body>
</html>
<?php
function jarak($data, $r){
	foreach($r as $keyr => $valuer){
		foreach($data as $key => $value){
			$jarak[$keyr][$key]['x'] = abs($valuer['x'] - $value['x']);
			$jarak[$keyr][$key]['y'] = abs($valuer['y'] - $value['y']);
			$jarak[$keyr][$key]['total'] = $jarak[$keyr][$key]['x'] + $jarak[$keyr][$key]['y'];
		}
	}
	return $jarak;
}
function bagiData($listdata){
	$temp = 1;
	foreach($listdata as $data){
		if($data == $i){
			$result[$data] = $temp++;
		}else{
			$temp = 1;
		}
		$result[$data] = $temp;
		$i = $data;
	}
	//var_dump($result);
	return $result;
}
function mean($listdata){
	sort($listdata);
	$result = bagiData($listdata);
	$total = 0;
	//echo "<br><br>";
//	var_dump($result);
	foreach($result as $data => $jml){
		$total  +=  $data*$jml; 
	}
	//echo $total;
	$mean = $total/count($listdata);
	return $mean;
}
function median($listdata){
	sort($listdata);
	//var_dump($listdata);
	$jmlfrekuensi = count($listdata);
	if($jmlfrekuensi%2==0){
		$median = ($listdata[$jmlfrekuensi/2]+ $listdata[($jmlfrekuensi/2)+1])/2;
	}else{
		$median = $listdata[$jmlfrekuensi/2];
	}
	return $median;
}
function modus($listdata){
	sort($listdata);
	$modus=0;
	$terbesar = 0;
	$result = bagiData($listdata);
	foreach($result as $data => $jml){
		if($jml > $terbesar){
			$terbesar = $jml;
			$modus = $data;
		}
	}
	return $modus;
}
?>
<script>
Highcharts.chart('k-means', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text: 'Perbandingan Jumlah Cluster'
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
        x: 570,
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
	foreach($r as $key => $value){
	?>
	{
        name: '<?php echo 'R'.$key;?>',
        data: [<?php foreach($kelompok[$key] as $value){?> [<?php echo $data[$value]['x'].", ".$data[$value]['y'];?>], <?Php }?>]

    }, 
	<?Php
	}
	?>
	]
});
</script>