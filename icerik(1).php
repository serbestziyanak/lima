<?php  
$SQL_birim_sayfa_tabs = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri_tabs
WHERE
  sayfa_id = ? 
SQL;

$SQL_birim_sayfa_sss = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri_sss
WHERE
  sayfa_id = ? 
SQL;

$SQL_birim_sayfa_personel = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri_personeller
WHERE
  sayfa_id = ? 
SQL;

$SQL_rektor_blogu = <<< SQL
SELECT
    rb.*
	,concat(p.adi," ",p.soyadi) AS rektor
	,p.foto
FROM 
  tb_rektor_blogu AS rb
LEFT JOIN tb_gorevler AS g ON rb.personel_id = g.personel_id
LEFT JOIN tb_personeller AS p ON g.personel_id = p.id
WHERE rb.yayin = 1 AND g.gorev_kategori_id = 1 AND g.birim_id = 1
ORDER BY rb.mesaj_tarihi DESC
SQL;

@$sayfa_tabs         = $vt->select($SQL_birim_sayfa_tabs, array( $sayfa_id ) )[ 2 ];
@$sayfa_sssler       = $vt->select($SQL_birim_sayfa_sss, array( $sayfa_id ) )[ 2 ];
@$sayfa_personeller  = $vt->select($SQL_birim_sayfa_personel, array( $sayfa_id ) )[ 2 ];
@$yorumlar           = $vt->select($SQL_rektor_blogu, array( ) )[ 2 ];
//var_dump( $sayfa_tabs );

    if( $birim_sayfa_bilgileri['kategori'] == 1 ){
        @$alt_menuler = $vt->select($SQL_alt_sayfalari_getir, array( $birim_sayfa_bilgileri['id'] ) )[ 2 ];
        $birim_sayfa_adi = $birim_sayfa_bilgileri['adi'.$dil];
        $birim_sayfa_kisa_ad = $birim_sayfa_bilgileri['kisa_ad'];
        $birim_sayfa_id = $birim_sayfa_bilgileri['id'];
    }else{
        @$alt_menuler = $vt->select($SQL_alt_sayfalari_getir, array( $birim_sayfa_bilgileri['ust_id'] ) )[ 2 ];
        @$birim_sayfa_bilgileri_id = $vt->selectSingle($SQL_birim_sayfa_bilgileri_id, array( $birim_sayfa_bilgileri['ust_id'] ) )[ 2 ];
        $birim_sayfa_adi = $birim_sayfa_bilgileri_id['adi'.$dil];
        $birim_sayfa_kisa_ad = $birim_sayfa_bilgileri_id['kisa_ad'];
        $birim_sayfa_id = $birim_sayfa_bilgileri_id['id'];
    }
