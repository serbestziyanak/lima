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
WHERE fd.dil_id = 1 
SQL;

$fuarlar	= $vt->select( $SQL_tum_fuarlar, array(  ) )[ 2 ];



$SQL_fuar_kategori_idler = <<< SQL
SELECT 
    GROUP_CONCAT(ft.fuar_kategori_idler) as fuar_kategori_idler
FROM tb_fuarlar as f
LEFT JOIN tb_fuar_tanimlari as ft ON ft.id=f.fuar_tanim_id
SQL;
$fuar_kategori_idler		= $vt->selectSingle( $SQL_fuar_kategori_idler, array( ) )[ 2 ]['fuar_kategori_idler'];

$SQL_fuar_bolge_idler = <<< SQL
SELECT GROUP_CONCAT(bolge_id) as bolge_idler FROM tb_fuarlar
SQL;

$fuar_bolge_idler		= $vt->selectSingle( $SQL_fuar_bolge_idler, array( ) )[ 2 ]['bolge_idler'];
// echo $fuar_bolge_idler;

$where = "WHERE fk.id in (".$fuar_kategori_idler.")";
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

?>
        <div class="edu-breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <h1 class="title"><?php echo dil_cevir( "Fuarlar", $dizi_dil, $_REQUEST["dil"] ); ?></h1>
                    </div>
                    <!-- <ul class="edu-breadcrumb">
                        <li class="breadcrumb-item"><a href="index-one.html">Home</a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="separator"><i class="icon-angle-right"></i></li>
                        <li class="breadcrumb-item active" aria-current="page">Event 2</li>
                    </ul> -->
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
        <div class="edu-event-area event-area-1 section-gap-equal">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-3 order-lg-2">
                        <form class="form-horizontal" action = "" method = "POST" enctype="multipart/form-data">
                            <input type="hidden" name="ara" value="ara">
                        <div class="course-sidebar-2">
                            <div class="edu-course-widget widget-category">
                                <div class="inner">
                                    <h5 class="widget-title">Kategori</h5>
                                    <div class="content">
                                        <?php  
                                        foreach( $fuar_kategorileri as $result ){
                                        ?>
                                        <div class="edu-form-check">
                                            <input type="checkbox" name="fuar_kategori_idler[]" value="<?php echo $result['id']; ?>" id="cat-check<?php echo $result['id']; ?>" <?php if( in_array( $result['id'], $_REQUEST['fuar_kategori_idler'] ) ) echo "checked"; ?>>
                                            <label for="cat-check<?php echo $result['id']; ?>"><?php echo $result['adi']; ?></span></label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="edu-course-widget widget-date-filter">
                                <div class="inner">
                                    <h5 class="widget-title">Date</h5>
                                    <div class="content">
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="date-check1">
                                            <label for="date-check1">Any Day</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="date-check2">
                                            <label for="date-check2">Today</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="date-check3">
                                            <label for="date-check3">Tomorrow</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="date-check4">
                                            <label for="date-check4">This Week</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="date-check5">
                                            <label for="date-check5">This Month</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="edu-course-widget widget-cities">
                                <div class="inner">
                                    <h5 class="widget-title">Cities</h5>
                                    <div class="content">
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="city-check1">
                                            <label for="city-check1">All Cities</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="city-check2">
                                            <label for="city-check2">Japan</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="city-check3">
                                            <label for="city-check3">New York</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="city-check4">
                                            <label for="city-check4">England</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="city-check5">
                                            <label for="city-check5">Mascow</label>
                                        </div>
                                        <div class="edu-form-check">
                                            <input type="checkbox" id="city-check6">
                                            <label for="city-check6">Paris</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="edu-btn btn-medium btn-gradient">Filtrele <i class="icon-4"></i></button> 
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="col-lg-9 order-lg-1 col-pr--35">
                        <div class="row g-5">
                            <?php foreach( $fuarlar as $result ){ ?>
                            <div class="col-12" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">
                                <div class="edu-event-list event-list-2">
                                    <div class="inner row">
                                        <div class="thumbnail col-xl-6">
                                            <a href="<?php echo $_REQUEST['dil']; ?>/fuardetay/<?php echo $result['id']; ?>" >
                                                <img src="admin/resimler/fuarlar/kucuk/<?php echo $result['foto']; ?>" alt="Event Images" >
                                            </a>
                                        </div>
                                        <div class="content col-xl-6">
                                            <ul class="event-meta">
                                                <li><i class="icon-27"></i><?php echo $fn->tarihVer($result['baslama_tarihi']); ?> - <?php echo $fn->tarihVer($result['bitis_tarihi']); ?></li>
                                            </ul>
                                            <h4 class="title"><a href="<?php echo $_REQUEST['dil']; ?>/fuardetay/<?php echo $result['id']; ?>"><?php echo $result['adi']; ?></a></h4>
                                            <span class="event-location"><i class="icon-40"></i><?php echo $result['sehir_adi']; ?>, <?php echo $result['ulke_adi']; ?></span>
                                            <p><?php echo $result['fuar_tanim_adi']; ?></p>
                                            <div class="read-more-btn">
                                                <a class="edu-btn btn-medium btn-border" href="<?php echo $_REQUEST['dil']; ?>/fuardetay/<?php echo $result['id']; ?>"><?php echo dil_cevir( "Fuar Detayı", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>


                <!-- <ul class="edu-pagination top-space-30 justify-content-start">
                    <li><a href="#" aria-label="Previous"><i class="icon-west"></i></a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li class="more-next"><a href="#"></a></li>
                    <li><a href="#">8</a></li>
                    <li><a href="#" aria-label="Next"><i class="icon-east"></i></a></li>
                </ul> -->

            </div>
        </div>
 