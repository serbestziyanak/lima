<?php 
if( $birim_sayfa_bilgileri['gorev_kategori_idler'] != "" ){
$where = "WHERE g.gorev_kategori_id IN (".$birim_sayfa_bilgileri['gorev_kategori_idler'].")";
$SQL_gorevli_personel_bilgileri = <<< SQL
SELECT 
	p.*
    ,g.*
    ,b.adi          AS birim_adi
    ,b.adi_kz       AS birim_adi_kz
    ,b.adi_en       AS birim_adi_en
    ,b.adi_ru       AS birim_adi_ru
    ,gk.adi as gorev
    ,gk.adi_kz as gorev_kz
    ,gk.adi_en as gorev_en
    ,gk.adi_ru as gorev_ru
    ,u.adi as unvan
    ,u.adi_kz as unvan_kz
    ,u.adi_en as unvan_en
    ,u.adi_ru as unvan_ru
    ,akt.adi        AS akademik_kadro_tipi
    ,akt.adi_kz     AS akademik_kadro_tipi_kz
    ,akt.adi_en     AS akademik_kadro_tipi_en
    ,akt.adi_ru     AS akademik_kadro_tipi_ru
    ,concat(ad.adi,',')         AS akademik_derece
    ,concat(ad.adi_kz,',')      AS akademik_derece_kz
    ,concat(ad.adi_en,',')      AS akademik_derece_en
    ,concat(ad.adi_ru,',')      AS akademik_derece_ru
    ,concat(au.adi,',')         AS akademik_unvan
    ,concat(au.adi_kz,',')      AS akademik_unvan_kz
    ,concat(au.adi_en,',')      AS akademik_unvan_en
    ,concat(au.adi_ru,',')      AS akademik_unvan_ru
    ,(select GROUP_CONCAT(gorev_kategori_id order by gorev_kategori_id) from tb_gorevler where personel_id = p.id order by gorev_kategori_id ASC) * 1 as gorevler
FROM 
    tb_gorevler as g 
LEFT JOIN tb_personeller as p ON p.id = g.personel_id
LEFT JOIN tb_unvanlar as u ON p.unvan_id = u.id
LEFT JOIN tb_gorev_kategorileri as gk ON gk.id = g.gorev_kategori_id
LEFT JOIN tb_personel_calisma_yeri_bilgileri AS pab ON pab.personel_id = p.id AND pab.aktif_calisma_yeri=1
LEFT JOIN tb_birim_agaci AS b ON b.id = pab.birim_id
LEFT JOIN tb_akademik_kadro_tipleri AS akt ON akt.id = pab.akademik_kadro_tipi_id
LEFT JOIN tb_akademik_dereceler AS ad ON ad.id = pab.akademik_derece_id
LEFT JOIN tb_akademik_unvanlar AS au ON au.id = pab.akademik_unvan_id
$where
ORDER BY gorevler IS NULL, gorevler, gk.oncelik_sirasi,au.sira IS NULL, au.sira ASC,p.adi ASC
SQL;

@$gorevli_personeller = $vt->select($SQL_gorevli_personel_bilgileri, array(  ) )[ 2 ];
//var_dump($gorevli_personeller);
}
?>
<style>
.edu-course .thumbnail a img {
    border-radius: 5px 5px 0 0;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    /* width: 100%; */
    width: 200px ;height: 200px ;object-fit: cover;
}
@media only screen and (max-width: 767px) {
    .edu-course .thumbnail a img {
        width: 100%;
        height: 100%;
    }
}
</style>
                        <?php if( @count($gorevli_personeller) > 0 ){ ?>
                        <hr>
                        <br>
                        <div class="row g-5">
                            <?php 
                            $sira=0; foreach( $gorevli_personeller as $key => $gorevli_personel ){ $sira++; 
                                $personel_adi = $gorevli_personel['adi'.$dil] ;
                                if( $gorevli_personel['adi'.$dil] == "" ){
                                    if( $gorevli_personel['adi'] != "" ) 
                                        if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                            $personel_adi = $gorevli_personel['akademik_derece']." ".$gorevli_personel['akademik_unvan']." ".$gorevli_personel['soyadi']." ".$gorevli_personel['adi']." ".$gorevli_personel['baba_adi'] ;
                                        else
                                            $personel_adi = $gorevli_personel['akademik_derece']." ".$gorevli_personel['akademik_unvan']." ".$gorevli_personel['adi']." ".$gorevli_personel['soyadi'] ;
                                    elseif( $gorevli_personel['adi_kz'] != "" )
                                        if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                            $personel_adi = $gorevli_personel['akademik_derece_kz']." ".$gorevli_personel['akademik_unvan_kz']." ".$gorevli_personel['soyadi_kz']." ".$gorevli_personel['adi_kz']." ".$gorevli_personel['baba_adi_kz'] ;
                                        else
                                            $personel_adi = $gorevli_personel['akademik_derece_kz']." ".$gorevli_personel['akademik_unvan_kz']." ".$gorevli_personel['adi_kz']." ".$gorevli_personel['soyadi_kz'] ;
                                    elseif( $gorevli_personel['adi_en'] != "" )
                                        if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                            $personel_adi = $gorevli_personel['akademik_derece_en']." ".$gorevli_personel['akademik_unvan_en']." ".$gorevli_personel['soyadi_en']." ".$gorevli_personel['adi_en']." ".$gorevli_personel['baba_adi_en'] ;
                                        else
                                            $personel_adi = $gorevli_personel['akademik_derece_en']." ".$gorevli_personel['akademik_unvan_en']." ".$gorevli_personel['adi_en']." ".$gorevli_personel['soyadi_en'] ;
                                    else
                                        if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                            $personel_adi = $gorevli_personel['akademik_derece_ru']." ".$gorevli_personel['akademik_unvan_ru']." ".$gorevli_personel['soyadi_ru']." ".$gorevli_personel['adi_ru']." ".$gorevli_personel['baba_adi_ru'] ;
                                        else
                                            $personel_adi = $gorevli_personel['akademik_derece_ru']." ".$gorevli_personel['akademik_unvan_ru']." ".$gorevli_personel['adi_ru']." ".$gorevli_personel['soyadi_ru'] ;
                                }else{
                                    if( $gorevli_personel[ 'uyruk_id' ] == 113 )
                                        $personel_adi = $gorevli_personel['akademik_derece'.$dil]." ".$gorevli_personel['akademik_unvan'.$dil]." ".$gorevli_personel['soyadi'.$dil]." ".$gorevli_personel['adi'.$dil]." ".$gorevli_personel['baba_adi'.$dil] ;
                                    else
                                        $personel_adi = $gorevli_personel['akademik_derece'.$dil]." ".$gorevli_personel['akademik_unvan'.$dil]." ".$gorevli_personel['adi'.$dil]." ".$gorevli_personel['soyadi'.$dil] ;
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


                            ?>
                            <div class="edu-course course-style-4 course-style-14 mb-0">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="<?php echo $_REQUEST['dil']."/personel_detay/".$gorevli_personel['personel_id']; ?>" >
                                            <img style="" src="admin/resimler/personel_resimler/<?php echo $gorevli_personel['foto']; ?>" alt="Course Meta">
                                        </a>

                                    </div>
                                    <div class="content">
                                        <div class="course-price"><a href="<?php echo $_REQUEST['dil']."/personel_detay/".$gorevli_personel['personel_id']; ?>" class="course-price"><?php echo $personel_adi; ?></a></div>
                                        <h6 class="title">
                                            <a><?php echo $personel_gorev; ?></a>
                                        </h6>
                                            <i class="fa-solid fa-envelope"></i>&nbsp;&nbsp; <?php echo $gorevli_personel['email']; ?>
                                            <br>
                                            <?php if( $gorevli_personel['is_telefonu'] != "" ){ ?>
                                            <i class="fa-solid fa-phone"></i>&nbsp; <?php echo $gorevli_personel['is_telefonu']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php } ?>
                                            <?php if( $gorevli_personel['dahili'] != "" ){ ?>
                                            <i class="fa-solid fa-phone-volume"></i>&nbsp; <?php echo $gorevli_personel['dahili']; ?>
                                            <?php } ?>
                                        <p>&nbsp;</p>
                                        <ul class="course-meta">
                                            <li><i class="fa-solid fa-school"></i><?php echo $gorevli_personel['bina_adi'.$dil]; ?></li>
                                            <li><i class="fa-solid fa-chair"></i><?php echo $gorevli_personel['oda_no']; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                        <?php } ?>

                        <?php if( @count($sayfa_personeller) > 0 ){ ?>
                        <hr>
                        <br>
                        <div class="row g-5">
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
                            ?>
                            <div class="edu-course course-style-4 course-style-14 mb-0">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a <?php echo $personel_link; ?> >
                                            <img style="width: 200px !important;height: 200px !important;object-fit: cover;" src="admin/resimler/personel_resimler/<?php echo $sayfa_personel['foto']; ?>" alt="Course Meta">
                                        </a>

                                    </div>
                                    <div class="content">
                                        <div class="course-price"><a <?php echo $personel_link; ?> class="course-price"><?php echo $personel_adi; ?></a></div>
                                        <h6 class="title">
                                            <a><?php echo $sayfa_personel['gorev'.$dil]; ?></a>
                                        </h6>
                                            <i class="fa-solid fa-envelope"></i>&nbsp;&nbsp; <?php echo $sayfa_personel['email']; ?>
                                            <br>
                                            <?php if( $sayfa_personel['tel'] != "" ){ ?>
                                            <i class="fa-solid fa-phone"></i>&nbsp; <?php echo $sayfa_personel['tel']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php } ?>
                                            <?php if( $sayfa_personel['dahili'] != "" ){ ?>
                                            <i class="fa-solid fa-phone-volume"></i>&nbsp; <?php echo $sayfa_personel['dahili']; ?>
                                            <?php } ?>
                                        <p>&nbsp;</p>
                                        <ul class="course-meta">
                                            <li><i class="fa-solid fa-school"></i><?php echo $birim_sayfa_bilgileri['adi'.$dil]; ?></li>
                                            <li><i class="fa-solid fa-chair"></i><?php echo $sayfa_personel['oda_no']; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                        <?php } ?>
