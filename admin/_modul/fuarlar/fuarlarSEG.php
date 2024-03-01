<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$islem				= array_key_exists( 'islem', $_REQUEST )			? $_REQUEST[ 'islem' ]			: 'ekle';
$id					= array_key_exists( 'id', $_REQUEST )	? $_REQUEST[ 'id' ]	: 0;

$fuar_sorumlu_idler = implode(",", $_REQUEST[ 'fuar_sorumlu_idler' ]);
if( $_REQUEST[ 'baslama_tarihi' ] == '' ) $baslama_tarihi = NULL;
else $baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'baslama_tarihi' ] ) );

if( $_REQUEST[ 'bitis_tarihi' ] == '' ) $bitis_tarihi = NULL;
else $bitis_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'bitis_tarihi' ] ) );


$SQL_ekle = <<< SQL
INSERT INTO
	tb_fuarlar
SET
     fuar_tanim_id                      = ?
    ,fuar_sorumlu_idler                 = ?
    ,bolge_id                           = ?
    ,ulke_id                            = ?
    ,sehir_id                           = ?
    ,fuar_alani_id                      = ?
    ,para_birimi_id                     = ?
    ,fuar_web_sitesi                    = ?
    ,toplam_katilimci_sayisi            = ?
    ,turkiyeden_katilimci_sayisi        = ?
    ,baslama_tarihi                     = ?
    ,bitis_tarihi                       = ?
    ,buyuk_expo_fiyat                   = ?
    ,kucuk_expo_fiyat                   = ?
    ,koli_fiyat                         = ?
    ,ekleme_tarihi                      = now()
    ,ekleyen_id                         = ?
SQL;

$SQL_ekle_dil = <<< SQL
INSERT INTO
	tb_fuarlar_dil
SET
     dil_id          = ?
    ,fuar_id        = ?
    ,adi            = ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_fuarlar
SET
     fuar_tanim_id                      = ?
    ,fuar_sorumlu_idler                 = ?
    ,bolge_id                           = ?
    ,ulke_id                            = ?
    ,sehir_id                           = ?
    ,fuar_alani_id                      = ?
    ,para_birimi_id                     = ?
    ,fuar_web_sitesi                    = ?
    ,toplam_katilimci_sayisi            = ?
    ,turkiyeden_katilimci_sayisi        = ?
    ,baslama_tarihi                     = ?
    ,bitis_tarihi                       = ?
    ,buyuk_expo_fiyat                   = ?
    ,kucuk_expo_fiyat                   = ?
    ,koli_fiyat                         = ?
    ,guncelleme_tarihi                  = now()
    ,guncelleyen_id                     = ?
WHERE
	id = ?
SQL;

$SQL_guncelle_dil = <<< SQL
UPDATE
	tb_fuarlar_dil
SET
     adi            = ?
WHERE
	fuar_id = ? AND dil_id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_fuarlar
WHERE
	id = ?
SQL;

$SQL_sil_dil = <<< SQL
DELETE FROM
	tb_fuarlar_dil
WHERE
	fuar_id = ?
SQL;

$SQL_dil_var_mi = <<< SQL
SELECT 
    *
FROM
	tb_fuarlar_dil
WHERE
	fuar_id = ? AND dil_id = ?
SQL;




$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':
		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
            $_REQUEST[	'fuar_tanim_id' ]
           ,$fuar_sorumlu_idler
           ,$_REQUEST[	'bolge_id' ]
           ,$_REQUEST[	'ulke_id' ]
           ,$_REQUEST[	'sehir_id' ]
           ,$_REQUEST[	'fuar_alani_id' ]
           ,$_REQUEST[	'para_birimi_id' ]
           ,$_REQUEST[	'fuar_web_sitesi' ]
           ,$_REQUEST[	'toplam_katilimci_sayisi' ]
           ,$_REQUEST[	'turkiyeden_katilimci_sayisi' ]
           ,$baslama_tarihi
           ,$bitis_tarihi
           ,$_REQUEST[	'buyuk_expo_fiyat' ]
           ,$_REQUEST[	'kucuk_expo_fiyat' ]
           ,$_REQUEST[	'koli_fiyat' ]
           ,$_SESSION[ 'kullanici_id' ]
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
            $sorgu_sonuc = $vt->insert( $SQL_ekle_dil, array(
                 $_REQUEST[	'dil_id' ]
                ,$son_eklenen_id
                ,$_REQUEST[	'adi' ]
            ) );
		}	
	break;
	case 'guncelle':
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
             $_REQUEST[	'fuar_tanim_id' ]
            ,$fuar_sorumlu_idler
            ,$_REQUEST[	'bolge_id' ]
            ,$_REQUEST[	'ulke_id' ]
            ,$_REQUEST[	'sehir_id' ]
            ,$_REQUEST[	'fuar_alani_id' ]
            ,$_REQUEST[	'para_birimi_id' ]
            ,$_REQUEST[	'fuar_web_sitesi' ]
            ,$_REQUEST[	'toplam_katilimci_sayisi' ]
            ,$_REQUEST[	'turkiyeden_katilimci_sayisi' ]
            ,$baslama_tarihi
            ,$bitis_tarihi
            ,$_REQUEST[	'buyuk_expo_fiyat' ]
            ,$_REQUEST[	'kucuk_expo_fiyat' ]
            ,$_REQUEST[	'koli_fiyat' ]
            ,$_SESSION[ 'kullanici_id' ]
			,$id
		) );
        $dil_varmi = $vt->select( $SQL_dil_var_mi, array( $id, $_REQUEST[	'dil_id' ] ) )[ 2 ];
        if( count( $dil_varmi ) > 0 ){
            $sorgu_sonuc = $vt->update( $SQL_guncelle_dil, array(
                 $_REQUEST[	'adi' ]
                ,$id
                ,$_REQUEST[	'dil_id' ]
            ) );

        }else{
            $sorgu_sonuc = $vt->insert( $SQL_ekle_dil, array(
                 $_REQUEST[	'dil_id' ]
                ,$id
                ,$_REQUEST[	'adi' ]
            ) );
        }

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}	
	break;
	case 'sil':
		$sorgu_sonuc = $vt->delete( $SQL_sil, array( $id ) );
		$sorgu_sonuc = $vt->delete( $SQL_sil_dil, array( $id ) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
		}	

	break;
}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
header( "Location:../../index.php?modul=fuarlar&islem=guncelle&id=$id" );
?>