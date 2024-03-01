<?php


$SQL_duzeyler = <<< SQL
SELECT
  *
FROM 
  tb_birim_agaci
WHERE
  ust_id = ? 
SQL;

$SQL_programlar = <<< SQL
SELECT
  *
FROM 
  tb_birim_agaci
WHERE
  ust_id = ? 
SQL;

if( $birim_id == 8 )
@$duzeyler = $vt->select($SQL_duzeyler, array( 9 ) )[ 2 ];
elseif( $birim_id == 278 )
@$duzeyler = $vt->select($SQL_duzeyler, array( 279 ) )[ 2 ];
else
@$duzeyler = $vt->select($SQL_duzeyler, array( $birim_id ) )[ 2 ];



?>


    <!--==============================
Project Area  
==============================-->
    <!--==============================
Event Area  
==============================-->
<?php if( count( $duzeyler ) > 0 ){ ?>
    <section class="space-top space-extra2-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="course-single">
                        <div class="course-single-bottom">
                            <ul class="nav course-tab" id="courseTab" role="tablist">
                                <?php
                                $sira = 0;
                                $icon = array( "fa-regular fa-bookmark","fa-regular fa-star-sharp","fa-regular fa-book","fa-regular fa-user" );
                                foreach( $duzeyler as $duzey ){
                                    $sira++;
                                ?>
                                <li class="nav-item " role="presentation">
                                    <a style="" class="nav-link <?php if( $sira == 1 ) echo "active"; ?>" id="tab-<?php echo $duzey['id']; ?>" data-bs-toggle="tab" href="#Coursedescription<?php echo $duzey['id']; ?>" role="tab" aria-controls="Coursedescription" aria-selected="true">
                                        <i class="<?php echo $icon[$sira-1]; ?>"></i>
                                        <?php echo $duzey['adi'.$dil]; ?>
                                    </a>
                                </li>
                                <?php 
                                }
                                ?>
                            </ul>
                            <div class="tab-content" id="productTabContent">
                                <?php
                                $sira = 0;
                                foreach( $duzeyler as $duzey ){
                                    $sira++;
                                    @$programlar = $vt->select($SQL_programlar, array( $duzey['id'] ) )[ 2 ];
                                ?>
                                <div class="tab-pane fade <?php if( $sira == 1 ) echo "show active"; ?>" id="Coursedescription<?php echo $duzey['id']; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $duzey['id']; ?>">
                                    <div class="course-Reviews">
                                        <div class="th-comments-wrap ">
                                            <ul class="comment-list">
                                                <?php foreach( $programlar as $programlar ){ ?>
                                                <li class="review th-comment-item">
                                                    <div class="th-post-comment" style="padding-bottom:10px;">
                                                        <div class="comment-avater2">
                                                            <img src="../admin/resimler/logolar/<?php echo $fakulte_bilgileri['birim_icon']; ?>"  alt="Comment Author">
                                                        </div>
                                                        <div class="comment-content">
                                                            <h4 class="name"><a href="<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']."/programlar/".$programlar['program_kodu']; ?>"><?php echo "<b>".$programlar['program_kodu']."</b>&emsp; ".$programlar['adi'.$dil] ?></a></h4>
                                                            <span class="commented-on"><i class="fa-solid fa-school"></i><?php echo $birim_bilgileri['adi'.$dil]; ?></span>
                                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                                <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div> <!-- Comment Form -->

                                    </div>
                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <!--aside class="sidebar-area">
                        <div class="widget  ">
                            <h3 class="widget_title"><?php echo dil_cevir( "Programlar", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                            <?php
                                $menu ="";
                                @$programlar = $vt->select($SQL_bolumler, array( $birim_bilgileri['id'] ) )[ 2 ];
                                $menu .= "<ul class='sub-cat'>";
                                foreach( $programlar as $program ){
                                    $program_adi = "adi".$dil;
                                    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                    $menu .= "<li ><b>{$program[$program_adi]}</b>";
                                        @$programlar2 = $vt->select($SQL_bolumler, array( $program['id'] ) )[ 2 ];
                                        $menu .= "<ul class='sub-cat' >";
                                        foreach( $programlar2 as $program2 ){                                                                                
                                            $menu .= "<li><a href='{$_REQUEST['dil']}/{$_REQUEST['kisa_ad']}/programlar/{$program2['program_kodu']}'>{$program2['program_kodu']} {$program2[$program_adi]}</a></li>";

                                        }
                                        $menu .= "</ul></li>";
                                }
                                $menu .= "</ul>";
                                echo $menu;
                            ?>
                        </div>
                    </aside-->
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
                                                        <h4 class="post-title" style="font-size: 12px;"><a class="text-inherit" href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><?php echo $duyuru['baslik'.$dil]; ?></a></h4>
                                                        <div class="recent-post-meta">
                                                            <small class="text-muted"><a href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/duyurular/<?php echo $duyuru['id']; ?>"><i class="fal fa-calendar"></i><?php echo $fn->tarihVer($duyuru['tarih']); ?></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
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
                                                            <small class="text-muted"><a href="<?php echo $_REQUEST["dil"]."/".$_REQUEST['kisa_ad']; ?>/etkinlikler/<?php echo $etkinlik['id']; ?>"><i class="fal fa-calendar"></i><?php echo $fn->tarihVer($etkinlik['tarih']); ?></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
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
<?php }else{ ?>
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
                        <span class="sub-title"><i class="fal fa-book me-2"></i> <?php echo $birim_bilgileri['adi'.$dil]; ?></span>
                        <h2 class="sec-title"><?php echo $genel_ayarlar['anasayfa_baslik'.$dil]; ?></h2>
                    </div>
                    <p class="mt-n2 mb-25">
                        <?php echo $genel_ayarlar['anasayfa_icerik'.$dil]; ?>
                    </p>
                    <!-- <div class="btn-group mt-40">
                        <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>/hakkimizda" class="th-btn"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $_REQUEST["dil"] ); ?><i class="fa-regular fa-arrow-right ms-2"></i></a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
<?php } ?>