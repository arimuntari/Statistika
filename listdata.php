<?php

include "error.php";
$path    = 'image';
$files = array_diff(scandir($path), array('..', '.'));
$no=0;
foreach($files as $value){
	$no++;
	$hasil = getData($value);
	?>
	<tr>
		<td><?php echo $no;?></td>
		<td><img src="image/<?php echo $value;?>" width="100px" height="50px"></img></td>
		<td><?php echo $hasil['mean1'];?></td>
		<td><?php echo $hasil['median1'];?></td>
		<td><?php echo $hasil['std1'];?></td>
		<td><?php echo $hasil['mean2'];?></td>
		<td><?php echo $hasil['median2'];?></td>
		<td><?php echo $hasil['std1'];?></td>
	</tr>
	<?php 
}
function getData($im){
	//echo $im;
	$ttd = "image/".$im;
	$img = imagecreatefrompng($ttd);
	$x=1;$y=1;
	$rgb = imagecolorat($img, $x, $y);
	$colors = imagecolorsforindex($img, $rgb);
	$bantu = 0;
	for($x=1;$x<=100;$x++){
		for($y=1;$y<=100;$y++){
			$rgb1 = imagecolorat($img, $x, $y);
			$colors1 = imagecolorsforindex($img, $rgb1);
			$data[0][$bantu] = getList($x, $y, $colors1);
			
			$rgb2 = imagecolorat($img, $x+100, $y);	
			$colors2 = imagecolorsforindex($img, $rgb2);
			$data[1][$bantu] = getList($x+100, $y, $colors2);
			$bantu++;
		}
	}
	$hasil['mean1'] =  mean($data[0]);
	$hasil['mean2'] =  mean($data[1]);
	$hasil['median1'] =  median($data[0]);
	$hasil['median2'] =  median($data[1]);
	$hasil['std1'] =  standartDeviation($data[0]);
	$hasil['std2'] =  standartDeviation($data[1]);
	return $hasil;
}
function getList($x, $y, $colors){
	$rata[$x][$y] = $colors['alpha'];
	if($rata[$x][$y]<=125){
		$hasil = 0;
	}else{
		$hasil = 255;
	}
	return $hasil;
}
function mean($data){
	//var_dump($data);
	$total = array_sum($data);
	return $total/count($data);
}
function median($listdata){
	sort($listdata);
	$jmlfrekuensi = count($listdata);
	if($jmlfrekuensi%2==0){
		$median = ($listdata[$jmlfrekuensi/2]+ $listdata[($jmlfrekuensi/2)+1])/2;
	}else{
		$median = $listdata[$jmlfrekuensi/2];
	}
	return $median;
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

?>