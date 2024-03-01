<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$islem				= array_key_exists( 'islem', $_REQUEST )			? $_REQUEST[ 'islem' ]			: 'ekle';
$id					= array_key_exists( 'id', $_REQUEST )	? $_REQUEST[ 'id' ]	: 0;
$personel_id		= array_key_exists( 'personel_id', $_REQUEST )	? $_REQUEST[ 'personel_id' ]	: 0;
$dil	 			= array_key_exists( 'dil', $_REQUEST ) 	? $_REQUEST[ 'dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

if( $_REQUEST[ 'baslama_tarihi' ] == '' ) $baslama_tarihi = NULL;
else $baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'baslama_tarihi' ] ) );

if( $_REQUEST[ 'bitis_tarihi' ] == '' ) $bitis_tarihi = NULL;
else $bitis_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'bitis_tarihi' ] ) );

if( $_REQUEST[ 'belge_tarihi' ] == '' ) $belge_tarihi = NULL;
else $belge_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'belge_tarihi' ] ) );

if( $_REQUEST[ 'emeklilik_tarihi' ] == '' ) $emeklilik_tarihi = NULL;
else $emeklilik_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'emeklilik_tarihi' ] ) );

echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
// exit;


$SQL_ekle = <<< SQL
INSERT INTO
	tb_personel_emekli_bilgileri
SET
     personel_id         			= ?
    ,egitim_ogretim_yili_id			= ?
    ,buyruk_id			= ?
    ,emeklilik_tarihi					= ?
    ,belge							= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_personel_emekli_bilgileri
SET
     personel_id         			= ?
    ,egitim_ogretim_yili_id			= ?
    ,buyruk_id			= ?
    ,emeklilik_tarihi				= ?
    ,belge							= ?
WHERE
	id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_personel_emekli_bilgileri
WHERE
	id = ?
SQL;

$SQL_tek_personel_emekli_bilgileri_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personel_emekli_bilgileri 
WHERE 
	id = ?
SQL;

$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':
		if( isset($_FILES["belge"]) and $_FILES["belge"]['size']>0 ){
			$belge = uniqid().basename($_FILES["belge"]["name"]);
			$target_dir = "../../belgeler/";
            $target_file = $target_dir . $belge;
            move_uploaded_file($_FILES["belge"]["tmp_name"], $target_file);
		}else{
			$belge = NULL;
		}

		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $_REQUEST[	'personel_id' ]
			,$_REQUEST[	'egitim_ogretim_yili_id' ]
			,$_REQUEST[	'buyruk_id' ]
			,$emeklilik_tarihi
			,$belge
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
		}	
	break;
	case 'guncelle':
        $tek_personel_emekli_bilgileri_oku = $vt->selectSingle( $SQL_tek_personel_emekli_bilgileri_oku, array( $id ) ) [ 2 ];
		if( isset($_FILES["belge"]) and $_FILES["belge"]['size']>0 ){
			$belge = uniqid().basename($_FILES["belge"]["name"]);
			$target_dir = "../../belgeler/";
            $target_file = $target_dir . $belge;
            move_uploaded_file($_FILES["belge"]["tmp_name"], $target_file);
		}else{
			$belge = $tek_personel_emekli_bilgileri_oku['belge'];
		}

		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 $_REQUEST[	'personel_id' ]
			,$_REQUEST[	'egitim_ogretim_yili_id' ]
			,$_REQUEST[	'buyruk_id' ]
			,$emeklilik_tarihi
			,$belge
			,$id
		) );
		
		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
		}	
	break;
	case 'sil':
		$sorgu_sonuc = $vt->delete( $SQL_sil, array( $id ) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}	

	break;
}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
header( "Location:../../index.php?modul=personelEmekliBilgileri&personel_id=".$personel_id );
?>