<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
//exit;
if( isset($_FILES["foto"]) and $_FILES["foto"]['size']>0 ){
list($genislik, $yukseklik) = getimagesize($_FILES["foto"]["tmp_name"]);
if( isset($_FILES["foto"]) and ($genislik != 1000 or $yukseklik != 600) and $_REQUEST['birim_id'] != 1 ){
$_SESSION[ 'sonuclar' ] = array( 'hata' => true, 'mesaj' => 'Eklediğiniz görsel 1000x600 boyutlarında olmalıdır.', 'id' => 0 );
header( "Location:../../index.php?modul=slaytlar&birim_id=".$_REQUEST['birim_id']."&birim_adi=".$_REQUEST['birim_adi']);
exit;
}}

$islem	= array_key_exists( 'islem', $_REQUEST )		? $_REQUEST[ 'islem' ]		: 'ekle';
$id		= array_key_exists( 'id', $_REQUEST )	? $_REQUEST[ 'id' ]	: 0;

if( $_REQUEST[ 'tarih' ] == '' ) $tarih = NULL;
else $tarih = date( 'Y-m-d', strtotime( $_REQUEST[ 'tarih' ] ) );

$SQL_ekle = <<< SQL
INSERT INTO
	tb_slaytlar
SET
	 foto			= ?
	,birim_id		= ?
	,baslik1		= ?
	,baslik1_kz		= ?
	,baslik1_en		= ?
	,baslik1_ru		= ?
	,baslik2		= ?
	,baslik2_kz		= ?
	,baslik2_en		= ?
	,baslik2_ru		= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_slaytlar
SET
	 birim_id		= ?
	,baslik1		= ?
	,baslik1_kz		= ?
	,baslik1_en		= ?
	,baslik1_ru		= ?
	,baslik2		= ?
	,baslik2_kz		= ?
	,baslik2_en		= ?
	,baslik2_ru		= ?
WHERE
	id = ?
SQL;

$SQL_foto_guncelle = <<< SQL
UPDATE
	tb_slaytlar
SET
	 foto		= ?
WHERE
	id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_slaytlar
WHERE
	id = ?
SQL;


$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':
		if( isset($_FILES["foto"]) and $_FILES["foto"]['size']>0 ){
			$dosya_adi = uniqid().str_replace(" ","",basename($_FILES["foto"]["name"]));
			$target_dir = "../../resimler/slaytlar/";
			$target_file = $target_dir . $dosya_adi;
			move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
		}else{
			$dosya_adi = "";
		}

		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $dosya_adi
			,$_REQUEST['birim_id']
			,$_REQUEST['baslik1']
			,$_REQUEST['baslik1_kz']
			,$_REQUEST['baslik1_en']
			,$_REQUEST['baslik1_ru']
			,$_REQUEST['baslik2']
			,$_REQUEST['baslik2_kz']
			,$_REQUEST['baslik2_en']
			,$_REQUEST['baslik2_ru']
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}
		$id = $sorgu_sonuc[ 2 ]; 
	break;
	case 'guncelle':	
		$sorgu_sonuc = $vt->insert( $SQL_guncelle, array(
			 $_REQUEST['birim_id']
			,$_REQUEST['baslik1']
			,$_REQUEST['baslik1_kz']
			,$_REQUEST['baslik1_en']
			,$_REQUEST['baslik1_ru']
			,$_REQUEST['baslik2']
			,$_REQUEST['baslik2_kz']
			,$_REQUEST['baslik2_en']
			,$_REQUEST['baslik2_ru']
			,$id
		) );

		if( isset($_FILES["foto"]) and $_FILES["foto"]['size']>0 ){
			$dosya_adi = uniqid().str_replace(" ","",basename($_FILES["foto"]["name"]));
			$target_dir = "../../resimler/slaytlar/";
			$target_file = $target_dir . $dosya_adi;
			move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

			$sorgu_sonuc2 = $vt->update( $SQL_foto_guncelle, array(
				 $dosya_adi
				,$id
			) );

		}

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
		}
	break;
	case 'sil':
		//Silinecek olan tarife giriş yapılan firmaya mı ait oldugu kontrol ediliyor Eger firmaya ait ise silinecektir.
			$sorgu_sonuc = $vt->delete( $SQL_sil, array( $id ) );
			unlink("../../resimler/slaytlar/".$_REQUEST['foto']);
			if( $sorgu_sonuc[ 0 ] ) $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinrken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );

}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
header( "Location:../../index.php?modul=slaytlar&birim_id=".$_REQUEST['birim_id']."&birim_adi=".$_REQUEST['birim_adi']);
?>