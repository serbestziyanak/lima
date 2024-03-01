<?php


$SQL_birimler = <<< SQL
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

@$birimler = $vt->select($SQL_birimler, array( $birim_id ) )[ 2 ];



?>


    <!--==============================
Project Area  
==============================-->
    <!--==============================
Event Area  
==============================-->
    <section class="space-top space-extra2-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="sidebar-area">
                        <div class="course-single-bottom">
                            <ul class="nav course-tab" id="courseTab" role="tablist">
                                <li class="nav-item " role="presentation">
                                    <a style="" class="nav-link active" id="tab-birim" data-bs-toggle="tab" href="#Coursedescription-birim" role="tab" aria-controls="Coursedescription" aria-selected="true">
                                        <i class="fa-regular fa-bookmark"></i>
                                        <?php echo $birim_bilgileri['adi'.$dil]; ?>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="productTabContent">
                                <div class="tab-pane fade show active" id="Coursedescription-birim" role="tabpanel" aria-labelledby="tab-birim">
                                    <div class="course-Reviews">
                                        <div class="th-comments-wrap p-0">
                                            <h3 class="widget_title p-0"></h3>
                                            <?php if( $birim_bilgileri['kategori'] == 1 ){ ?>
                                            <ul class="comment-list"  style="margin:50px;">
                                                <?php foreach( $birimler as $birim ){ ?>
                                                <li class="review th-comment-item">
                                                    <div class="th-post-comment" style="padding-top:20px;padding-bottom:10px;">
                                                        <div class="comment-avater2">
                                                            <img src="../admin/resimler/logolar/alev_icon.png"  alt="Comment Author">
                                                        </div>
                                                        <div class="comment-content">
                                                            <h4 class="name"><a href="<?php echo $_REQUEST['dil']."/".$_REQUEST['kisa_ad']."/yapisal-birimler/".$birim['id']; ?>"><?php echo $birim['adi'.$dil] ?></a></h4>
                                                            <span class="commented-on"><i class="fa-solid fa-school"></i><?php echo $birim_bilgileri['adi'.$dil]; ?></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                            <?php }else{ ?>
                                            <div class="blog-content p-4" >
                                                <h2 class="blog-title" style="font-size: 24px;"><?php echo @$genel_ayarlar['anasayfa_baslik'.$dil]; ?></h2>
                                                <div class="ck-content" style="font-family:'Roboto', sans-serif !important; font-size: 16px !important; ">
                                                    <?php echo @$genel_ayarlar['anasayfa_icerik'.$dil]; ?>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div> <!-- Comment Form -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
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
                                                        $etkinlik_foto = "ayu_logo.png";
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
