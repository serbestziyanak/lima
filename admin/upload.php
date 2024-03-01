<?php 
include "_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();



$target_dir = "tmp_galeri/";
$on_ek = date("Y-m-d")."_".$_SESSION[ 'kullanici_id' ];
$dosya_adi = $on_ek."_".basename($_FILES["file"]["name"]);
$target_file = $target_dir .$dosya_adi;

if( $_REQUEST['islem'] == "sil"  ){
    unlink($target_dir.$on_ek."_".$_REQUEST['name']);
}

if( $_REQUEST['islem'] == "tumunu_sil"  ){
    $files = glob($target_dir.$on_ek."_*");
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    } 
}

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $status = 1;
    $sonuc["on_ek"] = $on_ek;
    $sonuc["dosya_adi"] = $dosya_adi;
    echo json_encode($sonuc);
}


?>