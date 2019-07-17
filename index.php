<?php
$data = $_REQUEST['data']; 
$class = $_REQUEST['class']; 
if(!empty($data)){
	 $listdata = array_map('intval', explode(';', $data));
	 $jmldata = 0;
	 sort($listdata);
	 $tableFrekuensi = createTableFrekuensi($listdata, $class);
	 $range = json_encode($tableFrekuensi['range']);
	 $akclass = 0;
	 $jmlfrekuensi = 0;
	 for($i= 0; $i<$class;$i++){
		 $frekuensi[$i] = count($tableFrekuensi['list'][$i+1]);
		 if(count($tableFrekuensi['list'][$i+1])>$akclass){
			 $akclass= $frekuensi[$i];
		 }
		 $chartFrekuensi[] = array (
				'name' => $tableFrekuensi['range'][$i],
				'data'  => array( count($tableFrekuensi['list'][$i+1]) ), 
			);
		$jmlfrekuensi +=  $frekuensi[$i];
	 }
	 $tengah = $jmlfrekuensi/2;
	 $tengah2 = $jmlfrekuensi/2;
	 $hasilFrekuensi = json_encode($chartFrekuensi);
}
?>
<style>
textarea, td { vertical-align: top; }​
</style>
<html>
<head>
<title>Tugas Statistika | Tabel Frekuensi</title>
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
	<form action="index.php" method="POST" autocomplete="off" >
		  <div class="form-group">
			<label for="data">Masukkan Data:</label>
			<input type="text" class="form-control  input-sm" name="data" value="<?php echo $data;?>" placeholder="Contoh : 1; 2; 3; 4; 5; 6; 7; 8; 9 ">
		  </div>
		  <div class="form-group">
			<label for="class">Class</label>
			<input type="text" class="form-control input-sm" name="class"  value="<?php echo $class;?>" placeholder="Class">
		  </div>
		  <button type="submit" class="btn btn-success">Submit</button>
	</form>		
	