?>
    <!--=====================================-->
    <!--=       Breadcrumb Area Start      =-->
    <!--=====================================-->


    <!--div class="edu-breadcrumb-area breadcrumb-style-2 bg-image" style="background-image: url(assets/images/bg/icerik_bg3.jpg);">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="page-title">
                    <h1 class="title"><?php echo $birim_sayfa_bilgileri['adi'.$dil]; ?></h1>
                </div>
                <ul class="edu-breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $_REQUEST['dil']; ?>"><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                    <li class="separator"><i class="icon-angle-right"></i></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="separator"><i class="icon-angle-right"></i></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo @$birim_sayfa_bilgileri['adi'.$dil]; ?></li>
                </ul>
            </div>
        </div>
    </div-->
    <div class="edu-breadcrumb-area breadcrumb-style-3 bg-image" style="background-image: url(assets/images/bg/bg-image-37.webp);">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="edu-breadcrumb">
                    <?php $sira = 0; foreach( $sayfa_ust_bilgiler_dizi as $sayfa_ust_bilgi_dizi ){
                        $sira++; 
                        if( $sira == count( $sayfa_ust_bilgiler_dizi ) ){
                    ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $sayfa_ust_bilgi_dizi["adi".$dil]; ?></li>
                    <?php }else{ ?>
                    <li class="breadcrumb-item"><a href="<?php echo $_REQUEST['dil']."/".$sayfa_ust_bilgi_dizi["id"]."/".$sayfa_ust_bilgi_dizi["kisa_ad"]; ?>"><?php echo $sayfa_ust_bilgi_dizi["adi".$dil]; ?></a></li>
                    <li class="separator"><i class="icon-angle-right"></i></li>
                    <?php } ?>
                    <?php } ?>
                    <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="separator"><i class="icon-angle-right"></i></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo @$birim_sayfa_bilgileri['adi'.$dil]; ?></li> -->
                </ul>
                <div class="page-title">
                    <h1 class="title"><?php echo $birim_sayfa_bilgileri['adi'.$dil]; ?></h1>
                </div>
                <ul class="course-meta">
                    <li><i class="icon-58"></i><?php echo $birim_sayfa_adi; ?></li>
                    <li><i class="icon-59"></i><?php echo strtoupper($_REQUEST['dil']); ?></li>
                    <li class="course-rating">
                        <div class="rating">
                            <i class="icon-23"></i>
                            <i class="icon-23"></i>
                            <i class="icon-23"></i>
                            <i class="icon-23"></i>
                            <i class="icon-23"></i>
                        </div>
                        <span class="rating-count"></span>
                    </li>
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
    <section class="edu-section-gap course-details-area" style="padding: 35px 0 120px;">
        <div class="container">

            <div class="row row--30">
                <div class="col-lg-8 p-0">
                    <?php if( $birim_sayfa_icerikleri["baslik".$dil] != "" ){ ?>
                    <div class="blog-details-content" style="border-bottom:0px;padding:0px;">

                        <?php if( $birim_sayfa_bilgileri['adi'.$dil] != $birim_sayfa_icerikleri["baslik".$dil] ){ ?>
                        <div class="entry-content">
                            <h3 class="title"><?php echo $birim_sayfa_icerikleri["baslik".$dil]; ?></h3>
                            <!--ul class="blog-meta">
                                <li><i class="icon-27"></i>Oct 10, 2021</li>
                                <li><i class="icon-28"></i>Com 09</li>
                            </ul-->
                            <!--div class="thumbnail">
                                <img src="assets/images/blog/blog-large-1.jpg" alt="Blog Image">
                            </div-->
                        </div>
                        <?php } ?>
                        <div class="ck-content">
                            <?php echo $birim_sayfa_icerikleri["icerik".$dil]; ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php 
                    if( $birim_sayfa_bilgileri['kisa_ad'] == "rektor-blogu" ){ 
                        include "rektor_blogu.php";
                    } 
                    if( $birim_sayfa_bilgileri['kisa_ad'] == "yapisal-bolumler" ){ 
                        include "yapisal_birimler.php";
                    } 
                    ?>

                    <?php include "sayfa_tablar.php"; ?>
                    <?php include "sayfa_accordion.php"; ?>
                    <?php include "sayfa_personeller.php"; ?>

                </div>
                <div class="col-lg-4" style="padding-top : 80px;">
                    <div class="course-sidebar-3 sidebar-top-position">
                        <div class="edu-course-widget widget-course-summery">
                            <div class="inner">
                                <div class="thumbnail">
                                    <img src="assets/images/course/v2.jpg" alt="Courses">
                                    <a href="https://www.youtube.com/watch?v=YDua-fpwK28" class="play-btn video-popup-activation"><i class="icon-18"></i></a>
                                </div>
                                <div class="content">
                                    <h4 class="widget-title" style="color:#cd201f"><a href="<?php echo $_REQUEST['dil']."/".$birim_sayfa_id."/".$birim_sayfa_kisa_ad; ?>"><?php echo $birim_sayfa_adi; ?>:</a></h4>
                                    <ul class="course-item">
                                        <?php foreach( $alt_menuler as $alt_menu ){ ?>
                                        <li>
                                            <span class="label"><i class="fa-solid fa-circle-check" style="color:<?php if($birim_sayfa_bilgileri['kisa_ad'] == $alt_menu['kisa_ad']) echo "#cd201f"; else echo "#2A8DA3"; ?>"></i><a href="<?php echo $_REQUEST['dil']."/".$alt_menu['id']."/".$alt_menu['kisa_ad'] ?>"><?php echo $alt_menu['adi'.$dil]; ?> </a></span>
                                            <!--span class="value price">$70.00</span-->
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <br>
                                    <br>
                                    <div class="edu-blog-widget widget-action p-0">
                                        <div class="inner">
                                            <h4 class="title"><?php echo dil_cevir( "Belge, Şikayet ve İstek Başvuruları", $dizi_dil, $_REQUEST["dil"] ); ?></span></h4>
                                            <span class="shape-line"><i class="icon-19"></i></span>
                                            <a href="<?php echo $genel_ayarlar['buton_url2']; ?>" class="edu-btn btn-medium"><?php echo dil_cevir( "Öğrenci İşleri", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a>
                                        </div>
                                    </div>
                                    <div class="share-area">
                                        <h4 class="title"><?php echo dil_cevir( "Paylaş", $dizi_dil, $_REQUEST["dil"] ); ?>:</h4>
                                        <ul class="social-share">
                                            <li><a href="#"><i class="icon-facebook"></i></a></li>
                                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                                            <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                                            <li><a href="#"><i class="icon-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<div class="rn-progress-parent">
    <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>