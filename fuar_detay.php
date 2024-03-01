<?php 
$SQL_tum_fuarlar = <<< SQL
SELECT 
	f.*
    ,fd.fuar_id
    ,fd.dil_id
    ,fd.adi
    ,fd.aciklama
    ,fd.ne_yemeli
    ,fd.nerede_kalmali
    ,fd.diger_notlar
		,ft.fuar_kategori_idler
		,ftd.adi as fuar_tanim_adi
		,fg.foto
    ,b.adi as bolge_adi
    ,u.adi as ulke_adi
    ,s.adi as sehir_adi
    ,fad.adi as fuar_alani_adi
    ,fad.adres as fuar_alani_adres
    ,fa.map as fuar_alani_map
    ,fa.tel as fuar_alani_tel
    ,pb.kodu as para_birim_kodu
    ,pb.sembol as para_birim_sembol
    ,CONCAT(pb.kodu," - ",pb.sembol) as para_birimi
FROM 
	tb_fuarlar AS f
LEFT JOIN tb_fuarlar_dil AS fd ON f.id = fd.fuar_id
LEFT JOIN tb_fuar_tanimlari AS ft ON ft.id = f.fuar_tanim_id
LEFT JOIN tb_fuar_tanimlari_dil AS ftd ON ft.id = ftd.fuar_tanim_id AND ftd.dil_id = 1
LEFT JOIN tb_diller AS dil ON dil.id = fd.dil_id
LEFT JOIN tb_bolgeler AS b ON b.id = f.bolge_id
LEFT JOIN tb_ulkeler As u ON u.id = f.ulke_id
LEFT JOIN tb_sehirler AS s ON s.id = f.sehir_id
LEFT JOIN tb_fuar_alanlari AS fa ON fa.id = f.fuar_alani_id
LEFT JOIN tb_fuar_alanlari_dil AS fad ON fa.id = fad.fuar_alani_id AND fad.dil_id=1
LEFT JOIN tb_para_birimleri AS pb ON pb.id = f.para_birimi_id
LEFT JOIN tb_fuar_galeri AS fg ON fg.fuar_id = f.id AND fg.one_cikan_gorsel = 1
WHERE fd.dil_id = 1 AND f.id = ?
SQL;

$result	= $vt->selectSingle( $SQL_tum_fuarlar, array( $_REQUEST['fuar_id'] ) )[ 2 ];

// var_dump($_REQUEST);
$where = "WHERE fk.id in (".$result['fuar_kategori_idler'].")";
$SQL_fuar_kategorileri = <<< SQL
SELECT 
    fk.*
    ,fkd.fuar_kategori_id
    ,fkd.dil_id
    ,fkd.adi
FROM 
    tb_fuar_kategorileri AS fk
LEFT JOIN tb_fuar_kategorileri_dil AS fkd ON fk.id = fkd.fuar_kategori_id AND fkd.dil_id = 1
$where
SQL;
$fuar_kategorileri		= $vt->select( $SQL_fuar_kategorileri, array( ) )[ 2 ];


$where = "WHERE id in (".$result['fuar_sorumlu_idler'].")";
$SQL_fuar_sorumlulari = <<< SQL
SELECT 
    *
FROM 
    tb_sistem_kullanici
$where
SQL;
$fuar_sorumlulari		= $vt->select( $SQL_fuar_sorumlulari, array( ) )[ 2 ];

$SQL_galeri = <<< SQL
SELECT
  *
FROM 
  tb_fuar_galeri
WHERE
  fuar_id = ? 
SQL;

@$galeri        = $vt->select($SQL_galeri, array( $result['id'] ) )[ 2 ];


