<?php
include "admin/_cekirdek/fonksiyonlar.php";
$vt = new VeriTabani();
$fn = new Fonksiyonlar();



$birim_id				= array_key_exists( 'birim_id' ,$_REQUEST ) ? $_REQUEST[ 'birim_id' ]	: 0;

if( isset($_REQUEST['dil']) ){
$dil = array_key_exists( 'dil' ,$_REQUEST ) ? $_REQUEST[ 'dil' ]	: 0;
$dil = $dil == "tr" ? "" : "_".$dil;
}else{
header( "Location:tr/");
}

$SQL_akademik_birimler = <<< SQL
SELECT
	*
FROM 
	tb_birim_agaci
WHERE 
    ust_id = ?
SQL;

$SQL_birim_sayfalari_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_sayfalari
WHERE 
	birim_id = ?
ORDER BY sira
SQL;

$SQL_slaytlar = <<< SQL
SELECT
  *
FROM 
  tb_slaytlar
WHERE 
  birim_id = ?
SQL;

$SQL_genel_ayarlar = <<< SQL
SELECT
  *
FROM 
  tb_genel_ayarlar
WHERE 
  birim_id = ?
SQL;

$SQL_duyurular = <<< SQL
SELECT
  *
FROM 
  tb_duyurular
ORDER BY tarih DESC
SQL;

$SQL_etkinlikler = <<< SQL
SELECT
  *
FROM 
  tb_etkinlikler
ORDER BY tarih DESC
SQL;

$SQL_duyuru_icerik = <<< SQL
SELECT
  *
FROM 
  tb_duyurular
WHERE
  id = ? 
SQL;

$SQL_etkinlik_icerik = <<< SQL
SELECT
  *
FROM 
  tb_etkinlikler
WHERE
  id = ? 
SQL;

$SQL_birim_bilgileri = <<< SQL
SELECT
  *
FROM 
  tb_birim_agaci
WHERE
  id = ? 
SQL;

$SQL_bolumler = <<< SQL
SELECT
  *
FROM 
  tb_birim_agaci
WHERE
  ust_id = ? 
SQL;

$SQL_birim_sayfa_bilgileri = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfalari
WHERE
  kisa_ad = ? 
SQL;

$SQL_birim_sayfa_icerikleri = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri
WHERE
  sayfa_id = ? 
SQL;

$SQL_ceviriler = <<< SQL
SELECT
  *
FROM 
  tb_ceviriler
WHERE
  turu = 1 
SQL;

$SQL_tum_gorevler = <<< SQL
SELECT 
	g.*
	,concat(unv.adi,' ',p.adi,' ',p.soyadi) as adi_soyadi
	,concat(unv.adi_kz,' ',p.adi_kz,' ',p.soyadi_kz) as adi_soyadi_kz
	,concat(unv.adi_en,' ',p.adi_en,' ',p.soyadi_en) as adi_soyadi_en
	,concat(unv.adi_ru,' ',p.adi_ru,' ',p.soyadi_ru) as adi_soyadi_ru
    ,p.foto
	,gk.adi as gorev_adi
	,gk.adi_kz as gorev_adi_kz
	,gk.adi_en as gorev_adi_en
	,gk.adi_ru as gorev_adi_ru
    ,gk.oncelik_sirasi
FROM 
	tb_gorevler as g
LEFT JOIN tb_gorev_kategorileri AS gk ON gk.id = g.gorev_kategori_id
LEFT JOIN tb_personeller AS p ON p.id = g.personel_id
LEFT JOIN tb_unvanlar AS unv ON unv.id = p.unvan_id
WHERE 
	g.birim_id = ?
SQL;

@$birim_bilgileri 	    = $vt->selectSingle($SQL_birim_bilgileri, array( 1 ) )[ 2 ];

$birim_id				= @array_key_exists( 'id' ,$birim_bilgileri ) ? $birim_bilgileri[ 'id' ]	: 0;
@$birim_sayfa_bilgileri = $vt->selectSingle($SQL_birim_sayfa_bilgileri, array( $_REQUEST['sayfa_kisa_ad'] ) )[ 2 ];
$sayfa_id				= @array_key_exists( 'id' ,$birim_sayfa_bilgileri ) ? $birim_sayfa_bilgileri[ 'id' ]	: 0;
@$birim_sayfa_icerikleri = $vt->selectSingle($SQL_birim_sayfa_icerikleri, array( $sayfa_id ) )[ 2 ];
@$duyuru_icerik          = $vt->selectSingle($SQL_duyuru_icerik, array( $_REQUEST['id'] ) )[ 2 ];
@$etkinlik_icerik        = $vt->selectSingle($SQL_etkinlik_icerik, array( $_REQUEST['id'] ) )[ 2 ];

@$birim_sayfalari 		= $vt->select($SQL_birim_sayfalari_getir, array( $birim_id ) )[ 2 ];
@$duyurular 	        = $vt->select($SQL_duyurular, array( $birim_id ) )[ 2 ];
@$etkinlikler 	        = $vt->select($SQL_etkinlikler, array( $birim_id ) )[ 2 ];
@$slaytlar 	            = $vt->select($SQL_slaytlar, array( $birim_id ) )[ 2 ];
@$genel_ayarlar 	    = $vt->selectSingle($SQL_genel_ayarlar, array( $birim_id ) )[ 2 ];
@$gorevler   			= $vt->select( $SQL_tum_gorevler, 	array( $birim_id ) )[ 2 ];

@$ceviriler	            = $vt->select($SQL_ceviriler, array(  ) )[ 2 ];
foreach( $ceviriler as $ceviri ){
    $dizi[$ceviri['adi']]['tr'] = $ceviri['adi']; 
    $dizi[$ceviri['adi']]['kz'] = $ceviri['adi_kz']; 
    $dizi[$ceviri['adi']]['en'] = $ceviri['adi_en']; 
    $dizi[$ceviri['adi']]['ru'] = $ceviri['adi_ru']; 
}


?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<base href="/hr/" />
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ahmet Yesevi Üniversitesi</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <!-- CSS
	============================================ -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/vendor/icomoon.css">
    <link rel="stylesheet" href="assets/css/vendor/remixicon.css">
    <link rel="stylesheet" href="assets/css/vendor/magnifypopup.min.css">
    <link rel="stylesheet" href="assets/css/vendor/odometer.min.css">
    <link rel="stylesheet" href="assets/css/vendor/lightbox.min.css">
    <link rel="stylesheet" href="assets/css/vendor/animation.min.css">
    <link rel="stylesheet" href="assets/css/vendor/jqueru-ui-min.css">
    <link rel="stylesheet" href="assets/css/vendor/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/vendor/tipped.min.css">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="assets/css/app.css">
    <script src="https://kit.fontawesome.com/d89f504824.js" crossorigin="anonymous"></script>

</head>

