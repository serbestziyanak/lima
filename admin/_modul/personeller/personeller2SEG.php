<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
//exit;

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


$SQL_ekle = <<< SQL
INSERT INTO
	tb_personeller
SET
	 in_no						= ?
	,vatandaslik_no				= ?
	,pasaport_no				= ?
	,birim_id					= ?
	,adi$dil					= ?
	,soyadi$dil					= ?
	,uyruk_id					= ?
	,cinsiyet					= ?
	,dogum_tarihi				= ?
	,kan_grubu_id				= ?
	,engel_durumu				= ?
	,engel_turu$dil				= ?
	,personel_turu_id			= ?
	,personel_nitelik_id		= ?
	,egitim_duzeyi_id			= ?
	,unvan_id					= ?
	,ise_baslama_tarihi			= ?
	,sozlesme_baslama_tarihi	= ?
	,sozlesme_bitis_tarihi		= ?
	,email						= ?
	,gsm1						= ?
	,gsm2						= ?
	,ev_adresi$dil				= ?
	,is_adresi$dil				= ?
	,oda_no 					= ?
	,is_telefonu				= ?
	,arac_plaka					= ?
	,medeni_durumu				= ?
	,orcid						= ?
	,scholar					= ?
	,avesis						= ?
	,profil_kisa_aciklama$dil	= ?
	,ozgecmis$dil				= ?
	,sifre						= ?
	,rol_id						= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_personeller
