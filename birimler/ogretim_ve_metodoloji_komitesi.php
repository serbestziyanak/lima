<?php 
$SQL_tum_gorevler = <<< SQL
SELECT 
	g.*
    ,unv.adi as unvan
    ,unv.adi_kz as unvan_kz
    ,unv.adi_en as unvan_en
    ,unv.adi_ru as unvan_ru
    ,p.*
	,gk.adi as gorev_adi
	,gk.adi_kz as gorev_adi_kz
	,gk.adi_en as gorev_adi_en
	,gk.adi_ru as gorev_adi_ru
    ,gk.oncelik_sirasi
FROM 
	tb_gorevler as g
LEFT JOIN tb_gorev_kategorileri AS gk ON gk.id = g.gorev_kategori_id
LEFT JOIN tb_personeller AS p ON p.id = g.personel_id
LEFT JOIN tb_unvanlar AS unv ON unv.id = p.unvan_id
WHERE 
	g.birim_id = ? AND gorev_turu_id = 3
SQL;

@$gorevler   			= $vt->select( $SQL_tum_gorevler, 	array( $birim_id ) )[ 2 ];

?>

                                <h2 class="blog-title" style="font-size: 24px;"><?php echo dil_cevir( "Öğretim ve Metodoloji Komitesi", $dizi_dil, $_REQUEST["dil"] ); ?></h2>

                                <div class="row text-center justify-content-md-center">
                                    <?php foreach( $gorevler as $gorev ){ if( $gorev['oncelik_sirasi'] == 1 ){  
                                        if( $gorev['foto'] == "resim_yok.png" or $gorev['foto'] == "" ) $foto = "ayu_logo.png"; else $foto = $gorev['foto'];
                                    ?>
                                    <div class="col-xl-5 col-md-6 justify-content-md-center">
                                        <div class="team-card style3">
                                            <div class="team-img-wrap">
                                                <div class="team-img">
                                                    <img src="../admin/resimler/personel_resimler/<?php echo $foto; ?>" alt="Team" style="width: 327px;height: 250px;object-fit: cover;">
                                                </div>
                                            </div>
                                            <div class="team-hover-wrap">
                                                <div class="team-social">
                                                    <a href="<?php echo $mevcut_url; ?>#" class="icon-btn">
                                                        <i class="far fa-plus"></i>
                                                    </a>
                                                    <div class="th-social">
                                                        <a target="_blank" href="<?php echo $gorev['orcid'.$dil]; ?>" style="font-size:30px;"><i class="fa-brands fa-orcid"></i></a>
                                                        <a target="_blank" href="<?php echo $gorev['scholar'.$dil]; ?>"><img src="assets/img/icons8-google-scholar-48.png"></a>
                                                        <a target="_blank" href="mailto:<?php echo $gorev['email'.$dil]; ?>"><i class="fa-solid fa-envelope"></i></a>
                                                        <a target="_blank" href="<?php echo $gorev['avesis'.$dil]; ?>"><img src="assets/img/avesis.png"></i></a>
                                                    </div>
                                                </div>
                                                <div class="team-content">
                                                    <h3 class="team-title" style="font-size:18px;"><?php echo $gorev['unvan'.$dil]." ".$gorev['adi'.$dil]." ".$gorev['soyadi'.$dil]; ?></h3>
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
                                        <div class="team-card style3">
                                            <div class="team-img-wrap">
                                                <div class="team-img">
                                                    <img src="../admin/resimler/personel_resimler/<?php echo $foto; ?>" alt="Team" style="width: 327px;height: 250px;object-fit: cover;">
                                                </div>
                                            </div>
                                            <div class="team-hover-wrap">
                                                <div class="team-social">
                                                    <a href="<?php echo $mevcut_url; ?>#" class="icon-btn">
                                                        <i class="far fa-plus"></i>
                                                    </a>
                                                    <div class="th-social">
                                                        <a target="_blank" href="<?php echo $gorev['orcid'.$dil]; ?>" style="font-size:30px;"><i class="fa-brands fa-orcid"></i></a>
                                                        <a target="_blank" href="<?php echo $gorev['scholar'.$dil]; ?>"><img src="assets/img/icons8-google-scholar-48.png"></a>
                                                        <a target="_blank" href="mailto:<?php echo $gorev['email'.$dil]; ?>"><i class="fa-solid fa-envelope"></i></a>
                                                        <a target="_blank" href="<?php echo $gorev['avesis'.$dil]; ?>"><img src="assets/img/avesis.png"></i></a>
                                                    </div>
                                                </div>
                                                <div class="team-content">
                                                    <h3 class="team-title" style="font-size:18px;"><?php echo $gorev['unvan'.$dil]." ".$gorev['adi'.$dil]." ".$gorev['soyadi'.$dil]; ?></h3>
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
                                        <div class="team-card style3">
                                            <div class="team-img-wrap">
                                                <div class="team-img">
                                                    <img src="../admin/resimler/personel_resimler/<?php echo $foto; ?>" alt="Team" style="width: 327px;height: 250px;object-fit: cover;">
                                                </div>
                                            </div>
                                            <div class="team-hover-wrap">
                                                <div class="team-social">
                                                    <a href="<?php echo $mevcut_url; ?>#" class="icon-btn">
                                                        <i class="far fa-plus"></i>
                                                    </a>
                                                    <div class="th-social">
                                                        <a target="_blank" href="<?php echo $gorev['orcid'.$dil]; ?>" style="font-size:30px;"><i class="fa-brands fa-orcid"></i></a>
                                                        <a target="_blank" href="<?php echo $gorev['scholar'.$dil]; ?>"><img src="assets/img/icons8-google-scholar-48.png"></a>
                                                        <a target="_blank" href="mailto:<?php echo $gorev['email'.$dil]; ?>"><i class="fa-solid fa-envelope"></i></a>
                                                        <a target="_blank" href="<?php echo $gorev['avesis'.$dil]; ?>"><img src="assets/img/avesis.png"></i></a>
                                                    </div>
                                                </div>
                                                <div class="team-content">
                                                    <h3 class="team-title" style="font-size:18px;"><?php echo $gorev['unvan'.$dil]." ".$gorev['adi'.$dil]." ".$gorev['soyadi'.$dil]; ?></h3>
                                                    <span class="team-desig"><?php echo $gorev['gorev_adi'.$dil]; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <?php }} ?>
                                </div>
