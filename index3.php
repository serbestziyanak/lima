<?php
include "admin/_cekirdek/fonksiyonlar.php";
$vt = new VeriTabani();
$fn = new Fonksiyonlar();
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$diller = array("tr", "kz", "en", "ru");

$birim_id = 1;
$sayfa_id = $_REQUEST['sayfa_id'];
//var_dump($_REQUEST);
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
    ust_id = ? AND aktif = 1
SQL;

$SQL_birim_sayfalari_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_sayfalari
WHERE 
	aktif$dil = 1 AND harici = 0 AND birim_id = ?
ORDER BY sira
SQL;

$SQL_alt_sayfalari_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_sayfalari
WHERE 
	aktif$dil = 1 AND harici = 0 AND birim_id = 1 AND ust_id = ?
ORDER BY sira
SQL;

$SQL_alt_sayfalari_getir_eski = <<< SQL
SELECT
	 (select count(baslik$dil) from tb_birim_sayfa_icerikleri_sss WHERE sayfa_id = bs.id and baslik$dil!="" ) as sss_sayisi
	,(select count(baslik$dil) from tb_birim_sayfa_icerikleri_tabs WHERE sayfa_id = bs.id and baslik$dil!="" ) as tab_sayisi
	,(select count(adi$dil) from tb_birim_sayfa_icerikleri_personeller WHERE sayfa_id = bs.id and adi$dil!="" ) as personel_sayisi
	,(select count(foto) from tb_sayfa_galeri WHERE sayfa_id = bs.id  ) as galeri_sayisi
	,bsi.*
	,bs.*
FROM 
	tb_birim_sayfalari as bs
LEFT JOIN tb_birim_sayfa_icerikleri as bsi ON bs.id = bsi.sayfa_id
WHERE 
	bs.aktif$dil = 1 AND bs.harici = 0 AND bs.birim_id = 1 AND bs.ust_id = ?
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
WHERE 
    birim_id = ? and baslik$dil != ""
ORDER BY tarih DESC
LIMIT 6
SQL;

$SQL_haberler = <<< SQL
SELECT
  *
FROM 
  tb_haberler
WHERE 
    birim_id = ? and baslik$dil != ""
ORDER BY tarih DESC
LIMIT 6
SQL;

$SQL_etkinlikler = <<< SQL
SELECT
  *
FROM 
  tb_etkinlikler
WHERE 
    birim_id = ? and baslik$dil != ""
ORDER BY tarih DESC
LIMIT 6
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
  id = ?  AND aktif = 1
SQL;

$SQL_bolumler = <<< SQL
SELECT
  *
FROM 
  tb_birim_agaci
WHERE
  ust_id = ?  AND aktif = 1
SQL;

$SQL_birim_sayfa_bilgileri = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfalari
WHERE
  id = ? and birim_id = 1
SQL;

$SQL_birim_sayfa_bilgileri_id = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfalari
WHERE
  id = ? and birim_id = 1
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
SQL;

$SQL_fakulteler = <<< SQL
SELECT
  b.*
 ,g.birim_icon
FROM 
  tb_birim_agaci as b
LEFT JOIN tb_genel_ayarlar AS g ON b.id=g.birim_id
WHERE 
   b. birim_turu = 2  AND b.aktif = 1
ORDER BY adi
SQL;

$SQL_tum_onemli_baglantilar = <<< SQL
SELECT 
	*
FROM 
	tb_onemli_baglantilar
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

$SQL_sayfalar_ust_id_getir = <<< SQL
WITH RECURSIVE ust_kategoriler AS (
    SELECT *
    FROM tb_birim_sayfalari
    WHERE id = ? -- burası istediğiniz başlangıç ID'si
    UNION ALL
    SELECT k.*
    FROM tb_birim_sayfalari k
    JOIN ust_kategoriler uk ON k.id = uk.ust_id
)
SELECT * FROM ust_kategoriler ORDER BY ust_id;
SQL;
$sayfa_ust_bilgiler_dizi			= $vt->select( $SQL_sayfalar_ust_id_getir, array( $sayfa_id ) )[ 2 ];


@$birim_bilgileri 	    = $vt->selectSingle($SQL_birim_bilgileri, array( 1 ) )[ 2 ];

@$birim_sayfa_bilgileri = $vt->selectSingle($SQL_birim_sayfa_bilgileri, array( $sayfa_id ) )[ 2 ];
//var_dump($birim_sayfa_bilgileri);
@$birim_sayfa_icerikleri = $vt->selectSingle($SQL_birim_sayfa_icerikleri, array( $sayfa_id ) )[ 2 ];
@$duyuru_icerik          = $vt->selectSingle($SQL_duyuru_icerik, array( $_REQUEST['id'] ) )[ 2 ];
@$etkinlik_icerik        = $vt->selectSingle($SQL_etkinlik_icerik, array( $_REQUEST['id'] ) )[ 2 ];

@$birim_sayfalari 		= $vt->select($SQL_birim_sayfalari_getir, array( $birim_id ) )[ 2 ];
@$duyurular 	        = $vt->select($SQL_duyurular, array( $birim_id ) )[ 2 ];
@$haberler 	            = $vt->select($SQL_haberler, array( $birim_id ) )[ 2 ];
@$etkinlikler 	        = $vt->select($SQL_etkinlikler, array( $birim_id ) )[ 2 ];
@$slaytlar 	            = $vt->select($SQL_slaytlar, array( $birim_id ) )[ 2 ];
@$genel_ayarlar 	    = $vt->selectSingle($SQL_genel_ayarlar, array( $birim_id ) )[ 2 ];
@$gorevler   			= $vt->select( $SQL_tum_gorevler, 	array( $birim_id ) )[ 2 ];
@$fakulteler   			= $vt->select( $SQL_fakulteler, array(  ) )[ 2 ];
$onemli_baglantilar		= $vt->select( $SQL_tum_onemli_baglantilar, array( ) )[ 2 ];

@$ceviriler	            = $vt->select($SQL_ceviriler, array(  ) )[ 2 ];
foreach( $ceviriler as $ceviri ){
    $dizi_dil[$ceviri['adi']]['tr'] = $ceviri['adi']; 
    $dizi_dil[$ceviri['adi']]['kz'] = $ceviri['adi_kz']; 
    $dizi_dil[$ceviri['adi']]['en'] = $ceviri['adi_en']; 
    $dizi_dil[$ceviri['adi']]['ru'] = $ceviri['adi_ru']; 
}

function dil_cevir( $metin, $dizi, $dil ){
// $myfile = fopen("ceviriler.txt", "a") or die("Unable to open file!");
// $txt = $metin."\n";
// fwrite($myfile, $txt);
// fclose($myfile);

	if( array_key_exists( $metin, $dizi ) and $dizi[$metin][$dil] != "" )
		return $dizi[$metin][$dil];
	else
		return $metin;

}

