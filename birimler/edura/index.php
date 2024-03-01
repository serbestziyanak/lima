<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include "../admin/_cekirdek/fonksiyonlar.php";
$vt = new VeriTabani();
$fn = new Fonksiyonlar();

//var_dump($_REQUEST);
//exit;

$birim_id				= array_key_exists( 'birim_id' ,$_REQUEST ) ? $_REQUEST[ 'birim_id' ]	: 0;
$dil				    = array_key_exists( 'dil' ,$_REQUEST ) ? $_REQUEST[ 'dil' ]	: 0;
$dil = $dil == "tr" ? "" : "_".$dil;

$SQL_birim_sayfalari_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_sayfalari
WHERE 
	birim_id = ?
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
  birim_id = ?
ORDER BY tarih DESC
SQL;

$SQL_etkinlikler = <<< SQL
SELECT
  *
FROM 
  tb_etkinlikler
WHERE 
  birim_id = ?
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
  kisa_ad = ? 
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

@$birim_bilgileri 	    = $vt->selectSingle($SQL_birim_bilgileri, array( $_REQUEST['kisa_ad'] ) )[ 2 ];

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
    $dizi_dil[$ceviri['adi']]['tr'] = $ceviri['adi']; 
    $dizi_dil[$ceviri['adi']]['kz'] = $ceviri['adi_kz']; 
    $dizi_dil[$ceviri['adi']]['en'] = $ceviri['adi_en']; 
    $dizi_dil[$ceviri['adi']]['ru'] = $ceviri['adi_ru']; 
}

function dil_cevir( $metin, $dizi, $dil ){
	if( array_key_exists( $metin, $dizi ) and $dizi[$metin][$dil] != "" )
		return $dizi[$metin][$dil];
	else
		return $metin;

}


//var_dump($dizi);

