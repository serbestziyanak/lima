<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
//exit;

$islem		= array_key_exists( 'islem', $_REQUEST )		? $_REQUEST[ 'islem' ]		: 'ekle';
$birim_id 	= array_key_exists( 'birim_id', $_REQUEST )	? $_REQUEST[ 'birim_id' ]	: 0;

$SQL_ekle = <<< SQL
INSERT INTO
	tb_ceviriler
SET
	 turu					= ?
	,adi					= ?
	,adi_kz					= ?
	,adi_en					= ?
	,adi_ru					= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_ceviriler
SET
	 adi_kz					= ?
	,adi_en					= ?
	,adi_ru					= ?
WHERE
	turu = 1 AND id = ?
SQL;



$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':	
		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $_REQUEST[	'turu' ]
			,trim($_REQUEST[ 'adi' ])
			,trim($_REQUEST[ 'adi_kz' ])
			,trim($_REQUEST[ 'adi_en' ])
			,trim($_REQUEST[ 'adi_ru' ])
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
		}
	break;
	case 'guncelle':	
	foreach( $_REQUEST['id'] as $key=>$value ){
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 trim($_REQUEST[	'adi_kz' ][$key])
			,trim($_REQUEST[ 'adi_en' ][$key])
			,trim($_REQUEST[ 'adi_ru' ][$key])
			,$value
		) );
		}
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
		}
	break;

}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
header( "Location:../../index.php?modul=webCevirileri");
?>