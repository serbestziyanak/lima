<?php

$SQL_birim_bilgileri = <<< SQL
SELECT
  *
FROM 
  tb_birim_agaci
WHERE
  program_kodu = ? 
SQL;
@$birim_bilgileri = $vt->selectSingle($SQL_birim_bilgileri, array( $_REQUEST['id'] ) )[ 2 ];
$birim_id = $birim_bilgileri['id'];

$SQL_birim_bilgileri2 = <<< SQL
SELECT
  *
FROM 
  tb_birim_agaci
WHERE
  id = ? 
SQL;
@$duzey = $vt->selectSingle($SQL_birim_bilgileri2, array( $birim_bilgileri['ust_id'] ) )[ 2 ];
$duzey_adi = $duzey['adi'.$dil];
@$bolum = $vt->selectSingle($SQL_birim_bilgileri2, array( $duzey['ust_id'] ) )[ 2 ];
$bolum_adi = $bolum['adi'.$dil];
@$fakulte = $vt->selectSingle($SQL_birim_bilgileri2, array( $bolum['ust_id'] ) )[ 2 ];
$fakulte_adi = $fakulte['adi'.$dil];

$SQL_birim_sayfa_bilgileri = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfalari
WHERE
  birim_id = ? 
SQL;
@$birim_sayfalari = $vt->select($SQL_birim_sayfa_bilgileri, array( $birim_id ) )[ 2 ];


$SQL_birim_sayfa_icerikleri = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri
WHERE
  sayfa_id = ? 
SQL;



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
                <h1 class="breadcumb-title"><?php echo dil_cevir( "Programlar", $dizi_dil, $_REQUEST["dil"] ); ?></h1>
                <ul class="breadcumb-menu">
                    <li><a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $_REQUEST['kisa_ad']; ?>"><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                    <li><?php echo dil_cevir( "Programlar", $dizi_dil, $_REQUEST["dil"] );?></li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
Project Area  
==============================-->
    <!--==============================
Event Area  
==============================-->
    <section class="space-top space-extra2-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-lg-8">
                    <div class="course-single">
                        <div class="course-single-top">
                            <?php
                            foreach( $birim_sayfalari as $birim_sayfa ){
                                if( $birim_sayfa['kisa_ad'] == 'program-hakkinda' ){
                                @$sayfa_icerik = $vt->selectSingle($SQL_birim_sayfa_icerikleri, array( $birim_sayfa['id'] ) )[ 2 ];
                                
                                break;
                                }
                            }
                            ?>
                            <h5 ><a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $fakulte['kisa_ad']; ?>"><?php echo $fakulte_adi; ?></a> / <a href="<?php echo $_REQUEST['dil']; ?>/<?php echo $bolum['kisa_ad']; ?>"><?php echo $bolum_adi; ?></a> / <a><?php echo $duzey_adi; ?></a></h5>
                            <h2 class="course-title"><?php echo $birim_bilgileri['program_kodu']; ?> - <?php echo $birim_bilgileri['adi'.$dil]; ?></h2>
                            <?php 
                                if( $sayfa_icerik['foto'] == "" ){ 
                                    $program_foto = "program_resim.jpg";
                                }else{
                                    $program_foto = $sayfa_icerik['foto'];
                                } 
                            ?>
                            <div class="course-img">
                                <img src="../admin/resimler/programlar/<?php echo $program_foto; ?>" alt="Course Image">
                                <span class="tag"><i class="fas fa-clock"></i> <?php echo $fakulte_adi; ?></span>
                                <span class="tag2 bg-theme"><i class="fas fa-clock"></i> <?php echo $bolum_adi; ?></span>
                            </div>
                            <!--div class="course-meta style2">
                                <span><i class="fal fa-file"></i>Lesson 8</span>
                                <span><i class="fal fa-user"></i>Students 60+</span>
                                <span><i class="fal fa-chart-simple"></i>Beginner</span>
                            </div-->
                            <h2 class="course-title"><?php echo $sayfa_icerik['baslik'.$dil]; ?></h2>
                            <p>
                                <?php echo $sayfa_icerik['icerik'.$dil]; ?>
                            </p>
                            <!--ul class="course-single-meta">
                                <li class="course-single-meta-author">
                                    <img src="assets/img/course/author2.png" alt="author">
                                    <span>
                                        <span class="meta-title">Instructor: </span>
                                        <a href="course.html">Max Alexix</a>
                                    </span>
                                </li>
                                <li>
                                    <span class="meta-title">Category: </span>
                                    <a href="course.html">Web Development</a>
                                </li>
                                <li>
                                    <span class="meta-title">Last Update: </span>
                                    <a href="course.html">20 Jun, 2023</a>
                                </li>
                                <li>
                                    <span class="meta-title">Review: </span>
                                    <div class="course-rating">
                                        <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                                            <span style="width:80%">Rated <strong class="rating">4.00</strong> out of 5</span>
                                        </div>
                                        (4.00)
                                    </div>
                                </li>
                            </ul-->
                        </div>
                        <div class="course-single-bottom">
                            <ul class="nav course-tab" id="courseTab" role="tablist">
                                <?php
                                $sira = 0;
                                $icon = array( "fa-regular fa-bookmark","fa-regular fa-star-sharp","fa-regular fa-book","fa-regular fa-user" );
                                foreach( $birim_sayfalari as $birim_sayfa ){
                                    if( $birim_sayfa['kisa_ad'] == 'program-hakkinda' )
                                        continue;
                                    $sira++;
                                ?>
                                <li class="nav-item " role="presentation">
                                    <a style="" class="nav-link <?php if( $sira == 1 ) echo "active"; ?>" id="tab-<?php echo $birim_sayfa['id']; ?>" data-bs-toggle="tab" href="#Coursedescription<?php echo $birim_sayfa['id']; ?>" role="tab" aria-controls="Coursedescription" aria-selected="true">
                                        <i class="<?php echo $icon[$sira-1]; ?>"></i>
                                        <?php echo $birim_sayfa['adi'.$dil]; ?>
                                    </a>
                                </li>
                                <?php 
                                }
                                ?>
                            </ul>
                            <div class="tab-content" id="productTabContent">
                                <?php
                                $sira = 0;
                                foreach( $birim_sayfalari as $birim_sayfa ){
                                    if( $birim_sayfa['kisa_ad'] == 'program-hakkinda' )
                                        continue;
                                    $sira++;
                                    @$sayfa_icerik = $vt->selectSingle($SQL_birim_sayfa_icerikleri, array( $birim_sayfa['id'] ) )[ 2 ];
                                ?>
                                <div class="tab-pane fade <?php if( $sira == 1 ) echo "show active"; ?>" id="Coursedescription<?php echo $birim_sayfa['id']; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $birim_sayfa['id']; ?>">
                                    <div class="course-description">
                                        <h5 class="h5"><?php echo $sayfa_icerik['baslik'.$dil]; ?></h5>
                                        <div class="ck-content">
                                            <?php echo $sayfa_icerik['icerik'.$dil]; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <aside class="sidebar-area">
                        <div class="widget  ">
                            <h3 class="widget_title"><?php echo dil_cevir( "Programlar", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                            <?php
                                $menu ="";
                                @$programlar = $vt->select($SQL_bolumler, array( $bolum['id'] ) )[ 2 ];
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
                    </aside>
                </div>
            </div>
        </div>
    </section>