if( $birim_id == 0 ){
    include "error.html";
    exit;
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <base href="/hr/birimler/" />
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $birim_bilgileri['adi'.$dil]; ?></title>
    <meta name="author" content="themeholy">
    <meta name="description" content="Ahmet Yesevi Üniversitesi">
    <meta name="keywords" content="Ahmet Yesevi Üniversitesi">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Jost:wght@300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">


    <!--==============================
	    All CSS File
	============================== -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="assets/css/slick.min.css">
    <!-- Nice Select -->
    <link rel="stylesheet" href="assets/css/nice-select.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>


    <!--[if lte IE 9]>
    	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->



    <!--********************************
   		Code Start From Here 
	******************************** -->




    <!--==============================
     Preloader
  ==============================-->
    <div class="preloader ">
        <button class="th-btn style3 preloaderCls">Cancel Preloader </button>
        <div class="preloader-inner">
            <span class="loader"></span>
        </div>
    </div>
    <!--==============================
    Sidemenu
============================== -->
    <div class="sidemenu-wrapper d-none d-lg-block ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget woocommerce widget_shopping_cart">
                <h3 class="widget_title"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                <div class="widget_shopping_cart_content">
                    <ul class="woocommerce-mini-cart cart_list product_list_widget">
                        <?php 
                        foreach( $duyurular as $duyuru ){ 
                            if( $duyuru['foto'] == "" )
                                $duyuru_foto = "ayu_logo.png";
                            else
                                $duyuru_foto = $duyuru['foto'];
                        ?>
                        <li class="woocommerce-mini-cart-item mini_cart_item">
                            <span class="quantity">
                                <span class="" style="font-size:12px;line-height: normal; ">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <?php echo $fn->tarihVer($duyuru['tarih']); ?>
                                </span>
                            </span>
                            <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>" style="font-size:12px;line-height: normal; ">
                                <img src="../admin/resimler/duyurular/<?php echo $duyuru_foto; ?>" alt="Cart Image" style="object-fit: cover; ">
                                <?php echo $duyuru['baslik'.$dil]; ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-search-box d-none d-lg-block">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>
    <!--==============================
    Mobile Menu
  ============================== -->
    <div class="th-menu-wrapper">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']; ?>"><img src="assets/img/ayu_logo2.png" alt="Ahmet Yesevi Üniversitesi"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li><a href='<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']; ?>'><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                    <?php 
                        function buildList2(array $array, int $ust_id, int $ilk, $birim_id, $birim_kisa_ad, $dil,$vt,$SQL_bolumler): string
                        {
                            $dil2 = $dil == "tr" ? "" : "_".$dil ;
                            $adi = "adi".$dil2;
                            if( $ilk )
                            $menu = "";
                            else
                            $menu = "<ul class='sub-menu'>";
                            foreach($array as $item) {
                                if( $item['ust_id'] == $ust_id ){
                                    if( $item['kategori'] == 0 ){
                                        $menu .= "<li><a href='{$dil}/{$birim_kisa_ad}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                    }else{
                                            $menu .= "<li class='menu-item-has-children'><a href='#' >{$item[$adi]}</a>";
                                    }
                                    if ( $item['kategori'] == 1 ) {
                                            if( $item['kisa_ad'] == 'bolumler' ){
                                                @$bolumler = $vt->select($SQL_bolumler, array( $birim_id ) )[ 2 ];
                                                $menu .= "<ul class='sub-menu'>";
                                                foreach( $bolumler as $bolum ){
                                                    $menu .= "<li class='menu-item-has-children'><a href='#' >{$bolum['adi']}</a>";
                                                        @$bolumler2 = $vt->select($SQL_bolumler, array( $bolum['id'] ) )[ 2 ];
                                                        $menu .= "<ul class='sub-menu'>";
                                                        foreach( $bolumler2 as $bolum2 ){                                                                                
                                                            $menu .= "<li><a href='{$dil}/{$bolum2['kisa_ad']}'>{$bolum2['adi']}</a></li>";

                                                        }
                                                        $menu .= "</ul></li>";
                                                }
                                                $menu .= "</ul>";
                                            }else{
                                                $menu .= buildList2($array, $item['id'],0, $birim_id, $birim_kisa_ad, $dil,$vt,$SQL_bolumler);
                                                $menu .= "</li>";
                                            }
                                    }
                                }
                            }
                            $menu .= "</ul>";

                            return $menu;
                        }
                        echo buildList2($birim_sayfalari, 0, 1, $birim_id, $_REQUEST['kisa_ad'], $_REQUEST['dil'],$vt,$SQL_bolumler);
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
	Header Area
==============================-->
    <header class="th-header header-layout1">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-links">
                            <ul>
                                <li><i class="far fa-phone"></i><a href="tel:<?php echo $genel_ayarlar['tel']; ?>"><?php echo $genel_ayarlar['tel']; ?></a></li>
                                <li class="d-none d-xl-inline-block"><i class="far fa-envelope"></i><a href="mailto:<?php echo $genel_ayarlar['email']; ?>"><?php echo $genel_ayarlar['email']; ?></a></li>
                                <li><i class="far fa-clock"></i>Mon - Fri: 9:00 - 18:00</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-links header-right">
                            <ul>
                                <li>
                                    <div class="header-social">
                                        <span class="social-title"><?php echo dil_cevir( "Bizi takip et", $dizi_dil, $_REQUEST["dil"] ); ?>:</span>
                                        <a href="<?php echo $genel_ayarlar['facebook']; ?>"><i class="fab fa-facebook-f"></i></a>
                                        <a href="<?php echo $genel_ayarlar['twitter']; ?>"><i class="fab fa-twitter"></i></a>
                                        <a href="<?php echo $genel_ayarlar['linkedin']; ?>"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="<?php echo $genel_ayarlar['youtube']; ?>"><i class="fab fa-youtube"></i></a>
                                        <a href="<?php echo $genel_ayarlar['instagram']; ?>"><i class="fa-brands fa-instagram"></i></a>
                                    </div>
                                </li>
                                <li class="d-none d-lg-inline-block">
                                    <a href="tr/<?php echo $_REQUEST['kisa_ad']; ?>">
                                        <img src="assets/img/tr.svg" style="height: 20px;">
                                    </a>
                                    <a href="kz/<?php echo $_REQUEST['kisa_ad']; ?>">
                                        <img src="assets/img/kz.svg" style="height: 20px;">
                                    </a>
                                    <a href="en/<?php echo $_REQUEST['kisa_ad']; ?>">
                                        <img src="assets/img/en.svg" style="height: 20px;">
                                    </a>
                                    <a href="ru/<?php echo $_REQUEST['kisa_ad']; ?>">
                                        <img src="assets/img/ru.svg" style="height: 20px;">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo" style="padding: 1px;">
                                <?php if( $genel_ayarlar['logo'] == "" ) $logo = "ayu_logo2.png"; else $logo = $genel_ayarlar['logo'];  ?>
                                <a href="<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']; ?>"><img src="../admin/resimler/logolar/<?php echo $logo; ?>" alt="Ahmet Yesevi Üniversitesi" style="height:75px;"></a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <nav class="main-menu d-none d-lg-inline-block">
                                        <ul>
                                            <li><a href='<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']; ?>'><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                        <?php 
                                            function buildList(array $array, int $ust_id, int $ilk, $birim_id, $birim_kisa_ad, $dil,$vt,$SQL_bolumler): string
                                            {
                                                $dil2 = $dil == "tr" ? "" : "_".$dil ;
                                                $adi = "adi".$dil2;
                                                if( $ilk )
                                                $menu = "";
                                                else
                                                $menu = "<ul class='sub-menu'>";
                                                foreach($array as $item) {
                                                    if( $item['ust_id'] == $ust_id ){
                                                        if( $item['kategori'] == 0 ){
                                                            $menu .= "<li><a href='{$dil}/{$birim_kisa_ad}/{$item['kisa_ad']}'>{$item[$adi]}</a></li>";
                                                        }else{
                                                             $menu .= "<li class='menu-item-has-children'><a href='#' >{$item[$adi]}</a>";
                                                        }
                                                        if ( $item['kategori'] == 1 ) {
                                                                if( $item['kisa_ad'] == 'bolumler' ){
                                                                    @$bolumler = $vt->select($SQL_bolumler, array( $birim_id ) )[ 2 ];
                                                                    $menu .= "<ul class='sub-menu'>";
                                                                    foreach( $bolumler as $bolum ){
                                                                        $menu .= "<li class='menu-item-has-children'><a href='#' >{$bolum['adi']}</a>";
                                                                            @$bolumler2 = $vt->select($SQL_bolumler, array( $bolum['id'] ) )[ 2 ];
                                                                            $menu .= "<ul class='sub-menu'>";
                                                                            foreach( $bolumler2 as $bolum2 ){                                                                                
                                                                                $menu .= "<li><a href='{$dil}/{$bolum2['kisa_ad']}'>{$bolum2['adi']}</a></li>";

                                                                            }
                                                                            $menu .= "</ul></li>";
                                                                    }
                                                                    $menu .= "</ul>";
                                                                }else{
                                                                    $menu .= buildList($array, $item['id'],0, $birim_id, $birim_kisa_ad, $dil,$vt,$SQL_bolumler);
                                                                    $menu .= "</li>";
                                                                }
                                                        }
                                                    }
                                                }
                                                $menu .= "</ul>";

                                                return $menu;
                                            }
                                            echo buildList($birim_sayfalari, 0, 1, $birim_id, $_REQUEST['kisa_ad'], $_REQUEST['dil'],$vt,$SQL_bolumler);
                                        ?>
                                        </ul>
                                    </nav>
                                    <button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>
                                </div>
                                <div class="col-auto d-none d-xl-block">
                                    <div class="header-button">
                                        <button type="button" class="icon-btn searchBoxToggler"><i class="far fa-search"></i></button>
                                        <!--a href="wishlist.html" class="icon-btn">
                                            <i class="far fa-heart"></i>
                                            <span class="badge">3</span>
                                        </a-->
                                        <button type="button" class="icon-btn sideMenuToggler">
                                            <i class="fa-solid fa-bullhorn"></i>
                                            <span class="badge">5</span>
                                        </button>
                                        <a href="https://portal.ayu.edu.kz/" target="_blank" class="th-btn ml-25"><?php echo dil_cevir( "AYU Portal", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php if( $sayfa_id > 0 ){
    include "icerik.php";
}elseif( @$_REQUEST['sayfa_turu'] == 'duyurular' ){ 
    include "duyuru_icerik.php";
}elseif( @$_REQUEST['sayfa_turu'] == 'etkinlikler' ){ 
    include "etkinlik_icerik.php";
}else{ 

?>
    <!--==============================
Hero Area
==============================-->
    <div class="th-hero-wrapper hero-1" id="hero">
        <div class="hero-slider-1 th-carousel" data-fade="true" data-slide-show="1" data-md-slide-show="1" data-dots="false">


            <div class="th-hero-slide">
                <div class="th-hero-bg" data-overlay="title" data-opacity="8" data-bg-src="assets/img/hero/1.jpg"></div>
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-6">
                            <div class="hero-style1">
                                <h1 class="hero-title text-white" data-ani="slideinleft" data-ani-delay="0.4s">
                                    <?php echo $birim_bilgileri['adi'.$dil]; ?> 
                                <p class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s"><?php echo $genel_ayarlar['slogan'.$dil]; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 text-lg-end text-center">
                            <div class="hero-img1">
                                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <?php 
                                        $sira=0;
                                        foreach( $slaytlar as $slayt ){
                                            $slayt_aktif = $sira == 0 ? "active" : "";
                                            $slayt_aria = $sira == 0 ? "active" : "";
                                    ?>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $sira; ?>" class="<?php echo $slayt_aktif; ?>" ></button>
                                    <?php $sira++; } ?>
                                </div>
                                <div class="carousel-inner">
                                    <?php 
                                        $sira=0;
                                        foreach( $slaytlar as $slayt ){
                                        $sira++;
                                        $slayt_aktif = $sira == 1 ? "active" : "";
                                    ?>
                                    <div class="carousel-item <?php echo $slayt_aktif; ?>">
                                    <img src="../admin/resimler/slaytlar/<?php echo $slayt['foto']; ?>"  class="d-block w-100"  alt="First slide">
                                    </div>
                                    <?php } ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-shape shape1">
                    <img src="assets/img/hero/shape_1_1.png" alt="shape">
                </div>
                <div class="hero-shape shape2">
                    <img src="assets/img/hero/shape_1_2.png" alt="shape">
                </div>
                <div class="hero-shape shape3"></div>

                <div class="hero-shape shape4 shape-mockup jump-reverse" data-right="3%" data-bottom="7%">
                    <img src="assets/img/hero/shape_1_3.png" alt="shape">
                </div>
                <div class="hero-shape shape5 shape-mockup jump-reverse" data-left="0" data-bottom="0">
                    <img src="assets/img/hero/shape_1_4.png" alt="shape">
                </div>
            </div>
        </div>
    </div>
    <!--======== / Hero Section ========-->
    <!--==============================
About Area  
==============================-->
    <div class="space overflow-hidden" id="about-sec">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="img-box1 mb-40 mb-xl-0">
                        <div class="img1">
                            <img class="tilt-active" src="assets/img/bg/1.jpg" alt="About" style="width: 444px;height: 399px;object-fit: cover;">
                        </div>
                        <div class="about-grid" data-bg-src="assets/img/bg/3.jpg" style="width: 154px;height: 197px;object-fit: cover;">
                            <h3 class="about-grid_year"><span class="counter-number">10</span>k<span class="text-theme">+</span></h3>
                            <p class="about-grid_text"><?php echo dil_cevir( "Öğrenci", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                        </div>
                        <div class="img2">
                            <img class="tilt-active" src="assets/img/bg/7.jpg" alt="About" style="width: 340px;height: 265px;object-fit: cover;">
                        </div>
                        <div class="shape-mockup about-shape1 jump" data-left="-67px" data-bottom="0">
                            <img src="assets/img/normal/about_1_shape1.png" alt="img">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="title-area mb-30">
                        <span class="sub-title"><i class="fal fa-book me-2"></i> <?php echo $genel_ayarlar['anasayfa_baslik'.$dil]; ?></span>
                        <h2 class="sec-title"><?php echo $genel_ayarlar['anasayfa_baslik'.$dil]; ?></h2>
                    </div>
                    <p class="mt-n2 mb-25">
                        <?php echo $genel_ayarlar['anasayfa_icerik'.$dil]; ?>
                    </p>
                    <div class="btn-group mt-40">
                        <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>" class="th-btn"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $_REQUEST["dil"] ); ?><i class="fa-regular fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
Servce Area  
==============================-->
    <section class="space" data-bg-src="assets/img/bg/course_bg_1.png" id="course-sec">
        <div class="container">
            <div class="mb-35 text-center text-md-start">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-8">
                        <div class="title-area mb-md-0">
                            <span class="sub-title"><i class="fal fa-book me-2"></i> <?php echo dil_cevir( "Son Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></span>
                            <h2 class="sec-title"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></h2>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>" class="th-btn"><?php echo dil_cevir( "Tüm Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?><i class="fa-solid fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            <div class="row slider-shadow th-carousel course-slider-1" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-sm-slide-show="1" data-arrows="true">
                <?php 
                foreach( $duyurular as $duyuru ){ 
                    if( $duyuru['foto'] == "" )
                        $duyuru_foto = "ayu_logo.png";
                    else
                        $duyuru_foto = $duyuru['foto'];                
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="course-box" style="height: 500px;">
                        <div class="course-img" style="height: 250px;">
                            <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>">
                                <img src="../admin/resimler/duyurular/<?php echo $duyuru_foto; ?>" alt="img" style="height: 250px;object-fit: cover;">
                            </a>
                            <span class="tag"><i class="fas fa-clock"></i> <?php echo $fn->tarihVer($duyuru['tarih']); ?></span>
                        </div>
                        <div class="course-content">
                            <div class="course-rating">
                                <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                    <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5</span>
                                </div>
                            </div>
                            <h3 class="course-title" style="font-size: 16px; height:100px;">
                                <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>">
                                <?php echo $duyuru['baslik'.$dil] ?>
                                </a>
                            </h3>
                            <div class="course-meta ">
                                <span><i class="fa-solid fa-calendar-days"></i></i><?php echo $fn->tarihVer($duyuru['tarih']); ?></span>
                            </div>
                            <div class="course-author ">
                                <div class="author-info">
                                    <img src="assets/img/ayu_logo.png" alt="author">
                                    <a href="<?php echo $_REQUEST['kisa_ad']; ?>" class="author-name"><?php echo $birim_bilgileri['adi'.$dil]; ?></a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!--==============================
Counter Area  
==============================-->
    <div class="container">
        <div class="counter-area-1 bg-theme" data-bg-src="assets/img/bg/counter-bg_1.png">
            <div class="row justify-content-between">
                <div class="col-sm-6 col-xl-3 counter-card-wrap">
                    <div class="counter-card">
                        <h2 class="counter-card_number"><span class="counter-number"><?php echo $genel_ayarlar['sayac1']; ?></span><span class="fw-normal">+</span></h2>
                        <p class="counter-card_text"><strong><?php echo dil_cevir( $genel_ayarlar['sayac1_adi'.$dil], $dizi_dil, $_REQUEST["dil"] ); ?></strong> </p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 counter-card-wrap">
                    <div class="counter-card">
                        <h2 class="counter-card_number"><span class="counter-number"><?php echo $genel_ayarlar['sayac2']; ?></span><span class="fw-normal">+</span></h2>
                        <p class="counter-card_text"><strong><?php echo dil_cevir( $genel_ayarlar['sayac2_adi'.$dil], $dizi_dil, $_REQUEST["dil"] ); ?></strong> </p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 counter-card-wrap">
                    <div class="counter-card">
                        <h2 class="counter-card_number"><span class="counter-number"><?php echo $genel_ayarlar['sayac3']; ?></span><span class="fw-normal">%</span></h2>
                        <p class="counter-card_text"><strong><?php echo dil_cevir( $genel_ayarlar['sayac3_adi'.$dil], $dizi_dil, $_REQUEST["dil"] ); ?></strong></p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 counter-card-wrap">
                    <div class="counter-card">
                        <h2 class="counter-card_number"><span class="counter-number"><?php echo $genel_ayarlar['sayac4']; ?></span><span class="fw-normal">+</span></h2>
                        <p class="counter-card_text"><strong><?php echo dil_cevir( $genel_ayarlar['sayac4_adi'.$dil], $dizi_dil, $_REQUEST["dil"] ); ?></strong> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
Cta Area  
==============================-->
    <section class="cta-area-2 position-relative space-bottom">
        <div class="cta-bg-img" data-bg-src="assets/img/bg/cta-bg2.png">
        </div>
        <div class="cta-bg-img2" data-bg-src="assets/img/bg/cta-bg2-shape.png">
        </div>

        <div class="shape-mockup cta-shape1 jump d-md-block d-none" data-left="-2%" data-bottom="-7%">
            <img src="assets/img/normal/cta_2_shape1.png" alt="img">
        </div>

        <div class="shape-mockup cta-shape2 jump-reverse d-md-block d-none" data-right="-1%" data-top="-3%">
            <img src="assets/img/normal/cta_2_shape2.png" alt="img">
        </div>

        <div class="shape-mockup cta-shape3 spin d-md-block d-none" data-right="20%" data-top="30%">
            <img src="assets/img/normal/cta_2_shape3.png" alt="img">
        </div>

        <div class="container text-center">
            <div class="cta-wrap2">
                <div class="title-area text-center mb-35">
                    <h2 class="sec-title text-white">
                        <?php echo $genel_ayarlar['slogan2'.$dil]; ?>
                    </h2>
                    <p class="cta-text">
                        <?php echo $genel_ayarlar['slogan3'.$dil]; ?>
                    </p>
                </div>
                <div class="btn-group justify-content-center">
                    <a href="<?php echo $genel_ayarlar['buton_url1']; ?>" class="th-btn style3"><?php echo $genel_ayarlar['buton_deger1'.$dil]; ?><i class="fas fa-arrow-right ms-2"></i></a>
                    <a href="<?php echo $genel_ayarlar['buton_url2']; ?>" class="th-btn style2"><?php echo $genel_ayarlar['buton_deger2'.$dil]; ?><i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
Event Area  
==============================-->
    <section class="space" data-bg-src="assets/img/bg/event-bg_1.png">
        <div class="shape-mockup event-shape1 jump" data-top="0" data-left="-60px">
            <img src="assets/img/team/team-shape_1_1.png" alt="img">
        </div>
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title"><i class="fal fa-book me-2"></i> <?php echo dil_cevir( "Güncel Etkinlikler", $dizi_dil, $_REQUEST["dil"] ); ?></span>
                <h2 class="sec-title"><?php echo dil_cevir( "Etkinlikler", $dizi_dil, $_REQUEST["dil"] ); ?></h2>
            </div>
            <div class="row slider-shadow event-slider-1 th-carousel gx-70" data-slide-show="3" data-lg-slide-show="3" data-md-slide-show="1" data-sm-slide-show="1" data-xs-slide-show="1" data-arrows="true">
                <?php foreach( $etkinlikler as $etkinlik ){ ?>
                <div class="col-lg-6 col-xl-4">
                    <div class="event-card">
                        <div class="event-card_img" data-mask-src="assets/img/event/event_img-shape.png">
                            <img src="../admin/resimler/etkinlikler/<?php echo $etkinlik['foto'] ?>" alt="event" style="width: 200px;height: 200px;object-fit: cover;">
                        </div>
                        <div class="event-card_content">
                            <div class="event-author">
                                <div class="avater">
                                    <img src="assets/img/ayu_logo.png" alt="avater">
                                </div>
                                <div class="details">
                                    <span class="author-name"><?php echo $birim_bilgileri['adi'.$dil]; ?></span>
                                </div>
                            </div>
                            <div class="event-meta">
                                <p><i class="fal fa-location-dot"></i><?php echo dil_cevir( "Yer", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                                <p><i class="fal fa-clock"></i>08:00 am - 10:00 am</p>
                            </div>
                            <h3 class="event-card_title" style="font-size: 16px;;">
                                <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/etkinlikler/<?php echo $duyuru['id']; ?>">
                                <?php echo $etkinlik['baslik'.$dil]; ?>
                                </a>
                            </h3>
                            <div class="event-card_bottom">
                                <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/etkinlikler/<?php echo $duyuru['id']; ?>" class="th-btn"><?php echo dil_cevir( "Etkinliği Gör", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="far fa-arrow-right ms-1"></i></a>
                            </div>
                            <div class="event-card-shape jump">
                                <img src="assets/img/event/event-box-shape1.png" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>


<?php } ?>

    <!--==============================
	Footer Area
==============================-->
    <footer class="footer-wrapper footer-layout1" data-bg-src="assets/img/bg/footer-bg.png">
        <div class="shape-mockup footer-shape1 jump" data-left="60px" data-top="70px">
            <img src="assets/img/normal/footer-bg-shape1.png" alt="img">
        </div>
        <div class="shape-mockup footer-shape2 jump-reverse" data-right="80px" data-bottom="120px">
            <img src="assets/img/normal/footer-bg-shape2.png" alt="img">
        </div>
        <div class="footer-top">
            <div class="container">
                <div class="footer-contact-wrap">
                    <div class="footer-contact">
                        <div class="footer-contact_icon icon-btn">
                            <i class="fal fa-phone"></i>
                        </div>
                        <div class="media-body">
                            <p class="footer-contact_text"><?php echo dil_cevir( "Bizi ara", $dizi_dil, $_REQUEST["dil"] ); ?>:</p>
                            <a href="tel:<?php echo $genel_ayarlar['tel']; ?>" class="footer-contact_link"><?php echo $genel_ayarlar['tel']; ?></a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="footer-contact">
                        <div class="footer-contact_icon icon-btn">
                            <i class="fal fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <p class="footer-contact_text"><?php echo dil_cevir( "Email", $dizi_dil, $_REQUEST["dil"] ); ?>:</p>
                            <a href="mailto:<?php echo $genel_ayarlar['email']; ?>" class="footer-contact_link"><?php echo $genel_ayarlar['email']; ?>v</a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="footer-contact">
                        <div class="footer-contact_icon icon-btn">
                            <i class="fal fa-location-dot"></i>
                        </div>
                        <div class="media-body">
                            <p class="footer-contact_text"><?php echo dil_cevir( "Adres", $dizi_dil, $_REQUEST["dil"] ); ?>:</p>
                            <a href="https://goo.gl/maps/FfX1sG6LPF4vTT1g7" class="footer-contact_link"><?php echo $genel_ayarlar['adres'.$dil]; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-wrap" data-bg-src="assets/img/bg/jiji.png">
            <div class="widget-area">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-xxl-3 col-xl-3">
                            <div class="widget footer-widget">
                                <div class="th-widget-about">
                                    <div class="about-logo">
                                        <a href="<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']; ?>"><img src="../admin/resimler/logolar/<?php echo $genel_ayarlar['footer_logo']; ?>" alt="Ahmet Yesevi Üniversitesi" style="height: 200px;"></a>
                                    </div>
                                    <p class="about-text"><?php echo dil_cevir( "Türk dünyasının parlayan yıldızı.", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                                    <div class="th-social">
                                        <h6 class="title text-white"><?php echo dil_cevir( "Bizi takip et", $dizi_dil, $_REQUEST["dil"] ); ?>:</h6>
                                        <a href="<?php echo $genel_ayarlar['facebook']; ?>"><i class="fab fa-facebook-f"></i></a>
                                        <a href="<?php echo $genel_ayarlar['twitter']; ?>"><i class="fab fa-twitter"></i></a>
                                        <a href="<?php echo $genel_ayarlar['linkedin']; ?>"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="<?php echo $genel_ayarlar['youtube']; ?>"><i class="fab fa-youtube"></i></a>
                                        <a href="<?php echo $genel_ayarlar['instagram']; ?>"><i class="fa-brands fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title"><?php echo dil_cevir( "Hızlı Bağlantılar", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                                <div class="menu-all-pages-container">
                                    <ul class="menu">
                                        <li><a href="course.html">Life Coach</a></li>
                                        <li><a href="course.html">Business Coach</a></li>
                                        <li><a href="course.html">Health Coach</a></li>
                                        <li><a href="course.html">Development</a></li>
                                        <li><a href="course.html">Web Design</a></li>
                                        <li><a href="course.html">SEO Optimize</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title"><?php echo dil_cevir( "Lokasyon", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                                <div class="menu-all-pages-container">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23147.715132621033!2d68.4852074567093!3d43.51350782394916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4200d538dc3232cf%3A0x73b67e6d72ac6450!2sKentau!5e0!3m2!1str!2skz!4v1694599217045!5m2!1str!2skz" width="500" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright-wrap">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <p class="copyright-text">Copyright © 2023 <a href="<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']; ?>"><?php echo dil_cevir( "Ahmet Yesevi Üniversitesi", $dizi_dil, $_REQUEST["dil"] ); ?></a> All Rights Reserved.</p>
                        </div>
                        <div class="col-md-6 text-end d-none d-md-block">
                            <div class="footer-links">
                                <ul>
                                    <li><a href="about.html"><?php echo dil_cevir( "Gizlilik Politikası", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--********************************
			Code End  Here 
	******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>

    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Slick Slider -->
    <script src="assets/js/slick.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Magnific Popup -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up -->
    <script src="assets/js/jquery.counterup.min.js"></script>
    <!-- Circle Progress -->
    <script src="assets/js/circle-progress.js"></script>
    <!-- Range Slider -->
    <script src="assets/js/jquery-ui.min.js"></script>
    <!-- Isotope Filter -->
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <!-- Tilt JS -->
    <script src="assets/js/tilt.jquery.min.js"></script>
    <!-- Tweenmax JS -->
    <script src="assets/js/tweenmax.min.js"></script>
    <!-- Nice Select JS -->
    <script src="assets/js/nice-select.min.js"></script>

    <!-- Main Js File -->
    <script src="assets/js/main.js"></script>

</html>