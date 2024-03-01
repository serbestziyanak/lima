<?php  
$duyuru_id = $_REQUEST['duyuru_id'];

$SQL_duyurular = <<< SQL
SELECT
  *
FROM 
  tb_duyurular
WHERE birim_id = ?  and baslik$dil != ""
limit 8
SQL;

$SQL_tek_duyuru = <<< SQL
SELECT
  *
FROM 
  tb_duyurular
WHERE
  id = ? 
SQL;

$SQL_galeri = <<< SQL
SELECT
  *
FROM 
  tb_duyuru_galeri
WHERE
  duyuru_id = ? 
SQL;

@$galeri        = $vt->select($SQL_galeri, array( $duyuru_id ) )[ 2 ];

@$duyuru_icerik = $vt->selectSingle($SQL_tek_duyuru, array( $duyuru_id ) )[ 2 ];
@$duyurular     = $vt->select($SQL_duyurular, array( $birim_id ) )[ 2 ];

if( $personel_bilgileri['id'] < 1 ){
    header('Location: /404/');
}

?>

    <div class="edu-breadcrumb-area breadcrumb-style-3 bg-image" style="background-image: url(assets/images/bg/bg-image-37.webp);">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="edu-breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $_REQUEST['dil']; ?>/"><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                    <li class="separator"><i class="icon-angle-right"></i></li>
                    <li class="breadcrumb-item active"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></li>
                </ul>
                <div class="page-title">
                    <h1 class="title"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></h1>
                </div>
                <ul class="course-meta">
                    <li><i class="icon-58"></i><?php echo $birim_bilgileri['adi'.$dil]; ?></li>
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
                <div class="col-lg-8">
                    <div class="course-details-content course-details-3">

                        <div class="entry-content">
                            <h3 class="title"><?php echo $duyuru_icerik["baslik".$dil]; ?></h3>
                            <ul class="course-meta">
                                <li><i class="fa-regular fa-clock"></i><?php echo $fn->tarihVer($duyuru_icerik['tarih']); ?></li>
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
                            <br>
                            <div >
                                <?php if( $duyuru_icerik["foto"] != "" ){ ?>
                                <img src="admin/resimler/duyurular/buyuk/<?php echo $duyuru_icerik["foto"]; ?>" alt="Course" style="border-radius: 10px;">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="ck-content" style="padding-top:50px;">
                            <?php echo $duyuru_icerik["icerik".$dil]; ?>
                        </div>
                        <hr>
                    </div>
                    <?php if( count( $galeri ) > 0 ){ ?>
                    <div class="edu-gallery-area edu-section-gap" style="padding-top:50px;">
                        <div class="container">
                            <!-- <h3 class="title"><?php echo dil_cevir( "Galeri", $dizi_dil, $_REQUEST["dil"] ); ?></h3> -->
                            <div id="masonry-gallery" class="gallery-grid-wrap">
                                <div id="animated-thumbnials">

                                    <?php foreach( $galeri as $foto_galeri ){ ?>
                                    <a href="admin/resimler/duyurular/buyuk/<?php echo $foto_galeri['foto']; ?>"   class="edu-popup-image edu-gallery-grid p-gallery-grid-wrap masonry-item">
                                        <div class="thumbnail">
                                            <img style="object-fit: cover;height: 180px;" src="admin/resimler/duyurular/kucuk/<?php echo $foto_galeri['foto']; ?>" alt="Gallery Image">
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



                </div>
                <div class="col-lg-4" style="padding-top : 80px;">
                    <div class="course-sidebar-3 sidebar-top-position">
                        <div class="edu-course-widget widget-course-summery">
                            <div class="inner">
                                <div class="thumbnail">
                                    <img src="assets/images/course/v4.jpg" alt="Courses">
                                    <a href="https://www.youtube.com/watch?v=_0BqoeZFWQ4" class="play-btn video-popup-activation"><i class="icon-18"></i></a>
                                </div>
                                <div class="content">
                                    <h4 class="widget-title" style="color:#cd201f"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?>:</a></h4>
                                    <ul class="course-item">
                                        <?php foreach( $duyurular as $duyuru ){ ?>
                                        <li>
                                            <span class="label"><i class="fa-solid fa-circle-check" style="color:<?php if($duyuru['id'] == $duyuru_id) echo "#cd201f"; else echo "#2A8DA3"; ?>"></i><a href="<?php echo $_REQUEST['dil']."/duyurular/".$duyuru['id'] ?>"><?php echo $duyuru['baslik'.$dil]; ?> </a></span>
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