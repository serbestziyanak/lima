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
header( "Location:kz/");
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
<html class="" lang="<?php echo $_REQUEST["dil"]; ?>">
<head>
<base href="/" />
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo dil_cevir( "Ahmet Yesevi Üniversitesi", $dizi_dil, $_REQUEST["dil"] ); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/content-styles.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Spartan' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=icomoon' rel='stylesheet'>
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
    <?php
    if($sayfa_id == 50){
        ?>
        <script type="text/javascript" src="https://ayu.edu.kz/wp-includes/js/jquery/jquery.min.js?ver=3.6.0" id="jquery-core-js"></script>
        <script type="text/javascript" src="https://ayu.edu.kz/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.3.2" id="jquery-migrate-js"></script>
        <?php
    }
    ?>
</head>
<?php 
if( !in_array( $_REQUEST['dil'], $diller )   ){ 
    include "404.php";
    exit;
}
?>
<body class="sticky-header "><span style="display:none"></span>
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
        <header class="edu-header header-style-1 header-fullwidth">
            <div class="header-top-bar" >
                <div class="container">
                    <div class="header-top">
                        <div class="header-top-left">
                            <ul class="header-info">
                                <li><a target="_blank" href="https://avesis.ayu.edu.kz/"><?php echo dil_cevir( "AVESİS", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                <li><a target="_blank" href="https://students.ayu.edu.kz/"><?php echo dil_cevir( "Öğrenci", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                <li><a target="_blank" href=""><?php echo dil_cevir( "Mezun", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                <li><a target="_blank" href="https://sapa.ayu.edu.kz/"><?php echo dil_cevir( "Kalite", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                <li><a target="_blank" href="https://portal.ayu.edu.kz/"><?php echo dil_cevir( "Portal", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                <li><a target="_blank" href="https://lib.ayu.edu.kz/"><?php echo dil_cevir( "Kütüphane", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                                <li><a target="_blank" href="https://yassawifm.airtime.pro/"><?php echo dil_cevir( "Radyo", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                            </ul>

                        </div>
                        <div class="header-top-right">
                            <ul class="header-info">
                                <li class="social-icon">
                                    <a href="<?php echo $genel_ayarlar['facebook']; ?>" target="_blank"><i class="icon-facebook"></i></a>
                                    <a href="<?php echo $genel_ayarlar['instagram']; ?>" target="_blank"><i class="icon-instagram"></i></a>
                                    <a href="<?php echo $genel_ayarlar['twitter']; ?>" target="_blank"><i class="icon-twitter"></i></a>
                                    <a href="<?php echo $genel_ayarlar['linkedin']; ?>" target="_blank"><i class="icon-linkedin2"></i></a>
                                </li>
                                <li class="social-icon">
                                    <a style="<?php if( $_REQUEST['dil'] == "kz" )echo "color:#cd201f"; ?>" href="<?php echo str_replace(array('.kz/tr','.kz/kz','.kz/en','.kz/ru'),".kz/kz",$actual_link);?>">KZ</a>
                                    <a style="<?php if( $_REQUEST['dil'] == "tr" )echo "color:#cd201f"; ?>" href="<?php echo str_replace(array('.kz/tr','.kz/kz','.kz/en','.kz/ru'),".kz/tr",$actual_link);?>">TR</a>
                                    <a style="<?php if( $_REQUEST['dil'] == "en" )echo "color:#cd201f"; ?>" href="<?php echo str_replace(array('.kz/tr','.kz/kz','.kz/en','.kz/ru'),".kz/en",$actual_link);?>">EN</a>
                                    <a style="<?php if( $_REQUEST['dil'] == "ru" )echo "color:#cd201f"; ?>" href="<?php echo str_replace(array('.kz/tr','.kz/kz','.kz/en','.kz/ru'),".kz/ru",$actual_link);?>">RU</a>                                 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edu-sticky-placeholder"></div>
            <div class="header-mainmenu2">
                <div class="container">
                    <div class="header-navbar" style="height:150px;">
                        <div class="header-brand">
                            <div class="logo">
                                <a href="/<?php echo $_REQUEST['dil']; ?>/">
                                    <img class="logo-light" src="admin/resimler/logolar/<?php echo $genel_ayarlar['logo'.$dil]; ?>" alt="Corporate Logo" style="height:80px;">
                                    <img class="logo-dark" src="admin/resimler/logolar/<?php echo $genel_ayarlar['logo'.$dil]; ?>" alt="Corporate Logo">
                                </a>
                            </div>

                        </div>
                        <div class="header-mainnav text-center">
                            <?php  
                                //$genel_ayarlar['slogan']
                            ?>
                            <!-- <h6 style="color: #cd201f;margin:0px;">&#10077; Köklü Geçmişten &emsp;&emsp;&emsp;&emsp;&emsp;</h6>
                            <h6 style="color: #cd201f;margin:0px;">&emsp;&emsp;&emsp; Güçlü Geleceğe... &#10078;</h6> -->
                            <img src="assets/images/slogan<?php echo $dil;?>.png" style="width:320px;">
                        </div>
                        <div class="header-right">
                            <ul class="header-action">
                                <li class="search-bar">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ara">
                                        <button class="search-btn" type="button"><i class="icon-2"></i></button>
                                    </div>
                                </li>
                                <li class="icon search-icon">
                                    <a href="javascript:void(0)" class="search-trigger">
                                        <i class="icon-2"></i>
                                    </a>
                                </li>
                                <li class="header-btn">
                                    <a href="https://portal.ayu.edu.kz/" class="edu-btn btn-medium" style="background-color: #a20d20;"><?php echo dil_cevir( "AYU Portal", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a>
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
            <div class="header-top-bar" style="background-color: #a20d20;">
                <div class="container">
                    <div class="header-navbar">
                        <div class="header-mainnav">
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
                    </div>
                </div>
            </div>

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
<?php 
if( $_REQUEST['sayfa_adi'] == "tum_haberler"   ){ 
    include "tum_haberler.php";
}elseif( $_REQUEST['sayfa_adi'] == "tum_duyurular"   ){ 
    include "tum_duyurular.php";
}elseif( $_REQUEST['sayfa_adi'] == "tum_etkinlikler"   ){ 
    include "tum_etkinlikler.php";
}elseif( isset($_REQUEST['sayfa_adi']) ){ 
    header('Location: /404/');
    exit;
}elseif( $_REQUEST['sayfa_kisa_ad'] == "iletisim"   ){ 
    include "iletisim.php";
}elseif( $_REQUEST['sayfa_kisa_ad'] == "rektor-iletisim"   ){ 
    include "rektor_iletisim.php";
}elseif( $sayfa_id > 0 ){
    include "icerik.php";
}elseif( isset( $_REQUEST['personel_id'] )  ){ 
    include "personel_detay.php";
}elseif( isset( $_REQUEST['duyuru_id'] )  ){ 
    include "duyuru_icerik.php";
}elseif( isset( $_REQUEST['haber_id'] )  ){ 
    include "haber_icerik.php";
}elseif( isset( $_REQUEST['etkinlik_id'] )  ){ 
    include "etkinlik_icerik.php";
}else{ 

?>
        <!--=====================================-->
        <!--=       Hero Banner Area Start      =-->
        <!--=====================================-->
        <div class="hero-banner hero-style-3 bg-image">
            <div class="swiper university-activator">
                <div class="swiper-wrapper">
                    <?php 
                        $sira=0;
                        foreach( $slaytlar as $slayt ){
                        $sira++;
                        $slayt_aktif = $sira == 1 ? "active" : "";
                    ?>
                    <div class="swiper-slide">
                        <img data-transform-origin='center center' data-src="admin/resimler/slaytlar/<?php echo $slayt['foto']; ?>" class="swiper-lazy" alt="image">
                        <div class="thumbnail-bg-content">
                            <div class="container edublink-animated-shape">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="banner-content">
                                            <span class="subtitle" data-sal="slide-up" data-sal-duration="1000"><?php echo $slayt['baslik1'.$dil] ?></span>
                                            <h1 class="title"  style="font-family: 'Montserrat'" data-sal-delay="100" data-sal="slide-up" data-sal-duration="1000"><?php echo $slayt['baslik2'.$dil] ?></h1>
                                            <p data-sal-delay="200" data-sal="slide-up" data-sal-duration="1000"></p>
                                            <!--div class="banner-btn" data-sal-delay="400" data-sal="slide-up" data-sal-duration="1000">
                                                <a href="#" class="edu-btn ">Find courses <i class="icon-4"></i></a>
                                            </div-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
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
                            <h4 class="title"><?php echo dil_cevir( "Burs Olanağı", $dizi_dil, $_REQUEST["dil"] ); ?></h4>
                            <p><?php echo dil_cevir( "Üniversitemiz öğrencilerine çeşitli kuruluşlardan burs imkanı sağlamaktadır.", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                        </div>
                    </div>
                    <div class="features-box features-style-3 color-secondary-style edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="assets/images/animated-svg-icons/skilled-lecturers.svg" alt="animated icon">
                        </div>
                        <div class="content">
                            <h4 class="title"><?php echo dil_cevir( "Nitelikli Öğretim Elemanları", $dizi_dil, $_REQUEST["dil"] ); ?></h4>
                            <p><?php echo dil_cevir( "Birçok bilimsel alanda sayısız yayın yapmış seçkin öğretim elemanları.", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                        </div>
                    </div>
                    <div class="features-box features-style-3 color-extra02-style edublink-svg-animate">
                        <div class="icon">
                            <img class="svgInject" src="assets/images/animated-svg-icons/book-library.svg" alt="animated icon">
                            <!-- <i class="icon-36"></i> -->
                        </div>
                        <div class="content">
                            <h4 class="title"><?php echo dil_cevir( "Kütüphane", $dizi_dil, $_REQUEST["dil"] ); ?> </h4>
                            <p><?php echo dil_cevir( "Ahmet Yesevi Üniversitesi bünyesinde seçkin kitaplardan oluşan kütüphane.", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Categories Area  -->
        <div class="edu-categorie-area categorie-area-2 edu-section-gap section_ust_bilgi_bosluk" >
            <div class="container">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <h2 class="title"><?php echo dil_cevir( "Fakülteler", $dizi_dil, $_REQUEST["dil"] ); ?></h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                    <p></p>
                </div>

                <div class="row g-5">
                    <?php 
                        $sira=0;
                        $renkler = array(
                            "color-primary-style"
                            ,"color-secondary-style"
                            ,"color-extra01-style"
                            ,"color-tertiary-style"
                            ,"color-extra02-style"
                            ,"color-extra03-style"
                            ,"color-extra04-style"
                            ,"color-extra05-style"
                            ,"color-extra06-style"
                            ,"color-primary-style"
                            ,"color-secondary-style"
                            ,"color-extra01-style"
                            ,"color-tertiary-style"
                            ,"color-extra02-style"
                        );

                        foreach( $fakulteler as $fakulte ){
                        
                    ?>
                    <div class="col-lg-4 col-md-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="categorie-grid categorie-style-2 <?php echo $renkler[$sira]; ?> edublink-svg-animate">
                            <div class="icon">
                                <img src="admin/resimler/logolar/<?php echo $fakulte['birim_icon']; ?>" style = "height:50px;">
                            </div>
                            <div class="content">
                                <a href="birimler/<?php echo $_REQUEST['dil']."/".$sayfa_id."/".$fakulte['kisa_ad'] ?>">
                                    <h5 class="title"><?php echo $fakulte['adi'.$dil]; ?></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                        $sira++;
                    }
                    ?>

                </div>
            </div>
        </div>
        <!-- End Categories Area  -->
        <!-- Start Ad Banner Area  -->
        <div class="edu-cta-banner-area course-area-3 section-gap-large bg-lighten04 section_ust_bilgi_bosluk">
            <div class="container">
                <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                    <h2 class="title"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST['dil'] ); ?> & <?php echo dil_cevir( "Etkinlikler", $dizi_dil, $_REQUEST['dil'] ); ?></h2>
                    <span class="shape-line"><i class="icon-19"></i></span>
                </div>
                <div class="isotope-wrapper">
                    <div class="isotop-button isotop-filter">
                        <button data-filter=".haberler"  class="is-checked">
                            <span class="filter-text"><?php echo dil_cevir( "Haberler", $dizi_dil, $_REQUEST['dil'] ); ?></span>
                        </button>
                        <button data-filter=".duyurular">
                            <span class="filter-text"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST['dil'] ); ?></span>
                        </button>
                        <button data-filter=".etkinlikler">
                            <span class="filter-text"><?php echo dil_cevir( "Etkinlikler", $dizi_dil, $_REQUEST['dil'] ); ?></span>
                        </button>
                    </div>
                    <div class="row g-5 isotope-list">
                        <!-- Start Single Course  -->
                        <?php foreach( $haberler as $haber ){ 
                        if( $haber['baslik'.$dil] == "" )
                            continue;
                        ?>
                        <div class="col-md-6 col-lg-4 isotope-item haberler">
                            <div class="edu-course course-style-3" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="<?php echo $_REQUEST['dil']; ?>/haberler/<?php echo $haber['id']; ?>">
                                            <img src="admin/resimler/haberler/kucuk/<?php echo ( $haber['foto'] != "" ) ? $haber['foto'] : "ayu_logo_yazisiz.png";  ?>" alt="Course Meta" style="object-fit: cover; height: 250px; ">
                                        </a>
                                        <div class="time-top">
                                            <span class="duration"><i class="icon-61"></i><?php echo $fn->tarihVer($haber['tarih']); ?></span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <span class="course-level"><?php echo dil_cevir( "Haberler", $dizi_dil, $_REQUEST["dil"] ); ?></span>
                                        <h5 class="title" style="font-size:13px;">
                                            <a href="<?php echo $_REQUEST['dil']; ?>/haberler/<?php echo $haber['id']; ?>"><?php echo $haber['baslik'.$dil] ?></a>
                                        </h5>
                                        <div class="course-rating">
                                            <div class="rating">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <span class="rating-count"></span>
                                        </div>
                                        <div class="read-more-btn">
                                            <a class="edu-btn btn-small btn-secondary" href="<?php echo $_REQUEST['dil']; ?>/haberler/<?php echo $haber['id']; ?>"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-6 col-lg-12 isotope-item haberler">
                            <div class="event-view-all-btn" data-sal-delay="150" data-sal="slide-up" data-sal-duration="1200">
                                <h6 class="view-text"><a href="<?php echo $_REQUEST["dil"]."/tum_haberler"; ?>" class="btn-transparent"><?php echo dil_cevir( "Tüm haberler için tıklayın", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a></h6>
                            </div>
                        </div>

                        <?php foreach( $duyurular as $duyuru ){ 
                        if( $duyuru['baslik'.$dil] == "" )
                            continue;
                        ?>
                        <div class="col-md-6 col-lg-4 isotope-item duyurular">
                            <div class="edu-course course-style-3" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="<?php echo $_REQUEST['dil']; ?>/duyurular/<?php echo $duyuru['id']; ?>">
                                            <img src="admin/resimler/duyurular/kucuk/<?php echo ( $duyuru['foto'] != "" ) ? $duyuru['foto'] : "ayu_logo_yazisiz.png";  ?>" alt="Course Meta" style="object-fit: cover; height: 250px; ">
                                        </a>
                                        <div class="time-top">
                                            <span class="duration"><i class="icon-61"></i><?php echo $fn->tarihVer($duyuru['tarih']); ?></span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <span class="course-level"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></span>
                                        <h5 class="title" style="font-size:13px;">
                                            <a href="<?php echo $_REQUEST['dil']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><?php echo $duyuru['baslik'.$dil] ?></a>
                                        </h5>
                                        <div class="course-rating">
                                            <div class="rating">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <span class="rating-count"></span>
                                        </div>
                                        <div class="read-more-btn">
                                            <a class="edu-btn btn-small btn-secondary" href="<?php echo $_REQUEST['dil']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>
                        <div class="col-md-6 col-lg-12 isotope-item duyurular">
                            <div class="event-view-all-btn" data-sal-delay="150" data-sal="slide-up" data-sal-duration="1200">
                                <h6 class="view-text"><a href="<?php echo $_REQUEST["dil"]."/tum_duyurular"; ?>" class="btn-transparent"><?php echo dil_cevir( "Tüm duyurular için tıklayın", $dizi_dil, $_REQUEST["dil"] ); ?>  <i class="icon-4"></i></a></h6>
                            </div>
                        </div>

                        <?php foreach( $etkinlikler as $etkinlik ){ 
                        if( $etkinlik['baslik'.$dil] == "" )
                            continue;
                        ?>
                        <div class="col-md-6 col-lg-4 isotope-item etkinlikler asd">
                            <div class="edu-course course-style-3" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="<?php echo $_REQUEST['dil']; ?>/etkinlikler/<?php echo $etkinlik['id']; ?>">
                                            <img src="admin/resimler/etkinlikler/kucuk/<?php echo ( $etkinlik['foto'] != "" ) ? $etkinlik['foto'] : "ayu_logo_yazisiz.png";  ?>" alt="Course Meta" style="object-fit: cover; height: 250px;; ">
                                        </a>
                                        <div class="time-top">
                                            <span class="duration"><i class="icon-61"></i><?php echo $fn->tarihVer($etkinlik['tarih']); ?></span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <span class="course-level"><?php echo dil_cevir( "Etkinlikler", $dizi_dil, $_REQUEST["dil"] ); ?></span>
                                        <h5 class="title" style="font-size:13px;">
                                            <a href="<?php echo $_REQUEST['dil']; ?>/etkinlikler/<?php echo $etkinlik['id']; ?>"><?php echo $etkinlik['baslik'.$dil] ?></a>
                                        </h5>
                                        <div class="course-rating">
                                            <div class="rating">
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                                <i class="icon-23"></i>
                                            </div>
                                            <span class="rating-count"></span>
                                        </div>
                                        <div class="read-more-btn">
                                            <a class="edu-btn btn-small btn-secondary" href="<?php echo $_REQUEST['dil']; ?>/etkinlikler/<?php echo $etkinlik['id']; ?>"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-6 col-lg-12 isotope-item etkinlikler">
                            <div class="event-view-all-btn" data-sal-delay="150" data-sal="slide-up" data-sal-duration="1200">
                                <h6 class="view-text"> <a href="<?php echo $_REQUEST["dil"]."/tum_etkinlikler"; ?>" class="btn-transparent"><?php echo dil_cevir( "Tüm etkinlikler için tıklayın", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a></h6>
                            </div>
                        </div>

                        <!-- End Single Course  -->
                        <!-- Start Single Course  -->
                        <!--div class="col-md-6 col-lg-3 isotope-item undergraduate graduate">
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
                                        <h5 class="title" style="font-size:13px;">
                                            <a href="#">Karakalpakistan Tıp Enstitüsü ve Ahmet Yesevi Üniversitesi Arasında İş Birliği Protokolü İmzalandı</a>
                                        </h5>
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
                        </div-->
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

        <!-- End Ad Banner Area  -->
        <!--=====================================-->
        <!--=       About Area Start      		=-->
        <!--=====================================-->
        <div class="edu-about-area about-style-3 section_ust_bilgi_bosluk">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="about-content">
                            <div class="section-title section-left">
                                <span class="pre-title"></span>
                                <h2 class="title"><?php echo $genel_ayarlar['anasayfa_baslik'.$dil] ?></h2>
                                <span class="shape-line"><i class="icon-19"></i></span>
                            </div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#about-edu" type="button" role="tab" aria-selected="true"><?php echo dil_cevir( "Hakkımızda", $dizi_dil, $_REQUEST["dil"] ); ?></button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="about-edu" role="tabpanel">
                                    <p>
                                        <?php echo $genel_ayarlar['anasayfa_icerik'.$dil] ?>
                                    </p>
                                    <ul class="features-list">
                                        <li><?php echo dil_cevir( "Köklü Geçmişten Güçlü Geleceğe", $dizi_dil, $_REQUEST['dil'] ); ?></li>
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
        <div class="counterup-area-1 gap-lg-bottom-equal section_ust_bilgi_bosluk">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-3 col-sm-6" data-sal-delay="50" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-counterup counterup-style-1">
                            <h2 class="counter-item count-number primary-color">
                                <span class="odometer" data-odometer-final="<?php echo $genel_ayarlar['sayac1'] ?>">.</span><span></span>
                            </h2>
                            <h6 class="title"><?php echo dil_cevir( "Program", $dizi_dil, $_REQUEST["dil"] ); ?></h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-sal-delay="100" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-counterup counterup-style-1">
                            <h2 class="counter-item count-number secondary-color">
                                <span class="odometer" data-odometer-final="<?php echo $genel_ayarlar['sayac2'] ?>">.</span><span>K</span>
                            </h2>
                            <h6 class="title"><?php echo dil_cevir( "Öğrenci", $dizi_dil, $_REQUEST["dil"] ); ?></h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-counterup counterup-style-1">
                            <h2 class="counter-item count-number extra02-color">
                                <span class="odometer" data-odometer-final="<?php echo $genel_ayarlar['sayac3'] ?>">.</span><span>%</span>
                            </h2>
                            <h6 class="title"><?php echo dil_cevir( "İşe Yerleşme Oranı", $dizi_dil, $_REQUEST["dil"] ); ?></h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                        <div class="edu-counterup counterup-style-1">
                            <h2 class="counter-item count-number extra05-color">
                                <span class="odometer" data-odometer-final="<?php echo $genel_ayarlar['sayac4'] ?>">.</span><span>K+</span>
                            </h2>
                            <h6 class="title"><?php echo dil_cevir( "Akademik Personel", $dizi_dil, $_REQUEST["dil"] ); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="edu-cta-banner-area edu-cta-banner-area bg-image">
            <div class="container">
                <div class="edu-cta-banner">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="section-title section-center" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                                <h2 class="title"><?php echo dil_cevir( "Belge, Şikayet ve İstek Başvuruları", $dizi_dil, $_REQUEST["dil"] ); ?></h2>
                                <a href="<?php echo $genel_ayarlar['buton_url2']; ?>" class="edu-btn btn-secondary"><?php echo dil_cevir( "Öğrenci İşleri", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a>
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

        <!--=====================================-->
        <!--=       Course Area Start      		=-->
        <!--=====================================-->
        <!-- Start Course Area  -->
        <!-- End Course Area -->
        <!--=====================================-->
        <!--=       	Campus Area Start      =-->
        <!--=====================================-->
        <!-- Start Campus Area  -->
        <!--div class="edu-campus-area gap-lg-top-equal">
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
        </div-->
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
                            <h2 class="title"><?php echo dil_cevir( "Ahmet Yesevi Üniversitesi Tanıtım Videosu", $dizi_dil, $_REQUEST['dil'] ); ?></h2>
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
                                    <span class="subtitle"><?php echo dil_cevir( "Bize Yazın", $dizi_dil, $_REQUEST['dil'] ); ?>:</span>
                                    <h3 class="title"><a href="mailto:info@ayu.edu.kz">info@ayu.edu.kz</a></h3>
                                </div>
                                <div class="sparator">
                                    <span<?php echo $_REQUEST['dil'] == 'kz' ? ' style="font-size:15px;"' : ''; ?>><?php echo dil_cevir( "veya", $dizi_dil, $_REQUEST['dil'] ); ?></span>
                                </div>
                                <div class="content">
                                    <span class="subtitle"><?php echo dil_cevir( "Bizi Arayın", $dizi_dil, $_REQUEST['dil'] ); ?>:</span>
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
        <!--=====================================-->
        <!--=       Brand Area Start      		=-->
        <!--=====================================-->
        <!-- Start Brand Area  -->
        <div class="edu-brand-area brand-area-4 gap-lg-bottom-equal" style="padding-top:100px;">
<div class="container">
    <div class="row mx-auto my-auto justify-content-center">
        <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php $sira =0; foreach( $onemli_baglantilar as $onemli_baglanti ){ $sira++;?>
                <div class="carousel-item <?php if( $sira == 1 ) echo "active" ?>" data-bs-interval="3000">
                    <div class="col-md-2">
                        <div class="brand-grid">
                            <a href="<?php echo $onemli_baglanti[ 'link' ]; ?>" target="_blank"><img src="admin/resimler/logolar/<?php echo $onemli_baglanti[ 'foto' ]; ?>" alt="Brand Logo"></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- <a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a> -->
        </div>
    </div>
</div>
        </div>
<script>
let items = document.querySelectorAll('.carousel .carousel-item')

items.forEach((el) => {
    const minPerSlide = 6
    let next = el.nextElementSibling
    for (var i=1; i<minPerSlide; i++) {
        if (!next) {
            // wrap carousel by using first child
        	next = items[0]
      	}
        let cloneChild = next.cloneNode(true)
        el.appendChild(cloneChild.children[0])
        next = next.nextElementSibling
    }
})
</script>
<style>
@media (max-width: 767px) {
    .carousel-inner .carousel-item > div {
        display: none;
    }
    .carousel-inner .carousel-item > div:first-child {
        display: block;
    }
}

.carousel-inner .carousel-item.active,
.carousel-inner .carousel-item-next,
.carousel-inner .carousel-item-prev {
    display: flex;
}

/* medium and up screens */
@media (min-width: 768px) {
    
    .carousel-inner .carousel-item-end.active,
    .carousel-inner .carousel-item-next {
      transform: translateX(16.6%);
    }
    
    .carousel-inner .carousel-item-start.active, 
    .carousel-inner .carousel-item-prev {
      transform: translateX(-16.6%);
    }
}

.carousel-inner .carousel-item-end,
.carousel-inner .carousel-item-start { 
  transform: translateX(0);
}


</style>
        <!-- End Brand Area  -->
        <!--=====================================-->
<?php } ?>
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
                                        <img class="logo-light" src="admin/resimler/logolar/<?php echo $genel_ayarlar['footer_logo']; ?>" alt="Corporate Logo" style="width:200px;">
                                    </a>
                                </div>
                                <p class="description"><?php echo dil_cevir( "Türk dünyasının parlayan yıldızı", $dizi_dil, $_REQUEST['dil'] ); ?></p>
                                <div class="widget-information">
                                    <ul class="information-list">
                                        <li><span><?php echo dil_cevir( "Adres", $dizi_dil, $_REQUEST['dil'] ); ?>:</span><?php echo $genel_ayarlar['adres'.$dil] ?></li>
                                        <li><span><?php echo dil_cevir( "Tel", $dizi_dil, $_REQUEST['dil'] ); ?>:</span><a href="tel:+011235641231"><?php echo $genel_ayarlar['tel'] ?></a></li>
                                        <li><span><?php echo dil_cevir( "Email", $dizi_dil, $_REQUEST['dil'] ); ?>:</span><a href="mailto:info@edublink.com" target="_blank"><?php echo $genel_ayarlar['email'] ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="edu-footer-widget explore-widget">
                                <h4 class="widget-title">Online Platform</h4>
                                <div class="inner">
                                    <ul class="footer-link link-hover">
                                        <li><a href="https://portal.ayu.edu.kz/">AYU Portal</a></li>
                                        <li><a href="https://yassawifm.airtime.pro/">Yassawi FM</a></li>
                                        <li><a href="https://journals.ayu.edu.kz/">AYU Journals</a></li>
                                        <li><a href="http://mail.google.com/a/ayu.edu.kz">E-Mail</a></li>
                                        <li><a href="https://business.documentolog.kz/login">Documentolog</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="edu-footer-widget quick-link-widget">
                                <h4 class="widget-title"><?php echo dil_cevir( "Fakülteler", $dizi_dil, $_REQUEST['dil'] ); ?></h4>
                                <div class="inner">
                                    <ul class="footer-link link-hover">
                                        <?php foreach( $fakulteler as $fakulte ){ ?>
                                        <li><a href="birimler/<?php echo $_REQUEST['dil']."/".$sayfa_id."/".$fakulte['kisa_ad'] ?>"><?php echo $fakulte['adi'.$dil]; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="edu-footer-widget">
                                <h4 class="widget-title"><?php echo dil_cevir( "Lokasyon", $dizi_dil, $_REQUEST['dil'] ); ?></h4>
                                <div class="inner">
                                    <iframe src="<?php echo $genel_ayarlar['map']; ?>" width="400" height="300" style="border:0; border-radius:15px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                                <p><a href="<?php echo (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">Designed & Developed by <b>AYU Software Innovation Office</b></a></p>
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
    <script src="assets/js/vendor/owl.carousel.min.js"></script>
    <!-- Site Scripts -->
    <script src="assets/js/app.js"></script>
    <?php
    if($sayfa_id == 50){
        ?>
        <link media="all" href="assets/css/timeline.css" rel="stylesheet" />
        <script>
            (function ($) {
                "use strict";

                var sliderId = "stm-timeline-654e05245d7f8";

                $(document).ready(function () {
                    $("#" + sliderId + " .stm-timeline-images-carousel").owlCarousel({
                        nav: true,
                        dots: false,
                        items: 1,
                        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                        smartSpeed: 450,
                        navContainer: ".stm-timeline__nav",
                        URLhashListener: true,
                        autoplayHoverPause: true,
                        startPosition: "URLHash",
                    });

                    $("#" + sliderId + " .stm-timeline-captions-carousel").owlCarousel({
                        dots: false,
                        items: 1,
                        animateIn: "fadeIn",
                        mouseDrag: false,
                        URLhashListener: true,
                    });

                    $("#" + sliderId + " .stm-timeline-images-carousel").on("translated.owl.carousel", function (event) {
                        $("#" + sliderId + " .stm-timeline-captions-carousel").trigger("to.owl.carousel", [event.item.index, 300, true]);

                        $(".stm-timeline__step").eq(event.item.index).find("a").trigger("click");
                    });
                });

                $("#" + sliderId + " .stm-timeline-images-carousel")
                    .find(".stm-timeline__image")
                    .each(function () {
                        var itemHash = $(this).data("hash");

                        $(".stm-timeline__steps-list").append('<li class="stm-timeline__step"><a href="https://<?php echo $_SERVER['HTTP_HOST'].'/'.$_REQUEST["dil"]; ?>/50/tarihce#' + itemHash + '">' + itemHash + "</a></li>");
                    });

                $(document).on("click", ".stm-timeline__step a", function (e) {
                    
                    var stepEl = $(this).parent(),
                        progressLineWidth = stepEl.position().left;

                    stepEl.addClass("active").siblings().removeClass("active");

                    $(".stm-timeline__steps-progress").width(progressLineWidth + "px");
                });

                $("#" + sliderId + " .stm-timeline-images-carousel .stm-timeline__image").each(function () {
                    $(this).find(".stm-timeline__caption").clone().appendTo($(".stm-timeline-captions-carousel"));
                    $(this).find(".stm-timeline__caption").remove();
                });
            })(jQuery);
        </script>  
        <?php
    }
    ?>
</body>
<script>  

$(document).ready(function(){
    var $grid = $('.isotope-list').isotope({
        itemSelector: '.isotope-item'
    });

    // başlangıçta sadece .class1 öğelerini yükle
    $grid.isotope({ filter: '.haberler' });
});
</script>

</html>