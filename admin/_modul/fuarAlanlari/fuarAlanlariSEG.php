<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$islem				= array_key_exists( 'islem', $_REQUEST )			? $_REQUEST[ 'islem' ]			: 'ekle';
$id					= array_key_exists( 'id', $_REQUEST )	? $_REQUEST[ 'id' ]	: 0;


$SQL_ekle = <<< SQL
INSERT INTO
	tb_fuar_alanlari
SET
     map = ?
     ,tel = ?
SQL;

$SQL_ekle_dil = <<< SQL
INSERT INTO
	tb_fuar_alanlari_dil
SET
     fuar_alani_id   = ? 
    ,dil_id             = ? 
	,adi	            = ?
	,adres	            = ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_fuar_alanlari
SET
     map = ?
     ,tel = ?
WHERE
	id = ?
SQL;

$SQL_guncelle_dil = <<< SQL
UPDATE
	tb_fuar_alanlari_dil
SET
	 adi = ?
	,adres = ?
WHERE
	fuar_alani_id = ? AND dil_id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_fuar_alanlari
WHERE
	id = ?
SQL;
$SQL_sil_dil = <<< SQL
DELETE FROM
	tb_fuar_alanlari_dil
WHERE
	fuar_alani_id = ?
SQL;

$SQL_dil_var_mi = <<< SQL
SELECT 
    *
FROM
	tb_fuar_alanlari_dil
WHERE
	fuar_alani_id = ? AND dil_id = ?
SQL;
$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':
		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
            $_REQUEST[	'map' ]
            ,$_REQUEST[	'tel' ]
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
            $sorgu_sonuc = $vt->insert( $SQL_ekle_dil, array(
                 $son_eklenen_id
                ,$_REQUEST[	'dil_id' ]
                ,$_REQUEST[	'adi' ]
                ,$_REQUEST[	'adres' ]
            ) );
		}	
	break;
	case 'guncelle':
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
            $_REQUEST[	'map' ]
            ,$_REQUEST[	'tel' ]
			,$id
		) );
        $dil_varmi = $vt->select( $SQL_dil_var_mi, array( $id, $_REQUEST[	'dil_id' ] ) )[ 2 ];
        if( count( $dil_varmi ) > 0 ){
            $sorgu_sonuc = $vt->update( $SQL_guncelle_dil, array(
                $_REQUEST[	'adi' ]
                ,$_REQUEST[	'adres' ]
                ,$id
                ,$_REQUEST[	'dil_id' ]
            ) );
        }else{
            $sorgu_sonuc = $vt->insert( $SQL_ekle_dil, array(
                 $id
                ,$_REQUEST[	'dil_id' ]
                ,$_REQUEST[	'adi' ]
                ,$_REQUEST[	'adres' ]
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
header( "Location:../../index.php?modul=fuarAlanlari" );
?>