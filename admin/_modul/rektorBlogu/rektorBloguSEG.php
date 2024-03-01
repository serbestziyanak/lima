<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$islem				= array_key_exists( 'islem', $_REQUEST )			? $_REQUEST[ 'islem' ]			: 'ekle';
$id					= array_key_exists( 'id', $_REQUEST )	? $_REQUEST[ 'id' ]	: 0;

var_dump($_REQUEST);
//exit;
$SQL_ekle = <<< SQL
INSERT INTO
	tb_rektor_blogu
SET
	 mesaj						= ?
	,adi_kz						= ?
	,adi_en						= ?
	,adi_ru						= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_rektor_blogu
SET
	 mesaj						= ?
	,cevap						= ?
	,yayin						= ?
	,personel_id				= ?
	,cevap_tarihi   			= now()
WHERE
	id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_rektor_blogu
WHERE
	id = ?
SQL;

$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {

	case 'guncelle':
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			 $_REQUEST[	'mesaj' ]
			,$_REQUEST[	'cevap' ]
			,isset($_REQUEST['yayin'])*1
			,$_REQUEST['personel_id']
			,$id
		) );
		
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
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
		}	

	break;
}
$_SESSION[ 'sonuclar' ] 		= $___islem_sonuc;
$_SESSION[ 'sonuclar' ][ 'id' ] = $id;
header( "Location:../../index.php?modul=rektorBlogu" );
?>