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



$SQL_ekle_dil = <<< SQL
INSERT INTO
	tb_fuarlar_dil
SET
     dil_id          = ?
    ,diger_notlar       = ?
SQL;



$SQL_guncelle_dil = <<< SQL
UPDATE
	tb_fuarlar_dil
SET
    diger_notlar       = ?
WHERE
	fuar_id = ? AND dil_id = ?
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
	case 'guncelle':
        $dil_varmi = $vt->select( $SQL_dil_var_mi, array( $id, $_REQUEST[	'dil_id' ] ) )[ 2 ];
        if( count( $dil_varmi ) > 0 ){
            $sorgu_sonuc = $vt->update( $SQL_guncelle_dil, array(
                $_REQUEST[	'diger_notlar' ]
                ,$id
                ,$_REQUEST[	'dil_id' ]
            ) );

        }else{
            $sorgu_sonuc = $vt->insert( $SQL_ekle_dil, array(
                 $_REQUEST[	'dil_id' ]
                ,$id
                ,$_REQUEST[	'diger_notlar' ]
            ) );
        }

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt güncellenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
		}	
	break;
}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
header( "Location:../../index.php?modul=fuarlar&islem=guncelle&id=$id&aktif_tab=tab-notlar" );
?>