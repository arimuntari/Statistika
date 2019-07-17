<?php
$title = 'nbc';
$data = $_REQUEST['data'];
$attr = $_REQUEST['attr']; 
$text = $_REQUEST['text']; 
$textcari = $_REQUEST['textcari']; 
$class = $_REQUEST['class']; 

if(!empty($class)){
	$jenisclass = array_count_values($class);
	foreach($jenisclass as $key => $value){
		for($i=1;$i<=$data;$i++){
			if($class[$i] == $key){
				$listkata =  explode(' ', $text[$i] );
				foreach($listkata as $isikata){
					$listext[$key][] = ucfirst($isikata);
				}
			}
		}
		
	}
	//var_dump($listext);
	$listcari =  explode(' ', ucfirst($textcari) );
}
?>
<html>
<head>
<title>Tugas Statistika | Naive Bayes Classification</title>
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
	<form class="form-inline" action="naive-bayes-clasification.php" method="POST" autocomplete="off" >
		<div class="row">
			<div class="col-md-12">
				  <div class="form-group">
					<label for="data">Jumlah Data:</label>
					<input type="text" class="form-control input-sm" name="data" value="<?php echo $data;?>" placeholder="Jumlah Data ">
				  </div>
				  <button type="submit" class="btn btn-success btn-sm">Submit</button>
				  <hr>
			</div>
		</div>
		<?php 
		if(!empty($data) ){
		for($i=1;$i<=$data;$i++){
		?>
		<div class="row">
			<div class="col-md-12"  style="overflow:auto;white-space:nowrap;padding-bottom:10px;">
			  <div class="form-group">
			  </div>
			  <div class="form-group">
				<label for="data">Text <?php echo $i; ?></label><br>
				<input type="text" class="form-control input-sm" name="text[<?php echo $i; ?>]" size="80" value="<?php echo $text[$i];?>">
			  </div>
			  <div class="form-group">
				<label for="data">Class <?php echo $i; ?></label><br>
				<input type="text" class="form-control input-sm" name="class[<?php echo $i; ?>]" size="5" value="<?php echo $class[$i];?>">
			  </div>
			</div>
		</div>
		<?php }?>
		<div class="row">
			<div class="col-md-12"  style="overflow:auto;white-space:nowrap;padding-bottom:10px;">
			  <div class="form-group">
			  </div>
			  <div class="form-group">
				<label for="data">Text Dicari</label><br>
				<input type="text" class="form-control input-sm" name="textcari" size="80" value="<?php echo $textcari;?>">
			  </div>
			</div>
		</div>
			  <hr>
			 <button type="submit" class="btn btn-success btn-sm">Submit</button>
		<?php }?>
	</form>		
	<?Php 
	if(!empty($listcari)){
	?>
	<div class="row">
		<div class="col-md-12">
			<h3>Hasil</h3>
			<div class="table table-responsive">
				<table class="table">
					
					<tr>
						<?php foreach($jenisclass as $key=>$value){?>
						<td colspan="2">Perbandingan Ke <?php echo $key." : ".$value."/".array_sum($jenisclass); ?></td>
						<?php }?>
					</tr>
					<?php 
					foreach($listcari as $cari){
						$cari = ucfirst($cari);
					?>
					<tr>
						<?php 
							foreach($jenisclass as $key=>$value){
							
							$listtextperclass = array_count_values($listext[$key]);
							if(empty($listtextperclass[$cari])){
								$listtextperclass[$cari] = 0;
							}
							$hasil[$key][$cari] = ($listtextperclass[$cari]+1)/(count($listext[$key])+countAll($listext));
							?>
						<td><?php echo $cari; ?></td>
						<td><?php echo "(".$listtextperclass[$cari]." + 1)"."/"."(".count($listext[$key])."+".countAll($listext).") =".$hasil[$key][$cari] ; ?></td>
						<?php }?>
					</tr>
					<?php }?>
					<tr>
						<?php 
						$classakhir = '';
						$hasilakhir = 0;
							foreach($jenisclass as $key=>$value){
								$total = $value/array_sum($jenisclass)* multiple($hasil[$key]);
								if($hasilakhir<$total){
									$hasilakhir = $total;
									$classakhir = $key;
								}
						?>
						<td>Total :</td>
						<td> <?php echo "(".$value."/".array_sum($jenisclass)."*".multiple($hasil[$key]).")"." = ".($value/array_sum($jenisclass)* multiple($hasil[$key])) ;?> </td>
						<?php 
							}
						?>
					</tr>
					<tr>
						<td colspan="4">Hasil: <?php echo $classakhir."(".$hasilakhir.")";?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
	</body>
</html>
<?php
function countAll($listdata){
	$count = 0;
	foreach( $listdata as $data){
		$count += count( $data);
	}
	return $count;
}
function multiple($listdata){
	$hasil = 1;
	foreach($listdata as $data){
		$hasil = $hasil*$data;
	}
	return $hasil;
}
?>