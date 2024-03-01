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
                <h1 class="breadcumb-title"><?php echo $birim_sayfa_bilgileri['adi'.$dil]; ?></h1>
                <ul class="breadcumb-menu">
                    <li><a href="<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']; ?>">Anasayfa</a></li>
                    <li><?php echo @$birim_sayfa_bilgileri['adi'.$dil]; ?></li>
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
                        <!--div class="blog-img">
                            <img src="assets/img/blog/blog-s-1-5.jpg" alt="Blog Image">
                        </div-->
                        <div class="blog-content" style="min-height: 600px;">
                            <!--div class="blog-meta">
                                <a class="author" href="blog.html"><i class="far fa-user"></i>by David Smith</a>
                                <a href="blog.html"><i class="fa-light fa-calendar-days"></i>05 June, 2023</a>
                                <a href="blog-details.html"><i class="fa-light fa-book"></i>Business Analysis</a>
                            </div-->
                            <?php if( $_REQUEST['sayfa_kisa_ad'] == "fakulte-yonetimi" ){ ?>
                                <h2 class="blog-title" style="font-size: 24px;"><?php echo dil_cevir( "Fakülte Yönetimi", $dizi_dil, $_REQUEST["dil"] ); ?></h2>

                                <div class="row text-center justify-content-md-center">
                                    <?php foreach( $gorevler as $gorev ){ if( $gorev['oncelik_sirasi'] == 1 ){  
                                        if( $gorev['foto'] == "resim_yok.png" or $gorev['foto'] == "" ) $foto = "ayu_logo.png"; else $foto = $gorev['foto'];
                                    ?>
                                    <div class="col-xl-5 col-md-6 justify-content-md-center">
                                        <div class="team-card team-card-1-1-active mt-0">
                                            <div class="team-img-wrap">
                                                <div class="team-img">
                                                    <img src="../admin/resimler/personel_resimler/<?php echo $foto; ?>" alt="Team" style="width: 327px;height: 250px;object-fit: cover;">
                                                </div>
                                            </div>
                                            <div class="team-hover-wrap">
                                                <div class="team-social">
                                                    <a href="#" class="icon-btn">
                                                        <i class="far fa-plus"></i>
                                                    </a>
                                                    <div class="th-social">
                                                        <a target="_blank" href="https://vimeo.com/"><i class="fab fa-vimeo-v"></i></a>
                                                        <a target="_blank" href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                                        <a target="_blank" href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
                                                        <a target="_blank" href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                                    </div>
                                                </div>
                                                <div class="team-content">
                                                    <h3 class="team-title" style="font-size:18px;"><a href="#" ><?php echo $gorev['adi_soyadi'.$dil]; ?></a></h3>
                                                    <span class="team-desig"><?php echo $gorev['gorev_adi'.$dil]; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <?php }} ?>
                                </div>
                                <div class="row text-center justify-content-md-center">
                                    <?php foreach( $gorevler as $gorev ){ if( $gorev['oncelik_sirasi'] == 2 ){  
                                        if( $gorev['foto'] == "resim_yok.png" or $gorev['foto'] == "" ) $foto = "ayu_logo.png"; else $foto = $gorev['foto'];
                                    ?>
                                    <div class="col-xl-4 col-md-6 justify-content-md-center">
                                        <div class="team-card team-card-1-1-active mt-0">
                                            <div class="team-img-wrap">
                                                <div class="team-img">
                                                    <img src="../admin/resimler/personel_resimler/<?php echo $foto; ?>" alt="Team" style="width: 327px;height: 250px;object-fit: cover;">
                                                </div>
                                            </div>
                                            <div class="team-hover-wrap">
                                                <div class="team-social">
                                                    <a href="#" class="icon-btn">
                                                        <i class="far fa-plus"></i>
                                                    </a>
                                                    <div class="th-social">
                                                        <a target="_blank" href="https://vimeo.com/"><i class="fab fa-vimeo-v"></i></a>
                                                        <a target="_blank" href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                                        <a target="_blank" href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
                                                        <a target="_blank" href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                                    </div>
                                                </div>
                                                <div class="team-content">
                                                    <h3 class="team-title" style="font-size:18px;"><a href="#" ><?php echo $gorev['adi_soyadi'.$dil]; ?></a></h3>
                                                    <span class="team-desig"><?php echo $gorev['gorev_adi'.$dil]; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <?php }} ?>
                                </div>
                                <div class="row text-center justify-content-md-center">
                                    <?php foreach( $gorevler as $gorev ){ if( $gorev['oncelik_sirasi'] == 3 ){  
                                        if( $gorev['foto'] == "resim_yok.png" or $gorev['foto'] == "" ) $foto = "ayu_logo.png"; else $foto = $gorev['foto'];
                                    ?>
                                    <div class="col-xl-4 col-md-6 justify-content-md-center">
                                        <div class="team-card team-card-1-1-active mt-0">
                                            <div class="team-img-wrap">
                                                <div class="team-img">
                                                    <img src="../admin/resimler/personel_resimler/<?php echo $foto; ?>" alt="Team" style="width: 327px;height: 250px;object-fit: cover;">
                                                </div>
                                            </div>
                                            <div class="team-hover-wrap">
                                                <div class="team-social">
                                                    <a href="#" class="icon-btn">
                                                        <i class="far fa-plus"></i>
                                                    </a>
                                                    <div class="th-social">
                                                        <a target="_blank" href="https://vimeo.com/"><i class="fab fa-vimeo-v"></i></a>
                                                        <a target="_blank" href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                                        <a target="_blank" href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
                                                        <a target="_blank" href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                                    </div>
                                                </div>
                                                <div class="team-content">
                                                    <h3 class="team-title" style="font-size:18px;"><a href="#" ><?php echo $gorev['adi_soyadi'.$dil]; ?></a></h3>
                                                    <span class="team-desig"><?php echo $gorev['gorev_adi'.$dil]; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <?php }} ?>
                                </div>
                            <?php }else{ ?>
                                <h2 class="blog-title" style="font-size: 24px;"><?php echo @$birim_sayfa_icerikleri['baslik'.$dil]; ?></h2>
                                <p>
                                    <?php echo @$birim_sayfa_icerikleri['icerik'.$dil]; ?>
                                </p>
                            <?php } ?>
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
                                    <span class="share-links-title">Paylaş:</span>
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
                            <h3 class="widget_title">Duyurular</h3>
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
                                        <h4 class="post-title" style="font-size: 12px;"><a class="text-inherit" href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><?php echo $duyuru['baslik'.$dil]; ?></a></h4>
                                        <div class="recent-post-meta">
                                            <small class="text-muted"><a href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><i class="fal fa-calendar"></i><?php echo $fn->tarihVer($duyuru['tarih']); ?></a></small>
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
