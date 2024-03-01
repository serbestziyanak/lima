<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

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
	,adi					    = ?
	,adi_kz					    = ?
	,adi_en					    = ?
	,adi_ru					    = ?
	,soyadi				        = ?
	,soyadi_kz			        = ?
	,soyadi_en			        = ?
	,soyadi_ru			        = ?
	,baba_adi				    = ?
	,baba_adi_kz			    = ?
	,baba_adi_en			    = ?
	,baba_adi_ru			    = ?
	,cinsiyet					= ?
	,personel_nitelik_id		= ?
	,email						= ?
	,gsm1						= ?
	,tutor_id					= ?
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

$SQL_birim_id_oku = <<< SQL
SELECT 
	id
FROM 
	tb_birim_agaci
WHERE 
	epvo_id = ?
SQL;

$SQL_aktif_egitim_ogretim_yili = <<< SQL
SELECT 
	id
FROM 
	tb_egitim_ogretim_yillari
WHERE 
	aktif = 1
limit 1 
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
	case 'excel_epvo_ile_ekle':
        if( isset($_FILES["excel"]) and $_FILES["excel"]['size']>0 ){
            include '../../plugins/excel/PHPExcel.php'; // Excel kütüphanemizin yolunu belirtiyoruz.
            $ExcelDosyasi = $_FILES["excel"]["tmp_name"]; // Excel Dosyamızı Seçiyoruz. (Formatlar: xls, xlsx)
            $ExcelOku = PHPExcel_IOFactory::load($ExcelDosyasi);
            $ExcelVeriler = $ExcelOku->getActiveSheet()->toArray(null, true, true, true); //Excelde kullanacağımız sütunlarımızı seçiyoruz.
            $satir = 0;
            foreach( $ExcelVeriler AS $veri ){
                $satir++;
                if( $satir == 1 )
                    continue;
                $epvo_id                 = $veri[ "A" ];
                $aktif_calisma_yeri      = $veri[ "B" ];
                $cinsiyet                = $veri[ "C" ];
                $personel_nitelik_id     = $veri[ "D" ];
                $in_no                   = $veri[ "E" ];
                $email                   = $veri[ "F" ];
                $gsm1                    = $veri[ "G" ];
                $adi                     = $veri[ "H" ];
                $adi_kz                  = $veri[ "I" ];
                $adi_en                  = $veri[ "H" ];
                $adi_ru                  = $veri[ "I" ];
                $soyadi                  = $veri[ "J" ];
                $soyadi_kz               = $veri[ "K" ];
                $soyadi_en               = $veri[ "J" ];
                $soyadi_ru               = $veri[ "K" ];
                $baba_adi                = $veri[ "L" ];
                $baba_adi_kz             = $veri[ "M" ];
                $baba_adi_en             = $veri[ "L" ];
                $baba_adi_ru             = $veri[ "M" ];
                $tutor_id                = $veri[ "N" ];
                $sifre                   = md5( $in_no );
                $birim_id                   = $vt->selectSingle( $SQL_birim_id_oku, array( $epvo_id ) )[2]['id'];
                $egitim_ogretim_yili_id     = $vt->selectSingle( $SQL_aktif_egitim_ogretim_yili, array( ) )[2]['id'];
                $personel_varmi             = $vt->select( $SQL_tek_personel_oku, array( $in_no, $email ) )[2];
                if ( count( $personel_varmi ) < 1 ){

                    if( $birim_id>0 ){
                        $sorgu_sonuc = $vt->insert( $SQL_ekle, array(
                             $in_no
                            ,$adi
                            ,$adi_kz
                            ,$adi_en
                            ,$adi_ru
                            ,$soyadi
                            ,$soyadi_kz
                            ,$soyadi_en
                            ,$soyadi_ru
                            ,$baba_adi
                            ,$baba_adi_kz
                            ,$baba_adi_en
                            ,$baba_adi_ru
                            ,$cinsiyet
                            ,$personel_nitelik_id
                            ,$email
                            ,$gsm1
                            ,$tutor_id
                            ,$sifre
                        ) );
                        if( $sorgu_sonuc[ 0 ] ){
                            $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
                            $_SESSION[ 'sonuclar_toplu' ][$in_no] = array( 'hata' => true, 'mesaj' => 'Hata : Kayıt Eklenemedi', 'adi' => $adi." ".$soyadi );
                        }else{
                            $son_eklenen_id	= $sorgu_sonuc[ 2 ];
                            $___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
                            $_SESSION[ 'sonuclar_toplu' ][$in_no] = array( 'hata' => false, 'mesaj' => 'Başarıyla Eklendi', 'adi' => $adi." ".$soyadi );
                            $sorgu_sonuc = $vt->insert( $SQL_ekle2, array(
                                 $son_eklenen_id
                                ,$egitim_ogretim_yili_id
                                ,$birim_id
                                ,$personel_nitelik_id
                                ,$aktif_calisma_yeri
                            ) );
                            if( $sorgu_sonuc[ 0 ] ){
                                $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Çalışma yeri eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
                            }

                        }
                    }else{
                        $___islem_sonuc = array( 'hata' => true, 'mesaj' => 'Birim bulunamadı...', 'id' => $sonuc[ 2 ] );
                        $_SESSION[ 'sonuclar_toplu' ][$in_no] = array( 'hata' => true, 'mesaj' => 'Hata : Birim bulunamadı.', 'adi' => $adi." ".$soyadi );
                    }
                }else{
                    $_SESSION[ 'sonuclar_toplu' ][$in_no] = array( 'hata' => true, 'mesaj' => 'Hata : Bu IIN No veya Email zaten kayıtlı.', 'adi' => $adi." ".$soyadi );
                    $___islem_sonuc = array( 'hata' => true, 'mesaj' => 'Bazı kayıtlar eklenirken hata bulundu.', 'id' => $sonuc[ 2 ] );
                }
            }
        }
			
	break;
	case 'excel_birim_ile_ekle':
        if( isset($_FILES["excel"]) and $_FILES["excel"]['size']>0 ){
            include '../../plugins/excel/PHPExcel.php'; // Excel kütüphanemizin yolunu belirtiyoruz.
            $ExcelDosyasi = $_FILES["excel"]["tmp_name"]; // Excel Dosyamızı Seçiyoruz. (Formatlar: xls, xlsx)
            $ExcelOku = PHPExcel_IOFactory::load($ExcelDosyasi);
            $ExcelVeriler = $ExcelOku->getActiveSheet()->toArray(null, true, true, true); //Excelde kullanacağımız sütunlarımızı seçiyoruz.
            $satir = 0;
            foreach( $ExcelVeriler AS $veri ){
                $satir++;
                if( $satir == 1 )
                    continue;
                $birim_id                = $veri[ "A" ];
                $aktif_calisma_yeri      = $veri[ "B" ];
                $cinsiyet                = $veri[ "C" ];
                $personel_nitelik_id     = $veri[ "D" ];
                $in_no                   = $veri[ "E" ];
                $email                   = $veri[ "F" ];
                $gsm1                    = $veri[ "G" ];
                $adi                     = $veri[ "H" ];
                $adi_kz                  = $veri[ "I" ];
                $adi_en                  = $veri[ "H" ];
                $adi_ru                  = $veri[ "I" ];
                $soyadi                  = $veri[ "J" ];
                $soyadi_kz               = $veri[ "K" ];
                $soyadi_en               = $veri[ "J" ];
                $soyadi_ru               = $veri[ "K" ];
                $baba_adi                = $veri[ "L" ];
                $baba_adi_kz             = $veri[ "M" ];
                $baba_adi_en             = $veri[ "L" ];
                $baba_adi_ru             = $veri[ "M" ];
                $tutor_id                = $veri[ "N" ];
                $sifre                   = md5( $in_no );
                //$birim_id                   = $vt->selectSingle( $SQL_birim_id_oku, array( $epvo_id ) )[2]['id'];
                $egitim_ogretim_yili_id     = $vt->selectSingle( $SQL_aktif_egitim_ogretim_yili, array( ) )[2]['id'];
                $personel_varmi             = $vt->select( $SQL_tek_personel_oku, array( $in_no, $email ) )[2];
                if ( count( $personel_varmi ) < 1 ){

                    if( $birim_id>0 ){
                        $sorgu_sonuc = $vt->insert( $SQL_ekle, array(
                             $in_no
                            ,$adi
                            ,$adi_kz
                            ,$adi_en
                            ,$adi_ru
                            ,$soyadi
                            ,$soyadi_kz
                            ,$soyadi_en
                            ,$soyadi_ru
                            ,$baba_adi
                            ,$baba_adi_kz
                            ,$baba_adi_en
                            ,$baba_adi_ru
                            ,$cinsiyet
                            ,$personel_nitelik_id
                            ,$email
                            ,$gsm1
                            ,$tutor_id
                            ,$sifre
                        ) );
                        if( $sorgu_sonuc[ 0 ] ){
                            $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Kayıt eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
                            $_SESSION[ 'sonuclar_toplu' ][$in_no] = array( 'hata' => true, 'mesaj' => 'Hata : Kayıt Eklenemedi', 'adi' => $adi." ".$soyadi );
                        }else{
                            $son_eklenen_id	= $sorgu_sonuc[ 2 ];
                            $___islem_sonuc = array( 'hata' => false, 'mesaj' => 'İşlem başarı ile gerçekleşti', 'id' => $sorgu_sonuc[ 2 ] );
                            $_SESSION[ 'sonuclar_toplu' ][$in_no] = array( 'hata' => false, 'mesaj' => 'Başarıyla Eklendi', 'adi' => $adi." ".$soyadi );
                            $sorgu_sonuc = $vt->insert( $SQL_ekle2, array(
                                 $son_eklenen_id
                                ,$egitim_ogretim_yili_id
                                ,$birim_id
                                ,$personel_nitelik_id
                                ,$aktif_calisma_yeri
                            ) );
                            if( $sorgu_sonuc[ 0 ] ){
                                $___islem_sonuc = array( 'hata' => $sorgu_sonuc[ 0 ], 'mesaj' => 'Çalışma yeri eklenirken bir hata oluştu ' . $sorgu_sonuc[ 1 ] );
                            }

                        }
                    }else{
                        $___islem_sonuc = array( 'hata' => true, 'mesaj' => 'Birim bulunamadı...', 'id' => $sonuc[ 2 ] );
                        $_SESSION[ 'sonuclar_toplu' ][$in_no] = array( 'hata' => true, 'mesaj' => 'Hata : Birim bulunamadı.', 'adi' => $adi." ".$soyadi );
                    }
                }else{
                    $_SESSION[ 'sonuclar_toplu' ][$in_no] = array( 'hata' => true, 'mesaj' => 'Hata : Bu IIN No veya Email zaten kayıtlı.', 'adi' => $adi." ".$soyadi );
                    $___islem_sonuc = array( 'hata' => true, 'mesaj' => 'Bazı kayıtlar eklenirken hata bulundu.', 'id' => $sonuc[ 2 ] );
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
header( "Location:../../index.php?modul=topluPersonel");
?>