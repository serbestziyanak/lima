<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
echo "aktif_egitim_ogretim_yili_id ".$_SESSION[ 'aktif_egitim_ogretim_yili_id' ];
// exit;

$islem				= array_key_exists( 'islem', $_REQUEST )		? $_REQUEST[ 'islem' ]		: 'ekle';
$personel_id		= array_key_exists( 'personel_id', $_REQUEST )	? $_REQUEST[ 'personel_id' ]	: 0;
$dil	 			= array_key_exists( 'dil', $_REQUEST ) 	? $_REQUEST[ 'dil' ] : "";
$dil	 			= $dil == "_tr" ? "" : $dil;

if( $_REQUEST[ 'dogum_tarihi' ] == '' ) $dogum_tarihi = NULL;
else $dogum_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'dogum_tarihi' ] ) );

if( $_REQUEST[ 'baslama_tarihi' ] == '' ) $baslama_tarihi = NULL;
else $baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'baslama_tarihi' ] ) );

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
	,adi$dil					= ?
	,soyadi$dil					= ?
	,baba_adi$dil				= ?
	,uyruk_id					= ?
	,cinsiyet					= ?
	,personel_nitelik_id		= ?
	,email						= ?
	,gsm1						= ?
	,is_telefonu				= ?
	,dahili     				= ?
	,sifre						= ?
SQL;

$SQL_ekle2 = <<< SQL
INSERT INTO
	tb_personel_calisma_yeri_bilgileri
SET
     personel_id         			= ?
    ,egitim_ogretim_yili_id			= ?
    ,birim_id           			= ?
    ,personel_nitelik_id			= ?
    ,akademik_kadro_tipi_id			= ?
    ,idari_kadro_tipi_id			= ?
    ,akademik_derece_id	    		= ?
    ,akademik_unvan_id  			= ?
    ,baslama_tarihi       			= ?
    ,aktif_calisma_yeri       		= ?
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

$SQL_tek_personel_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personeller 
WHERE 
	aktif = 1 AND ( in_no  = ? OR email = ? )  
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

		$personel_varmi = $vt->select( $SQL_tek_personel_oku, array( $_REQUEST[ "in_no" ], $_REQUEST[ "email" ] ) )[2];
		if ( count( $personel_varmi ) < 1 ){
			$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
				 trim( $_REQUEST[	'in_no' ] )
				,trim( $_REQUEST[	'adi' ] )
				,trim( $_REQUEST[	'soyadi' ] )
				,trim( $_REQUEST[	'baba_adi' ] )
				,trim( $_REQUEST[	'uyruk_id' ] )
				,trim( $_REQUEST[	'cinsiyet' ] )
				,trim( $_REQUEST[	'personel_nitelik_id' ] )
				,trim( $_REQUEST[	'email' ] )
				,trim( $_REQUEST[	'gsm1' ] )
				,trim( $_REQUEST[	'is_telefonu' ] )
				,trim( $_REQUEST[	'dahili' ] )
				,md5( trim( $_REQUEST[ 'in_no' ] ) )
			) );
			if( $sorgu_sonuc[ 0 ] ){
				$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
			}else{
                $son_eklenen_id	= $sorgu_sonuc[ 2 ];
                $___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
                $resim_adi = "personel_".uniqid($son_eklenen_id.'_');
                $resim_sonuc = $fn->personelResimYukle( 'input_personel_resim', $resim_adi );
                if( $resim_sonuc[ 0 ] ) {
                    $vt->update( $SQL_resim_guncelle, array( $resim_sonuc[ 1 ], $son_eklenen_id ) );
                    $fn->fn_resize("../../resimler/personel_resimler/".$resim_sonuc[ 1 ],"../../resimler/personel_resimler/".$resim_sonuc[ 1 ], 1000);
                }
                $sorgu_sonuc = $vt->insert( $SQL_ekle2, array(
                    $son_eklenen_id
                    ,$_SESSION[ 'aktif_egitim_ogretim_yili_id' ]
                    ,$_REQUEST[	'birim_id' ]
                    ,$_REQUEST[	'personel_nitelik_id' ]
                    ,$_REQUEST[	'akademik_kadro_tipi_id' ]
                    ,$_REQUEST[	'idari_kadro_tipi_id' ]
                    ,$_REQUEST[	'akademik_derece_id' ]
                    ,$_REQUEST[	'akademik_unvan_id' ]
                    ,$baslama_tarihi
                    ,1
                ) );
                if( $sorgu_sonuc[ 0 ] ){
                    $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Çalışma yeri eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
                }

			}
		}else{
			$___islem_sonuc = array( 'hata' => true, 'mesaj' => 'Bu IIN No veya Email zaten kayıtlı..', 'id' => $sonuc[ 2 ] );
		}
			
	break;
	case 'sil':
		$sorgu_sonuc = $vt->delete( $SQL_sil, array( 0, $personel_id ) );
		if( $sorgu_sonuc[ 0 ] ) $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt silinrken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
	break;
}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $personel_id;
header( "Location:../../index.php?modul=personeller");
?>