<body class="sticky-header ">
    <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  	<![endif]-->

    <div id="edublink-preloader">
        <div class="loading-spinner">
            <div class="preloader-spin-1"></div>
            <div class="preloader-spin-2"></div>
        </div>
        <div class="preloader-close-btn-wraper">
            <span class="btn btn-primary preloader-close-btn">
                Cancel Preloader</span>
        </div>
    </div>

    <div id="main-wrapper" class="main-wrapper">

        <!--=====================================-->
        <!--=        Header Area Start       	=-->
        <!--=====================================-->
        <!--header class="edu-header header-style-2">
            <div class="header-top-bar">
                <div class="container">
                    <div class="header-top">
                        <div class="header-top-left">
                            <ul class="header-info">
                                <li><a href="tel:+011235641231"><i class="icon-phone"></i>Call: +7 (725) 336 36 36</a></li>
                                <li><a href="mailto:info@edublink.com" target="_blank"><i class="icon-envelope"></i>Email: info@ayu.edu.kz</a></li>
                            </ul>
                        </div>
                        <div class="header-top-right">
                            <ul class="header-info">
                                <li><a href="#">Giriş</a></li>
                                <li><a href="#">Kayıt Ol</a></li>
                                <li class="header-btn"><a href="#" class="edu-btn btn-medium">Ayu Portal <i class="icon-4"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edu-sticky-placeholder"></div>
            <div class="header-mainmenu">
                <div class="container">
                    <div class="header-navbar">
                        <div class="header-brand">
                            <div class="logo">
                                <a href="index.html">
                                    <img class="logo-light" src="assets/images/logo/ayu_logo.png" alt="Corporate Logo" style="height:85px;">
                                    <img class="logo-dark" src="assets/images/logo/ayu_logo.png" alt="Corporate Logo" style="height:85px;">

                                </a>
                            </div>
                        </div>
                        <div class="header-mainnav">
                            <nav class="mainmenu-nav">
                                <ul class="mainmenu">
                                    <li class="has-droupdown"><a href="#">Üniversitemiz</a>
                                        <ul class="mega-menu mega-menu-two">
                                            <li><h6 style="color:#eb0023;">&emsp;Hakkımızda</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Başkandan Mesaj</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Ahmet Yesevi Kimdir</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Vizyonumuz</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Misyonumuz</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Hakkımızda</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Temel Değerlerimiz</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Tarihçe</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Logolar</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h6 style="color:#eb0023;">&emsp;Yönetim</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Mütevelli Heyeti Başkanı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Rektör</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Rektör Vekili</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Eski Başkanlarımız</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Mevzuat</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Tüzük</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Kişisel Verilerin Korunması</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Kurum İçi Web</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h6 style="color:#eb0023;">&emsp;Yayınlar</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Kitap</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Dergi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Rapor</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Bildiri</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Video & Müzik</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-droupdown"><a href="#">Akademik</a>
                                        <ul class="mega-menu mega-menu-two">
                                            <li><h6 style="color:#eb0023;">&emsp;Fakülteler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Hazırlık Okulu</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Mühendislik Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Fen Bilimleri Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Filoloji Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">İnsan ve Toplum Bilimleri Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">İlahiyat Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Spor ve Sanat Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Sosyal Bilimler Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Diş Hekimliği Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Tıp Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Lisansüstü Tıp Eğitimi Fakültesi (Çimkent)</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h6 style="color:#eb0023;">&emsp;Enstitüler/Merkezler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Türkoloji Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Ekoloji Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Avrasya Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Arkeoloji Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Tıbbi Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Fen Bilimleri Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Yesevi Araştırma Enstitüsü</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Meslek Yüksekokulu</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Ahmet Yesevi Meslek Yüksekokulu</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Uzaktan Eğitim</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Türkiye Türkçesiyle Uzaktan Eğitim Programları (TÜRTEP)</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h6 style="color:#eb0023;">&emsp;Akademik</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Akademik Takvim</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Akademik Teşkilat</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Akademik</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Bilimsel Yayınlar</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Bilig Sosyal Bilimler Dergisi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Türkoloji Dergisi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Türk Edebiyatı İsimler Sözlüğü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Türk Edebiyatı Eserler Sözlüğü</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-droupdown"><a href="#">Akademik</a>
                                        <ul class="mega-menu mega-menu-two">
                                        <?php 
                                            @$akademik_birimler 		= $vt->select($SQL_akademik_birimler, array( 2 ) )[ 2 ];
                                            foreach( @$akademik_birimler as $birim ){
                                        ?>
                                            <li><h6 style="color:#eb0023;">&emsp;<?php echo $birim['adi']; ?></h6>    
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <?php 
                                                    @$akademik_birimler2 		= $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                    foreach(@$akademik_birimler2 as $birim2){

                                                    ?>
                                                    <li style="list-style-type: square;"><a href="birimler/tr/<?php echo $birim2['kisa_ad']; ?>"><?php echo $birim2['adi']; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <?php } ?>

                                        </ul>
                                    </li>
                                    <li class="has-droupdown"><a href="#">Öğrenci</a>
                                        <ul class="mega-menu mega-menu-two">
                                            <li><h6 style="color:#eb0023;">&emsp;Aday Öğrenci</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Tanıtım</a></li>
                                                    <li style="list-style-type: square;"><a href="#">T.C. Vatandaşları</a></li>
                                                    <li style="list-style-type: square;"><a href="#">K.C. Vatandaşları</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Diğer Ülke Vatandaşları</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Kayıt ve Kabul İşlemleri</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Diploma Denkliği</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Taban ve Tavan Puanlar</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Hazırlık Sınıfı</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Kayıt</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Ders Kaydı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Öğrenim Ücretleri</a></li>
                                                </ul>
                                            </li>
                                            <li><h6 style="color:#eb0023;">&emsp;Akademik İşler Daire Başkanlığı</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Eğitim Faaliyetleri Bölümü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Öğrenci İşleri Birimi (Kayıt Ofisi)</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Lisansüstü Eğitim Bölümü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Metodoloji Çalışmaları Organizasyon Bölümü</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Değişim Programları</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Akademik Değişim Birimi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Mevlana Değişim Programı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Orhun Değişim Programı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">İç Akademi Değişim Programı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">K.C. Eğitim ve Yükseköğretim Bakanlığı Değişim Programı</a></li>
                                                </ul>
                                            </li>
                                            <li><h6 style="color:#eb0023;">&emsp;Kampüste Yaşam</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Kültür Merkezi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Tıbbi Hizmetler</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Spor ve Spor Altyapısı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Yeme-İçme</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Yurtları</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Öğrenci Kurulu</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Uluslararası İlişkiler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Uluslararası İlişkiler Ofisi</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-droupdown"><a href="#">İletişim</a>
                                        <ul class="mega-menu mega-menu-one">
                                            <li><h6 style="color:#eb0023;">&emsp;Birimler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Mütevelli Heyeti Başkanlığı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Rektörlük</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Türkiye Türkçesiyle Uzaktan Eğitim Programları (TÜRTEP)</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Öğrenci İşleri (Örgün Eğitim)</a></li>

                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Kampüsler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Merkez Kampüs - Türkistan</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Hazırlık Okulu - Kentau</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Avrasya Araştırma Enstitüsü</a></li>
                                                </ul>
                                            </li>
                                            <li><h6 style="color:#eb0023;">&emsp;Sosyal Medya</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-twitter"></i>Twitter</a></li>
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-facebook"></i>Facebook</a></li>
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-instagram"></i>Instagram</a></li>
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-youtube"></i>Youtube</a></li>
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-linkedin2"></i>Linkedin</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-right">
                            <ul class="header-action">
                                <li class="icon search-icon">
                                    <a href="javascript:void(0)" class="search-trigger">
                                        <i class="icon-2"></i>
                                    </a>
                                </li>
   
                                <li class="mobile-menu-bar d-block d-xl-none">
                                    <button class="hamberger-button">
                                        <i class="icon-54"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-mobile-menu">
                <div class="inner">
                    <div class="header-top">
                        <div class="logo">
                            <a href="index.html">
                                <img class="logo-light" src="assets/images/logo/logo-dark.png" alt="Corporate Logo">
                                <img class="logo-dark" src="assets/images/logo/logo-white.png" alt="Corporate Logo">
                            </a>
                        </div>
                        <div class="close-menu">
                            <button class="close-button">
                                <i class="icon-73"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="mainmenu">
                        <li class="has-droupdown"><a href="#">Home</a>
                            <ul class="mega-menu mega-menu-one">
                                <li>
                                    <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                        <li><a href="index.html">EduBlink Education <span class="badge-1">hot</span></a></li>
                                        <li><a href="index-distant-learning.html">Distant Learning</a></li>
                                        <li><a href="index-university.html">University</a></li>
                                        <li><a href="index-online-academy.html">Online Academy <span class="badge-1">hot</span></a></li>
                                        <li><a href="index-modern-schooling.html">Modern Schooling</a></li>
                                        <li><a href="index-kitchen.html">Kitchen Coach</a></li>
                                        <li><a href="index-yoga.html">Yoga Instructor</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                        <li><a href="index-kindergarten.html">Kindergarten</a></li>
                                        <li><a href="index-health-coach.html">Health Coch <span class="badge">new</span></a></li>
                                        <li><a href="index-language-academy.html">Language Academy <span class="badge">new</span></a></li>
                                        <li><a href="index-remote-training.html">Remote Training <span class="badge">new</span></a></li>
                                        <li><a href="index-photography.html">Photography <span class="badge">new</span></a></li>
                                        <li><a href="https://edublink.html.dark.devsblink.com/" target="_blank">Dark Version</a></li>
                                        <li><a href="index-landing.html">Landing Demo</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="submenu mega-sub-menu-01">
                                        <li>
                                            <a href="https://1.envato.market/5bQ022">
                                                <img src="assets/images/others/mega-menu-image.webp" alt="advertising Image">
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-droupdown"><a href="#">Pages</a>
                            <ul class="mega-menu">
                                <li>
                                    <h6 class="menu-title">Inner Pages</h6>
                                    <ul class="submenu mega-sub-menu-01">
                                        <li><a href="about-one.html">About Us 1</a></li>
                                        <li><a href="about-two.html">About Us 2</a></li>
                                        <li><a href="about-three.html">About Us 3</a></li>
                                        <li><a href="team-one.html">Instructor 1</a></li>
                                        <li><a href="team-two.html">Instructor 2</a></li>
                                        <li><a href="team-three.html">Instructor 3</a></li>
                                        <li><a href="team-details.html">Instructor Profile</a></li>
                                        <li><a href="faq.html">Faq's</a></li>
                                        <li><a href="404.html">404 Error</a></li>
                                        <li><a href="coming-soon.html">Coming Soon</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <h6 class="menu-title">Inner Pages</h6>
                                    <ul class="submenu mega-sub-menu-01">
                                        <li><a href="gallery-grid.html">Gallery Grid</a></li>
                                        <li><a href="gallery-masonry.html">Gallery Masonry</a></li>
                                        <li><a href="event-grid.html">Event Grid</a></li>
                                        <li><a href="event-list.html">Event List</a></li>
                                        <li><a href="event-details.html">Event Details</a></li>
                                        <li><a href="pricing-table.html">Pricing Table</a></li>
                                        <li><a href="purchase-guide.html">Purchase Guide</a></li>
                                        <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                        <li><a href="terms-condition.html">Terms & Condition</a></li>
                                        <li><a href="my-account.html">Sign In</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <h6 class="menu-title">Shop Pages</h6>
                                    <ul class="submenu mega-sub-menu-01">
                                        <li><a href="shop.html">Shop</a></li>
                                        <li><a href="product-details.html">Product Details</a></li>
                                        <li><a href="cart.html">Cart</a></li>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="has-droupdown"><a href="#">Courses</a>
                            <ul class="submenu">
                                <li><a href="course-one.html">Course Style 1</a></li>
                                <li><a href="course-two.html">Course Style 2</a></li>
                                <li><a href="course-three.html">Course Style 3</a></li>
                                <li><a href="course-four.html">Course Style 4</a></li>
                                <li><a href="course-five.html">Course Style 5</a></li>
                                <li><a href="course-details.html">Course Details 1</a></li>
                                <li><a href="course-details-2.html">Course Details 2</a></li>
                                <li><a href="course-details-3.html">Course Details 3</a></li>
                            </ul>
                        </li>

                        <li class="has-droupdown"><a href="#">Blog</a>
                            <ul class="submenu">
                                <li><a href="blog-standard.html">Blog Standard</a></li>
                                <li><a href="blog-masonry.html">Blog Masonry</a></li>
                                <li><a href="blog-list.html">Blog List</a></li>
                                <li><a href="blog-details.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li class="has-droupdown"><a href="#">Contact</a>
                            <ul class="submenu">
                                <li><a href="contact-us.html">Contact Us</a></li>
                                <li><a href="contact-me.html">Contact Me</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="edu-search-popup">
                <div class="content-wrap">
                    <div class="site-logo">
                        <img class="logo-light" src="assets/images/logo/logo-dark.png" alt="Corporate Logo">
                        <img class="logo-dark" src="assets/images/logo/logo-white.png" alt="Corporate Logo">
                    </div>
                    <div class="close-button">
                        <button class="close-trigger"><i class="icon-73"></i></button>
                    </div>
                    <div class="inner">
                        <form class="search-form" action="#">
                            <input type="text" class="edublink-search-popup-field" placeholder="Search Here...">
                            <button class="submit-button"><i class="icon-2"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            
        </header-->
        <header class="edu-header header-style-1 header-fullwidth">
            <div class="header-top-bar">
                <div class="container-fluid">
                    <div class="header-top">
                        <div class="header-top-left">
                            <div class="header-notify">
                                Köklü Geçmişten, Güçlü Geleceğe...
                            </div>
                        </div>
                        <div class="header-top-right">
                            <ul class="header-info">
                                <li><a href="tel:+7(725) 336-36-36"><i class="icon-phone"></i>Call: +7(725) 336-36-36</a></li>
                                <li><a href="mailto:info@ayu.edu.kz" target="_blank"><i class="icon-envelope"></i>Email: info@ayu.edu.kz</a></li>
                                <li class="social-icon">
                                    <a href="#"><i class="icon-facebook"></i></a>
                                    <a href="#"><i class="icon-instagram"></i></a>
                                    <a href="#"><i class="icon-twitter"></i></a>
                                    <a href="#"><i class="icon-linkedin2"></i></a>
                                </li>
                                <li class="social-icon">
                                    <a href="tr/">TR</a>
                                    <a href="kz/">KZ</a>
                                    <a href="en/">EN</a>
                                    <a href="ru/">RU</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edu-sticky-placeholder"></div>
            <div class="header-mainmenu">
                <div class="container-fluid">
                    <div class="header-navbar">
                        <div class="header-brand">
                            <div class="logo">
                                <a href="index.php">
                                    <img class="logo-light" src="assets/images/logo/ayu_logo2.png" alt="Corporate Logo" style="height:80px;">
                                    <img class="logo-dark" src="assets/images/logo/ayu_logo2.png" alt="Corporate Logo">
                                </a>
                            </div>

                        </div>
                        <div class="header-mainnav">
                            <nav class="mainmenu-nav">
                                <ul class="mainmenu">
                                        <li><a href="#">Anasayfa</a></li>
                                        <?php 
                                            function buildList(array $array, int $ust_id, int $onceki_ust_id, int $ilk, $birim_id, $dil,$vt,$SQL_akademik_birimler): string
                                            {
                                                $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                                $dil2 = $dil == "tr" ? "" : "_".$dil ;
                                                $adi = "adi".$dil2;
                                                if( $ilk ){
                                                $menu = "";
                                                }
                                                else{
                                                    if( $onceki_ust_id == 0 )
                                                    $menu = "<ul class='mega-menu mega-menu-two'>";
                                                    else
                                                    $menu = "<ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                                }
                                                foreach($array as $item) {
                                                    if( $item['ust_id'] == $ust_id ){
                                                        if( $item['kategori'] == 0 ){
                                                            if( $item['ust_id'] == 0 )
                                                            $menu .= "<li><a href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                                            else
                                                            $menu .= "<li style='list-style-type: square;'><a href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                                        }else{
                                                            if( $ust_id == 0 )
                                                             $menu .= "<li class='has-droupdown'><a href='$actual_link#' >{$item[$adi]}</a>";
                                                             else
                                                             $menu .= "<li><h6 style='color:#eb0023;'>&emsp;{$item[$adi]}</h6>";
                                                        }
                                                        if ( $item['kategori'] == 1 ) {
                                                            if( $item['kisa_ad'] == 'akademik' ){
                                                                $menu .= "<ul class='mega-menu mega-menu-two'>";
                                                                @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 2 ) )[ 2 ];
                                                                foreach( @$akademik_birimler as $birim ){
                                                                $menu .= "<li><h6 style='color:#eb0023;'>&emsp;$birim[adi]</h6><ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                                                        
                                                                    @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                                    foreach(@$akademik_birimler2 as $birim2){
                                                                    $menu .= "<li style='list-style-type: square;'><a href='birimler/tr/$birim2[kisa_ad]'>$birim2[adi]</a></li>";
                                                                    } 
                                                                $menu .= "</ul></li>";
                                                                }
                                                                $menu .= "</ul>";
                                                            }elseif( $item['kisa_ad'] == 'idari' ){
                                                                $menu .= "<ul class='mega-menu mega-menu-two'>";
                                                                @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 3 ) )[ 2 ];
                                                                foreach( @$akademik_birimler as $birim ){
                                                                $menu .= "<li><h6 style='color:#eb0023;'>&emsp;$birim[adi]</h6><ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                                                        
                                                                    @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                                    foreach(@$akademik_birimler2 as $birim2){
                                                                    $menu .= "<li style='list-style-type: square;'><a href='birimler/tr/$birim2[kisa_ad]'>$birim2[adi]</a></li>";
                                                                    } 
                                                                $menu .= "</ul></li>";
                                                                }
                                                                $menu .= "</ul>";
                                                            }else{
                                                                $menu .= buildList($array, $item['id'], $item['ust_id'],0, $birim_id, $dil,$vt,$SQL_akademik_birimler);
                                                                $menu .= "</li>";
                                                            }
                                                        }
                                                    }
                                                }
                                                if( $ilk ){
                                                $menu .= "";
                                                }else{
                                                $menu .= "</ul>";
                                                }
                                                return $menu;
                                            }
                                            echo buildList($birim_sayfalari, 0,0, 1, $birim_id, $_REQUEST['dil'],$vt,$SQL_akademik_birimler);
                                        ?>

                                    <!--li class="has-droupdown"><a href="#">Üniversitemiz</a>
                                        <ul class="mega-menu mega-menu-two">
                                            <li><h6 style="color:#eb0023;">&emsp;Hakkımızda</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Başkandan Mesaj</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Ahmet Yesevi Kimdir</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Vizyonumuz</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Misyonumuz</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Hakkımızda</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Temel Değerlerimiz</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Tarihçe</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Logolar</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h6 style="color:#eb0023;">&emsp;Yönetim</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Mütevelli Heyeti Başkanı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Rektör</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Rektör Vekili</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Eski Başkanlarımız</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Mevzuat</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Tüzük</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Kişisel Verilerin Korunması</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Kurum İçi Web</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h6 style="color:#eb0023;">&emsp;Yayınlar</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Kitap</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Dergi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Rapor</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Bildiri</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Video & Müzik</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li-->
                                    <!--li class="has-droupdown"><a href="#">Akademik</a>
                                        <ul class="mega-menu mega-menu-two">
                                            <li><h6 style="color:#eb0023;">&emsp;Fakülteler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Hazırlık Okulu</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Mühendislik Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Fen Bilimleri Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Filoloji Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">İnsan ve Toplum Bilimleri Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">İlahiyat Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Spor ve Sanat Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Sosyal Bilimler Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Diş Hekimliği Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Tıp Fakültesi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Lisansüstü Tıp Eğitimi Fakültesi (Çimkent)</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h6 style="color:#eb0023;">&emsp;Enstitüler/Merkezler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Türkoloji Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Ekoloji Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Avrasya Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Arkeoloji Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Tıbbi Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Fen Bilimleri Araştırma Enstitüsü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Yesevi Araştırma Enstitüsü</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Meslek Yüksekokulu</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Ahmet Yesevi Meslek Yüksekokulu</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Uzaktan Eğitim</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Türkiye Türkçesiyle Uzaktan Eğitim Programları (TÜRTEP)</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h6 style="color:#eb0023;">&emsp;Akademik</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Akademik Takvim</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Akademik Teşkilat</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Akademik</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Bilimsel Yayınlar</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Bilig Sosyal Bilimler Dergisi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Türkoloji Dergisi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Türk Edebiyatı İsimler Sözlüğü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Türk Edebiyatı Eserler Sözlüğü</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li-->
                                    <!--li class="has-droupdown"><a href="#">Öğrenci</a>
                                        <ul class="mega-menu mega-menu-two">
                                            <li><h6 style="color:#eb0023;">&emsp;Aday Öğrenci</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Tanıtım</a></li>
                                                    <li style="list-style-type: square;"><a href="#">T.C. Vatandaşları</a></li>
                                                    <li style="list-style-type: square;"><a href="#">K.C. Vatandaşları</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Diğer Ülke Vatandaşları</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Kayıt ve Kabul İşlemleri</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Diploma Denkliği</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Taban ve Tavan Puanlar</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Hazırlık Sınıfı</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Kayıt</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Ders Kaydı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Öğrenim Ücretleri</a></li>
                                                </ul>
                                            </li>
                                            <li><h6 style="color:#eb0023;">&emsp;Akademik İşler Daire Başkanlığı</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Eğitim Faaliyetleri Bölümü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Öğrenci İşleri Birimi (Kayıt Ofisi)</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Lisansüstü Eğitim Bölümü</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Metodoloji Çalışmaları Organizasyon Bölümü</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Değişim Programları</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Akademik Değişim Birimi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Mevlana Değişim Programı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Orhun Değişim Programı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">İç Akademi Değişim Programı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">K.C. Eğitim ve Yükseköğretim Bakanlığı Değişim Programı</a></li>
                                                </ul>
                                            </li>
                                            <li><h6 style="color:#eb0023;">&emsp;Kampüste Yaşam</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Kültür Merkezi</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Tıbbi Hizmetler</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Spor ve Spor Altyapısı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Yeme-İçme</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Yurtları</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Öğrenci Kurulu</a></li>
                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Uluslararası İlişkiler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Uluslararası İlişkiler Ofisi</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-droupdown"><a href="#">İletişim</a>
                                        <ul class="mega-menu mega-menu-one">
                                            <li><h6 style="color:#eb0023;">&emsp;Birimler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Mütevelli Heyeti Başkanlığı</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Rektörlük</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Türkiye Türkçesiyle Uzaktan Eğitim Programları (TÜRTEP)</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Öğrenci İşleri (Örgün Eğitim)</a></li>

                                                </ul>
                                                <br>
                                                <h6 style="color:#eb0023;">&emsp;Kampüsler</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#">Merkez Kampüs - Türkistan</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Hazırlık Okulu - Kentau</a></li>
                                                    <li style="list-style-type: square;"><a href="#">Avrasya Araştırma Enstitüsü</a></li>
                                                </ul>
                                            </li>
                                            <li><h6 style="color:#eb0023;">&emsp;Sosyal Medya</h6>
                                                <ul class="submenu mega-sub-menu mega-sub-menu-01">
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-twitter"></i>Twitter</a></li>
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-facebook"></i>Facebook</a></li>
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-instagram"></i>Instagram</a></li>
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-youtube"></i>Youtube</a></li>
                                                    <li style="list-style-type: square;"><a href="#"><i class="icon-linkedin2"></i>Linkedin</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li-->
                                </ul>
                            </nav>
                        </div>
                        <div class="header-right">
                            <ul class="header-action">
                                <li class="search-bar">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <button class="search-btn" type="button"><i class="icon-2"></i></button>
                                    </div>
                                </li>
                                <li class="icon search-icon">
                                    <a href="javascript:void(0)" class="search-trigger">
                                        <i class="icon-2"></i>
                                    </a>
                                </li>
                                <li class="header-btn">
                                    <a href="https://portal.ayu.edu.kz/" class="edu-btn btn-medium">Ayu Portal <i class="icon-4"></i></a>
                                </li>
                                <li class="mobile-menu-bar d-block d-xl-none">
                                    <button class="hamberger-button">
                                        <i class="icon-54"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-top-bar">
                <div class="container-fluid">
                    <div class="header-top">
                        xffdgfdg
                    </div>
                </div>
            </div>

            <div class="popup-mobile-menu">
                <div class="inner">
                    <div class="header-top">
                        <div class="logo">
                            <a href="index.html">
                                <img class="logo-light" src="assets/images/logo/ayu_logo2.png" alt="Corporate Logo">
                                <img class="logo-dark" src="assets/images/logo/ayu_logo2.png" alt="Corporate Logo">
                            </a>
                        </div>
                        <div class="close-menu">
                            <button class="close-button">
                                <i class="icon-73"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="mainmenu">
                        <?php 
                            function buildList2(array $array, int $ust_id, int $onceki_ust_id, int $ilk, $birim_id, $dil,$vt,$SQL_akademik_birimler): string
                            {
                                $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                $dil2 = $dil == "tr" ? "" : "_".$dil ;
                                $adi = "adi".$dil2;
                                if( $ilk ){
                                $menu = "";
                                }
                                else{
                                    if( $onceki_ust_id == 0 )
                                    $menu = "<ul class='mega-menu mega-menu-two'>";
                                    else
                                    $menu = "<ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                }
                                foreach($array as $item) {
                                    if( $item['ust_id'] == $ust_id ){
                                        if( $item['kategori'] == 0 ){
                                            if( $item['ust_id'] == 0 )
                                            $menu .= "<li><a href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                            else
                                            $menu .= "<li style='list-style-type: square;'><a href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                        }else{
                                            if( $ust_id == 0 )
                                                $menu .= "<li class='has-droupdown'><a href='$actual_link#' >{$item[$adi]}</a>";
                                                else
                                                $menu .= "<li><h6 style='color:#eb0023;'>&emsp;{$item[$adi]}</h6>";
                                        }
                                        if ( $item['kategori'] == 1 ) {
                                            if( $item['kisa_ad'] == 'akademik' ){
                                                $menu .= "<ul class='mega-menu mega-menu-two'>";
                                                @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 2 ) )[ 2 ];
                                                foreach( @$akademik_birimler as $birim ){
                                                $menu .= "<li><h6 style='color:#eb0023;'>&emsp;$birim[adi]</h6><ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                                        
                                                    @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                    foreach(@$akademik_birimler2 as $birim2){
                                                    $menu .= "<li style='list-style-type: square;'><a href='birimler/tr/$birim2[kisa_ad]'>$birim2[adi]</a></li>";
                                                    } 
                                                $menu .= "</ul></li>";
                                                }
                                                $menu .= "</ul>";
                                            }elseif( $item['kisa_ad'] == 'idari' ){
                                                $menu .= "<ul class='mega-menu mega-menu-two'>";
                                                @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 3 ) )[ 2 ];
                                                foreach( @$akademik_birimler as $birim ){
                                                $menu .= "<li><h6 style='color:#eb0023;'>&emsp;$birim[adi]</h6><ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                                        
                                                    @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                    foreach(@$akademik_birimler2 as $birim2){
                                                    $menu .= "<li style='list-style-type: square;'><a href='birimler/tr/$birim2[kisa_ad]'>$birim2[adi]</a></li>";
                                                    } 
                                                $menu .= "</ul></li>";
                                                }
                                                $menu .= "</ul>";
                                            }else{
                                                $menu .= buildList2($array, $item['id'], $item['ust_id'],0, $birim_id, $dil,$vt,$SQL_akademik_birimler);
                                                $menu .= "</li>";
                                            }
                                        }
                                    }
                                }
                                if( $ilk ){
                                $menu .= "";
                                }else{
                                $menu .= "</ul>";
                                }
                                return $menu;
                            }
                            echo buildList2($birim_sayfalari, 0,0, 1, $birim_id, $_REQUEST['dil'],$vt,$SQL_akademik_birimler);
                        ?>
                    </ul>
                </div>
            </div>
            <!-- Start Search Popup  -->
            <div class="edu-search-popup">
                <div class="content-wrap">
                    <div class="site-logo">
                        <img class="logo-light" src="assets/images/logo/ayu_logo2.png" alt="Corporate Logo">
                        <img class="logo-dark" src="assets/images/logo/ayu_logo2.png" alt="Corporate Logo">
                    </div>
                    <div class="close-button">
                        <button class="close-trigger"><i class="icon-73"></i></button>
                    </div>
                    <div class="inner">
                        <form class="search-form" action="#">
                            <input type="text" class="edublink-search-popup-field" placeholder="Search Here...">
                            <button class="submit-button"><i class="icon-2"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Search Popup  -->
        </header>

        <!--=====================================-->
        <!--=       Hero Banner Area Start      =-->
        <!--=====================================-->
        <div class="hero-banner hero-style-3 bg-image">
            <div class="swiper university-activator">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img data-transform-origin='center center' data-src="assets/images/bg/4.jpg" class="swiper-lazy" alt="image">
                        <div class="thumbnail-bg-content">
                            <div class="container edublink-animated-shape">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="banner-content">
                                            <span class="subtitle" data-sal="slide-up" data-sal-duration="1000">Ahmet Yesevi Üniversitesine Hoşgeldiniz</span>
                                            <h1 class="title" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1000">Türk Dünyasının Parlayan Yıldızı</h1>
                                            <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000">Bir Dünya Üniversitesi.</p>
                                            <!--div class="banner-btn" data-sal-delay="400" data-sal="slide-up" data-sal-duration="1000">
                                                <a href="#" class="edu-btn ">Find courses <i class="icon-4"></i></a>
                                            </div-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img data-transform-origin='center center' data-src="assets/images/bg/2.jpg" class="swiper-lazy" alt="image">
                        <div class="thumbnail-bg-content">
                            <div class="container edublink-animated-shape">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="banner-content">
                                            <span class="subtitle" data-sal="slide-up" data-sal-duration="1000">Ahmet Yesevi Üniversitesine Hoşgeldiniz</span>
                                            <h1 class="title" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1000">Köklü Geçmişten Güçlü Geleceğe</h1>
                                            <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000"></p>
                                            <!--div class="banner-btn" data-sal-delay="400" data-sal="slide-up" data-sal-duration="1000">
                                                <a href="#" class="edu-btn btn-secondary">Find courses <i class="icon-4"></i></a>
                                            </div-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img data-transform-origin='center center' data-src="assets/images/bg/7.jpg" class="swiper-lazy" alt="image">
                        <div class="thumbnail-bg-content">
                            <div class="container edublink-animated-shape">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="banner-content">
                                            <span class="subtitle" data-sal="slide-up" data-sal-duration="1000">Ahmet Yesevi Üniversitesine Hoşgeldiniz</span>
                                            <h1 class="title" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1000">Bir Dünya Üniversitesi</h1>
                                            <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000"></p>
                                            <!--div class="banner-btn" data-sal-delay="400" data-sal="slide-up" data-sal-duration="1000">
                                                <a href="#" class="edu-btn btn-secondary">Find courses <i class="icon-4"></i></a>
                                            </div-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-slider-bg-controls">
                    <div class="swiper-slide-controls slide-prev">
                        <i class="icon-west"></i>
                    </div>
                    <div class="swiper-slide-controls slide-next">
                        <i class="icon-east"></i>
                    </div>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                    <img data-depth="2" src="assets/images/others/shape-10.png" alt="Shape">
                </li>
                <li class="shape-2 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                    <img data-depth="-3" src="assets/images/others/shape-11.png" alt="Shape">
                </li>
                <li class="shape-3">
                    <img src="assets/images/others/shape-25.png" alt="Shape">
                </li>
            </ul>
        </div>
        <!--=====================================-->
        <!--=       Features Area Start      	=-->
        <!--=====================================-->
        <!-- Start Categories Area  -->
        <div class="features-area-3">
            <div class="container">
                <div class="features-grid-wrap">
                    <div class="features-box features-style-3 color-primary-style edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="assets/images/animated-svg-icons/scholarship-facility.svg" alt="animated icon">
                            <!-- <i class="icon-34"></i> -->
                        </div>
                        <div class="content">
                            <h4 class="title">Burs Olanağı</h4>
                            <p>Üniversitemiz öğrencilerine çeşitli kuruluşlardan burs imkanı sağlamaktadır.</p>
                        </div>
                    </div>
                    <div class="features-box features-style-3 color-secondary-style edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="assets/images/animated-svg-icons/skilled-lecturers.svg" alt="animated icon">
                        </div>
                        <div class="content">
                            <h4 class="title">Nitelikli Öğretim Elemanları</h4>
                            <p>Birçok bilimsel alanda sayısız yayın yapmış seçkin öğretim elemanları.</p>
                        </div>
                    </div>
                    <div class="features-box features-style-3 color-extra02-style edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="assets/images/animated-svg-icons/book-library.svg" alt="animated icon">
                            <!-- <i class="icon-36"></i> -->
                        </div>
                        <div class="content">
                            <h4 class="title">Kütüphane </h4>
                            <p>Ahmet Yesevi Üniversitesi bünyesinde seçkin kitaplardan oluşan kütüphane.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Categories Area  -->
        <div class="edu-categorie-area categorie-area-2 edu-section-gap">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <h2 class="title">Hızlı Bağlantılar</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                    <p>Consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore</p>
                </div>

                <div class="row g-5">
                    <div class="col-lg-4 col-md-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-primary-style edublink-svg-animate">
                            <div class="icon">
                                <i class="icon-9"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Business Management</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-secondary-style">
                            <div class="icon">
                                <i class="icon-10 art-design"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Arts & Design</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-extra01-style">
                            <div class="icon">
                                <i class="icon-11 personal-development"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Personal Development</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-tertiary-style">
                            <div class="icon">
                                <i class="icon-12 health-fitness"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Health & Fitness</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-extra02-style">
                            <div class="icon">
                                <i class="icon-13 data-science"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Data Science</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-extra03-style">
                            <div class="icon">
                                <i class="icon-14"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Marketing</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-extra04-style">
                            <div class="icon">
                                <i class="icon-15"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Business & Finance</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-extra05-style">
                            <div class="icon">
                                <i class="icon-16 computer-science"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Computer Science</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 color-extra06-style">
                            <div class="icon">
                                <i class="icon-17 video-photography"></i>
                            </div>
                            <div class="content">
                                <a href="course-one.html">
                                    <h5 class="title">Video & Photography</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Categories Area  -->
        <!--=====================================-->
        <!--=       About Area Start      		=-->
        <!--=====================================-->
        <div class="edu-about-area about-style-3">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="about-content">
                            <div class="section-title section-left">
                                <span class="pre-title">Hakkımızda</span>
                                <h2 class="title">Bir <span class="color-primary">Dünya</span> Üniversitesi Olma Yolunda</h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                            </div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#about-edu" type="button" role="tab" aria-selected="true">Hakkımızda</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#about-mission" type="button" role="tab" aria-selected="false">Misyonumuz</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#about-vision" type="button" role="tab" aria-selected="false">Vizyonumuz</button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="about-edu" role="tabpanel">
                                    <p>Hoca Ahmet Yesevi Uluslararası Türk-Kazak Üniversitesi, Türkiye ve Kazakistan Cumhuriyetlerinin uluslararası, özerk statüye sahip, ortak devlet üniversitesidir.

