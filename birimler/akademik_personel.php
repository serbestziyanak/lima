<?php

$SQL_alt_id_getir = <<< SQL
WITH RECURSIVE alt_kategoriler AS (
    SELECT id
    FROM tb_birim_agaci
    WHERE id = ? -- burası istediğiniz başlangıç ID'si
    UNION ALL
    SELECT k.id
    FROM tb_birim_agaci k
    JOIN alt_kategoriler ak ON k.ust_id = ak.id
)
SELECT * FROM alt_kategoriler;
SQL;
$alt_idler	= $vt->select( $SQL_alt_id_getir, array( $birim_id ) )[ 2 ];
foreach( $alt_idler as $alt_id )
	$birim_alt_idler[] = $alt_id['id'];
$birim_alt_idler = implode(",",$birim_alt_idler);


$where = "AND pcyb.birim_id IN (".$birim_alt_idler.")";
$SQL_personeller = <<< SQL
SELECT
     unv.adi as unvan
    ,unv.adi_kz as unvan_kz
    ,unv.adi_en as unvan_en
    ,unv.adi_ru as unvan_ru
    ,p.*
    ,brm.adi as birim_adi
    ,brm.adi_kz as birim_adi_kz
    ,brm.adi_en as birim_adi_en
    ,brm.adi_ru as birim_adi_ru
    ,akt.adi    as akademik_kadro_tipi
    ,akt.adi_kz as akademik_kadro_tipi_kz
    ,akt.adi_en as akademik_kadro_tipi_en
    ,akt.adi_ru as akademik_kadro_tipi_ru
    ,akd.adi    as akademik_derece
    ,akd.adi_kz as akademik_derece_kz
    ,akd.adi_en as akademik_derece_en
    ,akd.adi_ru as akademik_derece_ru
FROM 
	tb_personeller as p
LEFT JOIN tb_unvanlar AS unv ON p.unvan_id = unv.id
LEFT JOIN tb_personel_calisma_yeri_bilgileri AS pcyb ON p.id = pcyb.personel_id AND pcyb.aktif_calisma_yeri=1
LEFT JOIN tb_birim_agaci as brm ON pcyb.birim_id = brm.id
LEFT JOIN tb_akademik_kadro_tipleri AS akt ON akt.id = pcyb.akademik_kadro_tipi_id
LEFT JOIN tb_akademik_dereceler AS akd ON akd.id = pcyb.akademik_derece_id
WHERE p.aktif = 1 $where
ORDER BY unv.sira IS NULL, unv.sira ASC,p.adi
SQL;

$personeller = $vt->select( $SQL_personeller, 	array(  ) )[ 2 ];

?>

    <!--==============================
Team Area  
==============================-->
    <div class="team-area overflow-hidden space">
        <div class="container">
            <div class="row align-items-center gy-4">
                <!-- Single Item -->
                <?php 
                    foreach( $personeller as $personel ){
                        if( $personel['foto'] == "resim_yok.png" or $personel['foto'] == "" ) $foto = "ayu_logo.png"; else $foto = $personel['foto'];
                ?>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="team-card style3">
                        <div class="team-img-wrap">
                            <div class="team-img">
                                <img src="../admin/resimler/personel_resimler/<?php echo $foto; ?>" alt="Team" style="width: 327px;height: 300px;object-fit: cover;">
                            </div>
                        </div>
                        <div class="team-hover-wrap">
                            <div class="team-social">
                                <a href="#" class="icon-btn">
                                    <i class="far fa-plus"></i>
                                </a>
                                <div class="th-social">
                                    <a target="_blank" href="<?php echo $personel['orcid']; ?>" style="font-size:30px;"><i class="fa-brands fa-orcid"></i></a>
                                    <a target="_blank" href="<?php echo $personel['scholar']; ?>"><img src="assets/img/icons8-google-scholar-48.png"></a>
                                    <a target="_blank" href="mailto:<?php echo $personel['email']; ?>"><i class="fa-solid fa-envelope"></i></a>
                                    <a target="_blank" href="<?php echo $personel['avesis']; ?>"><img src="assets/img/avesis.png"></i></a>
                                </div>
                            </div>
                            <div class="team-content">
                                <span class="team-desig pb-2"><?php echo $personel['akademik_kadro_tipi'.$dil]." ".$personel['akademik_derece'.$dil]; ?></span>
                                <h3 class="team-title" style="font-size:18px;"><a href="<?php echo $mevcut_url;?>#"><?php echo $personel['adi'.$dil]." ".$personel['soyadi'.$dil]; ?></a></h3>
                                <span class="team-desig"><?php echo $personel['birim_adi'.$dil]; ?></span>
                            </div>
                            <!-- <div class="team-info">
                                <span><i class="fal fa-file-check"></i>2 Courses</span>
                                <span><i class="fa-light fa-users"></i>Students 60+</span>
                            </div> -->
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
   
