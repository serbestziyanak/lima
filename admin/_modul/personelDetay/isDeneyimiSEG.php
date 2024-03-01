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

if( $_REQUEST[ 'ilk_ise_baslama_tarihi' ] == '' ) $ilk_ise_baslama_tarihi = NULL;
else $ilk_ise_baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'ilk_ise_baslama_tarihi' ] ) );

if( $_REQUEST[ 'ayu_ise_baslama_tarihi' ] == '' ) $ayu_ise_baslama_tarihi = NULL;
else $ayu_ise_baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'ayu_ise_baslama_tarihi' ] ) );

if( $_REQUEST[ 'ogretmenlik_baslama_tarihi' ] == '' ) $ogretmenlik_baslama_tarihi = NULL;
else $ogretmenlik_baslama_tarihi = date( 'Y-m-d', strtotime( $_REQUEST[ 'ogretmenlik_baslama_tarihi' ] ) );



$SQL_guncelle = <<< SQL
UPDATE
	tb_personeller
SET
	 ilk_ise_baslama_tarihi				= ?
	,ayu_ise_baslama_tarihi				= ?
	,ogretmenlik_baslama_tarihi			= ?
WHERE
	id = ?
SQL;



$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'guncelle':

		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
             $ilk_ise_baslama_tarihi
            ,$ayu_ise_baslama_tarihi
            ,$ogretmenlik_baslama_tarihi
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