Ahmet Yesevi Üniversitesinde, bugün 10 fakülte ve 1 yüksekokulda 12 binden fazla öğrenci öğrenim görmekte ve 900’ü aşkın akademik personel görev yapmaktadır.

Mütevelli Heyet Başkanlığı, Ankara'daki binasında faaliyetlerini sürdürmektedir. Aynı şekilde, Türkiye Türkçesiyle Uzaktan Eğitim Programlarının (TÜRTEP) koordinasyonu da Ankara'daki birimlerinden yürütülmektedir.</p>
                                    <ul class="features-list">
                                        <li>Köklü Geçmişten</li>
                                        <li>Güçlü Geleceğe</li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="about-mission" role="tabpanel">
                                    <p>
Türk Dili konuşan Devlet ve Topluklara mensup öğrencileri, bir çatı altında eğitmek; hür ve bilimsel düşünce gücüne, çağdaş bilgi ve beceriye, toplumsal sorumluluk duygusuna sahip, insan haklarına saygılı, hoşgörülü, millî ve ahlâkî değerlere bağlı, sorgulayan, araştıran, girişimci, demokratik ve laik devlet esaslarına bağlı, tarih ve kimlik şuuruna sahip bireyler yetiştirmek; araştırma ve geliştirme faaliyetleri ile bilim ve toplum hayatına katkıda bulunmaktır.                                    
                                    </p>
                                    <ul class="features-list">
                                        <li>Köklü Geçmişten</li>
                                        <li>Güçlü Geleceğe</li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="about-vision" role="tabpanel">
                                    <p>
