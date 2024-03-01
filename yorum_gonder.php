<?php
include "admin/_cekirdek/fonksiyonlar.php";
$vt = new VeriTabani();
$fn = new Fonksiyonlar();

$SQL_ceviriler = <<< SQL
SELECT
  *
FROM 
  tb_ceviriler
SQL;
@$ceviriler	            = $vt->select($SQL_ceviriler, array(  ) )[ 2 ];
foreach( $ceviriler as $ceviri ){
    $dizi_dil[$ceviri['adi']]['tr'] = $ceviri['adi']; 
    $dizi_dil[$ceviri['adi']]['kz'] = $ceviri['adi_kz']; 
    $dizi_dil[$ceviri['adi']]['en'] = $ceviri['adi_en']; 
    $dizi_dil[$ceviri['adi']]['ru'] = $ceviri['adi_ru']; 
}

function dil_cevir( $metin, $dizi, $dil ){
	if( array_key_exists( $metin, $dizi ) and $dizi[$metin][$dil] != "" )
		return $dizi[$metin][$dil];
	else
		return $metin;
}

$SQL_ekle = <<< SQL
INSERT
	tb_rektor_blogu
SET
	 adi_soyadi					= ?
	,email						= ?
	,mesaj						= ?
	,mesaj_tarihi   			= now()
SQL;

$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
     $_REQUEST[	'adi_soyadi' ]
    ,$_REQUEST[	'email' ]
    ,$_REQUEST[	'mesaj' ]
) );

if( $sorgu_sonuc[ 0 ] ){
    echo dil_cevir( "Mesajınız gönderilemedi!", $dizi_dil, $_REQUEST["dil"] );
}else{
    echo dil_cevir( "Mesajınız gönderildi", $dizi_dil, $_REQUEST["dil"] );
}
?>