SET
	 in_no						= ?
	,vatandaslik_no				= ?
	,pasaport_no				= ?
	,birim_id					= ?
	,adi$dil					= ?
	,soyadi$dil					= ?
	,uyruk_id					= ?
	,cinsiyet					= ?
	,dogum_tarihi				= ?
	,kan_grubu_id				= ?
	,engel_durumu				= ?
	,engel_turu$dil				= ?
	,personel_turu_id			= ?
	,personel_nitelik_id		= ?
	,egitim_duzeyi_id			= ?
	,unvan_id					= ?
	,ise_baslama_tarihi			= ?
	,sozlesme_baslama_tarihi	= ?
	,sozlesme_bitis_tarihi		= ?
	,email						= ?
	,gsm1						= ?
	,gsm2						= ?
	,ev_adresi$dil				= ?
	,is_adresi$dil				= ?
	,oda_no 					= ?
	,is_telefonu				= ?
	,arac_plaka					= ?
	,medeni_durumu				= ?
	,orcid						= ?
	,scholar					= ?
	,avesis						= ?
	,profil_kisa_aciklama$dil	= ?
	,ozgecmis$dil				= ?
	,sifre						= ?
	,rol_id						= ?
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
	case 'ekle':

		$personel_varmi = $vt->select( $SQL_tek_personel_in_oku, array( $_REQUEST[ "in_no" ] ) )[2];
		if ( count( $personel_varmi ) < 1 ){
			$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
				 $_REQUEST[	'in_no' ]
				,$_REQUEST[	'vatandaslik_no' ]
				,$_REQUEST[	'pasaport_no' ]
				,$_REQUEST[	'birim_id' ]
				,$_REQUEST[	'adi' ]
				,$_REQUEST[	'soyadi' ]
				,$_REQUEST[	'uyruk_id' ]
				,$_REQUEST[	'cinsiyet' ]
				,$dogum_tarihi
				,$_REQUEST[	'kan_grubu_id' ]
				,$_REQUEST[	'engel_durumu' ]
				,$_REQUEST[	'engel_turu' ]
				,$_REQUEST[	'personel_turu_id' ]
				,$_REQUEST[	'personel_nitelik_id' ]
				,$_REQUEST[	'egitim_duzeyi_id' ]
				,$_REQUEST[	'unvan_id' ]
				,$ise_baslama_tarihi
				,$sozlesme_baslama_tarihi
				,$sozlesme_bitis_tarihi
				,$_REQUEST[	'email' ]
				,$_REQUEST[	'gsm1' ]
				,$_REQUEST[	'gsm2' ]
				,$_REQUEST[	'ev_adresi' ]
				,$_REQUEST[	'is_adresi' ]
				,$_REQUEST[	'oda_no' ]
				,$_REQUEST[	'is_telefonu' ]
				,$_REQUEST[	'arac_plaka' ]
				,$_REQUEST[	'medeni_durumu' ]
				,$_REQUEST[	'orcid' ]
				,$_REQUEST[	'scholar' ]
				,$_REQUEST[	'avesis' ]
				,$_REQUEST[	'profil_kisa_aciklama' ]
				,$_REQUEST[	'ozgecmis' ]
				,md5($_REQUEST[	'sifre' ])
				,$_REQUEST[	'rol_id' ]
			) );
			if( $sorgu_sonuc[ 0 ] ){
				$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
			}else{
				$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
				$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
				$personel_id = $son_eklenen_id;
				$resim_adi = "personel_".uniqid($personel_id.'_');
				$resim_sonuc = $fn->personelResimYukle( 'input_personel_resim', $resim_adi );
				if( $resim_sonuc[ 0 ] ) {
					$sorgu_sonuc = $vt->update( $SQL_resim_guncelle, array( $resim_sonuc[ 1 ], $son_eklenen_id ) );
				}
			}
		}else{
			$___islem_sonuc = array( 'hata' => true, 'mesaj' => 'Öğrenci Önceden Eklenmiş', 'id' => $sonuc[ 2 ] );
		}
			
	break;
	case 'guncelle':
		$tek_personel_oku = $vt->selectSingle( $SQL_tek_personel_id_oku, array( $personel_id ) ) [ 2 ];
		if( $_REQUEST['sifre'] == $tek_personel_oku['sifre'] ){
			$sifre = $_REQUEST['sifre'];
		}else{
			$sifre = md5($_REQUEST['sifre']);
		}		
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
				 $_REQUEST[	'in_no' ]
				,$_REQUEST[	'vatandaslik_no' ]
				,$_REQUEST[	'pasaport_no' ]
				,$_REQUEST[	'birim_id' ]
				,$_REQUEST[	'adi' ]
				,$_REQUEST[	'soyadi' ]
				,$_REQUEST[	'uyruk_id' ]
				,$_REQUEST[	'cinsiyet' ]
				,$dogum_tarihi
				,$_REQUEST[	'kan_grubu_id' ]
				,$_REQUEST[	'engel_durumu' ]
				,$_REQUEST[	'engel_turu' ]
				,$_REQUEST[	'personel_turu_id' ]
				,$_REQUEST[	'personel_nitelik_id' ]
				,$_REQUEST[	'egitim_duzeyi_id' ]
				,$_REQUEST[	'unvan_id' ]
				,$ise_baslama_tarihi
				,$sozlesme_baslama_tarihi
				,$sozlesme_bitis_tarihi
				,$_REQUEST[	'email' ]
				,$_REQUEST[	'gsm1' ]
				,$_REQUEST[	'gsm2' ]
				,$_REQUEST[	'ev_adresi' ]
				,$_REQUEST[	'is_adresi' ]
				,$_REQUEST[	'oda_no' ]
				,$_REQUEST[	'is_telefonu' ]
				,$_REQUEST[	'arac_plaka' ]
				,$_REQUEST[	'medeni_durumu' ]
				,$_REQUEST[	'orcid' ]
				,$_REQUEST[	'scholar' ]
				,$_REQUEST[	'avesis' ]
				,$_REQUEST[	'profil_kisa_aciklama' ]
				,$_REQUEST[	'ozgecmis' ]
				,$sifre
                ,$_REQUEST[	'rol_id' ]
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
if( $islem == "ekle" or $islem == "guncelle" )
header( "Location:../../index.php?modul=personeller&islem=guncelle&personel_id=$personel_id");
else
header( "Location:../../index.php?modul=personeller");
?>