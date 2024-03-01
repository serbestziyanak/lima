<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
// exit; 

$islem				= array_key_exists( 'islem', $_REQUEST )		? $_REQUEST[ 'islem' ]		: 'ekle';
$personel_id		= array_key_exists( 'personel_id', $_REQUEST )	? $_REQUEST[ 'personel_id' ]	: 0;
$dil	 			= array_key_exists( 'dil', $_REQUEST ) 	? $_REQUEST[ 'dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

if( $_REQUEST[ 'pasaport_alis_tarihi' ] == '' ) $pasaport_alis_tarihi = NULL;
else $pasaport_alis_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'pasaport_alis_tarihi' ] ) );

if( $_REQUEST[ 'pasaport_bitis_tarihi' ] == '' ) $pasaport_bitis_tarihi = NULL;
else $pasaport_bitis_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'pasaport_bitis_tarihi' ] ) );

if( $_REQUEST[ 'sozlesme_baslama_tarihi' ] == '' ) $sozlesme_baslama_tarihi = NULL;
else $sozlesme_baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'sozlesme_baslama_tarihi' ] ) );

if( $_REQUEST[ 'sozlesme_bitis_tarihi' ] == '' ) $sozlesme_bitis_tarihi = NULL;
else $sozlesme_bitis_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'sozlesme_bitis_tarihi' ] ) );



$SQL_guncelle = <<< SQL
UPDATE
	tb_personeller
SET
	 pasaport_no				        = ?
	,pasaport_alis_tarihi				= ?
	,pasaport_bitis_tarihi				= ?
	,pasaportu_aldigi_ulke_id			= ?
	,pasaportu_veren_kurum_id			= ?
	,pasaport_dosya		                = ?
WHERE
	id = ?
SQL;

$SQL_resim_guncelle = <<<SQL
UPDATE
	tb_personeller
SET
	foto = ?
WHERE
	id = ?
SQL;

$SQL_tek_personel_id_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personeller 
WHERE 
	id  		= ? AND
	aktif 		= 1 
SQL;

$SQL_tek_personel_in_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personeller 
WHERE 
	in_no  = ? AND
	aktif 		  = 1 
SQL;


$SQL_sil = <<< SQL
UPDATE
	tb_personeller
SET
	aktif = ?
WHERE
	id = ?
SQL;

$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'guncelle':
		$tek_personel_oku = $vt->selectSingle( $SQL_tek_personel_id_oku, array( $personel_id ) ) [ 2 ];
	
		if( isset($_FILES["pasaport_dosya"]) and $_FILES["pasaport_dosya"]['size']>0 ){
			$pasaport_dosya = uniqid().basename($_FILES["pasaport_dosya"]["name"]);
			$target_dir = "../../belgeler/";
            $target_file = $target_dir . $pasaport_dosya;
            move_uploaded_file($_FILES["pasaport_dosya"]["tmp_name"], $target_file);
		}else{
			$pasaport_dosya = $tek_personel_oku['pasaport_dosya'];
		}

		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
             $_REQUEST[	'pasaport_no' ]
            ,$pasaport_alis_tarihi
            ,$pasaport_bitis_tarihi
            ,$_REQUEST[	'pasaportu_aldigi_ulke_id' ]
            ,$_REQUEST[	'pasaportu_veren_kurum_id' ]
            ,$pasaport_dosya
            ,$personel_id
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
		}
	break;
	case 'sil':
		$sorgu_sonuc = $vt->delete( $SQL_sil, array( 0, $personel_id ) );
		if( $sorgu_sonuc[ 0 ] ) $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinrken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
	break;
}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $personel_id;
header( "Location:../../index.php?modul=personelDetay&personel_id=$personel_id");
?>