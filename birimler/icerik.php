<?php
$SQL_ust_birim_sayfa_bilgileri = <<< SQL
SELECT
	*
FROM 
	tb_birim_sayfalari
WHERE 
	id = ?
ORDER BY sira
SQL;

$SQL_ust_birim_sayfalari_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_sayfalari
WHERE 
	aktif$dil = 1 AND harici = 0  AND ust_id = ? 
ORDER BY sira
SQL;

$SQL_birim_sayfa_sss = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri_sss
WHERE
  sayfa_id = ? 
ORDER BY sira
SQL;

$SQL_galeri = <<< SQL
SELECT
  *
FROM 
  tb_sayfa_galeri
WHERE
  sayfa_id = ? 
SQL;

@$galeri        = $vt->select($SQL_galeri, array( $sayfa_id ) )[ 2 ];


@$ust_birim_sayfalari 		= $vt->select($SQL_ust_birim_sayfalari_getir, array( $birim_sayfa_bilgileri['ust_id'] ) )[ 2 ];
@$ust_birim_sayfa_bilgileri	= $vt->selectSingle($SQL_ust_birim_sayfa_bilgileri, array( $birim_sayfa_bilgileri['ust_id'] ) )[ 2 ];
@$sayfa_sssler       = $vt->select($SQL_birim_sayfa_sss, array( $sayfa_id ) )[ 2 ];

//var_dump($ust_birim_sayfa_bilgileri);
?>

    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper " data-bg-src="assets/img/bg/2.jpg" data-overlay="title" data-opacity="8">
        <div class="breadcumb-shape" data-bg-src="assets/img/bg/breadcumb_shape_1_1.png">
        </div>
        <div class="shape-mockup breadcumb-shape2 jump d-lg-block d-none" data-right="30px" data-bottom="30px">
            <img src="assets/img/bg/breadcumb_shape_1_2.png" alt="shape">
        </div>
        <div class="shape-mockup breadcumb-shape3 jump-reverse d-lg-block d-none" data-left="50px" data-bottom="80px">
            <img src="assets/img/bg/breadcumb_shape_1_3.png" alt="shape">
        </div>
        <div class="container">
            <div class="breadcumb-content text-center">
                <h1 class="breadcumb-title" style="text-transform:none;"><?php echo $birim_sayfa_bilgileri['adi'.$dil]; ?></h1>
                <ul class="breadcumb-menu">
                    <li><a href="<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']; ?>"><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                    <li><?php echo @$birim_sayfa_bilgileri['adi'.$dil]; ?></li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
        Blog Area
    ==============================-->