<?php 
if(!empty($data)){
		$mean = mean($listdata);
		$median = median($listdata);
		$modus = modus($listdata);
		$range = rangeTunggal($listdata);
		$midRange = midRange($listdata);
		$kuartil1 = kuartil1($listdata);
		$kuartil3 = kuartil3($listdata);
		$grafikTunggal= grafikTunggal($listdata);
		$meanDeviation= meanDeviation($listdata);
		$variance= variance($listdata);
		$standartDeviation= standartDeviation($listdata);
		//echo $tunggal
	?>
	<div class="panel panel-primary">
	  <div class="panel-heading">Grafik Table Frekuensi Data Tunggal</div>
	  <div class="panel-body">
		<div class="row">
		
			<div class="col-md-9">
			  <div class="chart table-responsive">
				<!-- Sales Chart Canvas -->
				<div  id="hasilTunggal" style="height: 500px; width: 100%;"></div>
			  </div>
			  <!-- /.chart-responsive -->
			</div>
          	<div class="col-md-3">
				<h4>Hasil:</h4>
				    <div class="table-responsive">
						<table class="table">
							<tr>
								<td>Mean</td><td>=</td><td><?Php echo number_format($mean, 2);?></td>
							</tr>
							<tr>
								<td>Median</td><td>=</td><td><?php echo $median; ?></td>
							</tr>
							<tr>
								<td>Modus</td><td>=</td><td><?Php echo $modus; ?></td>
							</tr>
							<tr>
								<td>Range</td><td>=</td><td><?Php echo $range;?></td>
							</tr>
							<tr>
								<td>Midrange</td><td>=</td><td><?Php echo $midRange;?></td>
							</tr>
							<tr>
								<td>Kuartil 1</td><td>=</td><td><?Php echo $kuartil1;?></td>
							</tr>
							<tr>
								<td>Kuartil 2</td><td>=</td><td><?Php echo $median;?></td>
							</tr>
							<tr>
								<td>Kuartil 3</td><td>=</td><td><?Php echo $kuartil3;?></td>
							</tr>
							<tr>
								<td>Range Kuartil</td><td>=</td><td><?Php echo $kuartil3-$kuartil1;?></td>
							</tr>
							<tr>
								<td>Mean Deviation</td><td>=</td><td><?Php echo number_format($meanDeviation, 2);?></td>
							</tr>
							<tr>
								<td>Variance</td><td>=</td><td><?Php echo number_format($variance, 2);?></td>
							</tr>
							<tr>
								<td>Standart Deviation</td><td>=</td><td><?Php echo number_format($standartDeviation, 2);?></td>
							</tr>
						</table>
					</div>
				</div>
		</div>
           
	  </div>
	</div>

	<div class="panel panel-primary">
	  <div class="panel-heading">Grafik Table Frekuensi Data Kelompok</div>
	  <div class="panel-body">
		<div class="row">
                <div class="col-md-3">
				</div>
                <div class="col-md-9">
				</div>
                <div class="col-md-9">
				  <div class="table-responsive">
					  <table class="table table-bordered">
						<tr class="bg-primary">
						  <th align="center" style="width: 10px;">No.</th>
						  <th>Range</th>
						  <th style="width: 40px;text-align:center;">F<sub>1</sub></th>
						  <th style="width: 40px;text-align:center;">&Sigma;F<sub>1</sub></th>
						  <th style="width: 40px;text-align:center;">X<sub>1</sub></th>
						  <th style="width: 40px;text-align:center;"><sub>t</sub>b</th>
						  <th style="width: 40px;text-align:center;"><sub>t</sub>a</th>
						  <th style="width: 60px">X<sub>1</sub>.F<sub>1</sub></th>
						</tr>
						<?php 
						$totalData= 0;
						$totalMid= 0;
						$Ftotal= 0;
						$Jfrekuensi= 0;
						$akFrekuensi[-1] = 0;
							 for($i= 0; $i<$class;$i++){
								 $totalData += $frekuensi[$i]; 
								 $totalMid += $tableFrekuensi['mid'][$i];
								 $fX = $tableFrekuensi['mid'][$i]*$frekuensi[$i];
								 $Ftotal += $fX;
								 $Jfrekuensi  += $frekuensi[$i];
								 $akFrekuensi[]= $Jfrekuensi;
						?>
						<tr>
							<td  align="center" ><?php echo $i+1;?></td>
							<td  align="center" ><?php echo $tableFrekuensi['range'][$i];?></td>
							<td  align="center" <?php if($frekuensi[$i]==$akclass){echo "class='bg-danger'";$modclass=$i;}?>><?php echo $frekuensi[$i];?></td>
							<td  align="center" <?php if($Jfrekuensi >= $tengah){echo "class='bg-success'";$medclass=$i;$medfrekuensi=$Jfrekuensi;$tengah = $jmlfrekuensi+10;}?> ><?php echo $Jfrekuensi;?></td>
							<td  align="center" ><?php echo $tableFrekuensi['mid'][$i];?></td>
							<td  align="center" ><?php echo $tableFrekuensi['low'][$i]-0.5;?></td>
							<td  align="center" ><?php echo $tableFrekuensi['up'][$i]+0.5;?></td>
							<td  align="center" ><?php echo $fX;?></td>
						</tr>
						<?php 
							 } 
							 $hasilmean = number_format($Ftotal/$totalData, 2);
							 $hasilmedian = number_format((($tableFrekuensi['low'][$medclass]-0.5)+(($tengah2-($frekuensi[$medclass-1]))/$frekuensi[$medclass])*$tableFrekuensi['panjang']), 2);
							 
							 $hasilmodus = number_format((($tableFrekuensi['low'][$modclass]-0.5))+($tableFrekuensi['panjang']*(($frekuensi[$modclass]-$frekuensi[$modclass-1])/($frekuensi[$modclass]-$frekuensi[$modclass-1]+$frekuensi[$modclass]-$frekuensi[$modclass+1]))), 2);
							
						?>
						<tr>
							<td colspan="2" align="right"><strong>Total</strong></td>
							<td style="text-align: center;"><?php echo $totalData; ?></td>
							<td style="text-align: center;"></td>
							<td style="text-align: center;"><?php echo $totalMid; ?></td>
							<td style="text-align: center;"></td>
							<td style="text-align: center;"></td>
							<td style="text-align: center;"><?php echo $Ftotal; ?></td>
						</tr>
						<tr>
							<td colspan="2" align="right"><strong>Estimated Mean</strong></td>
							<td style="text-align: center;" colspan="6"><?php echo $hasilmean; ?></td>
						</tr>
						<tr>
							<td colspan="2" align="right"><strong>Estimated Median</strong></td>
							<td style="text-align: center;" colspan="6">
								<?php echo $hasilmedian; ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right"><strong>Estimated Modus</strong></td>
							<td style="text-align: center;" colspan="6">
								<?php echo $hasilmodus; ?>
							</td>
						</tr>
					  </table>
				  </div>
                </div>
         
				<div class="col-md-3">
				<h4>Keterangan:</h4>
				    <div class="table-responsive">
						<table class="table">
							<tr>
								<td>F<sub>1</sub></td><td>=</td><td>Frekuensi</td>
							</tr>
							<tr>
								<td>&Sigma;F<sub>1</sub></td><td>=</td><td>Akumulasi Frekuensi</td>
							</tr>
							<tr>
								<td>X<sub>1</sub></td><td>=</td><td>Nilai Tengah</td>
							</tr>
							<tr>
								<td><sub>t</sub>b</td><td>=</td><td>Batas Bawah</td>
							</tr>
							<tr>
								<td><sub>t</sub>a</td><td>=</td><td>Batas Atas</td>
							</tr>
							<tr>
								<td class="bg-success"></td><td>=</td><td>Class Median</td>
							</tr>
							<tr>
								<td class="bg-danger"></td><td>=</td><td>Class Modus</td>
							</tr>
						</table>
					</div>
				</div>
			<div class="col-md-12">
			  <div class="chart table-responsive">
				<!-- Sales Chart Canvas -->
				<div height="300" width="703" id="hasilFrekuensi" style="height: 400px; width: 100%;"></div>
			  </div>
			  <!-- /.chart-responsive -->
			</div>
		</div>
           
	  </div>
	</div>

<?php }?>	
</div>
	</body>
