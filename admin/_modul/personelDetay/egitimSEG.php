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
	 in_no						= ?
	,vatandaslik_no				= ?
	,adi$dil					= ?
	,soyadi$dil					= ?
	,baba_adi$dil				= ?
	,uyruk_id					= ?
	,cinsiyet					= ?
	,dogum_tarihi				= ?
	,dogum_yeri$dil				= ?
	,dogdugu_ulke_id			= ?
	,ulus_id        			= ?
	,kan_grubu_id				= ?
	,engel_durumu				= ?
	,engel_turu$dil				= ?
	,medeni_durumu				= ?
	,vatandaslik_belgesi		= ?
	,engel_belgesi				= ?
	,sifre						= ?
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
		if( $_REQUEST['sifre'] == $tek_personel_oku['sifre'] ){
			$sifre = $_REQUEST['sifre'];
		}else{
			$sifre = md5($_REQUEST['sifre']);
		}		
		if( isset($_FILES["engel_belgesi"]) and $_FILES["engel_belgesi"]['size']>0 ){
			$engel_belgesi = uniqid().basename($_FILES["engel_belgesi"]["name"]);
			$target_dir = "../../belgeler/";
            $target_file = $target_dir . $engel_belgesi;
            move_uploaded_file($_FILES["engel_belgesi"]["tmp_name"], $target_file);
		}else{
			$engel_belgesi = $tek_personel_oku['engel_belgesi'];
		}
		if( isset($_FILES["vatandaslik_belgesi"]) and $_FILES["vatandaslik_belgesi"]['size']>0 ){
			$vatandaslik_belgesi = uniqid().basename($_FILES["vatandaslik_belgesi"]["name"]);
			$target_dir = "../../belgeler/";
            $target_file = $target_dir . $vatandaslik_belgesi;
            move_uploaded_file($_FILES["vatandaslik_belgesi"]["tmp_name"], $target_file);
		}else{
			$vatandaslik_belgesi = $tek_personel_oku['vatandaslik_belgesi'];
		}
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
             $_REQUEST[	'in_no' ]
            ,$_REQUEST[	'vatandaslik_no' ]
            ,$_REQUEST[	'adi' ]
            ,$_REQUEST[	'soyadi' ]
            ,$_REQUEST[	'baba_adi' ]
            ,$_REQUEST[	'uyruk_id' ]
            ,$_REQUEST[	'cinsiyet' ]
            ,$dogum_tarihi
            ,$_REQUEST[	'dogum_yeri' ]
            ,$_REQUEST[	'dogdugu_ulke_id' ]
            ,$_REQUEST[	'ulus_id' ]
            ,$_REQUEST[	'kan_grubu_id' ]
            ,$_REQUEST[	'engel_durumu' ]
            ,$_REQUEST[	'engel_turu' ]
            ,$_REQUEST[	'medeni_durumu' ]
            ,$vatandaslik_belgesi
            ,$engel_belgesi
            ,$sifre
            ,$personel_id
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
			$resim_adi = "personel_".uniqid($personel_id.'_');
			$resim_sonuc = $fn->personelResimYukle( 'input_personel_resim', $resim_adi );
			if( $resim_sonuc[ 0 ] ) {
				$vt->update( $SQL_resim_guncelle, array( $resim_sonuc[ 1 ], $personel_id ) );
                $fn->fn_resize("../../resimler/personel_resimler/".$resim_sonuc[ 1 ],"../../resimler/personel_resimler/".$resim_sonuc[ 1 ], 1000);
				if( $tek_personel_oku['resim'] != "resim_yok.png" ){
					unlink(dirname(__FILE__)."/../../resimler/personel_resimler/".$tek_personel_oku['resim']);
				}
			}
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