<?php
$img = $_POST['foto']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
//echo var_dump($_POST);
$name = time().'.png';
echo $name;
file_put_contents('image/'.$name, $data);
?>