<?php
//$content = file_get_contents('php://input');
$file = $_FILES['file'];
$res = $_POST['label'];
$arr = ['file'=>$file,'label'=>$res];
var_dump($arr);
//var_dump($content);
//$time = time();
//$result = move_uploaded_file($_FILES["file"]["tmp_name"], "public/upload/" .$time.'_'. $_FILES["file"]["name"]);
//if($result){
//    echo 1;
//}else{
//    echo 0;
//}