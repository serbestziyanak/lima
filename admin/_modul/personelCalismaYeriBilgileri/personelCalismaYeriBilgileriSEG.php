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

$uzmanlik_alan_idler = implode(",", $_REQUEST[ 'uzmanlik_alan_idler' ]);


echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
// exit;


$SQL_ekle = <<< SQL
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
    ,bitis_tarihi         			= ?
    ,aktif_calisma_yeri    			= ?
    ,bilimsel_alan_id    			= ?
    ,uzmanlik_alan_idler   			= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
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
    ,bitis_tarihi         			= ?
    ,aktif_calisma_yeri    			= ?
    ,bilimsel_alan_id    			= ?
    ,uzmanlik_alan_idler   			= ?
WHERE
	id = ?
SQL;

$SQL_aktif_calisma_yeri_guncelle = <<< SQL
UPDATE
	tb_personel_calisma_yeri_bilgileri
SET
    aktif_calisma_yeri = 0
WHERE
	personel_id = ? and id != ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_personel_calisma_yeri_bilgileri
WHERE
	id = ?
SQL;

$SQL_tek_personel_calisma_yeri_bilgileri_oku = <<< SQL
SELECT 
	*
FROM 
	tb_personel_calisma_yeri_bilgileri 
WHERE 
	id = ?
SQL;

$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':
		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $_REQUEST[	'personel_id' ]
			,$_REQUEST[	'egitim_ogretim_yili_id' ]
			,$_REQUEST[	'birim_id' ]
			,$_REQUEST[	'personel_nitelik_id' ]
			,$_REQUEST[	'akademik_kadro_tipi_id' ]
			,$_REQUEST[	'idari_kadro_tipi_id' ]
			,$_REQUEST[	'akademik_derece_id' ]
			,$_REQUEST[	'akademik_unvan_id' ]
			,$baslama_tarihi
			,$bitis_tarihi
			,$_REQUEST[	'aktif_calisma_yeri' ]
			,$_REQUEST[	'bilimsel_alan_id' ]
			,$uzmanlik_alan_idler
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
			if( $_REQUEST[	'aktif_calisma_yeri' ] == 1 ){
				$sorgu_sonuc = $vt->update( $SQL_aktif_calisma_yeri_guncelle, array(
					$_REQUEST[	'personel_id' ]
					,$son_eklenen_id
				) );
			}

		}	
	break;
	case 'guncelle':
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 $_REQUEST[	'personel_id' ]
			,$_REQUEST[	'egitim_ogretim_yili_id' ]
			,$_REQUEST[	'birim_id' ]
			,$_REQUEST[	'personel_nitelik_id' ]
			,$_REQUEST[	'akademik_kadro_tipi_id' ]
			,$_REQUEST[	'idari_kadro_tipi_id' ]
			,$_REQUEST[	'akademik_derece_id' ]
			,$_REQUEST[	'akademik_unvan_id' ]
			,$baslama_tarihi
			,$bitis_tarihi
			,$_REQUEST[	'aktif_calisma_yeri' ]
			,$_REQUEST[	'bilimsel_alan_id' ]
			,$uzmanlik_alan_idler
			,$id
		) );
        if( $_REQUEST[	'aktif_calisma_yeri' ] == 1 ){
            $sorgu_sonuc = $vt->update( $SQL_aktif_calisma_yeri_guncelle, array(
                $_REQUEST[	'personel_id' ]
                ,$id
            ) );
        }
		
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
header( "Location:../../index.php?modul=personelCalismaYeriBilgileri&personel_id=".$personel_id );
?>