Uluslararası standartlarda eğitim ortamı, bilimsel ve teknolojik araştırma altyapısı ve hizmet anlayışı ile, eğitim ve araştırma faaliyetleri yürüten, Türk Devlet ve Toplulukları arasındaki dostluk ve dayanışmanın sembolü, rekabet gücü yüksek bir üniversite olmaktır.                                    
                                    
                                    </p>
                                    <ul class="features-list">
                                        <li>Köklü Geçmişten</li>
                                        <li>Güçlü Geleceğe</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-image-gallery">
                            <img class="main-img-1" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800" src="assets/images/about/a2.jpg" alt="About Image">
                            <img class="main-img-2" data-sal-delay="100" data-sal="slide-left" data-sal-duration="800" src="assets/images/about/a1.jpg" alt="About Image">
                            <ul class="shape-group">
                                <li class="shape-1 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <img data-depth="2" src="assets/images/about/shape-13.png" alt="Shape">
                                </li>
                                <li class="shape-2 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <img data-depth="-2" src="assets/images/about/shape-39.png" alt="Shape">
                                </li>
                                <li class="shape-3 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <img data-depth="2" src="assets/images/about/shape-07.png" alt="Shape">
                                </li>
                                <li class="shape-4" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-5">
                    <img class="rotateit" src="assets/images/about/shape-13.png" alt="Shape">
                </li>
                <li class="shape-6">
                    <span></span>
                </li>
            </ul>
        </div>
        <!--=====================================-->
        <!--=       CounterUp Area Start      	=-->
        <!--=====================================-->
        <div class="counterup-area-1 gap-lg-bottom-equal">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-3 col-sm-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-counterup counterup-style-1">
                            <h2 class="counter-item count-number primary-color">
                                <span class="odometer" data-odometer-final="12.3">.</span><span>K</span>
                            </h2>
                            <h6 class="title">Kayıtlı Öğrenci</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-counterup counterup-style-1">
                            <h2 class="counter-item count-number secondary-color">
                                <span class="odometer" data-odometer-final="12">.</span><span></span>
                            </h2>
                            <h6 class="title">Fakülte</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-counterup counterup-style-1">
                            <h2 class="counter-item count-number extra02-color">
                                <span class="odometer" data-odometer-final="100">.</span><span>%</span>
                            </h2>
                            <h6 class="title">Memnuniyet</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-counterup counterup-style-1">
                            <h2 class="counter-item count-number extra05-color">
                                <span class="odometer" data-odometer-final="1.2">.</span><span>K+</span>
                            </h2>
                            <h6 class="title">Ders</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=====================================-->
        <!--=       Course Area Start      		=-->
        <!--=====================================-->
        <!-- Start Course Area  -->
        <div class="edu-course-area course-area-3 section-gap-large bg-lighten04">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <span class="pre-title">Haberler</span>
                    <h2 class="title">Duyurular & Etkinlikler</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
                <div class="isotope-wrapper">
                    <div class="isotop-button isotop-filter">
                        <button data-filter=".undergraduate" class="is-checked">
                            <span class="filter-text">Duyurular</span>
                        </button>
                        <button data-filter=".graduate">
                            <span class="filter-text">Haberler</span>
                        </button>
                        <button data-filter=".online">
                            <span class="filter-text">Etkinlikler</span>
                        </button>
                    </div>
                    <div class="row g-5 isotope-list">
                        <!-- Start Single Course  -->
                        <div class="col-md-6 col-lg-4 isotope-item undergraduate graduate">
                            <div class="edu-course course-style-3" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="assets/images/course/h2.jpg" alt="Course Meta">
                                        </a>
                                        <div class="time-top">
                                            <span class="duration"><i class="icon-61"></i>17.04.2015</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <span class="course-level">Haberler</span>
                                        <h5 class="title">
                                            <a href="#">Cumhurbaşkanımız Sayın Recep Tayyip Erdoğan'ın Ziyareti</a>
                                        </h5>
                                        <p>T.C. Cumhurbaşkanı Sayın Recep Tayyip Erdoğan’ın Hoca Ahmet Yesevi Uluslararası Türk-Kazak Üniversitesi Tarafından Fahri Profesörlük Tevdii Töreni’nde Yaptıkları Konuşma.</p>
                                        <div class="course-rating">
                                            <div class="rating">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <span class="rating-count">(5.0 /7 Rating)</span>
                                        </div>
                                        <div class="read-more-btn">
                                            <a class="edu-btn btn-small btn-secondary" href="#">Learn More <i class="icon-4"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Course  -->
                        <!-- Start Single Course  -->
                        <div class="col-md-6 col-lg-4 isotope-item undergraduate graduate">
                            <div class="edu-course course-style-3" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="assets/images/course/h1.jpeg" alt="Course Meta">
                                        </a>
                                        <div class="time-top">
                                            <span class="duration"><i class="icon-61"></i>19.08.2023</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <span class="course-level">Haberler</span>
                                        <h5 class="title">
                                            <a href="#">Karakalpakistan Tıp Enstitüsü ve Ahmet Yesevi Üniversitesi Arasında İş Birliği Protokolü İmzalandı</a>
                                        </h5>
                                        <p>Karakalpakistan Tıp Enstitüsü ve Ahmet Yesevi Üniversitesi, akademik alanda iş birliğini güçlendirmek ve öğrenci değişimi ile bilgi görgü arttırma faaliyetlerini desteklemek amacıyla...</p>
                                        <div class="course-rating">
                                            <div class="rating">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <span class="rating-count">(4.9 /5 Rating)</span>
                                        </div>
                                        <div class="read-more-btn">
                                            <a class="edu-btn btn-small btn-secondary" href="#">Learn More <i class="icon-4"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Course  -->
                        <!-- Start Single Course  -->
                        <div class="col-md-6 col-lg-4 isotope-item undergraduate online">
                            <div class="edu-course course-style-3" data-sal-delay="300" data-sal="slide-up" data-sal-duration="800">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="assets/images/course/h3.jpeg" alt="Course Meta">
                                        </a>
                                        <div class="time-top">
                                            <span class="duration"><i class="icon-61"></i>16.08.2023</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <span class="course-level">Haberler</span>
                                        <h5 class="title">
                                            <a href="">Türk Devletleri Teşkilatı Sağlık Bakanları Toplantısı ve Türk Dünyası Tıp Kongresi Özbekistan’da Gerçekleştirildi</a>
                                        </h5>
                                        <p>Karakalpakistan Tıp Enstitüsü ve Ahmet Yesevi Üniversitesi, akademik alanda iş birliğini güçlendirmek ve öğrenci değişimi ile bilgi görgü arttırma faaliyetlerini desteklemek amacıyla...</p>
                                        <div class="course-rating">
                                            <div class="rating">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <span class="rating-count">(4.7 /9 Rating)</span>
                                        </div>
                                        <div class="read-more-btn">
                                            <a class="edu-btn btn-small btn-secondary" href="">Learn More <i class="icon-4"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Course  -->
                    </div>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1">
                    <img class="d-block-shape-light" data-depth="2" src="assets/images/others/map-shape-3.png" alt="Shape">
                    <img class="d-none-shape-dark" data-depth="2" src="assets/images/others/3-Home-1.png" alt="Shape">
                </li>
                <li class="shape-2">
                    <img class="d-block-shape-light" data-depth="2" src="assets/images/others/map-shape-3.png" alt="Shape">
                    <img class="d-none-shape-dark" data-depth="2" src="assets/images/others/dark-map-shape-3.png" alt="Shape">
                </li>
            </ul>
        </div>
        <!-- End Course Area -->
        <!--=====================================-->
        <!--=       	Campus Area Start      =-->
        <!--=====================================-->
        <!-- Start Campus Area  -->
        <div class="edu-campus-area gap-lg-top-equal">
            <div class="container edublink-animated-shape">
                <div class="row g-5">
                    <div class="col-xl-7" data-sal-delay="50" data-sal="slide-right" data-sal-duration="800">
                        <div class="campus-image-gallery">
                            <div class="campus-thumbnail">
                                <div class="thumbnail">
                                    <img src="assets/images/others/c1.jpg" alt="Campus">
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1 scene">
                                    <span data-depth=".8"></span>
                                </li>
                                <li class="shape-2 scene">
                                    <img data-depth="1.5" src="assets/images/about/shape-21.png" alt="Shape">
                                </li>
                                <li class="shape-3 scene">
                                    <img data-depth="-1.5" src="assets/images/about/shape-13.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-5" data-sal-delay="50" data-sal="slide-left" data-sal-duration="800">
                        <div class="campus-content">
                            <div class="inner">
                                <div class="section-title section-left">
                                    <span class="pre-title">Kampüs</span>
                                    <h2 class="title">Kampüste Yaşam</h2>
                                    <span class="shape-line"><i class="icon-19"></i></span>
                                </div>
                                <div class="features-list">
                                    <div class="features-box color-secondary-style">
                                        <div class="icon">
                                            <i class="icon-37 watch-icon"></i>
                                        </div>
                                        <div class="content">
                                            <h5 class="title">Kültür Merkezi</h5>
                                            <p>Üniversitemiz Türkistan Yerleşkesi’nde, kültür-sanat hizmetleri veren bir Kültür Merkezi bulunmaktadır. Merkezde bir de Kütüphane vardır.</p>
                                        </div>
                                    </div>
                                    <div class="features-box color-primary-style">
                                        <div class="icon">
                                            <i class="icon-38 art-board-icon"></i>
                                        </div>
                                        <div class="content">
                                            <h5 class="title">Sanat ve Kulüpler</h5>
                                            <p>Sanat Merkezleri, Müzeler ve Öğrenci Kulüpleri</p>
                                        </div>
                                    </div>
                                    <div class="features-box color-extra05-style">
                                        <div class="icon">
                                            <i class="icon-39 fitness-icon"></i>
                                        </div>
                                        <div class="content">
                                            <h5 class="title">Spor &amp; Fitness</h5>
                                            <p>2 tenis, 6 basketbol, 6 voleybol, 3 mini futbol sahası, 1 futbol sahası, profesyonel manada 1 futbol stadı, 1 Uzak Doğu sporları salonu ve dahası...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul class="shape-group">
                                <li class="shape-4 scene">
                                    <span data-depth=".8"></span>
                                </li>
                                <li class="shape-5 scene">
                                    <span data-depth="2"></span>
                                </li>
                                <li class="shape-6 scene">
                                    <img data-depth="-2" src="assets/images/about/shape-25.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Campus Area  -->
        <!--=====================================-->
        <!--=       Testimonial Area Start      =-->
        <!--=====================================-->
        <!-- Start Testimonial Area  -->
        <!--div class="testimonial-area-2 section-gap-large">
            <div class="container edublink-animated-shape">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                            <span class="pre-title">Testimonials</span>
                            <h2 class="title">What Our Students <br> Have To Say</h2>
                            <span class="shape-line"><i class="icon-19"></i></span>
                            <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor incidid unt labore dolore magna aliquaenim minim.</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-activation swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-slide">
                                <div class="content">
                                    <div class="logo"><img src="assets/images/testimonial/logo-01.png" alt="Logo"></div>
                                    <p>Lorem ipsum dolor amet consectur elit adicing elit sed do umod tempor ux incididunt enim ad minim veniam quis nosrud citation laboris nisiste aliquip comodo perspiatix.</p>
                                    <div class="rating-icon">
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                    </div>
                                </div>
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="assets/images/testimonial/testimonial-01.png" alt="Testimonial">
                                    </div>
                                    <div class="info">
                                        <h5 class="title">Ray Sanchez</h5>
                                        <span class="subtitle">Student</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-slide">
                                <div class="content">
                                    <div class="logo"><img src="assets/images/testimonial/logo-02.png" alt="Logo"></div>
                                    <p>Lorem ipsum dolor amet consectur elit adicing elit sed do umod tempor ux incididunt enim ad minim veniam quis nosrud citation laboris nisiste aliquip comodo perspiatix.</p>
                                    <div class="rating-icon">
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                    </div>
                                </div>
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="assets/images/testimonial/testimonial-02.png" alt="Testimonial">
                                    </div>
                                    <div class="info">
                                        <h5 class="title">Thomas Lopez</h5>
                                        <span class="subtitle">Designer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-slide">
                                <div class="content">
                                    <div class="logo"><img src="assets/images/testimonial/logo-03.png" alt="Logo"></div>
                                    <p>Lorem ipsum dolor amet consectur elit adicing elit sed do umod tempor ux incididunt enim ad minim veniam quis nosrud citation laboris nisiste aliquip comodo perspiatix.</p>
                                    <div class="rating-icon">
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                    </div>
                                </div>
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="assets/images/testimonial/testimonial-03.png" alt="Testimonial">
                                    </div>
                                    <div class="info">
                                        <h5 class="title">Amber Page</h5>
                                        <span class="subtitle">Developer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-slide">
                                <div class="content">
                                    <div class="logo"><img src="assets/images/testimonial/logo-02.png" alt="Logo"></div>
                                    <p>Lorem ipsum dolor amet consectur elit adicing elit sed do umod tempor ux incididunt enim ad minim veniam quis nosrud citation laboris nisiste aliquip comodo perspiatix.</p>
                                    <div class="rating-icon">
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                        <i class="icon-23"></i>
                                    </div>
                                </div>
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="assets/images/testimonial/testimonial-04.png" alt="Testimonial">
                                    </div>
                                    <div class="info">
                                        <h5 class="title">Robert Tapp</h5>
                                        <span class="subtitle">Content Creator</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <ul class="shape-group">
                    <li class="shape-1 scene" data-sal-delay="200" data-sal="fade" data-sal-duration="1000">
                        <img data-depth="1.4" src="assets/images/about/shape-30.png" alt="Shape">
                    </li>
                    <li class="shape-2 scene" data-sal-delay="200" data-sal="fade" data-sal-duration="1000">
                        <img data-depth="-1.4" src="assets/images/about/shape-25.png" alt="Shape">
                    </li>
                </ul>
            </div>
            <ul class="shape-group">
                <li class="shape-3" data-sal-delay="200" data-sal="fade" data-sal-duration="1000">
                    <img class="d-block-shape-light" data-depth="2" src="assets/images/others/map-shape-3.png" alt="Shape">
                    <img class="d-none-shape-dark" data-depth="2" src="assets/images/others/dark-map-2-shape-3.png" alt="Shape">
                </li>
            </ul>
        </div-->
        <!-- End Testimonial Area  -->
        <!--=====================================-->
        <!--=       Video Area Start      		=-->
        <!--=====================================-->
        <div class="video-area-2 bg-image--14 bg-image">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="video-banner-content">
                            <div class="video-btn">
                                <a href="https://www.youtube.com/watch?v=YDua-fpwK28" class="video-play-btn video-popup-activation">
                                    <i class="icon-18"></i>
                                </a>
                            </div>
                            <h2 class="title">Ahmet Yesevi Üniversitesi<br>Tanıtım Videosu</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=====================================-->
        <!--=       	CTA Area Start      	=-->
        <!--=====================================-->
        <!-- Start CTA Area  -->
        <div class="cta-area-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="edu-cta-box cta-style-2 bg-image bg-image--9">
                            <div class="inner">
                                <div class="content text-end">
                                    <span class="subtitle">Bize yazın:</span>
                                    <h3 class="title"><a href="mailto:info@ayu.edu.kz">info@ayu.edu.kz</a></h3>
                                </div>
                                <div class="sparator">
                                    <span>veya</span>
                                </div>
                                <div class="content">
                                    <span class="subtitle">Bizi arayın:</span>
                                    <h3 class="title"><a href="tel:+011235641231"> +7 (725) 336 36 36</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End CTA Area  -->
        <!--=====================================-->
        <!--=       Event Area Start      		=-->
        <!--=====================================-->
        <!-- Start Event Area  -->
        <div class="edu-event-area event-area-1 gap-large-text">
            <div class="container edublink-animated-shape">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <span class="pre-title">Etkinlikler</span>
                    <h2 class="title">Önemli Etkinlikler</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
                <div class="row g-5">
                    <!-- Start Event Grid  -->
                    <div class="col-lg-4 col-md-6" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-event event-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="event-details.html">
                                        <img src="assets/images/event/event-01.jpg" alt="Blog Images">
                                    </a>
                                    <div class="event-time">
                                        <span><i class="icon-33"></i>08:00AM-10:00PM</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="event-date">
                                        <span class="day">04</span>
                                        <span class="month">EYL</span>
                                    </div>
                                    <h5 class="title"><a href="event-details.html">Yeni Ders Yılı Başlıyor</a></h5>
                                    <p>2023-2024 Eğitim ve Öğretim Yılı 4 Eylül Pazartesi Günü Başlıyor</p>
                                    <ul class="event-meta">
                                        <li><i class="icon-40"></i>Türkistan, Kazakistan</li>
                                    </ul>
                                    <div class="read-more-btn">
                                        <a class="edu-btn btn-small btn-secondary" href="event-details.html">Learn More <i class="icon-4"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Event Grid  -->
                    <!-- Start Event Grid  -->
                    <div class="col-lg-4 col-md-6" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-event event-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="event-details.html">
                                        <img src="assets/images/event/event-02.jpg" alt="Blog Images">
                                    </a>
                                    <div class="event-time">
                                        <span><i class="icon-33"></i>04:00PM-07:00PM</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="event-date">
                                        <span class="day">25</span>
                                        <span class="month">KAS</span>
                                    </div>
                                    <h5 class="title"><a href="event-details.html">Ara Sınavlar Başlıyor</a></h5>
                                    <p>Ara Sınavlar 25 Kasım 2023 tarihinde başlıyor...</p>
                                    <ul class="event-meta">
                                        <li><i class="icon-40"></i>Türkistan, Kazakistan</li>
                                    </ul>
                                    <div class="read-more-btn">
                                        <a class="edu-btn btn-small btn-secondary" href="event-details.html">Learn More <i class="icon-4"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Event Grid  -->
                    <!-- Start Event Grid  -->
                    <div class="col-lg-4 col-md-6" data-sal-delay="300" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-event event-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="event-details.html">
                                        <img src="assets/images/event/event-03.jpg" alt="Blog Images">
                                    </a>
                                    <div class="event-time">
                                        <span><i class="icon-33"></i>10:00AM-11:00AM</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="event-date">
                                        <span class="day">18</span>
                                        <span class="month">MAR</span>
                                    </div>
                                    <h5 class="title"><a href="event-details.html">Nevruz Tatili Başlıyor</a></h5>
                                    <p>Nevruz Tatili 18 Mart 2024 tarihinde başlıyor..</p>
                                    <ul class="event-meta">
                                        <li><i class="icon-40"></i>Türkistan, Kazakistan</li>
                                    </ul>
                                    <div class="read-more-btn">
                                        <a class="edu-btn btn-small btn-secondary" href="event-details.html">Learn More <i class="icon-4"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Event Grid  -->
                    <!-- Start Event Grid  -->
                    <div class="col-lg-4 col-md-6" data-sal-delay="300" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-event event-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="event-details.html">
                                        <img src="assets/images/event/event-03.jpg" alt="Blog Images">
                                    </a>
                                    <div class="event-time">
                                        <span><i class="icon-33"></i>10:00AM-11:00AM</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="event-date">
                                        <span class="day">18</span>
                                        <span class="month">MAR</span>
                                    </div>
                                    <h5 class="title"><a href="event-details.html">Nevruz Tatili Başlıyor</a></h5>
                                    <p>Nevruz Tatili 18 Mart 2024 tarihinde başlıyor..</p>
                                    <ul class="event-meta">
                                        <li><i class="icon-40"></i>Türkistan, Kazakistan</li>
                                    </ul>
                                    <div class="read-more-btn">
                                        <a class="edu-btn btn-small btn-secondary" href="event-details.html">Learn More <i class="icon-4"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Event Grid  -->
                    <!-- Start Event Grid  -->
                    <div class="col-lg-4 col-md-6" data-sal-delay="300" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-event event-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="event-details.html">
                                        <img src="assets/images/event/event-03.jpg" alt="Blog Images">
                                    </a>
                                    <div class="event-time">
                                        <span><i class="icon-33"></i>10:00AM-11:00AM</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="event-date">
                                        <span class="day">18</span>
                                        <span class="month">MAR</span>
                                    </div>
                                    <h5 class="title"><a href="event-details.html">Nevruz Tatili Başlıyor</a></h5>
                                    <p>Nevruz Tatili 18 Mart 2024 tarihinde başlıyor..</p>
                                    <ul class="event-meta">
                                        <li><i class="icon-40"></i>Türkistan, Kazakistan</li>
                                    </ul>
                                    <div class="read-more-btn">
                                        <a class="edu-btn btn-small btn-secondary" href="event-details.html">Learn More <i class="icon-4"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Event Grid  -->
                </div>
                <div class="event-view-all-btn" data-sal-delay="150" data-sal="slide-up" data-sal-duration="1200">
                    <h6 class="view-text">The Latest Events from EduBlink. <a href="event-grid.html" class="btn-transparent">View All <i class="icon-4"></i></a></h6>
                </div>

                <ul class="shape-group">
                    <li class="shape-1" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                        <img class="rotateit" src="assets/images/about/shape-13.png" alt="Shape">
                    </li>
                    <li class="shape-2 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                        <span data-depth=".9"></span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Event Area  -->
        <!--=====================================-->
        <!--=       Brand Area Start      		=-->
        <!--=====================================-->
        <!-- Start Brand Area  -->
        <div class="edu-brand-area brand-area-4 gap-lg-bottom-equal">
            <div class="container">
                <div class="brand-grid-wrap brand-style-2">
                    <div class="brand-grid">
                        <img src="assets/images/brand/brand-01.png" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="assets/images/brand/brand-02.png" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="assets/images/brand/brand-03.png" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="assets/images/brand/brand-04.png" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="assets/images/brand/brand-05.png" alt="Brand Logo">
                    </div>
                    <div class="brand-grid">
                        <img src="assets/images/brand/brand-06.png" alt="Brand Logo">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Brand Area  -->
        <!--=====================================-->
        <!--=       CTA Banner Area Start      =-->
        <!--=====================================-->
        <!-- Start Ad Banner Area  -->
        <div class="university-cta-wrapper edu-cta-banner-area bg-image">
            <div class="container">
                <div class="edu-cta-banner">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                                <h2 class="title">Get Your Quality Skills <span class="color-primary">Certificate</span> Through EduBlink</h2>
                                <a href="contact-us.html" class="edu-btn btn-secondary">Get started now <i class="icon-4"></i></a>
                            </div>
                        </div>
                    </div>
                    <ul class="shape-group">
                        <li class="shape-01 scene">
                            <img data-depth="2.5" src="assets/images/cta/shape-10.png" alt="shape">
                        </li>
                        <li class="shape-02 scene">
                            <img data-depth="-2.5" src="assets/images/cta/shape-09.png" alt="shape">
                        </li>
                        <li class="shape-03 scene">
                            <img data-depth="-2" src="assets/images/cta/shape-08.png" alt="shape">
                        </li>
                        <li class="shape-04 scene">
                            <img data-depth="2" src="assets/images/about/shape-13.png" alt="shape">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Ad Banner Area  -->
        <!--=====================================-->
        <!--=        Footer Area Start       	=-->
        <!--=====================================-->
        <!-- Start Footer Area  -->
        <footer class="edu-footer footer-dark bg-image footer-style-3">
            <div class="footer-top">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-3 col-md-6">
                            <div class="edu-footer-widget">
                                <div class="logo">
                                    <a href="index.html">
                                        <img class="logo-light" src="assets/images/logo/ayu_logo.png" alt="Corporate Logo" style="width:200px;">
                                    </a>
                                </div>
                                <p class="description">Köklü Geçmişten <br> Güçlü Geleceğe...</p>
                                <div class="widget-information">
                                    <ul class="information-list">
                                        <li><span>Add:</span>70-80 Upper St Norwich NR2</li>
                                        <li><span>Call:</span><a href="tel:+011235641231">+01 123 5641 231</a></li>
                                        <li><span>Email:</span><a href="mailto:info@edublink.com" target="_blank">info@edublink.com</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="edu-footer-widget explore-widget">
                                <h4 class="widget-title">Online Platform</h4>
                                <div class="inner">
                                    <ul class="footer-link link-hover">
                                        <li><a href="about-one.html">About</a></li>
                                        <li><a href="course-one.html">Courses</a></li>
                                        <li><a href="team-one.html">Instructor</a></li>
                                        <li><a href="event-grid.html">Events</a></li>
                                        <li><a href="team-details.html">Instructor Profile</a></li>
                                        <li><a href="purchase-guide.html">Purchase Guide</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="edu-footer-widget quick-link-widget">
                                <h4 class="widget-title">Links</h4>
                                <div class="inner">
                                    <ul class="footer-link link-hover">
                                        <li><a href="contact-us.html">Contact Us</a></li>
                                        <li><a href="gallery-grid.html">Gallery</a></li>
                                        <li><a href="blog-standard.html">News & Articles</a></li>
                                        <li><a href="faq.html">FAQ's</a></li>
                                        <li><a href="my-account.html">Sign In/Registration</a></li>
                                        <li><a href="coming-soon.html">Coming Soon</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="edu-footer-widget">
                                <h4 class="widget-title">Contacts</h4>
                                <div class="inner">
                                    <p class="description">Enter your email address to register to our newsletter subscription</p>
                                    <div class="input-group footer-subscription-form">
                                        <input type="email" class="form-control" placeholder="Your email">
                                        <button class="edu-btn btn-secondary btn-medium" type="button">Subscribe <i class="icon-4"></i></button>
                                    </div>
                                    <ul class="social-share icon-transparent">
                                        <li><a href="#" class="color-fb"><i class="icon-facebook"></i></a></li>
                                        <li><a href="#" class="color-linkd"><i class="icon-linkedin2"></i></a></li>
                                        <li><a href="#" class="color-ig"><i class="icon-instagram"></i></a></li>
                                        <li><a href="#" class="color-twitter"><i class="icon-twitter"></i></a></li>
                                        <li><a href="#" class="color-yt"><i class="icon-youtube"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="inner text-center">
                                <p>Copyright 2023 <a href="https://1.envato.market/5bQ022" target="_blank">EduBlink</a> Designed By <a href="https://1.envato.market/YgGJbj" target="_blank">DevsBlink</a>. All Rights Reserved</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer Area  -->



    </div>

    <div class="rn-progress-parent">
        <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- JS
	============================================ -->
    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr.min.js"></script>
    <!-- Jquery Js -->
    <script src="assets/js/vendor/jquery.min.js"></script>
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script src="assets/js/vendor/sal.min.js"></script>
    <script src="assets/js/vendor/backtotop.min.js"></script>
    <script src="assets/js/vendor/magnifypopup.min.js"></script>
    <script src="assets/js/vendor/jquery.countdown.min.js"></script>
    <script src="assets/js/vendor/odometer.min.js"></script>
    <script src="assets/js/vendor/isotop.min.js"></script>
    <script src="assets/js/vendor/imageloaded.min.js"></script>
    <script src="assets/js/vendor/lightbox.min.js"></script>
    <script src="assets/js/vendor/paralax.min.js"></script>
    <script src="assets/js/vendor/paralax-scroll.min.js"></script>
    <script src="assets/js/vendor/jquery-ui.min.js"></script>
    <script src="assets/js/vendor/swiper-bundle.min.js"></script>
    <script src="assets/js/vendor/svg-inject.min.js"></script>
    <script src="assets/js/vendor/vivus.min.js"></script>
    <script src="assets/js/vendor/tipped.min.js"></script>
    <script src="assets/js/vendor/smooth-scroll.min.js"></script>
    <script src="assets/js/vendor/isInViewport.jquery.min.js"></script>

    <!-- Site Scripts -->
    <script src="assets/js/app.js"></script>
</body>

</html>