<?php 
    if( $_REQUEST['sayfa_kisa_ad'] == "iletisim" ){
        include "iletisim.php";
    }elseif( $_REQUEST['sayfa_kisa_ad'] == "akademik-personel" ){
         include "akademik_personel.php";
    }elseif( $_REQUEST['sayfa_kisa_ad'] == "programlar" ){
         include "programlar.php";
    }else{ ?>

    <section class="th-blog-wrapper blog-details space-top space-extra2-bottom">
        <div class="container">
            <div class="row gx-30">
                <div class="col-xxl-8 col-lg-7">
                    <div class="th-blog blog-single" >
                        <!--div class="blog-img">
                            <img src="assets/img/blog/blog-s-1-5.jpg" alt="Blog Image">
                        </div-->
                        <div class="blog-content" style="min-height: 600px;padding:2px;">
                            <!--div class="blog-meta">
                                <a class="author" href="blog.html"><i class="far fa-user"></i>by David Smith</a>
                                <a href="blog.html"><i class="fa-light fa-calendar-days"></i>05 June, 2023</a>
                                <a href="blog-details.html"><i class="fa-light fa-book"></i>Business Analysis</a>
                            </div-->
                            <?php 
                            if( $_REQUEST['sayfa_kisa_ad'] == "fakulte-yonetimi" ){ 
                                //include "fakulte_yonetimi.php";
                            }elseif( $_REQUEST['sayfa_kisa_ad'] == "fakulte-yonetim-kurulu" ){ 
                                //include "fakulte_yonetim_kurulu.php";
                            }elseif( $_REQUEST['sayfa_kisa_ad'] == "ogretim-ve-metodoloji-komitesi" ){ 
                                //include "ogretim_ve_metodoloji_komitesi.php";
                            }elseif( $_REQUEST['sayfa_kisa_ad'] == "kalite-komisyonu" ){ 
                                //include "kalite_komisyonu.php";
                            }elseif( $_REQUEST['sayfa_kisa_ad'] == "yonetim" ){ 
                                //include "bolum_yonetimi.php";
                            }else{ 
                                ?>
                                <h2 class="blog-title" style="font-size: 24px;"><?php echo @$birim_sayfa_icerikleri['baslik'.$dil]; ?></h2>
                                <div class="ck-content" style="font-family:'Roboto', sans-serif !important; font-size: 16px !important; ">
                                    <?php echo @$birim_sayfa_icerikleri['icerik'.$dil]; ?>
                                </div>
                                <?php if( count( $galeri ) > 0 ){ ?>
                                    <div class="space">
                                        <div class="container">
                                            <div class="row gy-4 masonary-active">
                                                <?php foreach( $galeri as $foto_galeri ){ ?>
                                                <div class="col-md-6 col-xxl-auto filter-item">
                                                    <div class="gallery-card">
                                                        <div class="gallery-img">
                                                            <img style="object-fit: cover;height: 180px;width: 180px;" src="../admin/resimler/sayfalar/kucuk/<?php echo $foto_galeri['foto']; ?>" alt="gallery image">
                                                            <a href="../admin/resimler/sayfalar/buyuk/<?php echo $foto_galeri['foto']; ?>" class="gallery-btn popup-image"><i class="fas fa-eye"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            <?php } ?> 
                            <?php include "sayfa_tablar.php"; ?>
                            <?php include "sayfa_accordion.php"; ?>
                            <?php include "sayfa_personeller.php"; ?>

                        </div>
                        <div class="share-links clearfix ">
                            <div class="row justify-content-between">
                                <div class="col-md-auto">
                                    <span class="share-links-title"></span>
                                    <div class="tagcloud">
                                        <a href="<?php echo $_REQUEST["dil"]."/".$birim_bilgileri['kisa_ad']; ?>"><?php echo @$birim_bilgileri['adi'.$dil]; ?></a>
                                    </div>
                                </div>
                                <div class="col-md-auto text-xl-end">
                                    <span class="share-links-title"><?php echo dil_cevir( "Paylaş", $dizi_dil, $_REQUEST["dil"] ); ?>:</span>
                                    <ul class="social-links">
                                        <li><a href="https://facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="https://linkedin.com/" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="https://instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    </ul><!-- End Social Share -->
                                </div><!-- Share Links Area end -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <?php if( $birim_sayfa_bilgileri['ust_id'] != 0 ){ ?>
                    <aside class="sidebar-area">
                        <div class="widget  ">
                            <h3 class="widget_title"><?php echo $ust_birim_sayfa_bilgileri['adi'.$dil]; ?></h3>
                            <div class="recent-post-wrap">
                                <ul>
                                <?php foreach( $ust_birim_sayfalari as $ust_birim_sayfa ){   
                                    if( $ust_birim_sayfa['kategori'] == 0 ){
                                        if( $ust_birim_sayfa['link'] == 1 ){
                                            $url = $ust_birim_sayfa['link_url'];
                                            $target = "_blank";
                                        }else{
                                            $url = $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']."/".$ust_birim_sayfa['kisa_ad'];
                                            $target = "";
                                        }
                                    }
                                ?>
                                    <li class="active"><a href="<?php echo $url; ?>" title="Aday Öğrenci" target="<?php echo $target; ?>"><?php echo $ust_birim_sayfa['adi'.$dil]; ?></a></li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </aside>
                    <?php } ?>
                    <aside class="sidebar-area">
                        <div class="course-single-bottom">
                            <ul class="nav course-tab" id="courseTab" role="tablist">
                                <li class="nav-item " role="presentation">
                                    <a style="" class="nav-link active" id="tab-duyurular" data-bs-toggle="tab" href="#Coursedescription-duyurular" role="tab" aria-controls="Coursedescription" aria-selected="true">
                                        <i class="fa-solid fa-bullhorn"></i>
                                        <?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?>
                                    </a>
                                </li>
                                <li class="nav-item " role="presentation">
                                    <a style="" class="nav-link" id="tab-etkinlikler" data-bs-toggle="tab" href="#Coursedescription-etkinlikler" role="tab" aria-controls="Coursedescription" aria-selected="false">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <?php echo dil_cevir( "Etkinlikler", $dizi_dil, $_REQUEST["dil"] ); ?>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="productTabContent">
                                <div class="tab-pane fade show active" id="Coursedescription-duyurular" role="tabpanel" aria-labelledby="tab-duyurular">
                                    <div class="course-Reviews">
                                        <div class="th-comments-wrap p-0">
                                            <h3 class="widget_title p-0"></h3>
                                            <div class="recent-post-wrap m-4">
                                                <?php foreach( $duyurular as $duyuru ){ 
                                                    if( $duyuru['foto'] == "" )
                                                        $duyuru_foto = "ayu_logo_yazisiz.png";
                                                    else
                                                        $duyuru_foto = $duyuru['foto'];    
                                                
                                                ?>
                                                <div class="recent-post">
                                                    <div class="media-img">
                                                        <a href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><img src="../admin/resimler/duyurular/kucuk/<?php echo $duyuru_foto; ?>" alt="Blog Image"  style="width: 80px;height: 80px;object-fit: cover;"></a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="post-title" style="font-size: 14px;"><a class="text-inherit" href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><?php echo $duyuru['baslik'.$dil]; ?></a></h4>
                                                        <div class="recent-post-meta">
                                                            <small class="text-muted" style="font-size: 12px;"><i class="fa-solid fa-calendar-days"></i> <?php echo $fn->tarihVer($duyuru['tarih']); ?></small>
                                                            <small class="text-muted" style="font-size: 12px;float: right;"><i class="fa-duotone fa-school"></i> <?php echo $duyuru['birim_adi'.$dil]; ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="event-card_bottom">
                                                    <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/tum_duyurular" class="th-btn"><?php echo dil_cevir( "Tüm Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?><i class="fa-solid fa-arrow-right ms-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Coursedescription-etkinlikler" role="tabpanel" aria-labelledby="tab-etkinlikler">
                                    <div class="course-Reviews">
                                        <div class="th-comments-wrap p-0">
                                            <h3 class="widget_title p-0"></h3>
                                            <div class="recent-post-wrap m-4">
                                                <?php foreach( $etkinlikler as $etkinlik ){ 
                                                    if( $etkinlik['foto'] == "" )
                                                        $etkinlik_foto = "ayu_logo_yazisiz.png";
                                                    else
                                                        $etkinlik_foto = $etkinlik['foto'];    
                                                
                                                ?>
                                                <div class="recent-post">
                                                    <div class="media-img">
                                                        <a href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/etkinlikler/<?php echo $etkinlik['id']; ?>"><img src="../admin/resimler/etkinlikler/kucuk/<?php echo $etkinlik_foto; ?>" alt="Blog Image"  style="width: 80px;height: 80px;object-fit: cover;"></a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="post-title" style="font-size: 12px;"><a class="text-inherit" href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/etkinlikler/<?php echo $etkinlik['id']; ?>"><?php echo $etkinlik['baslik'.$dil]; ?></a></h4>
                                                        <div class="recent-post-meta">
                                                            <small class="text-muted" style="font-size: 12px;"><i class="fa-solid fa-calendar-days"></i> <?php echo $fn->tarihVer($etkinlik['tarih']); ?></small>
                                                            <small class="text-muted" style="font-size: 12px;float: right;"><i class="fa-duotone fa-school"></i> <?php echo $etkinlik['birim_adi'.$dil]; ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="event-card_bottom">
                                                    <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/tum_etkinlikler" class="th-btn"><?php echo dil_cevir( "Tüm Etkinlikler", $dizi_dil, $_REQUEST["dil"] ); ?><i class="fa-solid fa-arrow-right ms-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
<?php } ?>