?>
<style>
.item {
    position:relative;
    display:inline-block;
}
.notify-badge{
    position: relative ;
    left:20px;
    top:10px;
    background:#ee4a62;
    text-align: center;
    border-radius: 10px 10px 10px 10px;
    color:white;
    padding:5px 10px;
}
</style>
<div class="edu-breadcrumb-area breadcrumb-style-4">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <!-- <span class="pre-title">DEVELOPER</span> -->
                        <h1 class="title"><?php echo $result['adi']; ?></h1>
                    </div>
                    <ul class="course-meta">
                        <li><i class="icon-27"></i><?php echo $fn->tarihVer($result['baslama_tarihi']); ?> - <?php echo $fn->tarihVer($result['bitis_tarihi']); ?></li>
                        <!-- <li><i class="icon-33"></i>08:00AM-10:00PM</li> -->
                        <li><i class="icon-40"></i><?php echo $result['sehir_adi']; ?>, <?php echo $result['ulke_adi']; ?></li>
                    </ul>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1">
                    <span></span>
                </li>
                <li class="shape-2 scene"><img data-depth="2" src="assets/images/about/shape-13.png" alt="shape"></li>
                <li class="shape-3 scene"><img data-depth="-2" src="assets/images/about/shape-15.png" alt="shape"></li>
                <li class="shape-4">
                    <span></span>
                </li>
                <li class="shape-5 scene"><img data-depth="2" src="assets/images/about/shape-07.png" alt="shape"></li>
            </ul>
        </div>

        <!--=====================================-->
        <!--=        Event Area Start         =-->
        <!--=====================================-->
        <section class="event-details-area edu-section-gap" style="padding-top: 50px;">
            <div class="container">
                <div class="event-details">
                    <h2 class="title"><?php echo $result['adi']; ?></h2>
                    <div class="main-thumbnail item">
                        <?php foreach( $fuar_kategorileri as $kategori ){ ?>
                        <span class="notify-badge"><?php echo $kategori['adi']; ?></span>
                        <?php } ?>
                        <img src="admin/resimler/fuarlar/buyuk/<?php echo $result['foto']; ?>" alt="Event">
                    </div>
                    <div class="row row--30">
                        <div class="col-lg-8">
                            <div class="details-content">
                                <h3><?php echo dil_cevir( "Fuar Hakkında", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                                <p>
                                    <?php echo $result['aciklama']; ?>
                                </p>
                                <?php if( count( $galeri ) > 0 ){ ?>
                                <div class="edu-gallery-area edu-section-gap" style="padding-top:50px;">
                                    <div class="container p-0">
                                        <h3 class="title"><?php echo dil_cevir( "Galeri", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                                        <div id="masonry-gallery" class="gallery-grid-wrap">
                                            <div id="animated-thumbnials">

                                                <?php foreach( $galeri as $foto_galeri ){ ?>
                                                <a href="admin/resimler/fuarlar/buyuk/<?php echo $foto_galeri['foto']; ?>"   class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap masonry-item">
                                                    <div class="thumbnail">
                                                        <img style="object-fit: cover;height: 180px;" src="admin/resimler/fuarlar/kucuk/<?php echo $foto_galeri['foto']; ?>" alt="Gallery Image">
                                                    </div>
                                                    <div class="zoom-icon">
                                                        <i class="icon-69"></i>
                                                    </div>
                                                </a>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <h3><?php echo dil_cevir( "Fuar Alanı", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                                <p>
                                    <h4><?php echo $result['fuar_alani_adi']; ?></h4>
                                </p>
                                <p>
                                    <?php echo dil_cevir( "Adres", $dizi_dil, $_REQUEST["dil"] ); ?> : <?php echo $result['fuar_alani_adres']; ?>
                                </p>
                                <ul class="event-meta">
                                    <li><i class="icon-40"></i><?php echo $result['sehir_adi']; ?>, <?php echo $result['ulke_adi']; ?></li>
                                    <li><i class="icon-71"></i><?php echo $result['fuar_alani_tel']; ?></li>
                                </ul>
                                <div class="gmap_canvas w-100">
                                    <?php echo $result['fuar_alani_map']; ?>
                                    <!-- <iframe id="gmap_canvas" src="https://maps.google.com/maps?q=melbourne,%20Australia&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="course-sidebar-3">
                                <div class="edu-course-widget widget-course-summery">
                                    <div class="inner">
                                        <div class="content">
                                            <h4 class="widget-title"><?php echo dil_cevir( "Taşıma Bedelleri", $dizi_dil, $_REQUEST["dil"] ); ?></h4>
                                            <ul class="course-item">
                                                <li>
                                                    <span class="label"><i class="fa-solid fa-cart-flatbed-suitcase"></i><b>Büyük Expo Case:</b></span>
                                                    <span class="value price text-dark"><?php echo $result['para_birim_sembol']; ?><?php echo $result['buyuk_expo_fiyat']; ?></span>
                                                </li>
                                                <li>
                                                    <span class="label"><i class="icon-60"></i>Tutar:</span>
                                                    <span class="value price"><?php echo $result['para_birim_sembol']; ?><span class="buyuk">0</span></span>
                                                </li>
                                                <li>
                                                    <span class="label"><i class="icon-3"></i>Adet:</span>
                                                    <input type="number" data-fiyat="<?php echo $result['buyuk_expo_fiyat']; ?>" data-tip="buyuk" class="form-control form-control-sm w-50 border adet" value="0">
                                                </li>
                                                    <br>
                                                    <br>
                                                <li>
                                                    <span class="label"><i class="fa-solid fa-cart-flatbed-suitcase"></i><b>Küçük Expo Case:</b></span>
                                                    <span class="value price text-dark"><?php echo $result['para_birim_sembol']; ?><?php echo $result['kucuk_expo_fiyat']; ?></span>
                                                </li>
                                                <li>
                                                    <span class="label"><i class="icon-60"></i>Tutar:</span>
                                                    <span class="value price"><?php echo $result['para_birim_sembol']; ?><span class="kucuk">0</span></span>
                                                </li>
                                                <li>
                                                    <span class="label"><i class="icon-3"></i>Adet:</span>
                                                    <input type="number" data-fiyat="<?php echo $result['kucuk_expo_fiyat']; ?>" data-tip="kucuk" class="form-control form-control-sm w-50 border adet" value="0">
                                                </li>
                                                    <br>
                                                    <br>
                                                <li>
                                                    <span class="label"><i class="fa-solid fa-cart-flatbed-suitcase"></i><b>Koli:</b></span>
                                                    <span class="value price text-dark"><?php echo $result['para_birim_sembol']; ?><?php echo $result['koli_fiyat']; ?></span>
                                                </li>
                                                <li>
                                                    <span class="label"><i class="icon-60"></i>Tutar:</span>
                                                    <span class="value price"><?php echo $result['para_birim_sembol']; ?><span class="koli">0</span></span>
                                                </li>
                                                <li>
                                                    <span class="label"><i class="icon-3"></i>Adet:</span>
                                                    <input type="number" data-fiyat="<?php echo $result['koli_fiyat']; ?>" data-tip="koli" class="form-control form-control-sm w-50 border adet" value="0">
                                                </li>
                                                <li>
                                                    <span class="label"><i class="icon-60"></i>Toplam Tutar:</span>
                                                    <span class="value price "><?php echo $result['para_birim_sembol']; ?><span class="toplam">0</span></span>
                                                </li>
                                            </ul>
                                            <div class="read-more-btn">
                                                <a href="<?php echo $actual_link; ?>#" class="edu-btn">TALEP GÖNDER <i class="icon-4"></i></a>
                                            </div>
                                            <div class="countdown"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
            

                    $(".adet").bind('keyup mouseup', function () {
                        var fiyat = $(this).data("fiyat")*$(this).val();
                        var tip = $(this).data("tip");
                        var toplam = $(".toplam").html();
                        $("."+tip).html(fiyat);            
                        toplam = 1*$(".kucuk").html() + 1*$(".buyuk").html() + 1*$(".koli").html();
                        $(".toplam").html(toplam);            
                    });                   
                </script>
                <div class="event-speaker">
                    <h3 class="heading-title"><?php echo dil_cevir( "Fuar Sorumluları", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                    <div class="row g-5">
                        <!-- Start Instructor Grid  -->
                        <?php foreach( $fuar_sorumlulari as $personel ){ ?>
                        <div class="col-lg-3 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                            <div class="edu-team-grid team-style-1">
                                <div class="inner">
                                    <div class="thumbnail-wrap">
                                        <div class="thumbnail">
                                            <a href="team-details.html">
                                                <img src="admin/resimler/<?php echo $personel['resim']; ?>" alt="team images">
                                            </a>
                                        </div>
                                        <ul class="team-share-info">
                                            <li><a href="<?php echo $actual_link; ?>#"><i class="icon-share-alt"></i></a></li>
                                            <li><a href="<?php echo $personel['instagram']; ?>"><i class="icon-instagram"></i></a></li>
                                            <li><a href="<?php echo $personel['twitter']; ?>"><i class="icon-twitter"></i></a></li>
                                            <li><a href="<?php echo $personel['linkedin']; ?>"><i class="icon-linkedin2"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="team-details.html"><?php echo $personel['adi']." ".$personel['soyadi']; ?></a></h5>
                                        <span class="designation"><?php echo $personel['unvan']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
