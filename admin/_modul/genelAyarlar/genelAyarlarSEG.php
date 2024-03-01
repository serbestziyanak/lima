<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$dil	 			= array_key_exists( 'dil', $_REQUEST ) 	? $_REQUEST[ 'dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";

if(basename($_FILES["logo"]["name"])=="")
echo "yok";
else
	echo "var";
//exit;

$islem		= array_key_exists( 'islem', $_REQUEST )		? $_REQUEST[ 'islem' ]		: 'ekle';
$birim_id 	= array_key_exists( 'birim_id', $_REQUEST )	? $_REQUEST[ 'birim_id' ]	: 0;

if( $_REQUEST[ 'tarih' ] == '' ) $tarih = NULL;
else $tarih = date( 'Y-m-d', strtotime( $_REQUEST[ 'tarih' ] ) );

$SQL_ekle = <<< SQL
INSERT INTO
	tb_genel_ayarlar
SET
	 birim_id				= ?
	,logo$dil				= ?
	,slogan$dil				= ?
	,footer_logo			= ?
	,birim_icon				= ?
	,map					= ?
	,adres$dil				= ?
	,tel					= ?
	,email					= ?
	,facebook				= ?
	,twitter				= ?
	,instagram				= ?
	,linkedin				= ?
	,youtube				= ?
	,anasayfa_baslik$dil	= ?
	,anasayfa_icerik$dil	= ?
	,sayac1					= ?
	,sayac2					= ?
	,sayac3					= ?
	,sayac4					= ?
	,slogan2$dil			= ?
	,slogan3$dil			= ?
	,buton_url1 			= ?
	,buton_url2 			= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_genel_ayarlar
SET
	 logo$dil				= ?
	,slogan$dil				= ?
	,footer_logo			= ?
	,birim_icon				= ?
	,map					= ?
	,adres$dil				= ?
	,tel					= ?
	,email					= ?
	,facebook				= ?
	,twitter				= ?
	,instagram				= ?
	,linkedin				= ?
	,youtube				= ?
	,anasayfa_baslik$dil	= ?
	,anasayfa_icerik$dil	= ?
	,sayac1					= ?
	,sayac2					= ?
	,sayac3					= ?
	,sayac4					= ?
	,slogan2$dil			= ?
	,slogan3$dil			= ?
	,buton_url1 			= ?
	,buton_url2 			= ?
WHERE
	birim_id = ?
SQL;



$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':	
		$target_dir = "../../resimler/logolar/";
		$logo = $_REQUEST['logo_eski'];
		$footer_logo = $_REQUEST['footer_logo_eski'];
		$birim_icon = $_REQUEST['birim_icon_eski'];

		if(basename($_FILES["logo"]["name"])!=""){
			$logo = "logo_".uniqid().basename($_FILES["logo"]["name"]);
			$target_file = $target_dir . $logo;
			move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
		}
		if(basename($_FILES["footer_logo"]["name"])!=""){
			$footer_logo = "footer_logo_".uniqid().basename($_FILES["footer_logo"]["name"]);
			$target_file = $target_dir . $footer_logo;
			move_uploaded_file($_FILES["footer_logo"]["tmp_name"], $target_file);
		}
		if(basename($_FILES["birim_icon"]["name"])!=""){
			$birim_icon = "birim_icon_".uniqid().basename($_FILES["birim_icon"]["name"]);
			$target_file = $target_dir . $birim_icon;
			move_uploaded_file($_FILES["birim_icon"]["tmp_name"], $target_file);
		}

		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $birim_id
			,$logo
			,$_REQUEST[	'slogan' ]
			,$footer_logo
			,$birim_icon
			,$_REQUEST[	'map' ]
			,$_REQUEST[	'adres' ]
			,$_REQUEST[	'tel' ]
			,$_REQUEST[	'email' ]
			,$_REQUEST[	'facebook' ]
			,$_REQUEST[	'twitter' ]
			,$_REQUEST[	'instagram' ]
			,$_REQUEST[	'linkedin' ]
			,$_REQUEST[	'youtube' ]
			,$_REQUEST[	'anasayfa_baslik' ]
			,$_REQUEST[	'anasayfa_icerik' ]
			,$_REQUEST[ 'sayac1' ]
			,$_REQUEST[ 'sayac2' ]
			,$_REQUEST[ 'sayac3' ]
			,$_REQUEST[ 'sayac4' ]
			,$_REQUEST[ 'slogan2' ]
			,$_REQUEST[ 'slogan3' ]
			,$_REQUEST[ 'buton_url1' ]
			,$_REQUEST[ 'buton_url2' ]
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
		}
	break;
	case 'guncelle':	
		$target_dir = "../../resimler/logolar/";
		$logo = $_REQUEST['logo_eski'];
		$footer_logo = $_REQUEST['footer_logo_eski'];
		$birim_icon = $_REQUEST['birim_icon_eski'];

		if(basename($_FILES["logo"]["name"])!=""){
			$logo = "logo_".uniqid().basename($_FILES["logo"]["name"]);
			$target_file = $target_dir . $logo;
			move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
		}
		if(basename($_FILES["footer_logo"]["name"])!=""){
			$footer_logo = "footer_logo_".uniqid().basename($_FILES["footer_logo"]["name"]);
			$target_file = $target_dir . $footer_logo;
			move_uploaded_file($_FILES["footer_logo"]["tmp_name"], $target_file);
		}
		if(basename($_FILES["birim_icon"]["name"])!=""){
			$birim_icon = "birim_icon_".uniqid().basename($_FILES["birim_icon"]["name"]);
			$target_file = $target_dir . $birim_icon;
			move_uploaded_file($_FILES["birim_icon"]["tmp_name"], $target_file);
		}

		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 $logo
			,$_REQUEST[	'slogan' ]
			,$footer_logo
			,$birim_icon
			,$_REQUEST[	'map' ]
			,$_REQUEST[	'adres' ]
			,$_REQUEST[	'tel' ]
			,$_REQUEST[	'email' ]
			,$_REQUEST[	'facebook' ]
			,$_REQUEST[	'twitter' ]
			,$_REQUEST[	'instagram' ]
			,$_REQUEST[	'linkedin' ]
			,$_REQUEST[	'youtube' ]
			,$_REQUEST[	'anasayfa_baslik' ]
			,$_REQUEST[	'anasayfa_icerik' ]
			,$_REQUEST[ 'sayac1' ]
			,$_REQUEST[ 'sayac2' ]
			,$_REQUEST[ 'sayac3' ]
			,$_REQUEST[ 'sayac4' ]
			,$_REQUEST[ 'slogan2' ]
			,$_REQUEST[ 'slogan3' ]
			,$_REQUEST[ 'buton_url1' ]
			,$_REQUEST[ 'buton_url2' ]
			,$birim_id
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
		}
	break;

}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
header( "Location:../../index.php?modul=genelAyarlar&islem=guncelle&birim_id=".$_REQUEST['birim_id']."&birim_adi=".$_REQUEST['birim_adi']);
?>