</html>
<?php 
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
	$result = bagiData($listdata);
	$total = 0;
	//echo "<br><br>";
//	var_dump($result);
	foreach($result as $data => $jml){
		$total  +=  $data*$jml; 
	}
	$mean = $total/count($listdata);
	return $mean;
}
function median($listdata){
	$jmlfrekuensi = count($listdata);
	if($jmlfrekuensi%2==0){
		$median = ($listdata[$jmlfrekuensi/2]+ $listdata[($jmlfrekuensi/2)+1])/2;
	}else{
		$median = $listdata[$jmlfrekuensi/2];
	}
	return $median;
}
function modus($listdata){
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
function rangeTunggal($listdata){
	$jmlfrekuensi = count($listdata);
	$range = $listdata[count($listdata)-1] - $listdata[0];
	return $range;
}
function midRange($listdata){
	$range =rangeTunggal($listdata);
	$midrange = $range/2;
	return $midrange;
}

function kuartil1($listdata){
	$jmlfrekuensi = count($listdata);
	if($jmlfrekuensi*1/4==0){
		 $k1 = ($listdata[$jmlfrekuensi/4]+ $listdata[($jmlfrekuensi/4)+1])/2;
	}else{
		 $k1 = $medianTunggal = $listdata[$jmlfrekuensi/4];
	}
	return $k1;
}
function kuartil3($listdata){
	$jmlfrekuensi = count($listdata);
	if($jmlfrekuensi*3/4==0){
		 $k3 = ($listdata[($jmlfrekuensi*3/4)]+ $listdata[($jmlfrekuensi*3/4)+1])/2;
	}else{
		 $k3 = $medianTunggal = $listdata[$jmlfrekuensi*3/4];
	}
	return $k3;
}
function grafikTunggal($listdata){
	$result = bagiData($listdata);
	foreach($result as $data => $jml){
		$kat[] = $data;
		$total[] = $jml;
	}
	$grafik['kategori'] = json_encode($kat);
	$grafik['total'] = json_encode($total);
	return $grafik;
}
function meanDeviation($listdata){
	$mean = mean($listdata);
	$totalDeviation= 0;
	foreach($listdata as $data){
		$totalDeviation += abs($data - $mean);
		//echo abs($data - $mean)."<br>";
	}
	//echo $totalDeviation;
	$meanDeviation = $totalDeviation/count($listdata);
	return $meanDeviation;
}
function variance($listdata){
	$mean = mean($listdata);
	$total= 0;
	foreach($listdata as $data){
		$jml = ($data - $mean) * ($data - $mean);
		$total += $jml;
	
	}
	$variance = $total/count($listdata);
	return $variance;
}
function standartDeviation($listdata){
	$variance = variance($listdata);
	$hasil = sqrt($variance);
	return $hasil;
}

function createTableFrekuensi($listdata, $class, $maks=null, $min=null){
	if(empty($maks)){
		$maks = $listdata[count($listdata)-1];
	}if(empty($min)){
		$min =  $listdata[0];
	}
	
	$width = ceil(($maks-$min)/$class);
	//echo $maks;
	$low[0] = $min;
	$up[0]  = $min + $width-1;
	
	$mid[0] = ($low[0] + $up[0])/2;
	for($i=1;$i<=$class;$i++){
		$range[] =  $low[$i-1]." - ".$up[$i-1];
		for($j=0;$j<count($listdata);$j++){
			if($low[$i-1]<=$listdata[$j] && $up[$i-1]>=$listdata[$j]){
				$list[$i][] =  $listdata[$j]." ";
			}
		}
		$low[$i] = $low[$i-1] + $width;
		$up[$i]  = $low[$i] + $width-1;
		$mid[$i] = ($low[$i] + $up[$i])/2;
	}
	if($up[$i-2]<$maks){
		//echo $up[$i-2]."#";
		if($min>0){
			$min=$min-1;
		}
		return createTableFrekuensi($listdata, $class, $maks+1, $min);
	}else{
		$data['up'] = $up;
		$data['mid'] = $mid;
		$data['low'] = $low;
		$data['range'] = $range;
		$data['list'] = $list;
		$data['panjang'] = $width;
		return $data;
	}
}
?>
<script>
Highcharts.chart('hasilTunggal', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Hasil Table Frekuensi Data Tunggal'
    },
    xAxis: {
        categories: <?php echo $grafikTunggal['kategori'];?>,
		 labels: {
            style: {

                fontSize: '16px'

            }

        },
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total '
        }
    },
    tooltip: {
        pointFormat: '{series.name} = ' + '{point.y:0f}',
        shared: false,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },
		series: {
			showInLegend: false,
			borderWidth: 0,

			dataLabels: {

				enabled: true,

				format: '{y}'

			}
		}
    },
    series: [{

        name: 'Harian',

		colorByPoint: true,

        data: <?php echo $grafikTunggal['total'];?>

    }]
});
</script>
<script>Highcharts.chart('hasilFrekuensi', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Hasil Table Frekuensi Data Kelompok'
    },
    xAxis: {
        categories: ['Range Data'],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total '
        }
    },
    tooltip: {
        pointFormat: '{series.name} = ' + '{point.y:0f}',
        shared: false,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: <?php echo $hasilFrekuensi;?>, 
});
</script>