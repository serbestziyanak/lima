<?php 
$where = "WHERE p.aktif=1 and g.aktif=1 and g.gorev_kategori_id IN (".$birim_sayfa_bilgileri['gorev_kategori_idler'].") AND g.birim_id = ".$birim_id;
$SQL_gorevli_personel_bilgileri = <<< SQL
SELECT 
	p.*
    ,g.*
    ,gk.adi as gorev
    ,gk.adi_kz as gorev_kz
    ,gk.adi_en as gorev_en
    ,gk.adi_ru as gorev_ru
    ,akt.adi    as akademik_kadro_tipi
    ,akt.adi_kz as akademik_kadro_tipi_kz
    ,akt.adi_en as akademik_kadro_tipi_en
    ,akt.adi_ru as akademik_kadro_tipi_ru
    ,concat(ad.adi,',')         AS akademik_derece
    ,concat(ad.adi_kz,',')      AS akademik_derece_kz
    ,concat(ad.adi_en,',')      AS akademik_derece_en
    ,concat(ad.adi_ru,',')      AS akademik_derece_ru
    ,concat(au.adi,',')         AS akademik_unvan
    ,concat(au.adi_kz,',')      AS akademik_unvan_kz
    ,concat(au.adi_en,',')      AS akademik_unvan_en
    ,concat(au.adi_ru,',')      AS akademik_unvan_ru
    ,u.adi as unvan
    ,u.adi_kz as unvan_kz
    ,u.adi_en as unvan_en
    ,u.adi_ru as unvan_ru
    ,gk.oncelik_sirasi
FROM 
    tb_gorevler as g 
LEFT JOIN tb_personeller as p ON p.id = g.personel_id
LEFT JOIN tb_unvanlar as u ON p.unvan_id = u.id
LEFT JOIN tb_gorev_kategorileri as gk ON gk.id = g.gorev_kategori_id
LEFT JOIN tb_personel_calisma_yeri_bilgileri AS pcy ON pcy.personel_id = p.id and pcy.aktif_calisma_yeri = 1
LEFT JOIN tb_akademik_kadro_tipleri AS akt ON akt.id = pcy.akademik_kadro_tipi_id
LEFT JOIN tb_akademik_dereceler AS ad ON ad.id = pcy.akademik_derece_id
LEFT JOIN tb_akademik_unvanlar AS au ON au.id = pcy.akademik_unvan_id
$where
ORDER BY gk.oncelik_sirasi,u.sira IS NULL, u.sira ASC,p.adi
SQL;

$SQL_birim_sayfa_personel = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri_personeller
WHERE
  sayfa_id = ? 
SQL;

@$gorevli_personeller = $vt->select($SQL_gorevli_personel_bilgileri, array(  ) )[ 2 ];
@$sayfa_personeller  = $vt->select($SQL_birim_sayfa_personel, array( $sayfa_id ) )[ 2 ];

if( $birim_sayfa_bilgileri['personeller_gorunecek'] == 1 ){
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

}

