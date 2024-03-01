<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<?php  
$SQL_haberler = <<< SQL
SELECT
  *
FROM 
  tb_haberler
WHERE birim_id = ?  and baslik$dil != ""
ORDER BY tarih DESC
SQL;

@$haberler = $vt->select($SQL_haberler, array( $birim_id ) )[ 2 ];



?>

    <div class="edu-breadcrumb-area breadcrumb-style-3 bg-image" style="background-image: url(assets/images/bg/bg-image-37.webp);">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="edu-breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $_REQUEST['dil']; ?>/"><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                    <li class="separator"><i class="icon-angle-right"></i></li>
                    <li class="breadcrumb-item active"><?php echo dil_cevir( "Tüm Haberler", $dizi_dil, $_REQUEST["dil"] ); ?></li>
                </ul>
                <div class="page-title">
                    <h1 class="title"><?php echo dil_cevir( "Tüm Haberler", $dizi_dil, $_REQUEST["dil"] ); ?></h1>
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
                    <table id="example" style="width:100%;border:0px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo dil_cevir( "Tarih", $dizi_dil, $_REQUEST["dil"] ); ?></th>
                                    <th><?php echo dil_cevir( "Haber Görsel", $dizi_dil, $_REQUEST["dil"] ); ?></th>
                                    <th><?php echo dil_cevir( "Başlık", $dizi_dil, $_REQUEST["dil"] ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sira = 0; foreach( $haberler as $haber ){ $sira++; ?>
                                <tr>
                                    <td style="border:0px;"><?php echo $sira; ?></td>
                                    <td style="border:0px;"><span style="display:none;"><?php echo $haber['tarih']; ?></span><?php echo $fn->tarihVer($haber['tarih']); ?></td>
                                    <td style="border:0px;"><a href="<?php echo $_REQUEST['dil']."/haberler/".$haber['id'] ?>"><img style="object-fit: cover; width:200px;height: 100px; " src="admin/resimler/haberler/kucuk/<?php echo $haber['foto']; ?>"></a></td>
                                    <td style="border:0px;"><a href="<?php echo $_REQUEST['dil']."/haberler/".$haber['id'] ?>"><?php echo $haber['baslik'.$dil]; ?> </a></td>
                                </tr>
                                <?php } ?>

                            </tbody>
                    </table>

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
                                    <h4 class="widget-title" style="color:#cd201f"><?php echo dil_cevir( "Tüm Haberler", $dizi_dil, $_REQUEST["dil"] ); ?>:</a></h4>
                                    <ul class="course-item">
                                    </ul>
                                    <br>
                                    <br>
                                    <!-- <div class="edu-blog-widget widget-action p-0">
                                        <div class="inner">
                                            <h4 class="title"><?php echo dil_cevir( "Belge, Şikayet ve İstek Başvuruları", $dizi_dil, $_REQUEST["dil"] ); ?></span></h4>
                                            <span class="shape-line"><i class="icon-19"></i></span>
                                            <a href="<?php echo $genel_ayarlar['buton_url2']; ?>" class="edu-btn btn-medium"><?php echo dil_cevir( "Öğrenci İşleri", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a>
                                        </div>
                                    </div> -->
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

<script>
    $('#example').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     false,
        "searching": true,
        "lengthChange": false
    } );
</script>