//var_dump($fakulteler);
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
<base href="/" />
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EduBlink | Online Education Platform</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Spartan:wght@100..900&display=swap" rel="stylesheet">    
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=icomoon' rel='stylesheet'>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">
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
        <header class="edu-header header-style-1 header-fullwidth">
            <div class="header-top-bar">
                <div class="container-fluid">
                    <div class="header-top">
                        <div class="header-top-left">
                            <div class="header-notify">
                                First 20 students get 50% discount. <a href="#">Hurry up!</a>
                            </div>
                        </div>
                        <div class="header-top-right">
                            <ul class="header-info">
                                <li><a href="#">Login</a></li>
                                <li><a href="#">Register</a></li>
                                <li><a href="tel:+011235641231"><i class="icon-phone"></i>Call: 123 4561 5523</a></li>
                                <li><a href="mailto:info@edublink.com" target="_blank"><i class="icon-envelope"></i>Email: info@edublink.com</a></li>
                                <li class="social-icon">
                                    <a href="#"><i class="icon-facebook"></i></a>
                                    <a href="#"><i class="icon-instagram"></i></a>
                                    <a href="#"><i class="icon-twitter"></i></a>
                                    <a href="#"><i class="icon-linkedin2"></i></a>
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
                                <a href="/<?php echo $_REQUEST['dil']; ?>/">
                                    <img class="logo-light" src="admin/resimler/logolar/<?php echo $genel_ayarlar['logo'.$dil]; ?>" alt="Corporate Logo" style="height:80px;">
                                    <img class="logo-dark" src="admin/resimler/logolar/<?php echo $genel_ayarlar['logo'.$dil]; ?>" alt="Corporate Logo">
                                </a>
                            </div>
                            <!-- <div class="logo">
                                <a href="index.html">
                                    <img class="logo-light" src="assets/images/logo/logo-dark.png" alt="Corporate Logo">
                                    <img class="logo-dark" src="assets/images/logo/logo-white.png" alt="Corporate Logo">
                                </a>
                            </div> -->
                            <!-- <div class="header-category">
                                <nav class="mainmenu-nav">
                                    <ul class="mainmenu">
                                        <li class="has-droupdown">
                                            <a href="#"><i class="icon-1"></i>Category</a>
                                            <ul class="submenu">
                                                <li><a href="course-one.html">Design</a></li>
                                                <li><a href="course-one.html">Development</a></li>
                                                <li><a href="course-one.html">Architecture</a></li>
                                                <li><a href="course-one.html">Life Style</a></li>
                                                <li><a href="course-one.html">Data Science</a></li>
                                                <li><a href="course-one.html">Marketing</a></li>
                                                <li><a href="course-one.html">Music</a></li>
                                                <li><a href="course-one.html">Photography</a></li>
                                                <li><a href="course-one.html">Finance</a></li>
                                                <li><a href="course-one.html">Motivation</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div> -->
                        </div>
                        <div class="header-mainnav">
                            <!-- <nav class="mainmenu-nav">
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
                            </nav> -->
                            <nav class="mainmenu-nav">
                                <ul class="mainmenu">
                                    <li style="color:white;border-left: 1px solid rgba(0, 0, 0, 0.08);"><a href="/<?php echo $_REQUEST['dil'] ?>"><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                    <?php 
                                        function buildList3(array $array, int $ust_id, int $onceki_ust_id, int $ilk, $birim_id, $dil,$vt,$SQL_akademik_birimler): string
                                        {
                                            $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            $dil2 = $dil == "tr" ? "" : "_".$dil ;
                                            $adi = "adi".$dil2;
                                            if( $ilk ){
                                                $menu = "";
                                            }else{
                                                if( $onceki_ust_id == 0 ){
                                                $menu = "<ul class='mega-menu mega-menu-one'>";
                                                        // $menu .= "<li>
                                                        //     <ul class='submenu mega-sub-menu-01'>
                                                        //         <li>
                                                        //             <a href='https://1.envato.market/5bQ022'>
                                                        //                 <img src='assets/images/others/mega-menu-image.webp' alt='advertising Image'>
                                                        //             </a>
                                                        //         </li>
                                                        //     </ul>
                                                        // </li>";

                                                }else{
                                                $menu = "<ul class='submenu '>";
                                                }
                                            }
                                            foreach($array as $item) {
                                                if( $item['ust_id'] == $ust_id ){
                                                    if( $item['kategori'] == 0 ){
                                                        if( $item['ust_id'] == 0 ){
                                                            $menu .= "<li><a href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                                        }else{
                                                            if( $onceki_ust_id == 0 )
                                                                $menu .= "<li ><h6 style='margin:0px;'><a style='color:#eb0023;margin-top:0px;margin-bottom:0px;' href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></h6></li>";
                                                            else
                                                                $menu .= "<li ><a href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                                        }
                                                    }else{
                                                        if( $ust_id == 0 )
                                                            $menu .= "<li class='has-droupdown'><a href='$actual_link#' >{$item[$adi]}</a>";
                                                            else
                                                            $menu .= "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>{$item[$adi]}</h6>";
                                                    }
                                                    if ( $item['kategori'] == 1 ) {
                                                        if( $item['kisa_ad'] == 'akademik' ){
                                                            $menu .= "<ul class='mega-menu mega-menu-one'>";
                                                            @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 2 ) )[ 2 ];
                                                            foreach( @$akademik_birimler as $birim ){
                                                            $menu .= "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim[$adi]</h6><ul class='submenu'>";
                                                                    
                                                                @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                                foreach(@$akademik_birimler2 as $birim2){
                                                                $menu .= "<li><a href='birimler/tr/$birim2[kisa_ad]'>$birim2[$adi]</a></li>";
                                                                } 
                                                            $menu .= "</ul></li>";
                                                            }
                                                            $menu .= "</ul>";
                                                        }elseif( $item['kisa_ad'] == 'idari' ){
                                                            $menu .= "<ul class='mega-menu mega-menu-one'>";
                                                            @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 3 ) )[ 2 ];
                                                            foreach( @$akademik_birimler as $birim ){
                                                            $menu .= "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim[$adi]</h6><ul class='submenu'>";
                                                                    
                                                                @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                                foreach(@$akademik_birimler2 as $birim2){
                                                                $menu .= "<li><a href='birimler/tr/$birim2[kisa_ad]'>$birim2[$adi]</a></li>";
                                                                } 
                                                            $menu .= "</ul></li>";
                                                            }
                                                            $menu .= "</ul>";
                                                        }else{
                                                            $menu .= buildList3($array, $item['id'], $item['ust_id'],0, $birim_id, $dil,$vt,$SQL_akademik_birimler);
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
                                        //echo buildList3($birim_sayfalari, 0,0, 1, $birim_id, $_REQUEST['dil'],$vt,$SQL_akademik_birimler,$SQL_alt_sayfalari_getir);
                                    ?>

                                <?php
                                $adi = "adi".$dil;
                                @$birim_sayfalari_bir = $vt->select($SQL_alt_sayfalari_getir, array( 0 ) )[ 2 ];
                                foreach( $birim_sayfalari_bir as $birim_sayfa_bir ){
                                    if( $birim_sayfa_bir['kategori'] == 0 ){
                                        if( $birim_sayfa_bir['link'] == 1 ){
                                            $link_url = $birim_sayfa_bir['link_url'];
                                            $target = "_blank";
                                        }else{
                                            $link_url = $_REQUEST['dil']."/".$birim_sayfa_bir['id']."/".$birim_sayfa_bir['kisa_ad'];
                                            $target = "";
                                        }


                                ?>
                                    <li><a href="<?php echo $link_url;?>" target="<?php echo $target;?>"><?php echo $birim_sayfa_bir['adi'.$dil]; ?></a></li>
                                    <?php
                                    }else{
                                    ?>
                                    <li class="has-droupdown"><a href="<?php echo $actual_link; ?>#" ><?php echo $birim_sayfa_bir['adi'.$dil]; ?></a>
                                                        <?php
                                                        if( $birim_sayfa_bir['kisa_ad'] == 'akademik' ){
                                                            @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 2 ) )[ 2 ];
                                                            echo "<ul class='mega-menu mega-menu-one' style='grid-template-columns: repeat(1, 1fr);'>";
                                                            foreach( @$akademik_birimler as $birim ){
                                                                if( $birim['id'] == 5)
                                                                    continue;
                                                                echo "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim[$adi]</h6><ul class='submenu'>";
                                                                    
                                                                @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                                foreach(@$akademik_birimler2 as $birim2){
                                                                    if( trim($birim2['link_url']) == "" ){
                                                                        $link_url = "birimler/$_REQUEST[dil]/$birim2[kisa_ad]";
                                                                    }else{
                                                                        $link_url = $birim2['link_url'];
                                                                    }

                                                                    echo "<li><a target='_blank' href='$link_url'>$birim2[$adi]</a></li>";
                                                                } 
                                                            echo "</ul></li>";
                                                            }
                                                            echo "</ul></li>";
                                                        }elseif( $birim_sayfa_bir['kisa_ad'] == 'enstituler' ){
                                                            echo "<ul class='mega-menu mega-menu-one' style='grid-template-columns: repeat(2, 1fr);'>";
                                                            echo "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim_sayfa_bir[$adi]</h6><ul class='submenu '>";
                                                            @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 5 ) )[ 2 ];
                                                            foreach( @$akademik_birimler as $birim ){
                                                                if( trim($birim['link_url']) == "" ){
                                                                    $link_url = "birimler/$_REQUEST[dil]/$birim[kisa_ad]";
                                                                }else{
                                                                    $link_url = $birim['link_url'];
                                                                }

                                                                echo "<li><a target='_blank' href='$link_url'>$birim[$adi]</a></li>";
                                                            }
                                                            echo "</ul></li></ul>";
                                                        }else{
                                                        ?>

                                    <ul class='mega-menu mega-menu-one'>
                                        <?php
                                        @$birim_sayfalari_iki = $vt->select($SQL_alt_sayfalari_getir, array( $birim_sayfa_bir['id'] ) )[ 2 ];
                                        $kategori_sayisi = 0;
                                        foreach( $birim_sayfalari_iki as $birim_sayfa_iki ){
                                            if( $birim_sayfa_iki['kategori'] == 1 ){
                                                $kategori_sayisi++;
                                        ?>
                                            <li><h6 style="color:#eb0023;margin-top:10px;margin-bottom:0px;"><?php echo $birim_sayfa_iki['adi'.$dil]; ?></h6>
                                                <ul class='submenu '>
                                                    <?php
                                                    @$birim_sayfalari_uc = $vt->select($SQL_alt_sayfalari_getir, array( $birim_sayfa_iki['id'] ) )[ 2 ];
                                                    foreach( $birim_sayfalari_uc as $birim_sayfa_uc ){
                                                    if( $birim_sayfa_uc['link'] == 1 ){
                                                        $link_url = $birim_sayfa_uc['link_url'];
                                                        $target = "_blank";
                                                    }else{
                                                        $link_url = $_REQUEST['dil']."/".$birim_sayfa_uc['id']."/".$birim_sayfa_uc['kisa_ad'];
                                                        $target = "";
                                                    }

                                                    ?>
                                                    <li><a href="<?php echo $link_url;?>" target="<?php echo $target;?>"><?php echo $birim_sayfa_uc['adi'.$dil]; ?></a></li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        $sira=0;
                                        foreach( $birim_sayfalari_iki as $birim_sayfa_iki ){
                                            if( $birim_sayfa_iki['kategori'] == 0 ){
                                                if( $birim_sayfa_iki['link'] == 1 ){
                                                    $link_url = $birim_sayfa_iki['link_url'];
                                                    $target = "_blank";
                                                }else{
                                                    $link_url = $_REQUEST['dil']."/".$birim_sayfa_iki['id']."/".$birim_sayfa_iki['kisa_ad'];
                                                    $target = "";
                                                }

                                                $sira++;
                                                if( $sira == 1 ){
                                                    if( $kategori_sayisi == 0 )
                                                        echo "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim_sayfa_bir[$adi]</h6><ul class='submenu '>";   
                                                    else
                                                        echo "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'></h6><ul class='submenu '>"; 
                                                }                                        
                                        ?>
                                            <li><a href="<?php echo $link_url;?>" target="<?php echo $target;?>"><?php echo $birim_sayfa_iki['adi'.$dil]; ?></a></li>
                                            <?php
                                            }
                                            ?>

                                        <?php
                                        }
                                        if( $sira > 0 ) echo "</ul></li>";                                            
                                        ?>
                                    </ul>
                                    <?php 
                                    }
                                    } 
                                    ?>
                            
                                <?php
                                }
                                ?>
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
                                <li class="icon cart-icon">
                                    <a href="cart.html" class="cart-icon">
                                        <i class="icon-3"></i>
                                        <span class="count">0</span>
                                    </a>
                                </li>
                                <li class="header-btn">
                                    <a href="contact-us.html" class="edu-btn btn-medium">Try for free <i class="icon-4"></i></a>
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
            <!-- <div class="popup-mobile-menu">
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
            </div> -->
            <div class="popup-mobile-menu">
                <div class="inner">
                    <div class="header-top">
                        <div class="logo">
                            <a href="index.html">
                                <img class="logo-light" src="admin/resimler/logolar/<?php echo $genel_ayarlar['logo'.$dil]; ?>" alt="Corporate Logo">
                                <img class="logo-dark" src="admin/resimler/logolar/<?php echo $genel_ayarlar['logo'.$dil]; ?>" alt="Corporate Logo">
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
                                    $menu = "<ul class='mega-menu mega-menu-one'>";
                                    else
                                    $menu = "<ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                }
                                foreach($array as $item) {
                                    if( $item['ust_id'] == $ust_id ){
                                        if( $item['kategori'] == 0 ){
                                            if( $item['ust_id'] == 0 )
                                            $menu .= "<li><a href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                            else
                                            $menu .= "<li ><a href='{$dil}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                        }else{
                                            if( $ust_id == 0 )
                                                $menu .= "<li class='has-droupdown'><a href='$actual_link#' >{$item[$adi]}</a>";
                                                else
                                                $menu .= "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>{$item[$adi]}</h6>";
                                        }
                                        if ( $item['kategori'] == 1 ) {
                                            if( $item['kisa_ad'] == 'akademik' ){
                                                $menu .= "<ul class='mega-menu mega-menu-one'>";
                                                @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 2 ) )[ 2 ];
                                                foreach( @$akademik_birimler as $birim ){
                                                $menu .= "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim[$adi]</h6><ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                                        
                                                    @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                    foreach(@$akademik_birimler2 as $birim2){
                                                    $menu .= "<li><a href='birimler/tr/$birim2[kisa_ad]'>$birim2[$adi]</a></li>";
                                                    } 
                                                $menu .= "</ul></li>";
                                                }
                                                $menu .= "</ul>";
                                            }elseif( $item['kisa_ad'] == 'idari' ){
                                                $menu .= "<ul class='mega-menu mega-menu-one'>";
                                                @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 3 ) )[ 2 ];
                                                foreach( @$akademik_birimler as $birim ){
                                                $menu .= "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim[$adi]</h6><ul class='submenu mega-sub-menu mega-sub-menu-01'>";
                                                        
                                                    @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                    foreach(@$akademik_birimler2 as $birim2){
                                                    $menu .= "<li><a href='birimler/tr/$birim2[kisa_ad]'>$birim2[$adi]</a></li>";
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

                            //echo buildList2($birim_sayfalari, 0,0, 1, $birim_id, $_REQUEST['dil'],$vt,$SQL_akademik_birimler);
                        ?>
                                <?php
                                $adi = "adi".$dil;
                                @$birim_sayfalari_bir = $vt->select($SQL_alt_sayfalari_getir, array( 0 ) )[ 2 ];
                                foreach( $birim_sayfalari_bir as $birim_sayfa_bir ){
                                    if( $birim_sayfa_bir['kategori'] == 0 ){
                                        if( $birim_sayfa_bir['link'] == 1 ){
                                            $link_url = $birim_sayfa_bir['link_url'];
                                            $target = "_blank";
                                        }else{
                                            $link_url = $_REQUEST['dil']."/".$birim_sayfa_bir['id']."/".$birim_sayfa_bir['kisa_ad'];
                                            $target = "";
                                        }


                                ?>
                                    <li><a href="<?php echo $link_url;?>" target="<?php echo $target;?>"><?php echo $birim_sayfa_bir['adi'.$dil]; ?></a></li>
                                    <?php
                                    }else{
                                    ?>
                                    <li class="has-droupdown"><a href="<?php echo $actual_link; ?>#" ><?php echo $birim_sayfa_bir['adi'.$dil]; ?></a>
                                                        <?php
                                                        if( $birim_sayfa_bir['kisa_ad'] == 'akademik' ){
                                                            @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 2 ) )[ 2 ];
                                                            echo "<ul class='mega-menu mega-menu-one' style='grid-template-columns: repeat(1, 1fr);'>";
                                                            foreach( @$akademik_birimler as $birim ){
                                                                if( $birim['id'] == 5)
                                                                    continue;
                                                            echo "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim[$adi]</h6><ul class='submenu'>";
                                                                    
                                                                @$akademik_birimler2 = $vt->select($SQL_akademik_birimler, array( $birim['id'] ) )[ 2 ];
                                                                foreach(@$akademik_birimler2 as $birim2){
                                                                echo "<li><a target='_blank' href='birimler/$_REQUEST[dil]/$birim2[kisa_ad]'>$birim2[$adi]</a></li>";
                                                                } 
                                                            echo "</ul></li>";
                                                            }
                                                            echo "</ul></li>";
                                                        }elseif( $birim_sayfa_bir['kisa_ad'] == 'enstituler' ){
                                                            echo "<ul class='mega-menu mega-menu-one' style='grid-template-columns: repeat(2, 1fr);'>";
                                                            echo "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim_sayfa_bir[$adi]</h6><ul class='submenu '>";
                                                            @$akademik_birimler = $vt->select($SQL_akademik_birimler, array( 5 ) )[ 2 ];
                                                            foreach( @$akademik_birimler as $birim ){
                                                                echo "<li><a target='_blank' href='birimler/$_REQUEST[dil]/$birim[kisa_ad]'>$birim[$adi]</a></li>";
                                                            }
                                                            echo "</ul></li></ul>";
                                                        }else{
                                                        ?>

                                    <ul class='mega-menu mega-menu-one'>
                                        <?php
                                        @$birim_sayfalari_iki = $vt->select($SQL_alt_sayfalari_getir, array( $birim_sayfa_bir['id'] ) )[ 2 ];
                                        $kategori_sayisi = 0;
                                        foreach( $birim_sayfalari_iki as $birim_sayfa_iki ){
                                            if( $birim_sayfa_iki['kategori'] == 1 ){
                                                $kategori_sayisi++;
                                        ?>
                                            <li><h6 style="color:#eb0023;margin-top:10px;margin-bottom:0px;"><?php echo $birim_sayfa_iki['adi'.$dil]; ?></h6>
                                                <ul class='submenu '>
                                                    <?php
                                                    @$birim_sayfalari_uc = $vt->select($SQL_alt_sayfalari_getir, array( $birim_sayfa_iki['id'] ) )[ 2 ];
                                                    foreach( $birim_sayfalari_uc as $birim_sayfa_uc ){
                                                    if( $birim_sayfa_uc['link'] == 1 ){
                                                        $link_url = $birim_sayfa_uc['link_url'];
                                                        $target = "_blank";
                                                    }else{
                                                        $link_url = $_REQUEST['dil']."/".$birim_sayfa_uc['id']."/".$birim_sayfa_uc['kisa_ad'];
                                                        $target = "";
                                                    }

                                                    ?>
                                                    <li><a href="<?php echo $link_url;?>" target="<?php echo $target;?>"><?php echo $birim_sayfa_uc['adi'.$dil]; ?></a></li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        $sira=0;
                                        foreach( $birim_sayfalari_iki as $birim_sayfa_iki ){
                                            if( $birim_sayfa_iki['kategori'] == 0 ){
                                                if( $birim_sayfa_iki['link'] == 1 ){
                                                    $link_url = $birim_sayfa_iki['link_url'];
                                                    $target = "_blank";
                                                }else{
                                                    $link_url = $_REQUEST['dil']."/".$birim_sayfa_iki['id']."/".$birim_sayfa_iki['kisa_ad'];
                                                    $target = "";
                                                }

                                                $sira++;
                                                if( $sira == 1 ){
                                                    if( $kategori_sayisi == 0 )
                                                        echo "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'>$birim_sayfa_bir[$adi]</h6><ul class='submenu '>";   
                                                    else
                                                        echo "<li><h6 style='color:#eb0023;margin-top:10px;margin-bottom:0px;'></h6><ul class='submenu '>"; 
                                                }                                        
                                        ?>
                                            <li><a href="<?php echo $link_url;?>" target="<?php echo $target;?>"><?php echo $birim_sayfa_iki['adi'.$dil]; ?></a></li>
                                            <?php
                                            }
                                            ?>

                                        <?php
                                        }
                                        if( $sira > 0 ) echo "</ul></li>";                                            
                                        ?>

                                    </ul>
                                    <?php 
                                    }
                                    } 
                                    ?>
                            
                                <?php
                                }
                                ?>
                                <li class="has-droupdown"><a href="<?php echo $actual_link; ?>#" class="open"><i class="fa-solid fa-globe"></i> <?php echo dil_cevir( "Dil", $dizi_dil, $_REQUEST["dil"] ); ?></a>
                                <ul class='mega-menu mega-menu-one active' style="display: block;">
                                    <li>
                                    <a style="<?php if( $_REQUEST['dil'] == "kz" )echo "color:#cd201f"; ?>" href="<?php echo str_replace(array('.kz/tr','.kz/kz','.kz/en','.kz/ru'),".kz/kz",$actual_link);?>"><img src="assets/images/kz.svg" style="height: 20px;"> KZ</a>
                                    </li>
                                    <li>
                                    <a style="<?php if( $_REQUEST['dil'] == "tr" )echo "color:#cd201f"; ?>" href="<?php echo str_replace(array('.kz/tr','.kz/kz','.kz/en','.kz/ru'),".kz/tr",$actual_link);?>"><img src="assets/images/tr.svg" style="height: 20px;"> TR</a>
                                    </li>
                                    <li>
                                    <a style="<?php if( $_REQUEST['dil'] == "en" )echo "color:#cd201f"; ?>" href="<?php echo str_replace(array('.kz/tr','.kz/kz','.kz/en','.kz/ru'),".kz/en",$actual_link);?>"><img src="assets/images/en.svg" style="height: 20px;"> EN</a>
                                    </li>
                                    <li>
                                    <a style="<?php if( $_REQUEST['dil'] == "ru" )echo "color:#cd201f"; ?>" href="<?php echo str_replace(array('.kz/tr','.kz/kz','.kz/en','.kz/ru'),".kz/ru",$actual_link);?>"><img src="assets/images/ru.svg" style="height: 20px;"> RU</a>                                 
                                    </li>
                                </ul>
                                </li>

                    </ul>
                </div>
            </div>

            <!-- Start Search Popup  -->
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
            <!-- End Search Popup  -->
        </header>
        <!--=====================================-->
        <!--=       Hero Banner Area Start      =-->
        <!--=====================================-->
        <div class="hero-banner hero-style-1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="banner-content">
                            <h1 class="title" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1000">Get <span class="color-secondary">2500+</span> <br>Best Online Courses From EduBlink</h1>
                            <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000">Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit.</p>
                            <div class="banner-btn" data-sal-delay="400" data-sal="slide-up" data-sal-duration="1000">
                                <a href="course-one.html" class="edu-btn">Find courses <i class="icon-4"></i></a>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                                    <img data-depth="2" src="assets/images/about/shape-13.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner-thumbnail">
                            <div class="thumbnail" data-sal-delay="500" data-sal="slide-left" data-sal-duration="1000">
                                <img src="assets/images/banner/girl-1.webp" alt="Girl Image">
                            </div>
                            <div class="instructor-info" data-sal-delay="600" data-sal="slide-up" data-sal-duration="1000">
                                <div class="inner">
                                    <h5 class="title">Instrunctor</h5>
                                    <div class="media">
                                        <div class="thumb">
                                            <img src="assets/images/banner/author-1.png" alt="Images">
                                        </div>
                                        <div class="content">
                                            <span>200+</span> Instactors
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                                    <img data-depth="1.5" src="assets/images/about/shape-15.png" alt="Shape">
                                </li>
                                <li class="shape-2 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                                    <img data-depth="-1.5" src="assets/images/about/shape-16.png" alt="Shape">
                                </li>
                                <li class="shape-3 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                                    <span data-depth="3" class="circle-shape"></span>
                                </li>
                                <li class="shape-4" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                                    <img data-depth="-1" src="assets/images/counterup/shape-02.png" alt="Shape">
                                </li>
                                <li class="shape-5 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                                    <img data-depth="1.5" src="assets/images/about/shape-13.png" alt="Shape">
                                </li>
                                <li class="shape-6 scene" data-sal-delay="1000" data-sal="fade" data-sal-duration="1000">
                                    <img data-depth="-2" src="assets/images/about/shape-18.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shape-7">
                <img src="assets/images/about/h-1-shape-01.png" alt="Shape">
            </div>
        </div>
        <!--=====================================-->
        <!--=       Features Area Start      =-->
        <!--=====================================-->
        <!-- Start Categories Area  -->
        <div class="features-area-2">
            <div class="container">
                <div class="features-grid-wrap">
                    <div class="features-box features-style-2 edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="assets/images/animated-svg-icons/online-class.svg" alt="animated icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><span>3020</span> Online Courses</h5>
                        </div>
                    </div>
                    <div class="features-box features-style-2 edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="assets/images/animated-svg-icons/instructor.svg" alt="animated icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><span>Top</span>Instructors</h5>
                        </div>
                    </div>
                    <div class="features-box features-style-2 edublink-svg-animate">
                        <div class="icon certificate">
                            <img class="svgInject" src="assets/images/animated-svg-icons/certificate.svg" alt="animated icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><span>Online</span>Certifications</h5>
                        </div>
                    </div>
                    <div class="features-box features-style-2 edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="assets/images/animated-svg-icons/user.svg" alt="animated icon">
                        </div>
                        <div class="content">
                            <h5 class="title"><span>6000</span>Members</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Categories Area  -->
        <!--=====================================-->
        <!--=       Categories Area Start      =-->
        <!--=====================================-->
        <!-- Start Categories Area  -->
        <div class="edu-categorie-area categorie-area-2 edu-section-gap">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <h2 class="title">Top Categories</h2>
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
        <!--=       About Us Area Start      	=-->
        <!--=====================================-->
        <div class="gap-bottom-equal edu-about-area about-style-1">
            <div class="container edublink-animated-shape">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="about-image-gallery">
                            <img class="main-img-1" src="assets/images/about/about-01.webp" alt="About Image">
                            <div class="video-box" data-sal-delay="150" data-sal="slide-down" data-sal-duration="800">
                                <div class="inner">
                                    <div class="thumb">
                                        <img src="assets/images/about/about-02.webp" alt="About Image">
                                        <a href="https://www.youtube.com/watch?v=PICj5tr9hcc" class="popup-icon video-popup-activation">
                                            <i class="icon-18"></i>
                                        </a>
                                    </div>
                                    <div class="loading-bar">
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="award-status bounce-slide">
                                <div class="inner">
                                    <div class="icon">
                                        <i class="icon-21"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="title">29+</h6>
                                        <span class="subtitle">Wonderful Awards</span>
                                    </div>
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <img data-depth="1" src="assets/images/about/shape-36.png" alt="Shape">
                                </li>
                                <li class="shape-2 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <img data-depth="-1" src="assets/images/about/shape-37.png" alt="Shape">
                                </li>
                                <li class="shape-3 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <img data-depth="1" src="assets/images/about/shape-02.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6" data-sal-delay="150" data-sal="slide-left" data-sal-duration="800">
                        <div class="about-content">
                            <div class="section-title section-left">
                                <span class="pre-title">About Us</span>
                                <h2 class="title">Learn & Grow Your Skills From <span class="color-secondary">Anywhere</span></h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                                <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod ex tempor incididunt labore dolore magna aliquaenim minim veniam quis nostrud exercitation ullamco laboris.</p>
                            </div>
                            <ul class="features-list">
                                <li>Expert Trainers</li>
                                <li>Online Remote Learning</li>
                                <li>Lifetime Access</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="shape-group">
                    <li class="shape-1 circle scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                        <span data-depth="-2.3"></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--=====================================-->
        <!--=       Course Area Start      		=-->
        <!--=====================================-->
        <!-- Start Course Area  -->
        <div class="edu-course-area course-area-1 edu-section-gap bg-lighten01">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <span class="pre-title">Popular Courses</span>
                    <h2 class="title">Pick A Course To Get Started</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
                <div class="row g-5">
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="course-details.html">
                                        <img src="assets/images/course/course-07.jpg" alt="Course Meta">
                                    </a>
                                    <div class="time-top">
                                        <span class="duration"><i class="icon-61"></i>4 Weeks</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="course-level">Advanced</span>
                                    <h6 class="title">
                                        <a href="#">Starting SEO as your Home Based Business</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.9 /8 Rating)</span>
                                    </div>
                                    <div class="course-price">$49.00</div>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>13 Lessons</li>
                                        <li><i class="icon-25"></i>28 Students</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-hover-content-wrapper">
                                <button class="wishlist-btn"><i class="icon-22"></i></button>
                            </div>
                            <div class="course-hover-content">
                                <div class="content">
                                    <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    <span class="course-level">Advanced</span>
                                    <h6 class="title">
                                        <a href="course-details.html">Starting SEO as your Home Based Business</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.9 /8 Rating)</span>
                                    </div>
                                    <div class="course-price">$49.00</div>
                                    <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>13 Lessons</li>
                                        <li><i class="icon-25"></i>28 Students</li>
                                    </ul>
                                    <a href="course-details.html" class="edu-btn btn-secondary btn-small">Enrolled <i class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="course-details.html">
                                        <img src="assets/images/course/course-04.jpg" alt="Course Meta">
                                    </a>
                                    <div class="time-top">
                                        <span class="duration"><i class="icon-61"></i>3 Weeks</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="course-level">Beginner</span>
                                    <h6 class="title">
                                        <a href="#">Java Programming Masterclass for Software Developers</a>
                                    </h6>
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
                                    <div class="course-price">$29.00</div>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>8 Lessons</li>
                                        <li><i class="icon-25"></i>20 Students</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-hover-content-wrapper">
                                <button class="wishlist-btn"><i class="icon-22"></i></button>
                            </div>
                            <div class="course-hover-content">
                                <div class="content">
                                    <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    <span class="course-level">Beginner</span>
                                    <h6 class="title">
                                        <a href="course-details.html">Java Programming Masterclass for Software Developers</a>
                                    </h6>
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
                                    <div class="course-price">$29.00</div>
                                    <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>8 Lessons</li>
                                        <li><i class="icon-25"></i>20 Students</li>
                                    </ul>
                                    <a href="course-details.html" class="edu-btn btn-secondary btn-small">Enrolled <i class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="course-details.html">
                                        <img src="assets/images/course/course-05.jpg" alt="Course Meta">
                                    </a>
                                    <div class="time-top">
                                        <span class="duration"><i class="icon-61"></i>8 Weeks</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="course-level">Advanced</span>
                                    <h6 class="title">
                                        <a href="#">Building A Better World One Student At A Time</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.8 /9 Rating)</span>
                                    </div>
                                    <div class="course-price">$35.00</div>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>32 Lessons</li>
                                        <li><i class="icon-25"></i>18 Students</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-hover-content-wrapper">
                                <button class="wishlist-btn"><i class="icon-22"></i></button>
                            </div>
                            <div class="course-hover-content">
                                <div class="content">
                                    <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    <span class="course-level">Advanced</span>
                                    <h6 class="title">
                                        <a href="course-details.html">Building A Better World One Student At A Time</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.8 /9 Rating)</span>
                                    </div>
                                    <div class="course-price">$29.00</div>
                                    <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>35 Lessons</li>
                                        <li><i class="icon-25"></i>18 Students</li>
                                    </ul>
                                    <a href="course-details.html" class="edu-btn btn-secondary btn-small">Enrolled <i class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                    <!-- Start Single Course  -->
                    <div class="col-md-6 col-xl-3" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-course course-style-1 hover-button-bg-white">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="course-details.html">
                                        <img src="assets/images/course/course-06.jpg" alt="Course Meta">
                                    </a>
                                    <div class="time-top">
                                        <span class="duration"><i class="icon-61"></i>6 Weeks</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="course-level">Intermediate</span>
                                    <h6 class="title">
                                        <a href="#">Master Your Personal Brand Like a Marketing Pro</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.7 /5 Rating)</span>
                                    </div>
                                    <div class="course-price">$49.00</div>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>15 Lessons</li>
                                        <li><i class="icon-25"></i>12 Students</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-hover-content-wrapper">
                                <button class="wishlist-btn"><i class="icon-22"></i></button>
                            </div>
                            <div class="course-hover-content">
                                <div class="content">
                                    <button class="wishlist-btn"><i class="icon-22"></i></button>
                                    <span class="course-level">Intermediate</span>
                                    <h6 class="title">
                                        <a href="course-details.html">Master Your Personal Brand Like a Marketing Pro</a>
                                    </h6>
                                    <div class="course-rating">
                                        <div class="rating">
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                            <i class="icon-23"></i>
                                        </div>
                                        <span class="rating-count">(4.7 /5 Rating)</span>
                                    </div>
                                    <div class="course-price">$49.00</div>
                                    <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor.</p>
                                    <ul class="course-meta">
                                        <li><i class="icon-24"></i>15 Lessons</li>
                                        <li><i class="icon-25"></i>12 Students</li>
                                    </ul>
                                    <a href="course-details.html" class="edu-btn btn-secondary btn-small">Enrolled <i class="icon-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                </div>
                <div class="course-view-all" data-sal-delay="150" data-sal="slide-up" data-sal-duration="1200">
                    <a href="course-one.html" class="edu-btn">Browse more courses <i class="icon-4"></i></a>
                </div>
            </div>
        </div>
        <!-- End Course Area -->
        <!--=====================================-->
        <!--=       CounterUp Area Start      	=-->
        <!--=====================================-->
        <div class="counterup-area-2">
            <div class="container">
                <div class="row g-5 justify-content-center">
                    <div class="col-lg-8">
                        <div class="counterup-box-wrap">
                            <div class="counterup-box counterup-box-1">
                                <div class="edu-counterup counterup-style-2">
                                    <h2 class="counter-item count-number primary-color">
                                        <span class="odometer" data-odometer-final="45.2">.</span><span>K</span>
                                    </h2>
                                    <h6 class="title">Student Enrolled</h6>
                                </div>
                                <div class="edu-counterup counterup-style-2">
                                    <h2 class="counter-item count-number secondary-color">
                                        <span class="odometer" data-odometer-final="32.4">.</span><span>K</span>
                                    </h2>
                                    <h6 class="title">Class Completed</h6>
                                </div>
                            </div>
                            <div class="counterup-box counterup-box-2">
                                <div class="edu-counterup counterup-style-2">
                                    <h2 class="counter-item count-number extra05-color">
                                        <span class="odometer" data-odometer-final="354">.</span><span>+</span>
                                    </h2>
                                    <h6 class="title">Top Instructors</h6>
                                </div>
                                <div class="edu-counterup counterup-style-2">
                                    <h2 class="counter-item count-number extra02-color">
                                        <span class="odometer" data-odometer-final="99.9">.</span><span>%</span>
                                    </h2>
                                    <h6 class="title">Satisfaction Rate</h6>
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1 scene">
                                    <img data-depth="-2" src="assets/images/about/shape-13.png" alt="Shape">
                                </li>
                                <li class="shape-2">
                                    <img class="rotateit" src="assets/images/counterup/shape-02.png" alt="Shape">
                                </li>
                                <li class="shape-3 scene">
                                    <img data-depth="1.6" src="assets/images/counterup/shape-04.png" alt="Shape">
                                </li>
                                <li class="shape-4 scene">
                                    <img data-depth="-1.6" src="assets/images/counterup/shape-05.png" alt="Shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=====================================-->
        <!--=       Testimonial Area Start      =-->
        <!--=====================================-->
        <!-- Start Testimonial Area  -->
        <div class="testimonial-area-1 section-gap-equal">
            <div class="container">
                <div class="row g-lg-5">
                    <div class="col-lg-5">
                        <div class="testimonial-heading-area">
                            <div class="section-title section-left" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                                <span class="pre-title">Testimonials</span>
                                <h2 class="title">What Our Students Have To Say</h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                                <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor incididunt labore dolore magna aliquaenim ad minim.</p>
                                <a href="#" class="edu-btn btn-large">View All<i class="icon-4"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="home-one-testimonial-activator swiper ">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial-grid">
                                        <div class="thumbnail">
                                            <img src="assets/images/testimonial/testimonial-01.png" alt="Testimonial">
                                            <span class="qoute-icon"><i class="icon-26"></i></span>

                                        </div>
                                        <div class="content">
                                            <p>Lorem ipsum dolor amet consec tur elit adicing sed do usmod zx tempor enim minim veniam quis nostrud exer citation.</p>
                                            <div class="rating-icon">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <h5 class="title">Ray Sanchez</h5>
                                            <span class="subtitle">Student</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-grid">
                                        <div class="thumbnail">
                                            <img src="assets/images/testimonial/testimonial-02.png" alt="Testimonial">
                                            <span class="qoute-icon"><i class="icon-26"></i></span>

                                        </div>
                                        <div class="content">
                                            <p>Lorem ipsum dolor amet consec tur elit adicing sed do usmod zx tempor enim minim veniam quis nostrud exer citation.</p>
                                            <div class="rating-icon">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <h5 class="title">Thomas Lopez</h5>
                                            <span class="subtitle">Designer</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-grid">
                                        <div class="thumbnail">
                                            <img src="assets/images/testimonial/testimonial-03.png" alt="Testimonial">
                                            <span class="qoute-icon"><i class="icon-26"></i></span>

                                        </div>
                                        <div class="content">
                                            <p>Lorem ipsum dolor amet consec tur elit adicing sed do usmod zx tempor enim minim veniam quis nostrud exer citation.</p>
                                            <div class="rating-icon">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <h5 class="title">Amber Page</h5>
                                            <span class="subtitle">Developer</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-grid">
                                        <div class="thumbnail">
                                            <img src="assets/images/testimonial/testimonial-04.png" alt="Testimonial">
                                            <span class="qoute-icon"><i class="icon-26"></i></span>

                                        </div>
                                        <div class="content">
                                            <p>Lorem ipsum dolor amet consec tur elit adicing sed do usmod zx tempor enim minim veniam quis nostrud exer citation.</p>
                                            <div class="rating-icon">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <h5 class="title">Robert Tapp</h5>
                                            <span class="subtitle">Content Creator</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Testimonial Area  -->
        <!--=====================================-->
        <!--=      Call To Action Area Start   	=-->
        <!--=====================================-->
        <!-- Start CTA Area  -->
        <div class="home-one-cta-two cta-area-1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="home-one-cta edu-cta-box bg-image">
                            <div class="inner">
                                <div class="content text-md-end">
                                    <span class="subtitle">Get In Touch:</span>
                                    <h3 class="title"><a href="mailto:info@edublink">info@edublink</a></h3>
                                </div>
                                <div class="sparator">
                                    <span>or</span>
                                </div>
                                <div class="content">
                                    <span class="subtitle">Call Us Via:</span>
                                    <h3 class="title"><a href="tel:+011235641231">+01 123 5641 231</a></h3>
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-01 scene">
                                    <img data-depth="2" src="assets/images/cta/shape-06.png" alt="shape">
                                </li>
                                <li class="shape-02 scene">
                                    <img data-depth="-2" src="assets/images/cta/shape-12.png" alt="shape">
                                </li>
                                <li class="shape-03 scene">
                                    <img data-depth="-3" src="assets/images/cta/shape-04.png" alt="shape">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End CTA Area  -->
        <!--=====================================-->
        <!--=      		Team Area Start   		=-->
        <!--=====================================-->
        <!-- Start Team Area  -->
        <div class="edu-team-area team-area-1 gap-tb-text">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <span class="pre-title">Instructors</span>
                    <h2 class="title">Course Instructors</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
                <div class="row g-5">
                    <!-- Start Instructor Grid  -->
                    <div class="col-lg-3 col-sm-6 col-12" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-team-grid team-style-1">
                            <div class="inner">
                                <div class="thumbnail-wrap">
                                    <div class="thumbnail">
                                        <a href="team-details.html">
                                            <img src="assets/images/team/team-01.webp" alt="team images">
                                        </a>
                                    </div>
                                    <ul class="team-share-info">
                                        <li><a href="#"><i class="icon-share-alt"></i></a></li>
                                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                                        <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                                    </ul>
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="team-details.html">Jane Seymour</a></h5>
                                    <span class="designation">UI Designer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Instructor Grid  -->
                    <!-- Start Instructor Grid  -->
                    <div class="col-lg-3 col-sm-6 col-12" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-team-grid team-style-1">
                            <div class="inner">
                                <div class="thumbnail-wrap">
                                    <div class="thumbnail">
                                        <a href="team-details.html">
                                            <img src="assets/images/team/team-02.webp" alt="team images">
                                        </a>
                                    </div>
                                    <ul class="team-share-info">
                                        <li><a href="#"><i class="icon-share-alt"></i></a></li>
                                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                                        <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                                    </ul>
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="team-details.html">Edward Norton</a></h5>
                                    <span class="designation">Web Developer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Instructor Grid  -->
                    <!-- Start Instructor Grid  -->
                    <div class="col-lg-3 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-team-grid team-style-1">
                            <div class="inner">
                                <div class="thumbnail-wrap">
                                    <div class="thumbnail">
                                        <a href="team-details.html">
                                            <img src="assets/images/team/team-03.webp" alt="team images">
                                        </a>
                                    </div>
                                    <ul class="team-share-info">
                                        <li><a href="#"><i class="icon-share-alt"></i></a></li>
                                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                                        <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                                    </ul>
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="team-details.html">Penelope Cruz</a></h5>
                                    <span class="designation">Digital Marketer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Instructor Grid  -->
                    <!-- Start Instructor Grid  -->
                    <div class="col-lg-3 col-sm-6 col-12" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-team-grid team-style-1">
                            <div class="inner">
                                <div class="thumbnail-wrap">
                                    <div class="thumbnail">
                                        <a href="team-details.html">
                                            <img src="assets/images/team/team-04.webp" alt="team images">
                                        </a>
                                    </div>
                                    <ul class="team-share-info">
                                        <li><a href="#"><i class="icon-share-alt"></i></a></li>
                                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                                        <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                                    </ul>
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="team-details.html">John Travolta</a></h5>
                                    <span class="designation">WordPress Expert</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Instructor Grid  -->
                </div>
            </div>
        </div>
        <!-- End Team Area  -->
        <!--=====================================-->
        <!--=      CTA Banner Area Start   		=-->
        <!--=====================================-->
        <!-- Start Ad Banner Area  -->
        <div class="edu-cta-banner-area home-one-cta-wrapper bg-image">
            <div class="container">
                <div class="edu-cta-banner">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                                <h2 class="title">Get Your Quality Skills <span class="color-secondary">Certificate</span> Through EduBlink</h2>
                                <a href="contact-us.html" class="edu-btn">Get started now <i class="icon-4"></i></a>
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
        <!--=      		Brand Area Start   		=-->
        <!--=====================================-->
        <!-- Start Brand Area  -->
        <div class="edu-brand-area brand-area-1 gap-top-equal">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="brand-section-heading">
                            <div class="section-title section-left" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                                <span class="pre-title">Our Partners</span>
                                <h2 class="title">Learn with Our Partners</h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                                <p>Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor incididunt.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="brand-grid-wrap">
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
                            <div class="brand-grid">
                                <img src="assets/images/brand/brand-07.png" alt="Brand Logo">
                            </div>
                            <div class="brand-grid">
                                <img src="assets/images/brand/brand-08.png" alt="Brand Logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Brand Area  -->
        <!--=====================================-->
        <!--=      		Blog Area Start   		=-->
        <!--=====================================-->
        <!-- Start Blog Area  -->
        <div class="edu-blog-area blog-area-1 edu-section-gap">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                    <span class="pre-title">Latest Articles</span>
                    <h2 class="title">Get News with EduBlink</h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
                <div class="row g-5">
                    <!-- Start Blog Grid  -->
                    <div class="col-lg-4 col-md-6 col-12" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-blog blog-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="blog-details.html">
                                        <img src="assets/images/blog/blog-01.jpg" alt="Blog Images">
                                    </a>
                                </div>
                                <div class="content position-top">
                                    <div class="read-more-btn">
                                        <a class="btn-icon-round" href="blog-details.html"><i class="icon-4"></i></a>
                                    </div>
                                    <div class="category-wrap">
                                        <a href="#" class="blog-category">ONLINE</a>
                                    </div>
                                    <h5 class="title"><a href="blog-details.html">Become a Better Blogger: Content Planning</a></h5>
                                    <ul class="blog-meta">
                                        <li><i class="icon-27"></i>Oct 10, 2021</li>
                                        <li><i class="icon-28"></i>Com 09</li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet cons tetur adipisicing sed.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Blog Grid  -->
                    <!-- Start Blog Grid  -->
                    <div class="col-lg-4 col-md-6 col-12" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-blog blog-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="blog-details.html">
                                        <img src="assets/images/blog/blog-02.jpg" alt="Blog Images">
                                    </a>
                                </div>
                                <div class="content position-top">
                                    <div class="read-more-btn">
                                        <a class="btn-icon-round" href="blog-details.html"><i class="icon-4"></i></a>
                                    </div>
                                    <div class="category-wrap">
                                        <a href="#" class="blog-category">LECTURE</a>
                                    </div>
                                    <h5 class="title"><a href="blog-details.html">How to Keep Workouts Fresh in the Morning</a></h5>
                                    <ul class="blog-meta">
                                        <li><i class="icon-27"></i>Oct 10, 2021</li>
                                        <li><i class="icon-28"></i>Com 09</li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet cons tetur adipisicing sed do eiusmod ux tempor incid idunt labore dol oremagna aliqua.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Blog Grid  -->
                    <!-- Start Blog Grid  -->
                    <div class="col-lg-4 col-md-6 col-12" data-sal-delay="300" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-blog blog-style-1">
                            <div class="inner">
                                <div class="thumbnail">
                                    <a href="blog-details.html">
                                        <img src="assets/images/blog/blog-03.jpg" alt="Blog Images">
                                    </a>
                                </div>
                                <div class="content position-top">
                                    <div class="read-more-btn">
                                        <a class="btn-icon-round" href="blog-details.html"><i class="icon-4"></i></a>
                                    </div>
                                    <div class="category-wrap">
                                        <a href="#" class="blog-category">BUSINESS</a>
                                    </div>
                                    <h5 class="title"><a href="blog-details.html">Four Ways to Keep Your Workout Routine Fresh</a></h5>
                                    <ul class="blog-meta">
                                        <li><i class="icon-27"></i>Oct 10, 2021</li>
                                        <li><i class="icon-28"></i>Com 09</li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet cons tetur adipisicing sed do eiusmod ux tempor incid idunt.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Blog Grid  -->
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1 scene">
                    <img data-depth="-1.4" src="assets/images/about/shape-02.png" alt="Shape">
                </li>
                <li class="shape-2 scene">
                    <span data-depth="2.5"></span>
                </li>
                <li class="shape-3 scene">
                    <img data-depth="-2.3" src="assets/images/counterup/shape-05.png" alt="Shape">
                </li>
            </ul>
        </div>
        <!-- End Blog Area  -->
        <!--=====================================-->
        <!--=        Footer Area Start       	=-->
        <!--=====================================-->
        <!-- Start Footer Area  -->
        <footer class="edu-footer footer-lighten bg-image footer-style-1">
            <div class="footer-top">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-3 col-md-6">
                            <div class="edu-footer-widget">
                                <div class="logo">
                                    <a href="index.html">
                                        <img class="logo-light" src="assets/images/logo/logo-dark.png" alt="Corporate Logo">
                                        <img class="logo-dark" src="assets/images/logo/logo-white.png" alt="Corporate Logo">
                                    </a>
                                </div>
                                <p class="description">Lorem ipsum dolor amet consecto adi pisicing elit sed eiusm tempor incidid unt labore dolore.</p>
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
                                        <button class="edu-btn btn-medium" type="button">Subscribe <i class="icon-4"></i></button>
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