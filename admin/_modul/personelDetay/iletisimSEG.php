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

if( $_REQUEST[ 'dogum_tarihi' ] == '' ) $dogum_tarihi = NULL;
else $dogum_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'dogum_tarihi' ] ) );

if( $_REQUEST[ 'ise_baslama_tarihi' ] == '' ) $ise_baslama_tarihi = NULL;
else $ise_baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'ise_baslama_tarihi' ] ) );

if( $_REQUEST[ 'sozlesme_baslama_tarihi' ] == '' ) $sozlesme_baslama_tarihi = NULL;
else $sozlesme_baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'sozlesme_baslama_tarihi' ] ) );

if( $_REQUEST[ 'sozlesme_bitis_tarihi' ] == '' ) $sozlesme_bitis_tarihi = NULL;
else $sozlesme_bitis_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'sozlesme_bitis_tarihi' ] ) );



$SQL_guncelle = <<< SQL
UPDATE
	tb_personeller
SET
	 gsm1				= ?
	,gsm2				= ?
	,email				= ?
	,email2				= ?
	,is_telefonu		= ?
	,dahili     		= ?
	,is_adresi$dil		= ?
	,bina_adi$dil		= ?
	,kat_no				= ?
	,oda_no				= ?
	,ev_adresi$dil		= ?
	,arac_plaka1		= ?
	,arac_plaka2		= ?
	,arac_plaka3		= ?
	,orcid		= ?
	,avesis		= ?
	,scholar		= ?
	,yerlesim_yeri_belgesi	= ?
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
	
		if( isset($_FILES["yerlesim_yeri_belgesi"]) and $_FILES["yerlesim_yeri_belgesi"]['size']>0 ){
			$yerlesim_yeri_belgesi = uniqid().basename($_FILES["yerlesim_yeri_belgesi"]["name"]);
			$target_dir = "../../belgeler/";
            $target_file = $target_dir . $yerlesim_yeri_belgesi;
            move_uploaded_file($_FILES["yerlesim_yeri_belgesi"]["tmp_name"], $target_file);
		}else{
			$yerlesim_yeri_belgesi = $tek_personel_oku['yerlesim_yeri_belgesi'];
		}

		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
             trim( $_REQUEST[	'gsm1' ] )
            ,trim( $_REQUEST[	'gsm2' ] )
            ,trim( $_REQUEST[	'email' ] )
            ,trim( $_REQUEST[	'email2' ] )
            ,trim( $_REQUEST[	'is_telefonu' ] )
            ,trim( $_REQUEST[	'dahili' ] )
            ,trim( $_REQUEST[	'is_adresi' ] )
            ,trim( $_REQUEST[	'bina_adi' ] )
            ,trim( $_REQUEST[	'kat_no' ] )
            ,trim( $_REQUEST[	'oda_no' ] )
            ,trim( $_REQUEST[	'ev_adresi' ] )
            ,trim( $_REQUEST[	'arac_plaka1' ] )
            ,trim( $_REQUEST[	'arac_plaka2' ] )
            ,trim( $_REQUEST[	'arac_plaka3' ] )
            ,trim( $_REQUEST[	'orcid' ] )
            ,trim( $_REQUEST[	'avesis' ] )
            ,trim( $_REQUEST[	'scholar' ] )
            ,$yerlesim_yeri_belgesi
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