?>

                        <?php if( @count($gorevli_personeller) > 0 ){ ?>
                        <hr>
                        <br>
                        <div class="row text-center justify-content-md-center">
                            <?php 
                            $sira=0; foreach( $gorevli_personeller as $key => $gorevli_personel ){ $sira++; 
                                $personel_adi = $gorevli_personel['adi'.$dil] ;
                                if( $gorevli_personel['adi'.$dil] == "" ){
                                    if( $gorevli_personel['adi'] != "" ) 
                                        if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                            $personel_adi = $gorevli_personel['soyadi']." ".$gorevli_personel['adi']." ".$gorevli_personel['baba_adi'] ;
                                        else
                                            $personel_adi = $gorevli_personel['adi']." ".$gorevli_personel['soyadi'] ;
                                    elseif( $gorevli_personel['adi_kz'] != "" )
                                        if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                            $personel_adi = $gorevli_personel['soyadi_kz']." ".$gorevli_personel['adi_kz']." ".$gorevli_personel['baba_adi_kz'] ;
                                        else
                                            $personel_adi = $gorevli_personel['adi_kz']." ".$gorevli_personel['soyadi_kz'] ;
                                    elseif( $gorevli_personel['adi_en'] != "" )
                                        if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                            $personel_adi = $gorevli_personel['soyadi_en']." ".$gorevli_personel['adi_en']." ".$gorevli_personel['baba_adi_en'] ;
                                        else
                                            $personel_adi = $gorevli_personel['adi_en']." ".$gorevli_personel['soyadi_en'] ;
                                    else
                                        if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                            $personel_adi = $gorevli_personel['soyadi_ru']." ".$gorevli_personel['adi_ru']." ".$gorevli_personel['baba_adi_ru'] ;
                                        else
                                            $personel_adi = $gorevli_personel['adi_ru']." ".$gorevli_personel['soyadi_ru'] ;
                                }else{
                                    if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                        $personel_adi = $gorevli_personel['soyadi'.$dil]." ".$gorevli_personel['adi'.$dil]." ".$gorevli_personel['baba_adi'.$dil] ;
                                    else
                                        $personel_adi = $gorevli_personel['adi'.$dil]." ".$gorevli_personel['soyadi'.$dil] ;
                                }

                                $personel_gorev = $gorevli_personel['gorev'.$dil] ;
                                if( $gorevli_personel['gorev'.$dil] == "" ){
                                    if( $gorevli_personel['gorev'] != "" ) 
                                        $personel_gorev = $gorevli_personel['gorev'] ;
                                    elseif( $gorevli_personel['gorev_kz'] != "" )
                                        $personel_gorev = $gorevli_personel['gorev_kz'] ;
                                    elseif( $gorevli_personel['gorev_en'] != "" )
                                        $personel_gorev = $gorevli_personel['gorev_en'] ;
                                    else
                                        $personel_gorev = $gorevli_personel['gorev_ru'] ;
                                }
                                
                                if( $gorevli_personel['gorev_aciklama'.$dil] != "" ){
                                    $personel_gorev = $gorevli_personel['gorev_aciklama'.$dil] ;
                                }
                                if( $gorevli_personel['foto'] == "" or $gorevli_personel['foto'] == "resim_yok.png" ){
                                    $personel_foto = "ayu_logo.png" ;
                                }else{
                                    $personel_foto = $gorevli_personel['foto'] ;
                                }


                            ?>
                            <div class="col-sm-6 col-lg-6 col-xl-5 pb-4">
                                <div class="team-card style3">
                                    <div class="team-img-wrap">
                                        <div class="team-img">
                                            <img style="height: 300px;object-fit: cover;" src="../admin/resimler/personel_resimler/<?php echo $personel_foto; ?>" alt="Team">
                                        </div>
                                    </div>
                                    <div class="team-hover-wrap">
                                        <div class="team-social">
                                            <a href="#" class="icon-btn">
                                                <i class="far fa-plus"></i>
                                            </a>
                                            <div class="th-social">
                                                <a href="<?php echo $gorevli_personel['orcid'] != "" ? $gorevli_personel['orcid']: $actual_link."#"; ?>" style="font-size:30px;"><i class="fa-brands fa-orcid"></i></a>
                                                <a href="<?php echo $gorevli_personel['scholar'] != "" ? $gorevli_personel['scholar']: $actual_link."#"; ?>"><img src="assets/img/icons8-google-scholar-48.png"></a>
                                                <a href="mailto:<?php echo $gorevli_personel['email']; ?>"><i class="fa-solid fa-envelope"></i></a>
                                                <a href="<?php echo $gorevli_personel['avesis'] != "" ? $gorevli_personel['avesis']: $actual_link."#"; ?>"><img src="assets/img/avesis.png"></i></a>
                                            </div>
                                        </div>
                                        <div class="team-content">
                                            <span class="team-desig pb-2"><?php echo $gorevli_personel['akademik_derece'.$dil]." ".$gorevli_personel['akademik_unvan'.$dil]; ?></span>
                                            <h3 class="team-title" style="font-size:20px;"><?php echo $personel_adi; ?></h3>
                                            <span class="team-desig"><?php echo $personel_gorev; ?></span>
                                            <br>
                                            <?php if( $gorevli_personel['email'] != "" ){ ?>
                                            <small><i class="fa-solid fa-envelope"></i> <?php echo $gorevli_personel['email']; ?></small>
                                            <?php } ?>
                                            <?php if( $gorevli_personel['is_telefonu'] != "" ){ ?>
                                            <br>
                                            <small><i class="fa-solid fa-phone"></i> <?php echo $gorevli_personel['is_telefonu']; ?></small>
                                            <?php } ?>
                                        </div>
                                        <div class="team-info text-center justify-content-md-center">
                                            <?php if( $gorevli_personel['dahili'] != "" ){ echo "<span><i class='fa-solid fa-phone'></i>".$gorevli_personel['dahili']."</span>";  } ?>
                                            <?php if( $gorevli_personel['oda_no'] != "" ){ echo "<span><i class='fa-solid fa-chair'></i>".$gorevli_personel['oda_no']."</span>";  } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if( $gorevli_personel['oncelik_sirasi'] == 1 ) echo "<div class='ml-auto'></div>";?>  
                            <?php } ?>

                        </div>
                        <?php } ?>

                        <?php if( @count($sayfa_personeller) > 0 ){ ?>
                        <hr>
                        <br>
                        <div class="row text-center justify-content-md-center">
                            <?php 
                            $sira=0; foreach( $sayfa_personeller as $key => $sayfa_personel ){ $sira++; 
                                $personel_adi = $sayfa_personel['adi'.$dil] ;
                                if( $sayfa_personel['adi'.$dil] == "" ){
                                    if( $sayfa_personel['adi'] != "" ) 
                                        $personel_adi = $sayfa_personel['adi'] ;
                                    elseif( $sayfa_personel['adi_kz'] != "" )
                                        $personel_adi = $sayfa_personel['adi_kz'] ;
                                    elseif( $sayfa_personel['adi_en'] != "" )
                                        $personel_adi = $sayfa_personel['adi_en'] ;
                                    else
                                        $personel_adi = $sayfa_personel['adi_ru'] ;
                                }

                                $personel_gorev = $sayfa_personel['gorev'.$dil] ;
                                if( $sayfa_personel['gorev'.$dil] == "" ){
                                    if( $sayfa_personel['gorev'] != "" ) 
                                        $personel_gorev = $sayfa_personel['gorev'] ;
                                    elseif( $sayfa_personel['gorev_kz'] != "" )
                                        $personel_gorev = $sayfa_personel['gorev_kz'] ;
                                    elseif( $sayfa_personel['gorev_en'] != "" )
                                        $personel_gorev = $sayfa_personel['gorev_en'] ;
                                    else
                                        $personel_gorev = $sayfa_personel['gorev_ru'] ;
                                }
                                if( $sayfa_personel['link'] != "" )
                                    $personel_link = "href='$sayfa_personel[link]'";
                                else
                                    $personel_link = "";

                                if( $sayfa_personel['foto'] == "" or $sayfa_personel['foto'] == "resim_yok.png" ){
                                    $sayfa_personel_foto = "ayu_logo.png" ;
                                }else{
                                    $sayfa_personel_foto = $sayfa_personel['foto'] ;
                                }

                            ?>


                            <div class="col-sm-6 col-lg-6 col-xl-5 pb-4">
                                <div class="team-card style3">
                                    <div class="team-img-wrap">
                                        <div class="team-img">
                                            <img style="height: 300px;object-fit: cover;" src="../admin/resimler/personel_resimler/<?php echo $sayfa_personel_foto; ?>" alt="Team">
                                        </div>
                                    </div>
                                    <div class="team-hover-wrap">
                                        <div class="team-social">
                                            <a href="#" class="icon-btn">
                                                <i class="far fa-plus"></i>
                                            </a>
                                            <div class="th-social">
                                                <a href="<?php echo $sayfa_personel['orcid'] != "" ? $sayfa_personel['orcid']: "mailto:"; ?>" style="font-size:30px;"><i class="fa-brands fa-orcid"></i></a>
                                                <a href="<?php echo $sayfa_personel['scholar'] != "" ? $sayfa_personel['scholar']: "mailto:"; ?>"><img src="assets/img/icons8-google-scholar-48.png"></a>
                                                <a href="mailto:<?php echo $sayfa_personel['email']; ?>"><i class="fa-solid fa-envelope"></i></a>
                                                <a href="<?php echo $sayfa_personel['avesis'] != "" ? $sayfa_personel['avesis']: "mailto:"; ?>"><img src="assets/img/avesis.png"></i></a>
                                            </div>
                                        </div>
                                        <div class="team-content">
                                            <h3 class="team-title" style="font-size:20px;"><a <?php echo $personel_link; ?> class="course-price"><?php echo $personel_adi; ?></a></h3>
                                            <span class="team-desig"><?php echo $personel_gorev; ?></span>
                                            <br>
                                            <?php if( $sayfa_personel['email'] != "" ){ ?>
                                            <small><i class="fa-solid fa-envelope"></i> <?php echo $sayfa_personel['email']; ?></small>
                                            <?php } ?>
                                            <?php if( $sayfa_personel['tel'] != "" ){ ?>
                                            <br>
                                            <small><i class="fa-solid fa-phone"></i> <?php echo $sayfa_personel['tel']; ?></small>
                                            <?php } ?>
                                        </div>
                                        <div class="team-info text-center justify-content-md-center">
                                            <?php if( $sayfa_personel['dahili'] != "" ){ echo "<span><i class='fa-solid fa-phone'></i>".$sayfa_personel['dahili']."</span>";  } ?>
                                            <?php if( $sayfa_personel['oda_no'] != "" ){ echo "<span><i class='fa-solid fa-chair'></i>".$sayfa_personel['oda_no']."</span>";  } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>

                        </div>
                        <?php } ?>
<?php if( $birim_sayfa_bilgileri['personeller_gorunecek'] == 1 AND @count($personeller) > 0 ){ ?>
    <div class="team-area overflow-hidden space">
        <div class="container">
            <div class="row align-items-center gy-4">
                <!-- Single Item -->
                <?php 
                    foreach( $personeller as $personel ){
                        if( $personel['foto'] == "resim_yok.png" or $personel['foto'] == "" ) $foto = "ayu_logo.png"; else $foto = $personel['foto'];
                ?>
                <div class="col-sm-6 col-lg-4 col-xl-4">
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
                                <?php if( $personel['uyruk_id'] == 113 ){ ?>
                                <h3 class="team-title" style="font-size:18px;"><a href="<?php echo $mevcut_url;?>#"><?php echo $personel['soyadi'.$dil]." ".$personel['adi'.$dil]." ".$personel['baba_adi'.$dil]; ?></a></h3>
                                <?php }else{ ?>
                                <h3 class="team-title" style="font-size:18px;"><a href="<?php echo $mevcut_url;?>#"><?php echo $personel['adi'.$dil]." ".$personel['soyadi'.$dil]; ?></a></h3>
                                <?php } ?>
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

<?php } ?>