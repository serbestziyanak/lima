<?php
include "../../_cekirdek/fonksiyonlar.php";
$vt		= new VeriTabani();
$fn		= new Fonksiyonlar();

$islem				= array_key_exists( 'islem', $_REQUEST )			? $_REQUEST[ 'islem' ]			: 'ekle';
$id					= array_key_exists( 'id', $_REQUEST )	? $_REQUEST[ 'id' ]	: 0;


$SQL_ekle = <<< SQL
INSERT INTO
	tb_onemli_baglantilar
SET
	 foto						= ?
	,link						= ?
SQL;

$SQL_guncelle = <<< SQL
UPDATE
	tb_onemli_baglantilar
SET
	 link						= ?
WHERE
	id = ?
SQL;

$SQL_foto_guncelle = <<< SQL
UPDATE
	tb_onemli_baglantilar
SET
	 foto		= ?
WHERE
	id = ?
SQL;

$SQL_sil = <<< SQL
DELETE FROM
	tb_onemli_baglantilar
WHERE
	id = ?
SQL;

$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => 0 );

switch( $islem ) {
	case 'ekle':
		if( isset($_FILES["foto"]) and $_FILES["foto"]['size']>0 ){
			$dosya_adi = uniqid().basename($_FILES["foto"]["name"]);
			$target_dir = "../../resimler/logolar/";
			$target_file = $target_dir . $dosya_adi;
			move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
		}else{
			$dosya_adi = "";
		}

		$sorgu_sonuc = $vt->insert( $SQL_ekle, array(
			 $dosya_adi
			,$_REQUEST[	'link' ]
		) );

		if( $sorgu_sonuc[ 0 ] ){
			$___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
		}else{
			$___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] ); 
			$son_eklenen_id	= $sorgu_sonuc[ 2 ]; 
		}	
	break;
	case 'guncelle':
		$sorgu_sonuc = $vt->update( $SQL_guncelle, array(
			$_REQUEST[	'link' ]
			,$id
		) );
		if( isset($_FILES["foto"]) and $_FILES["foto"]['size']>0 ){
			$dosya_adi = uniqid().basename($_FILES["foto"]["name"]);
			$target_dir = "../../resimler/logolar/";
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
header( "Location:../../index.php?modul=onemliBaglantilar" );
?>