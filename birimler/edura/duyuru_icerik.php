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
                <h1 class="breadcumb-title"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></h1>
                <ul class="breadcumb-menu">
                    <li><a href="<?php echo $_REQUEST['kisa_ad']; ?>"><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                    <li><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
        Blog Area
    ==============================-->
    <section class="th-blog-wrapper blog-details space-top space-extra2-bottom">
        <div class="container">
            <div class="row gx-30">
                <div class="col-xxl-8 col-lg-7">
                    <div class="th-blog blog-single" >
                        <div class="blog-img">
                            <?php 
                                if( $duyuru_icerik['foto'] != "" ){
                            ?>
                            <img src="../admin/resimler/duyurular/<?php echo $duyuru_icerik['foto']; ?>" alt="Blog Image">
                            <?php } ?>
                        </div>
                        <div class="blog-content" style="min-height: 600px;">
                            <div class="blog-meta">
                                <a class="author" href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/"><i class="far fa-user"></i><?php echo @$birim_bilgileri['adi'.$dil]; ?></a>
                                <a ><i class="fa-light fa-calendar-days"></i><?php echo $fn->tarihVer($duyuru_icerik['tarih']); ?></a>
                                <!--a href="blog-details.html"><i class="fa-light fa-book"></i>Business Analysis</a-->
                            </div>
                            <h2 class="blog-title" style="font-size: 24px;"><?php echo @$duyuru_icerik['baslik'.$dil]; ?></h2>
                            <p>
                                <?php echo @$duyuru_icerik['icerik'.$dil]; ?>
                            </p>
                        </div>
                        <div class="share-links clearfix ">
                            <div class="row justify-content-between">
                                <div class="col-md-auto">
                                    <div class="tagcloud">
                                        <a href="<?php echo $birim_bilgileri['kisa_ad']; ?>"><?php echo @$birim_bilgileri['adi'.$dil]; ?></a>
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
                    <aside class="sidebar-area">
                        <div class="widget  ">
                            <h3 class="widget_title"><?php echo dil_cevir( "Duyurular", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                            <div class="recent-post-wrap">
                                <?php foreach( $duyurular as $duyuru ){ 
                                    if( $duyuru['foto'] == "" )
                                        $duyuru_foto = "ayu_logo.png";
                                    else
                                        $duyuru_foto = $duyuru['foto'];    
                                
                                ?>
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><img src="../admin/resimler/duyurular/<?php echo $duyuru_foto; ?>" alt="Blog Image"  style="width: 80px;height: 80px;object-fit: cover;"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title" style="font-size: 12px;"><a class="text-inherit" href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><?php echo $duyuru['baslik'.$dil]; ?></a></h4>
                                        <div class="recent-post-meta">
                                            <small class="text-muted"><a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><i class="fal fa-calendar"></i><?php echo $fn->tarihVer($duyuru['tarih']); ?></a></small>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
